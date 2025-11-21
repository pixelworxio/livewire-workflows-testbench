<?php

namespace App\Livewire\Checkout;

use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class BillingStep extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public array $billingAddress = [
        'full_name' => '',
        'address_line_1' => '',
        'address_line_2' => '',
        'city' => '',
        'state' => '',
        'zip_code' => '',
        'country' => 'US',
    ];

    /**
     * Same as shipping checkbox.
     */
    public bool $sameAsShipping = false;

    /**
     * Mount component.
     */
    public function mount(): void
    {
        // Pre-populate billing address if already in session
        if (session()->has('checkout_billing_address')) {
            $this->billingAddress = session('checkout_billing_address');
        }
    }

    /**
     * Validation rules for billing address.
     */
    protected function rules(): array
    {
        return [
            'billingAddress.full_name' => 'required|string|max:255',
            'billingAddress.address_line_1' => 'required|string|max:255',
            'billingAddress.address_line_2' => 'nullable|string|max:255',
            'billingAddress.city' => 'required|string|max:100',
            'billingAddress.state' => 'required|string|max:50',
            'billingAddress.zip_code' => 'required|string|max:20',
            'billingAddress.country' => 'required|string|max:2',
        ];
    }

    /**
     * Toggle same as shipping.
     */
    public function updatedSameAsShipping($value): void
    {
        if ($value && session()->has('checkout_shipping_address')) {
            $shippingAddress = session('checkout_shipping_address');
            $this->billingAddress = $shippingAddress;
        }
    }

    /**
     * Save billing address and continue.
     */
    public function saveBillingAddress(): void
    {
        // Validate input
        $this->validate();

        // Store billing address in session
        session()->put('checkout_billing_address', $this->billingAddress);

        // Continue to next step
        $this->continue('checkout');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->back('checkout', 'billing');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.checkout.billing-step', [
            'shippingAddress' => session('checkout_shipping_address'),
        ])->layout('layouts.app');
    }
}
