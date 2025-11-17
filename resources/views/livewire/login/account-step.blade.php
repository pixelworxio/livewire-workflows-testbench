<div id="accountStepWrapper" class="max-w-md mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Login to Your Account</h2>

        <form wire:submit.prevent="login">
            <!-- Email Field -->
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

            <!-- Password Field -->
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
            </div>

            <!-- Remember Me Checkbox -->
            <div class="mb-6">
                <label for="remember" class="inline-flex items-center">
                    <input
                        id="remember"
                        type="checkbox"
                        wire:model="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    >
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <x-primary-button type="submit" class="w-full justify-center">
                    Login
                </x-primary-button>
            </div>
        </form>

        <!-- Helper Text -->
        <div class="mt-4 text-center text-sm text-gray-600">
            <p>Demo: Use any registered user credentials</p>
        </div>
    </div>
</div>
