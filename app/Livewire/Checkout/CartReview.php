<?php

namespace App\Livewire\Checkout;

use App\Livewire\Traits\CheckoutProperties;
use App\Models\CartItem;
use Illuminate\Support\Str;
use Livewire\Component;
use Pixelworxio\LivewireWorkflows\Attributes\{WorkflowState,WorkflowStep};
use Pixelworxio\LivewireWorkflows\Livewire\Concerns\InteractsWithWorkflows;

#[WorkflowStep(flow:'checkout', key:'cart-review', middleware: ['web', 'auth'])]
class CartReview extends Component
{
    use CheckoutProperties;
    use InteractsWithWorkflows;

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

        $this->cart_items = $items->map(function ($item) {
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
        $this->cart_total = collect($this->cart_items)->sum('subtotal');
    }

    /**
     * Proceed to shipping step.
     */
    public function proceedToShipping(): void
    {
        // Validate cart is not empty
        if (empty($this->cart_items)) {
            $this->addError('cart', 'Your cart is empty. Please add items before proceeding.');
            return;
        }

        $this->cart_confirmed = true;

        // Continue to next step
        $this->continue();
    }

    public function addDemoProducts(): void
    {
        $user = auth()->user();
        CartItem::where('user_id', $user->id)->delete();

        // Create sample cart items
        $products = [
            [
                'product_name' => 'Premium Wireless Headphones',
                'quantity' => 1,
                'price' => 149.99,
            ],
            [
                'product_name' => 'Smart Watch Series X',
                'quantity' => 2,
                'price' => 299.99,
            ],
            [
                'product_name' => 'USB-C Charging Cable (3-Pack)',
                'quantity' => 1,
                'price' => 19.99,
            ],
            [
                'product_name' => 'Portable Power Bank 20000mAh',
                'quantity' => 1,
                'price' => 45.99,
            ],
            [
                'product_name' => 'Bluetooth Speaker - Waterproof',
                'quantity' => 3,
                'price' => 79.99,
            ],
        ];

        foreach ($products as $product) {
            CartItem::create([
                'user_id' => $user->id,
                'session_id' => session()->id() ?? Str::uuid(),
                'product_name' => $product['product_name'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }
    }

    /**
     * Render the component view.
     */
    public function render()
    {
        $this->loadCartItems();

        return view('livewire.checkout.cart-review')
            ->layout('layouts.app');
    }
}
