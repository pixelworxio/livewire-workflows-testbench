<?php

namespace App\Livewire\Registration;

use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class UserStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $email = '';

    #[WorkflowState]
    public string $password = '';

    #[WorkflowState]
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

        // Store data in session (for guard checks and later use)
        session()->put('registration.email', $this->email);
        session()->put('registration.password', $this->password);

        // Continue workflow (moves to next step)
        $this->continue('register');
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
