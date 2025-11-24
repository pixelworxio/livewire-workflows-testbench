<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use App\Models\Provider;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowStep;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow: 'book-appointment', key:'confirm-appointment')]
class ConfirmationStep extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public ?int $service_id = null;

    #[WorkflowState]
    public ?int $provider_id = null;

    #[WorkflowState]
    public ?string $scheduled_at = null;

    #[WorkflowState]
    public bool $confirmed = false;

    /**
     * Additional notes for the appointment.
     */
    public string $notes = '';

    /**
     * Loaded models for display.
     */
    public ?Service $service = null;
    public ?Provider $provider = null;

    /**
     * Create the appointment and complete the workflow.
     */
    public function confirmAppointment(): void
    {
        // Create the appointment record
        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'service_id' => $this->service_id,
            'provider_id' => $this->provider_id,
            'scheduled_at' => $this->scheduled_at,
            'status' => 'scheduled',
            'notes' => $this->notes,
        ]);

        $this->confirmed = true;

        // Store appointment ID for confirmation page
        session()->put('appointment_id', $appointment->id);
        session()->put('appointment_success', 'Your appointment has been successfully scheduled!');

        // Complete workflow (redirect to finish route)
        $this->continue();
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->confirmed = false;

        $this->back();
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        // Load service and provider for display
        if ($this->service_id) {
            $this->service = Service::find($this->service_id);
        }

        if ($this->provider_id) {
            $this->provider = Provider::find($this->provider_id);
        }

        return view('livewire.appointments.confirmation-step', [
            'scheduled_date_time' => $this->scheduled_at ? Carbon::parse($this->scheduled_at) : null,
        ])->layout('layouts.app');
    }
}
