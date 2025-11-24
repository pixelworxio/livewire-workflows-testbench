<?php

namespace App\Livewire\Registration;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'register', key: 'user')]
class UserStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState(namespace:'registration')]
    public string $email = '';

    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|confirmed',
        ];
    }

    /**
     * Process step and continue to next.
     */
    public function goToNextStep(): void
    {
        // Validate input
        $this->validate();

        User::updateOrCreate(
            ['email' => $this->email],
            [
                'password' => Hash::make($this->password), // replace pwd – it's a demo, who cares?
                'name' => $this->email, // Use email as name for now
                'enabled_mfa' => true, // for testing mfa part of flow
            ]
        );

        // Continue workflow (moves to next step)
        $this->continue();
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.registration.user-step')
            ->layout('layouts.guest');
    }
}
