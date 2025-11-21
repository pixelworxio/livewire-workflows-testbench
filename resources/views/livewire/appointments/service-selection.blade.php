<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-3xl font-bold mb-2">Book an Appointment</h2>
                <p class="text-gray-600 mb-8">Step 1 of 4: Select a Service</p>

                @if($services->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-800">No services available at this time. Please contact support.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($services as $service)
                            <div wire:key="service-{{ $service->id }}"
                                 class="border border-gray-200 rounded-lg p-6 {{ $service->id === $serviceId ? 'border-blue-500 shadow-lg' : 'hover:border-blue-500 hover:shadow-lg' }} transition-all cursor-pointer group"
                                 wire:click="selectService({{ $service->id }})"
                            >
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="text-xl font-semibold {{ $service->id === $serviceId ? 'text-blue-600' : 'text-gray-900 group-hover:text-blue-600' }}">
                                        {{ $service->name }}
                                    </h3>
                                    <span class="text-2xl font-bold text-blue-600">
                                        ${{ number_format($service->price, 2) }}
                                    </span>
                                </div>

                                <p class="text-gray-600 mb-4 line-clamp-3">
                                    {{ $service->description }}
                                </p>

                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $service->duration_minutes }} minutes</span>
                                </div>

                                <div class="mt-4">
                                    <x-primary-button class="w-full justify-center">
                                        Select Service
                                    </x-primary-button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
