<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                    <p class="text-gray-600 mb-8">Step 4 of 5: Payment Method</p>

                    <!-- Payment Method Selection Form -->
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf

                        <div class="mb-6">
                            <x-input-label for="payment_method" value="Select Payment Method" class="mb-4" />

                            <div class="space-y-3">
                                @foreach($paymentMethods as $key => $label)
                                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition {{ old('payment_method', $paymentMethod) === $key ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300' }}">
                                        <input
                                            type="radio"
                                            name="payment_method"
                                            value="{{ $key }}"
                                            class="text-indigo-600 focus:ring-indigo-500"
                                            {{ old('payment_method', $paymentMethod) === $key ? 'checked' : '' }}
                                            required
                                        />
                                        <div class="ml-3 flex-1">
                                            <span class="font-semibold text-gray-900">{{ $label }}</span>

                                            @if($key === 'credit_card')
                                                <p class="text-sm text-gray-600 mt-1">Visa, MasterCard, American Express</p>
                                            @elseif($key === 'debit_card')
                                                <p class="text-sm text-gray-600 mt-1">Direct debit from your bank account</p>
                                            @elseif($key === 'paypal')
                                                <p class="text-sm text-gray-600 mt-1">Secure payment via PayPal</p>
                                            @elseif($key === 'stripe')
                                                <p class="text-sm text-gray-600 mt-1">Fast and secure with Stripe</p>
                                            @elseif($key === 'bank_transfer')
                                                <p class="text-sm text-gray-600 mt-1">Direct bank transfer (may take 2-3 days)</p>
                                            @endif
                                        </div>

                                        <!-- Payment Method Icon -->
                                        <div class="ml-3">
                                            @if($key === 'credit_card' || $key === 'debit_card')
                                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                </svg>
                                            @elseif($key === 'bank_transfer')
                                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                        </div>

                        <!-- Payment Security Notice -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-sm text-green-800 font-semibold">Secure Payment</p>
                                    <p class="text-sm text-green-700 mt-1">
                                        Your payment information is encrypted and secure. We never store your payment details.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Important Note -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <p class="text-sm text-blue-800">
                                <strong>Note:</strong> This is a controller-based step demonstrating the package's flexibility.
                                Traditional form submission with POST request.
                            </p>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center border-t pt-6">
                            <a
                                href="{{ url()->previous() }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                Back to Billing
                            </a>

                            <x-primary-button type="submit">
                                Continue to Review
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
