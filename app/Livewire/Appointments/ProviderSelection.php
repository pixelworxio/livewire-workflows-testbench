<?php

namespace App\Livewire\Appointments;

use App\Models\Provider;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class ProviderSelection extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public ?int $serviceId = null;

    #[WorkflowState]
    public ?int $providerId = null;

    /**
     * Select a provider and continue to next step.
     *
     * @param int $providerId
     */
    public function selectProvider(int $providerId): void
    {
        // Store provider ID in workflow state
        $this->providerId = $providerId;

        // Store in session for guard checks
        session()->put('appointment_provider_id', $providerId);

        // Continue to next step
        $this->continue('book-appointment');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        // Clear current step data
        session()->forget('appointment_provider_id');
        $this->providerId = null;

        $this->back('book-appointment');
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
