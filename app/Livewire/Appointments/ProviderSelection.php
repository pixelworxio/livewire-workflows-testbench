<?php

namespace App\Livewire\Appointments;

use App\Models\Provider;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState, WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow: 'book-appointment', key:'select-provider')]
class ProviderSelection extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public ?int $provider_id = null;

    /**
     * Select a provider and continue to next step.
     *
     * @param int $providerId
     */
    public function selectProvider(int $provider_id): void
    {
        // Store provider ID in workflow state
        $this->provider_id = $provider_id;

        // Store in session for guard checks
        session()->put('appointment_provider_id', $provider_id);

        // Continue to next step
        $this->continue('book-appointment');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->provider_id = null; // optional

        $this->back('book-appointment', 'select-provider');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        // Get only available providers
        $providers = Provider::where('is_available', true)->get();

        return view('livewire.appointments.provider-selection', [
            'providers' => $providers,
        ])->layout('layouts.app');
    }
}
