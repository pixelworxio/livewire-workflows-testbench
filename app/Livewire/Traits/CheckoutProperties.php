<?php

namespace App\Livewire\Traits;

use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;

trait CheckoutProperties
{
    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState(namespace: 'checkout.cart')]
    public array $cart_items = [];

    #[WorkflowState(namespace: 'checkout.cart')]
    public float $cart_total = 0.0;

    #[WorkflowState(namespace: 'checkout.cart')]
    public bool $cart_confirmed = false;

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

    #[WorkflowState(namespace: 'checkout.billing')]
    public array $billing_address = [
        'full_name' => '',
        'address_line_1' => '',
        'address_line_2' => '',
        'city' => '',
        'state' => '',
        'zip_code' => '',
        'country' => 'US',
    ];

    #[WorkflowState(namespace: 'checkout.billing')]
    public bool $same_as_shipping = false;

    #[WorkflowState(namespace: 'checkout.payment')]
    public string $selected_payment_method = '';

    #[WorkflowState(namespace: 'checkout.payment')]
    public bool $confirmed_payment_method = false;

    #[WorkflowState(namespace: 'checkout.order')]
    public string $order_number = '';

    #[WorkflowState(namespace: 'checkout.order')]
    public bool $order_confirmed = false;
}
