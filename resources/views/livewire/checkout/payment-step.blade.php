<div class="py-12">
    <div class="relative w-full max-w-7xl mx-auto">

        <!-- Shipping Address Form -->
        <form wire:submit.prevent="savePaymentMethod">

            @csrf

            <div class="w-full flex justify-between items-start gap-8">
                <div class="relative w-full xl:w-2/3">
                    <div class="-z-0 absolute inset-x-12 inset-y-14 mx-auto top-0 bg-gradient-to-br from-blue-500/30 to-pink-600/20 dark:from-indigo-600 dark:to-pink-600 blur-3xl"></div>
                    <x-custom-card title="checkout" class="z-20">
                        <x-slot:tableHeader>
                            <div class="p-4">
                                <div>
                                    <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                                    <p class="mb-2 text-zinc-600 dark:text-zinc-400">Step 4 of 5: Payment Method</p>
                                </div>
                            </div>
                        </x-slot:tableHeader>

                        <div class="p-4 pb-8 space-y-4">
                            <div class="">
                                <x-input-label for="selected_payment_method" value="Select Payment Method" class="mb-4" />

                                <div class="space-y-3">
                                    @foreach($payment_methods as $key => $label)
                                        <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition {{ ($key === $selected_payment_method) ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950' : 'border-zinc-200 dark:border-zinc-700 hover:border-indigo-300 dark:hover:border-indigo-600' }} transition-all duration-150 ease-in-out">
                                            <input
                                                type="radio"
                                                wire:model.live="selected_payment_method"
                                                name="selected_payment_method"
                                                value="{{ $key }}"
                                                class="text-indigo-600 focus:ring-indigo-500"
                                                required
                                            />
                                            <div class="ml-3 flex-1">
                                                <span class="font-semibold text-zinc-900 dark:text-white">{{ $label }}</span>

                                                @if($key === 'credit_card')
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Visa, MasterCard, American Express</p>
                                                @elseif($key === 'debit_card')
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Direct debit from your bank account</p>
                                                @elseif($key === 'paypal')
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Secure payment via PayPal</p>
                                                @elseif($key === 'stripe')
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Fast and secure with Stripe</p>
                                                @elseif($key === 'bank_transfer')
                                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Direct bank transfer (may take 2-3 days)</p>
                                                @endif
                                            </div>

                                            <!-- Payment Method Icon -->
                                            <div class="ml-3">
                                                @if($key === 'credit_card' || $key === 'debit_card')
                                                    <svg class="w-8 h-8 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                    </svg>
                                                @elseif($key === 'bank_transfer')
                                                    <svg class="w-8 h-8 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-8 h-8 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                                <x-input-error :messages="$errors->get('selected_payment_method')" class="mt-2" />
                            </div>

                            <!-- Payment Security Notice -->
                            <div class="bg-green-50 dark:bg-green-950/25 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm text-green-800 dark:text-green-300 font-semibold">Secure Payment</p>
                                        <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                                            Your payment information is encrypted and secure. We never store your payment details.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </x-custom-card>

                    <div class="mt-9 relative z-10">
                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center pt-6">
                            <button type="button"
                                    wire:click="goBack"
                                    class="inline-flex items-center px-4 py-2 border border-zinc-800 dark:border-white rounded-md font-semibold text-xs text-zinc-900 dark:text-white uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-zinc-100/10"
                            >Back to Billing</button>

                            <x-primary-button type="submit">
                                Continue to Review
                            </x-primary-button>
                        </div>
                    </div>
                </div>

                <div class="w-full xl:w-1/3">
                    @include('livewire.checkout.cart-manager')
                </div>
            </div>

        </form>
    </div>
</div>
