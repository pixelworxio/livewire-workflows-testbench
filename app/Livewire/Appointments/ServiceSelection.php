<?php

namespace App\Livewire\Appointments;

use App\Models\Service;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class ServiceSelection extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public ?int $serviceId = null;

    /**
     * Select a service and continue to next step.
     *
     * @param int $serviceId
     */
    public function selectService(int $serviceId): void
    {
        // Store service ID in workflow state
        $this->serviceId = $serviceId;

        // Store in session for example guard checks
        session()->put('appointment_service_id', $serviceId);

        // Continue to next step
        $this->continue('book-appointment');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        $services = Service::all();

        return view('livewire.appointments.service-selection', [
            'services' => $services,
        ])->layout('layouts.app');
    }
}
