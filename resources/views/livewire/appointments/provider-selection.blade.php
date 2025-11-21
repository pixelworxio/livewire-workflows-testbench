<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-3xl font-bold mb-2">Book an Appointment (Service ID: {{ $serviceId ?? 'missing' }})</h2>
                <p class="text-gray-600 mb-8">Step 2 of 4: Select a Provider</p>

                @if($providers->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <p class="text-yellow-800">No providers available at this time. Please try again later.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($providers as $provider)
                            <div wire:key="provider-{{ $provider->id }}"
                                 class="border border-gray-200 rounded-lg p-6 hover:border-blue-500 hover:shadow-lg transition-all cursor-pointer group"
                                 wire:click="selectProvider({{ $provider->id }})">
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                                        {{ substr($provider->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-900 group-hover:text-blue-600">
                                            {{ $provider->name }}
                                        </h3>
                                        <p class="text-sm text-gray-500">{{ $provider->specialty }}</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <x-primary-button class="w-full justify-center">
                                        Select Provider
                                    </x-primary-button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-between items-center border-t pt-6">
                    <x-secondary-button wire:click="goBack">
                        Back to Services
                    </x-secondary-button>
                </div>
            </div>
        </div>
    </div>
</div>
