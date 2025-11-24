<?php

namespace App\Livewire\Appointments;

use App\Models\Appointment;
use Livewire\Component;

class ViewAppointments extends Component
{
    public function render()
    {
        return view('livewire.appointments.view-appointments', [
            'appointments' => Appointment::orderByDesc('created_at')->paginate(5),
        ]);
    }
}
