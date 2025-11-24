@php
    $hide_cart = (isset($hide_cart) && $hide_cart) ?? false;
@endphp

<div class="z-0 motion-opacity-in-0 motion-blur-in-md motion-duration-300">

    @if(empty($cart_items))
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
            <p class="text-yellow-800">Your cart is empty. Please add items to your cart before proceeding to checkout.</p>
        </div>
    @elseif(!$hide_cart)
        <h3 class="mb-3 text-xl font-bold dark:text-white px-2 opacity-50">Cart</h3>

        <!-- Cart Items Table -->
        <div class="dark:bg-white/10 backdrop-filter backdrop-blur border border-white/20 p-2 rounded-2xl">
            <div class="w-full grid grid-cols-3 bg-zinc-200 dark:bg-neutral-950 rounded-lg overflow-clip text-sm">
                <div class="col-span-2 text-left py-1 px-2 font-semibold text-zinc-700 dark:text-white/70">(Qty) Product</div>
                <div class="text-right py-1 px-2 font-semibold text-zinc-700 dark:text-white/70">Subtotal</div>
            </div>

            <div class="mt-2">
                @foreach($cart_items as $item)
                    <div class="grid grid-cols-3 items-center {{ $loop->even ? 'bg-black/10 dark:bg-black/30' : '' }} hover:bg-zinc-50 dark:hover:bg-white/[2%] py-0.5 rounded-xl" wire:key="cart-item-{{ $item['id'] }}">
                        <div class="pl-2 col-span-2 flex items-center text-sm">
                            <p class="font-medium text-zinc-900 dark:text-white">(x{{ $item['quantity'] }}) {{ $item['product_name'] }}</p>
                        </div>

                        <div class="p-2 text-right font-semibold text-zinc-900 dark:text-white text-sm">
                            ${{ number_format($item['subtotal'], 2) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-2 w-full font-bold text-zinc-900 dark:text-white text-base py-2 px-4">
            <div class="w-full flex justify-between items-baseline leading-6">
                <div class="col-span-2 text-left">{{ collect($cart_items)->sum('quantity') }} items</div>
                <div class="text-right"><span class="opacity-50">Total:</span> <span class="text-lg">${{ number_format($cart_total, 2) }}</span></div>
            </div>
        </div>
    @endif

    @if(isset($shipping_address) && $this->addressIsFilled($shipping_address))
        <div class="mt-9 dark:text-white overflow-clip -motion-translate-y-in-0 motion-opacity-in-0">
            <h3 class="mb-3 text-xl font-bold dark:text-white px-2 opacity-50">Shipping Address</h3>
            <div class="px-2">
                <div class="font-semibold">{{ $shipping_address['full_name'] ?? '' }}</div>
                <div>{{ $shipping_address['address_line_1'] ?? '' }}{{ isset($shipping_address['address_line_2']) ? ', '.$shipping_address['address_line_2'] : '' }}</div>
                <div>{{ $shipping_address['city'] }}{{ (!empty($shipping_address['city']) && !empty($shipping_address['state'])) ? (', '.$shipping_address['state']) : ($shipping_address['state'] ?? '') }} {{ $shipping_address['zip_code'] }}</div>
            </div>
        </div>
    @endif

    @if(isset($billing_address) && $this->addressIsFilled($billing_address))
        <div class="mt-9 dark:text-white overflow-clip -motion-translate-y-in-0 motion-opacity-in-0">
            <h3 class="mb-3 text-xl font-bold dark:text-white px-2 opacity-50">Billing Address</h3>
            <div class="px-2">
                <div class="font-semibold">{{ $billing_address['full_name'] ?? '' }}</div>
                <div>{{ $billing_address['address_line_1'] ?? '' }}{{ isset($billing_address['address_line_2']) ? ', '.$billing_address['address_line_2'] : '' }}</div>
                <div>{{ $billing_address['city'] }}{{ (!empty($billing_address['city']) && !empty($billing_address['state'])) ? (', '.$billing_address['state']) : ($billing_address['state'] ?? '') }} {{ $billing_address['zip_code'] }}</div>
            </div>
        </div>
    @endif

    @if(! empty($selected_payment_method))
        <div class="mt-9 dark:text-white overflow-clip -motion-translate-y-in-0 motion-opacity-in-0">
            <h3 class="mb-3 text-xl font-bold dark:text-white px-2 opacity-50">Payment Method</h3>
            <div class="px-2">{{ ucwords(\Illuminate\Support\Str::replace('_',' ',$selected_payment_method)) }}</div>
        </div>
    @endif
</div>
