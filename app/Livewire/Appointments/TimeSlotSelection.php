<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use Carbon\Carbon;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowStep;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow: 'book-appointment', key:'select-time')]
class TimeSlotSelection extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public ?string $scheduled_at = null;

    #[WorkflowState]
    public ?string $selected_time = null;

    /**
     * Regular properties (without attribute) are NOT persisted.
     */
    public string $selected_date = '';
    public array $available_time_slots = [];

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'selected_date' => 'required|date|after_or_equal:today',
            'selected_time' => 'required',
        ];
    }

    /**
     * Mount component and set default date.
     */
    public function mount(): void
    {
        // Set default date to tomorrow
        $this->selected_date = Carbon::tomorrow()->format('Y-m-d');
        $this->generateTimeSlots();
    }

    /**
     * Called when date is updated.
     */
    public function updatedSelectedDate(): void
    {
        $this->selected_time = null;
        $this->generateTimeSlots();
    }

    /**
     * Generate available time slots for the selected date.
     */
    protected function generateTimeSlots(): void
    {
        $this->available_time_slots = [];

        if (!$this->selected_date) {
            return;
        }

        // Generate time slots from 9 AM to 5 PM (every 30 minutes)
        $date = Carbon::parse($this->selected_date);
        $start_time = $date->copy()->setTime(9, 0);
        $end_time = $date->copy()->setTime(17, 0);

        while ($start_time < $end_time) {
            // Only show future time slots if date is today
            if ($date->isToday() && $start_time <= Carbon::now()) {
                $start_time->addMinutes(30);
                continue;
            }

            $existing_appointment = Appointment::where('scheduled_at', $start_time)->exists();

            if (! $existing_appointment) {
                $this->available_time_slots[] = $start_time->format('H:i');
            }

            $start_time->addMinutes(30);
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
        $this->scheduled_at = Carbon::parse($this->selected_date . ' ' . $this->selected_time)->toDateTimeString();

        // Continue to next step
        $this->continue('book-appointment');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        // Clear current step data
        $this->selected_time = null;
        $this->scheduled_at = null;

        $this->back('book-appointment', 'select-time');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.appointments.time-slot-selection')->layout('layouts.app');
    }
}
