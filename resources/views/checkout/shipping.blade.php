<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                    <p class="text-gray-600 mb-8">Step 2 of 5: Shipping Address</p>

                    <!-- Shipping Address Form -->
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf

                        <div class="space-y-4">
                            <!-- Full Name -->
                            <div>
                                <x-input-label for="full_name" value="Full Name" />
                                <x-text-input
                                    id="full_name"
                                    name="full_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    value="{{ old('full_name', $shippingAddress['full_name'] ?? '') }}"
                                    required
                                />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>

                            <!-- Address Line 1 -->
                            <div>
                                <x-input-label for="address_line_1" value="Address Line 1" />
                                <x-text-input
                                    id="address_line_1"
                                    name="address_line_1"
                                    type="text"
                                    class="mt-1 block w-full"
                                    value="{{ old('address_line_1', $shippingAddress['address_line_1'] ?? '') }}"
                                    required
                                />
                                <x-input-error :messages="$errors->get('address_line_1')" class="mt-2" />
                            </div>

                            <!-- Address Line 2 -->
                            <div>
                                <x-input-label for="address_line_2" value="Address Line 2 (Optional)" />
                                <x-text-input
                                    id="address_line_2"
                                    name="address_line_2"
                                    type="text"
                                    class="mt-1 block w-full"
                                    value="{{ old('address_line_2', $shippingAddress['address_line_2'] ?? '') }}"
                                />
                                <x-input-error :messages="$errors->get('address_line_2')" class="mt-2" />
                            </div>

                            <!-- City -->
                            <div>
                                <x-input-label for="city" value="City" />
                                <x-text-input
                                    id="city"
                                    name="city"
                                    type="text"
                                    class="mt-1 block w-full"
                                    value="{{ old('city', $shippingAddress['city'] ?? '') }}"
                                    required
                                />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" />
                            </div>

                            <!-- State and Zip Code -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="state" value="State" />
                                    <x-text-input
                                        id="state"
                                        name="state"
                                        type="text"
                                        class="mt-1 block w-full"
                                        value="{{ old('state', $shippingAddress['state'] ?? '') }}"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="zip_code" value="Zip Code" />
                                    <x-text-input
                                        id="zip_code"
                                        name="zip_code"
                                        type="text"
                                        class="mt-1 block w-full"
                                        value="{{ old('zip_code', $shippingAddress['zip_code'] ?? '') }}"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('zip_code')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Country -->
                            <div>
                                <x-input-label for="country" value="Country" />
                                <select
                                    id="country"
                                    name="country"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required
                                >
                                    <option value="US" {{ old('country', $shippingAddress['country'] ?? 'US') === 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('country', $shippingAddress['country'] ?? '') === 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="MX" {{ old('country', $shippingAddress['country'] ?? '') === 'MX' ? 'selected' : '' }}>Mexico</option>
                                </select>
                                <x-input-error :messages="$errors->get('country')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Important Note -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                            <p class="text-sm text-blue-800">
                                <strong>Note:</strong> This is a controller-based step demonstrating the package's flexibility.
                                Traditional form submission with POST request and validation.
                            </p>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center border-t mt-6 pt-6">
                            <a
                                href="{{ url()->previous() }}"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                Back to Cart
                            </a>

                            <x-primary-button type="submit">
                                Continue to Billing
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
