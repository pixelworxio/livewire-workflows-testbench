<div class="py-12">
    <div class="relative w-full max-w-7xl mx-auto">

        <!-- Shipping Address Form -->
        <div>
            <div class="w-full flex justify-between items-start gap-8">
                <div class="relative w-full xl:w-2/3">
                    <div class="-z-0 absolute inset-x-12 inset-y-14 mx-auto top-0 bg-gradient-to-br from-blue-500/30 to-pink-600/20 dark:from-indigo-600 dark:to-pink-600 blur-3xl"></div>
                    <x-custom-card title="checkout" class="z-20">
                        <x-slot:tableHeader>
                            <div class="p-4">
                                <div>
                                    <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                                    <p class="mb-2 text-zinc-600 dark:text-zinc-400">Step 5 of 5: Review & Confirm Order</p>
                                </div>

                                @if($errors->has('order'))
                                    <div class="my-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                        <p class="text-red-800">{{ $errors->first('order') }}</p>
                                    </div>
                                @endif
                            </div>
                        </x-slot:tableHeader>

                        <div class="p-2 space-y-4">
                            <!-- Order Summary -->
                            <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-transparent dark:to-transparent border border-blue-200 dark:border-transparent rounded-lg p-2">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Order Summary</h3>

                                <!-- Cart Items -->
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-800 dark:text-white/80 mb-2 border-b border-transparent dark:border-white/30 pb-2">{{ collect($cart_items)->sum('quantity') }} Items</h4>
                                    <div class="space-y-2">
                                        @foreach($cart_items as $item)
                                            <div wire:key="confirm-item-{{ $item['id'] }}"
                                                 class="flex justify-between text-base {{ $loop->even ? 'bg-black/5 dark:bg-white/5' : '' }} py-1 px-2 rounded-md"
                                            >
                                                <span class="text-gray-700 dark:text-white">
                                                    {{ $item['product_name'] }} <span class="text-gray-700 dark:text-white/70">(x{{ $item['quantity'] }})</span>
                                                </span>
                                                <span class="font-medium text-gray-900 dark:text-white">
                                                    ${{ number_format($item['subtotal'], 2) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="border-t border-blue-200 dark:border-white/30 pt-3 mt-3">
                                    <div class="flex justify-between text-base font-bold text-gray-900 dark:text-white">
                                        <span>Total:</span>
                                        <span>${{ number_format($cart_total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Important Information -->
                            <div class="bg-yellow-50 dark:bg-yellow-950/20 border border-yellow-200 dark:border-yellow-800/50 rounded-lg p-4 mb-6">
                                <h4 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">Important Information</h4>
                                <ul class="text-sm text-yellow-700 dark:text-yellow-400 space-y-1 list-disc list-inside">
                                    <li>By placing this order, you agree to our terms and conditions</li>
                                    <li>You will receive an order confirmation email shortly</li>
                                    <li>Estimated delivery: 3-5 business days</li>
                                    <li>For questions, contact support@example.com</li>
                                </ul>
                            </div>
                        </div>

                    </x-custom-card>

                    <div class="mt-9 relative z-10">
                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center pt-6">
                            <button type="button"
                                    wire:click="goBack"
                                    class="inline-flex items-center px-4 py-2 border border-zinc-800 dark:border-white rounded-md font-semibold text-xs text-zinc-900 dark:text-white uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-zinc-100/10"
                            >Back to Payment</button>

                            <x-primary-button wire:click="placeOrder" type="button">
                                Place Order
                            </x-primary-button>
                        </div>
                    </div>
                </div>

                <div class="w-full xl:w-1/3">
                    @include('livewire.checkout.cart-manager', ['hide_cart' => true])
                </div>
            </div>

        </div>
    </div>
</div>
