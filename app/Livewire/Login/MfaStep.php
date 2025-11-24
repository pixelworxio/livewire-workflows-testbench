<?php

namespace App\Livewire\Login;

use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'login', key: 'mfa', middleware: ['web', 'auth'])]
class MfaStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $mfaCode = '';

    public bool $showResendMessage = false;

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'mfaCode' => ['required', 'string', 'size:6', 'regex:/^[0-9]{6}$/'],
        ];
    }

    /**
     * Validate the MFA code and continue to the next step.
     */
    public function verify(): void
    {
        $this->validate();

        $user = auth()->user();

        // Validate the MFA code matches what was sent
        if ($this->mfaCode !== $user->mfa_code) {
            throw ValidationException::withMessages([
                'mfaCode' => 'The MFA code you entered is invalid.',
            ]);
        }

        // Clear the MFA code and timestamp to mark as completed
        $user->update([
            'mfa_code' => null,
            'mfa_sent_at' => null,
        ]);

        // Continue to the next step in the workflow
        $this->continue();
    }

    /**
     * Simulate resending the MFA code.
     */
    public function resend(): void
    {
        $user = auth()->user();

        // Generate a new demo 6-digit MFA code
        $mfaCode = str_pad((string) rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Update the MFA code and timestamp
        $user->update([
            'mfa_code' => $mfaCode,
            'mfa_sent_at' => now(),
        ]);

        $this->showResendMessage = true;
        $this->mfaCode = '';
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        $user = auth()->user();

        return view('livewire.login.mfa-step', [
            'mfaCodeForDemo' => $user?->mfa_code,
        ])->layout('layouts.guest');
    }
}
