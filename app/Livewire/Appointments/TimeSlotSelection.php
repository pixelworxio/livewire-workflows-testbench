<?php

namespace App\Livewire\Appointments;

use Carbon\Carbon;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class TimeSlotSelection extends Component
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
     * Regular properties (without attribute) are NOT persisted.
     */
    public string $selectedDate = '';
    public ?string $selectedTime = null;
    public array $availableTimeSlots = [];

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'selectedDate' => 'required|date|after_or_equal:today',
            'selectedTime' => 'required',
        ];
    }

    /**
     * Mount component and set default date.
     */
    public function mount(): void
    {
        // Set default date to tomorrow
        $this->selectedDate = Carbon::tomorrow()->format('Y-m-d');
        $this->generateTimeSlots();
    }

    /**
     * Called when date is updated.
     */
    public function updatedSelectedDate(): void
    {
        $this->selectedTime = null;
        $this->generateTimeSlots();
    }

    /**
     * Generate available time slots for the selected date.
     */
    protected function generateTimeSlots(): void
    {
        $this->availableTimeSlots = [];

        if (!$this->selectedDate) {
            return;
        }

        // Generate time slots from 9 AM to 5 PM (every 30 minutes)
        $date = Carbon::parse($this->selectedDate);
        $startTime = $date->copy()->setTime(9, 0);
        $endTime = $date->copy()->setTime(17, 0);

        while ($startTime < $endTime) {
            // Only show future time slots if date is today
            if ($date->isToday() && $startTime <= Carbon::now()) {
                $startTime->addMinutes(30);
                continue;
            }

            $this->availableTimeSlots[] = $startTime->format('H:i');
            $startTime->addMinutes(30);
        }
    }

    /**
     * Select a time slot and continue to next step.
     */
    public function confirmTimeSlot(): void
    {
        // Validate input
        $this->validate();

        // Combine date and time
        $this->scheduledAt = Carbon::parse($this->selectedDate . ' ' . $this->selectedTime)->toDateTimeString();

        // Store in session for guard checks
        session()->put('appointment_scheduled_at', $this->scheduledAt);

        // Continue to next step
        $this->continue('book-appointment');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        // Clear current step data
        session()->forget('appointment_scheduled_at');
        $this->scheduledAt = null;

        $this->back('book-appointment', 'select-time');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.appointments.time-slot-selection', [
            'serviceId' => $this->serviceId,
            'providerId' => $this->providerId,
            'scheduledAt' => $this->scheduledAt,
        ])->layout('layouts.app');
    }
}
