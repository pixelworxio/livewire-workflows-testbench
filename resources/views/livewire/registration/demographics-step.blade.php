<div id="demographicsStepWrapper" class="max-w-xl mx-auto">
    <div class="px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-2">Personal Information</h2>
        <p class="text-gray-600 mb-6">Step 3 of 4: Tell us a bit about yourself</p>

        <!-- Age -->
        <div class="mb-4">
            <x-input-label for="age" value="Age" />
            <x-text-input
                id="age"
                wire:model="age"
                type="number"
                min="18"
                max="120"
                class="mt-1 block w-full"
                required
                autofocus
            />
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>

        <!-- Location -->
        <div class="mb-4">
            <x-input-label for="location" value="Location" />
            <x-text-input
                id="location"
                wire:model="location"
                type="text"
                class="mt-1 block w-full"
                placeholder="City, State or Country"
                required
            />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mb-6">
            <x-input-label for="phone" value="Phone Number" />
            <x-text-input
                id="phone"
                wire:model="phone"
                type="tel"
                class="mt-1 block w-full"
                placeholder="+1 (555) 123-4567"
                required
            />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
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
