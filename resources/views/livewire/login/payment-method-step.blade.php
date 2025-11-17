<div id="paymentMethodStepWrapper" class="max-w-md mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-2 text-gray-800">Add Payment Method</h2>
        <p class="text-gray-600 mb-6">Please add a payment method to complete your account setup.</p>

        <form wire:submit.prevent="addPaymentMethod">
            <!-- Payment Type Field -->
            <div class="mb-4">
                <x-input-label for="paymentType" value="Payment Type" />
                <select
                    id="paymentType"
                    wire:model="paymentType"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    required
                >
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="bank_account">Bank Account</option>
                </select>
                <x-input-error :messages="$errors->get('paymentType')" class="mt-2" />
            </div>

            <!-- Last Four Digits Field -->
            <div class="mb-6">
                <x-input-label for="lastFour" value="Last 4 Digits" />
                <x-text-input
                    id="lastFour"
                    wire:model="lastFour"
                    type="text"
                    class="mt-1 block w-full"
                    maxlength="4"
                    pattern="[0-9]{4}"
                    placeholder="1234"
                    required
                />
                <x-input-error :messages="$errors->get('lastFour')" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500">Enter any 4 digits for demo purposes</p>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col gap-3">
                <x-primary-button type="submit" class="w-full justify-center">
                    Add Payment Method
                </x-primary-button>

                <p class="text-xs text-gray-500 text-center">
                    Demo: This will save a payment method record
                </p>
            </div>
        </form>
    </div>
</div>
