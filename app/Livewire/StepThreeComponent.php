<?php

namespace App\Livewire;

use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class StepThreeComponent extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $name;

    public bool $exiting = false;

    public function goBack(): void
    {
        $this->back('test-flow', 'step-three');
    }

    public function goToNextStep(): void
    {
        $this->exiting = true;

        session()->put('testProperty3', 'test-value3');

        $this->continue('test-flow');
    }

    public function render()
    {
        return view('livewire.step-three-component')->layout('layouts.guest');
    }
}
