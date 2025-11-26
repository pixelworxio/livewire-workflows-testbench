<?php

namespace App\Livewire\Checkout;

use App\Livewire\Traits\{CheckoutProperties,HasAddress};
use App\Models\{Order,OrderItem};
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'checkout', key:'confirmation', middleware: ['web', 'auth'])]
class ConfirmationStep extends Component
{
    use CheckoutProperties;
    use HasAddress;
    use InteractsWithWorkflows;

    /**
     * Create order and complete workflow.
     */
    public function placeOrder(): void
    {
        // Validate we have all required data
        if (
            empty($this->cart_items)
            || !$this->addressIsFilled($this->shipping_address)
            || !$this->addressIsFilled($this->billing_address)
            || empty($this->selected_payment_method)
        ) {
            $this->addError('order', 'Missing required order information. Please go back and complete all steps.');

            return;
        }

        $order_number = 'ORD-' . time() . '-' . rand(1000, 9999);

        // Create order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $order_number,
            'total' => $this->cart_total,
            'status' => 'pending',
            'shipping_address' => $this->shipping_address,
            'billing_address' => $this->billing_address,
            'payment_method' => $this->selected_payment_method,
        ]);

        // Create order items
        foreach ($this->cart_items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Handle state
        $this->order_number = $order_number;
        $this->order_confirmed = true;

        // Clear cart items from database
        $session_id = session()->getId();
        $user_id = auth()->id();

        \App\Models\CartItem::query()
            ->when($user_id, fn($q) => $q->where('user_id', $user_id))
            ->when(!$user_id, fn($q) => $q->where('session_id', $session_id))
            ->delete();

        // Store order ID for confirmation page
        session()->flash('order_id', $order->id);
        session()->flash('order_number', $order->order_number);
        session()->flash('order_success', 'Your order has been successfully placed!');

        // Complete workflow (redirects to finish route if all steps are complete)
        $this->continue('checkout');
    }

    /**
     * Go back to previous step.
     */
    public function goBack(): void
    {
        $this->back('checkout', 'confirmation');
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
