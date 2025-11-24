<?php

namespace App\Livewire\Appointments;

use App\Models\Service;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState, WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow: 'book-appointment', key:'select-service')]
class ServiceSelection extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public ?int $service_id = null;

    /**
     * Select a service and continue to next step.
     *
     * @param int $serviceId
     */
    public function selectService(int $service_id): void
    {
        // Store service ID in workflow state
        $this->service_id = $service_id;

        // Continue to next step
        $this->continue();
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
