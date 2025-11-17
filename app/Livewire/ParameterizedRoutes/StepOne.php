<?php

namespace App\Livewire\ParameterizedRoutes;

use App\Models\TestModel;
use App\Models\User;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class StepOne extends Component
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
        session()->put('test-continue-one', $this->test);

        $this->continue('parameterized-routes');
    }

    public function render()
    {
        return view('livewire.parameterized-routes.step-one')->layout('layouts.guest');
    }
}
