<div id="businessStepWrapper" class="max-w-xl mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-2">Business Information</h2>
        <p class="text-gray-600 mb-6">Step 2 of 4: Tell us about your business</p>

        <!-- Business Name -->
        <div class="mb-4">
            <x-input-label for="business_name" value="Business Name" />
            <x-text-input
                id="business_name"
                wire:model="business_name"
                type="text"
                class="mt-1 block w-full"
                required
                autofocus
            />
            <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
        </div>

        <!-- Business Type -->
        <div class="mb-6">
            <x-input-label for="business_type" value="Business Type" />
            <select
                id="business_type"
                wire:model="business_type"
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required
            >
                <option value="">Select a business type</option>
                @foreach($businessTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('business_type')" class="mt-2" />
        </div>

        <!-- Navigation buttons -->
        <div class="flex justify-between items-center">
            <x-secondary-button wire:click="goBack">
                Back
            </x-secondary-button>

            <x-primary-button wire:click="goToNextStep">
                Continue
            </x-primary-button>
        </div>
    </div>
</div>
