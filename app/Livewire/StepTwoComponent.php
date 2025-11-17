<?php

namespace App\Livewire;

use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class StepTwoComponent extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $name;

    public bool $exiting = false;

    public function goBack(): void
    {
        session()->flush();
        $this->back('test-flow', 'step-two');
    }

    public function goToNextStep(): void
    {
        $this->exiting = true;

        session()->put('testProperty2', 'test-value2');

        $this->continue('test-flow');
    }

    public function render()
    {
        return view('livewire.step-two-component')->layout('layouts.guest');
    }
}
