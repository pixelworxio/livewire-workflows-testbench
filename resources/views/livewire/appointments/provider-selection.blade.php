<div class="py-12">
    <div class="w-full max-w-7xl mx-auto">
        <div class="bg-white dark:bg-white/[2%] dark:border dark:border-white/5 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-white">
                <h2 class="text-3xl font-bold mb-2">Book an Appointment</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">Step 2 of 4: Select a Provider</p>

                @if($providers->isEmpty())
                    <div class="bg-yellow-50 dark:bg-yellow-950/30 border border-yellow-200 dark:border-yellow-800/50 rounded-lg p-4">
                        <p class="text-yellow-800 dark:text-yellow-200">No providers available at this time. Please try again later.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($providers as $provider)
                            <div wire:key="provider-{{ $provider->id }}"
                                 class="dark:bg-white/5 border border-gray-200 dark:border-gray-600 rounded-lg p-6 {{ $provider->id === $provider_id ? 'bg-blue-100 dark:bg-blue-900/20 border-blue-500 dark:border-blue-700 shadow-lg' : 'hover:border-blue-500 hover:shadow-lg' }} transition-all cursor-pointer group"
                                 wire:click="selectProvider({{ $provider->id }})">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                                        {{ substr($provider->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold {{ $provider->id === $provider_id ? 'text-blue-600 dark:text-blue-400' : 'text-gray-900 dark:text-white' }}">
                                            {{ $provider->name }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $provider->specialty }}</p>
                                    </div>
                                </div>

                                <div class="mt-7">
                                    <x-primary-button class="w-full justify-center {{ $provider->id === $provider_id ? '!bg-blue-600 !text-white' : '' }}">
                                        {{ $provider->id === $provider_id ? 'Selected' : 'Select' }} Provider
                                    </x-primary-button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-between items-center border-t dark:border-white/10 pt-6">
                    <x-secondary-button wire:click="goBack">
                        Back to Services
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>
