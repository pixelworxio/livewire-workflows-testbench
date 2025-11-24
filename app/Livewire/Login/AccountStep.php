<?php

namespace App\Livewire\Login;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'login', key: 'account')]
class AccountStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to log the user in and continue to the next step.
     */
    public function login(): void
    {
        $this->validate();

        // Attempt to authenticate the user
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            throw ValidationException::withMessages([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        // Regenerate session for security
        session()->regenerate();

        // If user has MFA enabled, set up MFA code and timestamp
        $user = Auth::user();
        if ($user->enabled_mfa) {
            // Generate a demo 6-digit MFA code
            $mfaCode = str_pad((string) rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store MFA code and timestamp in user record
            $user->update([
                'mfa_code' => $mfaCode,
                'mfa_sent_at' => now(),
            ]);
        }

        // Continue to the next step in the workflow
        $this->continue();
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.login.account-step')
            ->layout('layouts.guest');
    }
}
