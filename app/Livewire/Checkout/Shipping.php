<?php

namespace App\Livewire\Checkout;

use App\Livewire\Traits\CheckoutProperties;
use App\Livewire\Traits\HasAddress;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'checkout', key:'shipping', middleware: ['web', 'auth'])]
class Shipping extends Component
{
    use CheckoutProperties;
    use HasAddress;
    use InteractsWithWorkflows;

    #[WorkflowState(namespace: 'checkout.cart')]
    public array $cart_items = [];

    #[WorkflowState(namespace: 'checkout.cart')]
    public float $cart_total = 0;

    #[WorkflowState(namespace: 'checkout.shipping')]
    public array $shipping_address = [
            'full_name' => '',
            'address_line_1' => '',
            'address_line_2' => '',
            'city' => '',
            'state' => '',
            'zip_code' => '',
            'country' => 'US',
        ];

    public function submitAddress(): void
    {
        $this->validate([
            'shipping_address.full_name' => 'required|string|max:255',
            'shipping_address.address_line_1' => 'required|string|max:255',
            'shipping_address.address_line_2' => 'nullable|string|max:255',
            'shipping_address.city' => 'required|string|max:100',
            'shipping_address.state' => 'required|string|max:50',
            'shipping_address.zip_code' => 'required|string|max:20',
            'shipping_address.country' => 'required|string|max:2',
        ]);

        $this->continue();
    }

    public function goBack(): void
    {
        workflowState('checkout')
            ->forRequest(request())
            ->set('checkout.cart.cartConfirmed', false);

        $this->back();
    }

    public function fillShippingAddress(): void
    {
        $this->shipping_address = [
            'full_name' => 'Test Buyer',
            'address_line_1' => '12345 Shipping Dr.',
            'address_line_2' => '#2',
            'city' => 'Shipping City',
            'state' => 'FL',
            'zip_code' => '12345',
            'country' => 'US',
        ];
    }

    public function clearShippingAddress(): void
    {
        $this->reset('shipping_address');
    }

    #[Computed]
    public function shippingAddressIsFilled(): bool
    {
        return $this->addressIsFilled($this->shipping_address);
    }

    public function render()
    {
        return view('livewire.checkout.shipping');
    }
}
