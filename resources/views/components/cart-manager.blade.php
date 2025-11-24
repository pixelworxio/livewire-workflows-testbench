{{--@props([--}}
{{--    'cart_items' => [],--}}
{{--    'cart_total' => 0,--}}
{{--    'shipping_address' => [],--}}
{{--    'billing_address' => [],--}}
{{--    'payment_method' => null,--}}
{{--])--}}

<div id="cartManager"
     x-data="{
         billing_address: $wire.entangle.live($billing_address),
         shipping_address: $wire.entangle.live($shipping_address),
         get isAddressValid(address) {
             const required = ['full_name', 'address_line_1', 'city', 'state', 'zip_code', 'country'];
             return required.every(field => address[field]?.trim());
         }
     }"
     class="z-0 motion-opacity-in-0 motion-blur-in-md motion-duration-300"
>
    @if(empty($cart_items))
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
            <p class="text-yellow-800">Your cart is empty. Please add items to your cart before proceeding to checkout.</p>
        </div>
    @else
        <h3 class="mb-3 text-xl font-bold dark:text-white px-2">Cart</h3>

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
            <div class="w-full grid grid-cols-3">
                <div class="col-span-2 text-left">{{ collect($cart_items)->sum('quantity') }} items</div>
                <div class="text-right"><span class="opacity-50">Total:</span> ${{ number_format($cart_total, 2) }}</div>
            </div>
        </div>
    @endif

    <div x-show="isAddressValid(shipping_address)" class="mt-9 dark:text-white">
        <h3 class="mb-3 text-xl font-bold dark:text-white px-2">Shipping Address</h3>
        <div class="px-2">{{ $shipping_address['address_line_1'] ?? 'missing' }}</div>
    </div>
</div>

