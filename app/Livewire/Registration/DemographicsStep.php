<?php

namespace App\Livewire\Registration;

use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class DemographicsStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $age = '';

    #[WorkflowState]
    public string $location = '';

    #[WorkflowState]
    public string $phone = '';

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'age' => 'required|integer|min:18|max:120',
            'location' => 'required|min:3|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20',
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
        session()->put('registration.age', $this->age);
        session()->put('registration.location', $this->location);
        session()->put('registration.phone', $this->phone);

        // Continue workflow (moves to next step)
        $this->continue('register');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->back('register');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.registration.demographics-step')
            ->layout('layouts.guest');
    }
}
