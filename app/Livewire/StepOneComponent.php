<?php

namespace App\Livewire;

use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class StepOneComponent extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $name = '';

    public bool $exiting = false;

    public function goToNextStep(): void
    {
        $this->exiting = true;

        session()->put('testProperty1', 'test-value');

        $this->continue('test-flow');
    }

    public function render()
    {
//        session()->flush();

        $this->name = 'test name';

        return view('livewire.step-one-component')->layout('layouts.guest');
    }
}
