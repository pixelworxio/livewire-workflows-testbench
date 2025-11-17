<?php

namespace App\Livewire\Checkout;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class ConfirmationStep extends Component
{
    use InteractsWithWorkflows;

    /**
     * Properties with #[WorkflowState] are persisted across steps.
     */
    #[WorkflowState]
    public array $cartItems = [];

    #[WorkflowState]
    public float $cartTotal = 0.0;

    /**
     * Order summary data.
     */
    public array $shippingAddress = [];
    public array $billingAddress = [];
    public string $paymentMethod = '';

    /**
     * Mount component and load order summary.
     */
    public function mount(): void
    {
        // Load addresses and payment method from session
        $this->shippingAddress = session('checkout_shipping_address', []);
        $this->billingAddress = session('checkout_billing_address', []);
        $this->paymentMethod = session('checkout_payment_method', '');
    }

    /**
     * Create order and complete workflow.
     */
    public function placeOrder(): void
    {
        // Validate we have all required data
        if (empty($this->cartItems) || empty($this->shippingAddress) ||
            empty($this->billingAddress) || empty($this->paymentMethod)) {
            $this->addError('order', 'Missing required order information. Please go back and complete all steps.');
            return;
        }

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'total' => $this->cartTotal,
            'status' => 'pending',
            'shipping_address' => $this->shippingAddress,
            'billing_address' => $this->billingAddress,
            'payment_method' => $this->paymentMethod,
        ]);

        // Create order items
        foreach ($this->cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Clear cart items from database
        $sessionId = session()->getId();
        $userId = auth()->id();

        \App\Models\CartItem::query()
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('session_id', $sessionId))
            ->delete();

        // Clear checkout session data
        session()->forget([
            'checkout_cart_reviewed',
            'checkout_shipping_address',
            'checkout_billing_address',
            'checkout_payment_method',
        ]);

        // Store order ID for confirmation page
        session()->flash('order_id', $order->id);
        session()->flash('order_number', $order->order_number);
        session()->flash('order_success', 'Your order has been successfully placed!');

        // Complete workflow (redirect to finish route)
        $this->finish('checkout');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->back('checkout');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.checkout.confirmation-step')
            ->layout('layouts.app');
    }
}
