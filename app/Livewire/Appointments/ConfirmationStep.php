<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use App\Models\Provider;
use App\Models\Service;
use Carbon\Carbon;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class ConfirmationStep extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public ?int $serviceId = null;

    #[WorkflowState]
    public ?int $providerId = null;

    #[WorkflowState]
    public ?string $scheduledAt = null;

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
     * Mount component and load related data.
     */
    public function mount(): void
    {
        // Load service and provider for display
        if ($this->serviceId) {
            $this->service = Service::find($this->serviceId);
        }

        if ($this->providerId) {
            $this->provider = Provider::find($this->providerId);
        }
    }

    /**
     * Create the appointment and complete the workflow.
     */
    public function confirmAppointment(): void
    {
        // Create the appointment record
        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'service_id' => $this->serviceId,
            'provider_id' => $this->providerId,
            'scheduled_at' => $this->scheduledAt,
            'status' => 'scheduled',
            'notes' => $this->notes,
        ]);

        // Clear workflow session data
        session()->forget([
            'appointment_service_id',
            'appointment_provider_id',
            'appointment_scheduled_at',
        ]);

        // Store appointment ID for confirmation page
        session()->flash('appointment_id', $appointment->id);
        session()->flash('appointment_success', 'Your appointment has been successfully scheduled!');

        // Complete workflow (redirect to finish route)
        $this->finish('book-appointment');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->back('book-appointment', 'confirm-appointment');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.appointments.confirmation-step', [
            'scheduledDateTime' => $this->scheduledAt ? Carbon::parse($this->scheduledAt) : null,
        ])->layout('layouts.app');
    }
}
