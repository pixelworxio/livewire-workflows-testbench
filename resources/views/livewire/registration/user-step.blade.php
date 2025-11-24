<div id="userStepWrapper" class="max-w-xl mx-auto">
    <div class="px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-2">Create Your Account</h2>
        <p class="text-gray-600 mb-6">Step 1 of 4: Enter your email and password</p>

        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="email" value="Email Address" />
            <x-text-input
                id="email"
                wire:model="email"
                type="email"
                class="mt-1 block w-full"
                required
                autofocus
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <x-input-label for="password" value="Password" />
            <x-text-input
                id="password"
                wire:model="password"
                type="password"
                class="mt-1 block w-full"
                required
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-sm text-gray-500">Must be at least 8 characters</p>
        </div>

        <!-- Password Confirmation -->
        <div class="mb-6">
            <x-input-label for="password_confirmation" value="Confirm Password" />
            <x-text-input
                id="password_confirmation"
                wire:model="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                required
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Navigation buttons -->
        <div class="flex justify-center items-center">
            <x-primary-button wire:click="goToNextStep" class="w-full justify-center">
                Continue
            </x-primary-button>
        </div>
    </div>
</div>
