<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class TestLoginComponent extends Component
{
    public function render()
    {
        return view('livewire.auth.test-login-component')->layout('layouts.guest');
    }
}
