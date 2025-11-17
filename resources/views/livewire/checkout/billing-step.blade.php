<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                <p class="text-gray-600 mb-8">Step 3 of 5: Billing Address</p>

                <!-- Same as Shipping Checkbox -->
                @if($shippingAddress)
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <label class="flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                wire:model.live="sameAsShipping"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            >
                            <span class="ml-2 text-sm text-gray-700 font-medium">Billing address is the same as shipping address</span>
                        </label>
                    </div>
                @endif

                <!-- Billing Address Form -->
                <form wire:submit.prevent="saveBillingAddress">
                    <div class="space-y-4">
                        <!-- Full Name -->
                        <div>
                            <x-input-label for="billing_full_name" value="Full Name" />
                            <x-text-input
                                id="billing_full_name"
                                wire:model="billingAddress.full_name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <x-input-error :messages="$errors->get('billingAddress.full_name')" class="mt-2" />
                        </div>

                        <!-- Address Line 1 -->
                        <div>
                            <x-input-label for="billing_address_line_1" value="Address Line 1" />
                            <x-text-input
                                id="billing_address_line_1"
                                wire:model="billingAddress.address_line_1"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <x-input-error :messages="$errors->get('billingAddress.address_line_1')" class="mt-2" />
                        </div>

                        <!-- Address Line 2 -->
                        <div>
                            <x-input-label for="billing_address_line_2" value="Address Line 2 (Optional)" />
                            <x-text-input
                                id="billing_address_line_2"
                                wire:model="billingAddress.address_line_2"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <x-input-error :messages="$errors->get('billingAddress.address_line_2')" class="mt-2" />
                        </div>

                        <!-- City -->
                        <div>
                            <x-input-label for="billing_city" value="City" />
                            <x-text-input
                                id="billing_city"
                                wire:model="billingAddress.city"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <x-input-error :messages="$errors->get('billingAddress.city')" class="mt-2" />
                        </div>

                        <!-- State and Zip Code -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="billing_state" value="State" />
                                <x-text-input
                                    id="billing_state"
                                    wire:model="billingAddress.state"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <x-input-error :messages="$errors->get('billingAddress.state')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="billing_zip_code" value="Zip Code" />
                                <x-text-input
                                    id="billing_zip_code"
                                    wire:model="billingAddress.zip_code"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <x-input-error :messages="$errors->get('billingAddress.zip_code')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Country -->
                        <div>
                            <x-input-label for="billing_country" value="Country" />
                            <select
                                id="billing_country"
                                wire:model="billingAddress.country"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="MX">Mexico</option>
                            </select>
                            <x-input-error :messages="$errors->get('billingAddress.country')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between items-center border-t mt-6 pt-6">
                        <x-secondary-button type="button" wire:click="goBack">
                            Back to Shipping
                        </x-secondary-button>

                        <x-primary-button type="submit">
                            Continue to Payment
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
