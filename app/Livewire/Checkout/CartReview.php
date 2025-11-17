<?php

namespace App\Livewire\Checkout;

use App\Models\CartItem;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\WorkflowState;
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

class CartReview extends Component
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
     * Mount component and load cart items.
     */
    public function mount(): void
    {
        $this->loadCartItems();
    }

    /**
     * Load cart items from database.
     */
    public function loadCartItems(): void
    {
        $sessionId = session()->getId();
        $userId = auth()->id();

        $items = CartItem::query()
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(!$userId, fn($q) => $q->where('session_id', $sessionId))
            ->get();

        $this->cartItems = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'product_name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => (float) $item->price,
                'subtotal' => (float) $item->subtotal,
            ];
        })->toArray();

        $this->calculateTotal();
    }

    /**
     * Update item quantity.
     */
    public function updateQuantity(int $itemId, int $quantity): void
    {
        if ($quantity < 1) {
            $this->removeItem($itemId);
            return;
        }

        $item = CartItem::find($itemId);
        if ($item) {
            $item->update(['quantity' => $quantity]);
            $this->loadCartItems();
        }
    }

    /**
     * Remove item from cart.
     */
    public function removeItem(int $itemId): void
    {
        CartItem::destroy($itemId);
        $this->loadCartItems();
    }

    /**
     * Calculate cart total.
     */
    private function calculateTotal(): void
    {
        $this->cartTotal = collect($this->cartItems)->sum('subtotal');
    }

    /**
     * Proceed to shipping step.
     */
    public function proceedToShipping(): void
    {
        // Validate cart is not empty
        if (empty($this->cartItems)) {
            $this->addError('cart', 'Your cart is empty. Please add items before proceeding.');
            return;
        }

        // Mark cart as reviewed
        session()->put('checkout_cart_reviewed', true);

        // Continue to next step
        $this->continue('checkout');
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        return view('livewire.checkout.cart-review')
            ->layout('layouts.app');
    }
}
