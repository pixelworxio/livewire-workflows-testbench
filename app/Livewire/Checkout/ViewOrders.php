<?php

namespace App\Livewire\Checkout;

use App\Models\Order;
use Livewire\Component;

class ViewOrders extends Component
{
    public int $orders_total = 0;

    public function render()
    {
        return view('livewire.checkout.view-orders', [
            'orders' => Order::with(['user','items'])->orderByDesc('created_at')->paginate(10),
        ]);
    }
}
