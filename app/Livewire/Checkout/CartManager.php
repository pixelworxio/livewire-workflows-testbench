<?php

namespace App\Livewire\Checkout;

use App\Livewire\Traits\HasAddress;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class CartManager extends Component
{
    use HasAddress;
    use InteractsWithWorkflows;

    #[WorkflowState(namespace: 'checkout.cart')]
    public array $cart_items = [];

    #[WorkflowState(namespace: 'checkout.cart')]
    public float $cart_total = 0;

    #[WorkflowState(namespace: 'checkout.shipping')]
    public array $shipping_address = [];

    #[WorkflowState(namespace: 'checkout.billing')]
    public array $billing_address = [];

    public function mount(): void
    {
        $this->workflowName = 'checkout';
    }

    #[Computed]
    public function shippingAddressIsFilled(): bool
    {
        return $this->addressIsFilled($this->shipping_address);
    }

    #[Computed]
    public function billingAddressIsFilled(): bool
    {
        return $this->addressIsFilled($this->billing_address);
    }

    public function render()
    {
        return view('livewire.checkout.cart-manager');
    }
}
