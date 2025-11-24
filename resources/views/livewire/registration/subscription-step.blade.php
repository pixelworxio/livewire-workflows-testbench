<div id="subscriptionStepWrapper" class="w-full max-w-7xl mx-auto">
    <div class="px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-2">Choose Your Plan</h2>
        <p class="text-gray-600 mb-6">Step 4 of 4: Select a subscription plan</p>

        @if($errors->has('registration'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ $errors->first('registration') }}
            </div>
        @endif

        <!-- Subscription Plans -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <!-- Basic Plan -->
            <div
                class="border-2 rounded-lg p-6 cursor-pointer transition-all {{ $subscription_plan === 'basic' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300 hover:border-gray-400' }}"
                wire:click="selectPlan('basic')"
            >
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold">{{ $plans['basic']['name'] }}</h3>
                        <p class="text-3xl font-bold mt-2">${{ $plans['basic']['price'] }}<span class="text-base font-normal text-gray-600">/month</span></p>
                    </div>
                    @if($subscription_plan === 'basic')
                        <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </div>
                <ul class="space-y-2">
                    @foreach($plans['basic']['features'] as $feature)
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Premium Plan -->
            <div
                class="border-2 rounded-lg p-6 cursor-pointer transition-all {{ $subscription_plan === 'premium' ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300 hover:border-gray-400' }}"
                wire:click="selectPlan('premium')"
            >
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-xl font-bold">{{ $plans['premium']['name'] }}</h3>
                            <span class="bg-indigo-600 text-white text-xs font-semibold px-2 py-1 rounded">POPULAR</span>
                        </div>
                        <p class="text-3xl font-bold mt-2">${{ $plans['premium']['price'] }}<span class="text-base font-normal text-gray-600">/month</span></p>
                    </div>
                    @if($subscription_plan === 'premium')
                        <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                </div>
                <ul class="space-y-2">
                    @foreach($plans['premium']['features'] as $feature)
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <x-input-error :messages="$errors->get('subscription_plan')" class="mb-4" />

        <!-- Navigation buttons -->
        <div class="flex justify-between items-center">
            <x-secondary-button wire:click="goBack">
                Back
            </x-secondary-button>

            <x-primary-button wire:click="completeRegistration" :disabled="!$subscription_plan">
                Complete Registration
            </x-primary-button>
        </div>
    </div>
</div>
