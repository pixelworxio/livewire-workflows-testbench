<div class="py-12">
    <div class="relative w-full max-w-7xl mx-auto">

        <!-- Shipping Address Form -->
        <form wire:submit.prevent="saveBillingAddress">

            @csrf

            <div class="w-full flex justify-between items-start gap-8">
                <div class="relative w-full xl:w-2/3">
                    <div class="-z-0 absolute inset-x-12 inset-y-14 mx-auto top-0 bg-gradient-to-br from-blue-500/30 to-pink-600/20 dark:from-indigo-600 dark:to-pink-600 blur-3xl"></div>
                    <x-custom-card title="checkout" class="z-20">
                        <x-slot:tableHeader>
                            <div class="p-4">
                                <div>
                                    <h2 class="text-3xl font-bold mb-2">Checkout</h2>
                                    <p class="mb-2 text-zinc-600 dark:text-zinc-400">Step 3 of 5: Billing Address</p>
                                </div>
                            </div>
                        </x-slot:tableHeader>

                        <div class="p-4 pb-8 space-y-4">
                            <!-- Same as Shipping Checkbox -->
                            @if($shipping_address)
                                <div class="mt-2 mb-6 p-4 bg-blue-50 dark:bg-blue-950 border border-blue-200 dark:border-blue-800 rounded-lg">
                                    <label class="flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            wire:model.live="same_as_shipping"
                                            class="rounded border-zinc-300 dark:border-white text-blue-600 shadow-sm focus:ring-blue-500"
                                        >
                                        <span class="ml-2 text-sm text-zinc-700 dark:text-white/70 font-medium">Billing address is the same as shipping address</span>
                                    </label>
                                </div>
                            @endif

                            <!-- Full Name -->
                            <div>
                                <x-input-label for="billing_full_name" value="Full Name" />
                                <x-text-input
                                    id="billing_full_name"
                                    wire:model="billing_address.full_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <x-input-error :messages="$errors->get('billing_address.full_name')" class="mt-2" />
                            </div>

                            <!-- Address Line 1 -->
                            <div>
                                <x-input-label for="billing_address_line_1" value="Address Line 1" />
                                <x-text-input
                                    id="billing_address_line_1"
                                    wire:model="billing_address.address_line_1"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <x-input-error :messages="$errors->get('billing_address.address_line_1')" class="mt-2" />
                            </div>

                            <!-- Address Line 2 -->
                            <div>
                                <x-input-label for="billing_address_line_2" value="Address Line 2 (Optional)" />
                                <x-text-input
                                    id="billing_address_line_2"
                                    wire:model="billing_address.address_line_2"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <x-input-error :messages="$errors->get('billing_address.address_line_2')" class="mt-2" />
                            </div>

                            <!-- City -->
                            <div>
                                <x-input-label for="billing_city" value="City" />
                                <x-text-input
                                    id="billing_city"
                                    wire:model="billing_address.city"
                                    type="text"
                                    class="mt-1 block w-full"
                                    required
                                />
                                <x-input-error :messages="$errors->get('billing_address.city')" class="mt-2" />
                            </div>

                            <!-- State and Zip Code -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="billing_state" value="State" />
                                    <x-text-input
                                        id="billing_state"
                                        wire:model="billing_address.state"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('billing_address.state')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="billing_zip_code" value="Zip Code" />
                                    <x-text-input
                                        id="billing_zip_code"
                                        wire:model="billing_address.zip_code"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <x-input-error :messages="$errors->get('billing_address.zip_code')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Country -->
                            <div>
                                <x-input-label for="billing_country" value="Country" />
                                <select
                                    id="billing_country"
                                    wire:model="billing_address.country"
                                    class="mt-1 block w-full dark:bg-white/10 border-zinc-300 dark:border-zinc-700 focus:border-indigo-500 dark:focus:border-pink-500 focus:ring-indigo-500 dark:focus:ring-pink-500 rounded-md shadow-sm"
                                    required
                                >
                                    <option>Select country...</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="MX">Mexico</option>
                                </select>
                                <x-input-error :messages="$errors->get('billing_address.country')" class="mt-2" />
                            </div>
                        </div>

                    </x-custom-card>

                    <div class="mt-9 relative z-10">
                        <!-- Navigation Buttons -->
                        <div class="flex justify-between items-center pt-6">
                            <button type="button"
                                    wire:click="goBack"
                                    class="inline-flex items-center px-4 py-2 border border-zinc-800 dark:border-white rounded-md font-semibold text-xs text-zinc-900 dark:text-white uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-zinc-100/10"
                            >Back to Shipping</button>

                            <x-primary-button type="submit">
                                Continue to Payment
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
