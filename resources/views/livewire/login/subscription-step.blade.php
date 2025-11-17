<div id="subscriptionStepWrapper" class="max-w-md mx-auto">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-2 text-gray-800">Subscription Required</h2>
        <p class="text-gray-600 mb-6">{{ $businessName }} needs an active subscription to continue.</p>

        @if(session()->has('error'))
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Subscription Plan Info -->
        <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded">
            <h3 class="font-semibold text-gray-800 mb-2">Basic Plan</h3>
            <ul class="text-sm text-gray-600 space-y-1">
                <li>• Access to all core features</li>
                <li>• 1 year subscription</li>
                <li>• Support included</li>
            </ul>
            <p class="mt-3 text-lg font-bold text-gray-800">Free (Demo)</p>
        </div>

        <!-- Action Button -->
        <div class="flex flex-col gap-3">
            <x-primary-button wire:click="createSubscription" class="w-full justify-center">
                Create Subscription
            </x-primary-button>

            <p class="text-xs text-gray-500 text-center">
                Demo: This will create a basic subscription for your business
            </p>
        </div>
    </div>
</div>
