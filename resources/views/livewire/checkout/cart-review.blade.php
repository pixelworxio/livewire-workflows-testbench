<div class="py-12">
    <div class="relative w-full max-w-7xl mx-auto">
        <div class="-z-0 absolute inset-x-8 inset-y-24 mx-auto top-0 bg-gradient-to-br from-blue-500/30 to-pink-600/20 dark:from-indigo-600 dark:to-pink-600 blur-3xl transition-all duration-200 ease-in-out"></div>

        <x-custom-card title="checkout" class="z-20">
            <x-slot:tableHeader>
                <div class="p-4">
                    <div class="w-full flex justify-between items-start gap-6">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                            <p class="mb-2 text-zinc-600 dark:text-zinc-400">Step 1 of 5: Review Your Cart</p>
                        </div>

                        <button
                            wire:click.prevent="addDemoProducts"
                            type="button"
                            class="opacity-60 hover:opacity-100 hover:underline underline-offset-4"
                        >Add Products to Cart (Demo)</button>
                    </div>

                    @if($errors->has('cart'))
                        <div class="bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/40 rounded-lg p-4 my-6">
                            <p class="text-red-800 dark:text-red-300">{{ $errors->first('cart') }}</p>
                        </div>
                    @endif
                </div>
            </x-slot:tableHeader>

            @if(empty($cart_items))
                <div class="bg-yellow-50 dark:bg-yellow-950/20 border border-yellow-200 dark:border-yellow-800/30 rounded-lg p-6">
                    <p class="text-yellow-800 dark:text-yellow-300">Your cart is empty. Please add items to your cart before proceeding to checkout.</p>
                </div>
            @else
                <!-- Cart Items Table -->
                <div class="">
                    <div class="w-full grid grid-cols-6 bg-zinc-200 dark:bg-neutral-950 rounded-lg overflow-clip">
                        <div class="col-span-2 text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Product</div>
                        <div class="text-center py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Price</div>
                        <div class="text-center py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Quantity</div>
                        <div class="text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Action</div>
                        <div class="text-right py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Subtotal</div>
                    </div>

                    <div class="mt-2">
                        @foreach($cart_items as $item)
                            <div class="grid grid-cols-6 items-center {{ $loop->even ? 'bg-black/10 dark:bg-black/30' : '' }} hover:bg-zinc-50 dark:hover:bg-white/[2%] rounded-xl" wire:key="cart-item-{{ $item['id'] }}">
                                <div class="p-4 col-span-2 flex items-center">
                                    <p class="font-medium text-zinc-900 dark:text-white">{{ $item['product_name'] }}</p>
                                </div>
                                <div class="p-4 text-center text-zinc-700 dark:text-white/70">
                                    ${{ number_format($item['price'], 2) }}
                                </div>
                                <div class="h-full py-2 px-4">
                                    <div class="w-auto h-full flex items-stretch justify-evenly gap-2 border border-zinc-300 dark:border-white/10 rounded-lg">
                                        <button
                                            wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                            class="w-full h-auto px-2 py-1 bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded text-zinc-700 dark:text-white/70"
                                        >
                                            -
                                        </button>
                                        <span class="w-full h-auto flex items-center justify-center px-4 p-1">{{ $item['quantity'] }}</span>
                                        <button
                                            wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                            class="w-full h-auto px-2 py-1 bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded text-zinc-700 dark:text-white/70"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>

                                <div class="p-4 text-left">
                                    <button
                                        wire:click="removeItem({{ $item['id'] }})"
                                        class="text-red-600 hover:text-red-800 dark:hover:text-red-500 font-medium"
                                    >
                                        Remove
                                    </button>
                                </div>

                                <div class="p-4 text-right font-semibold text-zinc-900 dark:text-white">
                                    ${{ number_format($item['subtotal'], 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <x-slot:footer>
                        <div class="mt-2 w-full font-bold text-zinc-900 dark:text-white text-lg p-4">
                            <div class="w-full grid grid-cols-5">
                                <div class="col-span-2">{{ count($cart_items) }} Items in the cart</div>
                                <div class="col-span-2 text-center transform -translate-x-4">{{ collect($cart_items)->sum('quantity') }} total items</div>
                                <div class="text-right">Total: ${{ number_format($cart_total, 2) }}</div>
                            </div>
                        </div>
                    </x-slot:footer>

                </div>
            @endif
        </x-custom-card>

        <div class="mt-9 relative z-10">
            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center pt-6">
                <a href="{{ route('index') }}"
                   class="inline-flex items-center px-4 py-2 border border-zinc-800 dark:border-white rounded-md font-semibold text-xs text-zinc-900 dark:text-white uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-zinc-100/10"
                >Continue Shopping</a>

                @if(!empty($cart_items))
                    <x-primary-button wire:click="proceedToShipping">
                        Proceed to Shipping
                    </x-primary-button>
                @endif
            </div>

        </div>
    </div>
</div>
