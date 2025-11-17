<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                <p class="text-gray-600 mb-8">Step 5 of 5: Review & Confirm Order</p>

                @if($errors->has('order'))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <p class="text-red-800">{{ $errors->first('order') }}</p>
                    </div>
                @endif

                <!-- Order Summary -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h3>

                    <!-- Cart Items -->
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">Items ({{ count($cartItems) }})</h4>
                        <div class="space-y-2">
                            @foreach($cartItems as $item)
                                <div class="flex justify-between text-sm" wire:key="confirm-item-{{ $item['id'] }}">
                                    <span class="text-gray-700">
                                        {{ $item['product_name'] }} (x{{ $item['quantity'] }})
                                    </span>
                                    <span class="font-medium text-gray-900">
                                        ${{ number_format($item['subtotal'], 2) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="border-t border-blue-200 pt-3 mt-3">
                        <div class="flex justify-between text-lg font-bold text-gray-900">
                            <span>Total:</span>
                            <span>${{ number_format($cartTotal, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                @if(!empty($shippingAddress))
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Shipping Address</h4>
                        <p class="text-gray-700">{{ $shippingAddress['full_name'] ?? '' }}</p>
                        <p class="text-gray-700">{{ $shippingAddress['address_line_1'] ?? '' }}</p>
                        @if(!empty($shippingAddress['address_line_2']))
                            <p class="text-gray-700">{{ $shippingAddress['address_line_2'] }}</p>
                        @endif
                        <p class="text-gray-700">
                            {{ $shippingAddress['city'] ?? '' }}, {{ $shippingAddress['state'] ?? '' }} {{ $shippingAddress['zip_code'] ?? '' }}
                        </p>
                        <p class="text-gray-700">{{ $shippingAddress['country'] ?? '' }}</p>
                    </div>
                @endif

                <!-- Billing Address -->
                @if(!empty($billingAddress))
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Billing Address</h4>
                        <p class="text-gray-700">{{ $billingAddress['full_name'] ?? '' }}</p>
                        <p class="text-gray-700">{{ $billingAddress['address_line_1'] ?? '' }}</p>
                        @if(!empty($billingAddress['address_line_2']))
                            <p class="text-gray-700">{{ $billingAddress['address_line_2'] }}</p>
                        @endif
                        <p class="text-gray-700">
                            {{ $billingAddress['city'] ?? '' }}, {{ $billingAddress['state'] ?? '' }} {{ $billingAddress['zip_code'] ?? '' }}
                        </p>
                        <p class="text-gray-700">{{ $billingAddress['country'] ?? '' }}</p>
                    </div>
                @endif

                <!-- Payment Method -->
                @if($paymentMethod)
                    <div class="mb-6 p-4 border border-gray-200 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Payment Method</h4>
                        <p class="text-gray-700 capitalize">{{ str_replace('_', ' ', $paymentMethod) }}</p>
                    </div>
                @endif

                <!-- Important Information -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-yellow-800 mb-2">Important Information</h4>
                    <ul class="text-sm text-yellow-700 space-y-1 list-disc list-inside">
                        <li>By placing this order, you agree to our terms and conditions</li>
                        <li>You will receive an order confirmation email shortly</li>
                        <li>Estimated delivery: 3-5 business days</li>
                        <li>For questions, contact support@example.com</li>
                    </ul>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center border-t pt-6">
                    <x-secondary-button wire:click="goBack">
                        Back to Payment
                    </x-secondary-button>

                    <x-primary-button wire:click="placeOrder">
                        Place Order
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>
