<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class TestMfaComponent extends Component
{
    public function render()
    {
        return view('livewire.auth.test-mfa-component')->layout('layouts.guest');
    }
}
