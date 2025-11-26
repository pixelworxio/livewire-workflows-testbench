<?php

namespace App\Livewire\Checkout;

use App\Livewire\Traits\CheckoutProperties;
use App\Livewire\Traits\HasAddress;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'checkout', key:'payment', middleware: ['web', 'auth'])]
class PaymentStep extends Component
{
    use CheckoutProperties;
    use HasAddress;
    use InteractsWithWorkflows;

    // Available payment methods
    public array $payment_methods = [
        'credit_card' => 'Credit Card',
        'debit_card' => 'Debit Card',
        'paypal' => 'PayPal',
        'stripe' => 'Stripe',
        'bank_transfer' => 'Bank Transfer',
    ];

    public function savePaymentMethod()
    {
        $this->validate([
            'selected_payment_method' => 'required|string|in:credit_card,debit_card,paypal,stripe,bank_transfer',
        ]);

        $this->confirmed_payment_method = true;

        $this->continue('checkout');
    }

    public function goBack(): void
    {
        $this->confirmed_payment_method = false; // for demo purposes

        $this->back('checkout', 'payment');
    }

    public function render()
    {
        return view('livewire.checkout.payment-step');
    }
}
