<?php

namespace App\Livewire\Registration;

use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class BusinessStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $business_name = '';

    #[WorkflowState]
    public string $business_type = '';

    /**
     * Available business types.
     */
    public array $businessTypes = [
        'LLC' => 'Limited Liability Company (LLC)',
        'Corporation' => 'Corporation',
        'Sole Proprietor' => 'Sole Proprietor',
        'Partnership' => 'Partnership',
    ];

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'business_name' => 'required|min:3|max:255',
            'business_type' => 'required|in:LLC,Corporation,Sole Proprietor,Partnership',
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
        session()->put('registration.business_name', $this->business_name);
        session()->put('registration.business_type', $this->business_type);

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
        return view('livewire.registration.business-step')
            ->layout('layouts.guest');
    }
}
