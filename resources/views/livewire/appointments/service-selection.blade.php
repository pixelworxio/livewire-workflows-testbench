<div class="py-12">
    <div class="w-full max-w-7xl mx-auto">
        <div class="bg-white dark:bg-white/[2%] dark:border dark:border-white/5 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-white">
                <h2 class="text-3xl font-bold mb-2">Book an Appointment</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">Step 1 of 4: Select a Service</p>

                @if($services->isEmpty())
                    <div class="bg-yellow-50 dark:bg-yellow-950/30 border border-yellow-200 dark:border-yellow-800/50 rounded-lg p-4">
                        <p class="text-yellow-800 dark:text-yellow-200">No services available at this time. Please contact support.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($services as $service)
                            <div wire:key="service-{{ $service->id }}"
                                 class="dark:bg-white/5 border border-gray-200 dark:border-gray-600 rounded-lg p-6 {{ $service->id === $service_id ? 'bg-blue-100 dark:bg-blue-900/20 border-blue-500 dark:border-blue-700 shadow-lg' : 'hover:border-blue-500 hover:shadow-lg' }} transition-all cursor-pointer group"
                                 wire:click="selectService({{ $service->id }})"
                            >
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="text-xl font-semibold {{ $service->id === $service_id ? 'text-blue-600 dark:text-blue-400' : 'text-gray-900 dark:text-white' }}">
                                        {{ $service->name }}
                                    </h3>
                                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                        ${{ number_format($service->price, 2) }}
                                    </span>
                                </div>

                                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                    {{ $service->description }}
                                </p>

                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $service->duration_minutes }} minutes</span>
                                </div>

                                <div class="mt-4">
                                    <x-primary-button class="w-full justify-center {{ $service->id === $service_id ? '!bg-blue-600 !text-white' : '' }}">
                                        {{ $service->id === $service_id ? 'Selected' : 'Select' }} Service
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
