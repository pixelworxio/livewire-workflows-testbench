<?php

namespace App\Livewire\Login;

use App\Models\PaymentMethod;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class PaymentMethodStep extends Component
{
    use InteractsWithWorkflows;

    #[WorkflowState]
    public string $paymentType = 'credit_card';

    #[WorkflowState]
    public string $lastFour = '';

    /**
     * Validation rules for this step.
     */
    protected function rules(): array
    {
        return [
            'paymentType' => ['required', 'string', 'in:credit_card,debit_card,bank_account'],
            'lastFour' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
        ];
    }

    /**
     * Add payment method and continue to the next step.
     */
    public function addPaymentMethod(): void
    {
        $this->validate();

        $user = auth()->user();

        // Create the payment method
        PaymentMethod::create([
            'user_id' => $user->id,
            'type' => $this->paymentType,
            'last_four' => $this->lastFour,
            'is_valid' => true,
        ]);

        // Continue to the next step (or finish the workflow)
        $this->continue('login');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.login.payment-method-step')
            ->layout('layouts.app');
    }
}
