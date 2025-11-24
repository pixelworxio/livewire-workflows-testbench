<?php

namespace App\Livewire\Registration;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowStep;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'register', key: 'demographics')]
class DemographicsStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState(namespace: 'registration')]
    public string $age = '';

    #[WorkflowState(namespace: 'registration')]
    public string $location = '';

    #[WorkflowState(namespace: 'registration')]
    public string $phone = '';

    #[WorkflowState(namespace: 'registration')]
    public string $email = '';

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

        User::whereEmail($this->email)->update([
            'age' => $this->age,
            'location' => $this->location,
            'phone' => $this->phone,
        ]);

        // Continue workflow (moves to next step)
        $this->continue();
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->back();
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
