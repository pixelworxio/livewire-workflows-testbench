<?php

namespace App\Livewire\ParameterizedRoutes;

use App\Models\TestModel;
use App\Models\User;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class StepThree extends Component
{
    use InteractsWithWorkflows;

    public TestModel $test;
    public User $user;

    public function mount(TestModel $test, User $user)
    {
        $this->test = $test;
        $this->user = $user;
    }

    public function goToNextStep(): void
    {
        session()->forget('test-continue-two');
        session()->forget('test-continue-three');

        $this->back('parameterized-routes', 'second-one'); // should return to step one
    }

    public function render()
    {
        return view('livewire.parameterized-routes.step-three')->layout('layouts.guest');
    }
}
