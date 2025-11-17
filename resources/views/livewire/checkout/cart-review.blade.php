<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                <p class="text-gray-600 mb-8">Step 1 of 5: Review Your Cart</p>

                @if($errors->has('cart'))
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <p class="text-red-800">{{ $errors->first('cart') }}</p>
                    </div>
                @endif

                @if(empty($cartItems))
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                        <p class="text-yellow-800">Your cart is empty. Please add items to your cart before proceeding to checkout.</p>
                    </div>
                @else
                    <!-- Cart Items Table -->
                    <div class="mb-6 overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="text-left p-4 font-semibold text-gray-700">Product</th>
                                    <th class="text-center p-4 font-semibold text-gray-700">Price</th>
                                    <th class="text-center p-4 font-semibold text-gray-700">Quantity</th>
                                    <th class="text-right p-4 font-semibold text-gray-700">Subtotal</th>
                                    <th class="text-center p-4 font-semibold text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr class="border-b hover:bg-gray-50" wire:key="cart-item-{{ $item['id'] }}">
                                        <td class="p-4">
                                            <p class="font-medium text-gray-900">{{ $item['product_name'] }}</p>
                                        </td>
                                        <td class="p-4 text-center text-gray-700">
                                            ${{ number_format($item['price'], 2) }}
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button
                                                    wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                                    class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-gray-700"
                                                >
                                                    -
                                                </button>
                                                <span class="px-4 py-1 border rounded">{{ $item['quantity'] }}</span>
                                                <button
                                                    wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                                    class="px-2 py-1 bg-gray-200 hover:bg-gray-300 rounded text-gray-700"
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </td>
                                        <td class="p-4 text-right font-semibold text-gray-900">
                                            ${{ number_format($item['subtotal'], 2) }}
                                        </td>
                                        <td class="p-4 text-center">
                                            <button
                                                wire:click="removeItem({{ $item['id'] }})"
                                                class="text-red-600 hover:text-red-800 font-medium"
                                            >
                                                Remove
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-50 border-t-2">
                                    <td colspan="3" class="p-4 text-right font-bold text-gray-900">Total:</td>
                                    <td class="p-4 text-right font-bold text-gray-900 text-lg">
                                        ${{ number_format($cartTotal, 2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Cart Summary -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Cart Summary</h3>
                        <div class="flex justify-between text-gray-700">
                            <span>Items in cart:</span>
                            <span class="font-medium">{{ count($cartItems) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-700 mt-1">
                            <span>Total quantity:</span>
                            <span class="font-medium">{{ collect($cartItems)->sum('quantity') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center border-t pt-6">
                    <a href="{{ route('index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Continue Shopping
                    </a>

                    @if(!empty($cartItems))
                        <x-primary-button wire:click="proceedToShipping">
                            Proceed to Shipping
                        </x-primary-button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
