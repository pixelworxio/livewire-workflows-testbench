<div class="py-12">
    <div class="relative w-full max-w-7xl mx-auto">

        <!-- Shipping Address Form -->
        <form wire:submit.prevent="submitAddress">

            @csrf

            <div class="w-full flex justify-between items-start gap-8">
                <div class="relative w-full xl:w-2/3">
                    <div class="-z-0 absolute inset-x-6 inset-y-8 mx-auto top-0 bg-gradient-to-br from-blue-500/30 to-pink-600/20 dark:from-indigo-600 dark:to-pink-600 blur-3xl"></div>
                    <x-custom-card title="checkout" class="z-20">
                        <x-slot:tableHeader>
                            <div class="p-4">
                                <div>
                                    <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                                    <p class="mb-2 text-gray-600 dark:text-gray-400">Step 2 of 5: Shipping Address</p>
                                </div>
                            </div>
                        </x-slot:tableHeader>

                        <div class="p-4 pb-8 space-y-4">
                            <div class="flex justify-start items-baseline gap-7 pb-3">
                                <button
                                    wire:click="fillShippingAddress"
                                    type="button"
                                    class="opacity-60 hover:opacity-100 hover:underline underline-offset-4"
                                >Fill Shipping Address</button>
                                <button
                                    wire:click="clearShippingAddress"
                                    type="button"
                                    class="opacity-60 hover:opacity-100 hover:underline underline-offset-4"
                                >Clear Shipping Address</button>
                            </div>

                            <!-- Full Name -->
                            <div>
                                <x-input-label for="full_name" value="Full Name" />
                                <x-text-input
                                    wire:model.blur="shipping_address.full_name"
                                    id="full_name"
                                    name="full_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <x-input-error :messages="$errors->get('shipping_address.full_name')" class="mt-2" />
                            </div>

                            <!-- Address Line 1 -->
                            <div>
                                <x-input-label for="address_line_1" value="Address Line 1" />
                                <x-text-input
                                    wire:model.blur="shipping_address.address_line_1"
                                    id="address_line_1"
                                    name="address_line_1"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <x-input-error :messages="$errors->get('shipping_address.address_line_1')" class="mt-2" />
                            </div>

                            <!-- Address Line 2 -->
                            <div>
                                <x-input-label for="address_line_2" value="Address Line 2 (Optional)" />
                                <x-text-input
                                    wire:model.blur="shipping_address.address_line_2"
                                    id="address_line_2"
                                    name="address_line_2"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <x-input-error :messages="$errors->get('shipping_address.address_line_2')" class="mt-2" />
                            </div>

                            <!-- City -->
                            <div>
                                <x-input-label for="city" value="City" />
                                <x-text-input
                                    wire:model.blur="shipping_address.city"
                                    id="city"
                                    name="city"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <x-input-error :messages="$errors->get('shipping_address.city')" class="mt-2" />
                            </div>

                            <!-- State and Zip Code -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="state" value="State" />
                                    <x-text-input
                                        wire:model.blur="shipping_address.state"
                                        id="state"
                                        name="state"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('shipping_address.state')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="zip_code" value="Zip Code" />
                                    <x-text-input
                                        wire:model.blur="shipping_address.zip_code"
                                        id="zip_code"
                                        name="zip_code"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('shipping_address.zip_code')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Country -->
                            <div>
                                <x-input-label for="country" value="Country" />
                                <select
                                    wire:model="shipping_address.country"
                                    id="country"
                                    name="country"
                                    class="mt-1 block w-full dark:bg-white/10 border-zinc-300 dark:border-zinc-700 focus:border-indigo-500 dark:focus:border-pink-500 focus:ring-indigo-500 dark:focus:ring-pink-500 rounded-md shadow-sm"
                                    required
                                >
                                    <option>Select country...</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="MX">Mexico</option>
                                </select>
                                <x-input-error :messages="$errors->get('shipping_address.country')" class="mt-2" />
                            </div>
                        </div>
                    </x-custom-card>

                    <div class="mt-9 relative z-10">
                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center pt-6">
                            <button type="button"
                                    wire:click="goBack"
                                    class="inline-flex items-center px-4 py-2 border border-gray-800 dark:border-white rounded-md font-semibold text-xs text-gray-900 dark:text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-gray-100/10"
                            >Back to Cart</button>

                            <x-primary-button type="submit" class="{{ !$this->shippingAddressIsFilled() ? 'opacity-50 pointer-events-none cursor-none' : '' }}">
                                Continue to Billing
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
