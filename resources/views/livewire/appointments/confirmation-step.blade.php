<div class="py-12">
    <div class="w-full max-w-7xl mx-auto">
        <div class="bg-white dark:bg-white/[2%] dark:border dark:border-white/5 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-white">
                <h2 class="text-3xl font-bold mb-2">Book an Appointment</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">Step 4 of 4: Confirm Your Appointment</p>

                <!-- Appointment Summary -->
                <div class="bg-gradient-to-r from-blue-50 dark:from-blue-950/40 to-indigo-50 dark:to-blue-950/40 border border-blue-200 dark:border-blue-800/30 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Appointment Summary</h3>

                    <div class="space-y-4">
                        <!-- Service -->
                        @if($service)
                            <div class="flex items-start">
                                <div class="w-24 text-gray-600 dark:text-gray-400 font-medium">Service:</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $service->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $service->description }}</p>
                                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $service->duration_minutes }} min
                                        </span>
                                        <span class="font-semibold text-blue-600">${{ number_format($service->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Provider -->
                        @if($provider)
                            <div class="flex items-start border-t border-blue-200 dark:border-blue-800/30 pt-4">
                                <div class="w-24 text-gray-600 dark:text-gray-400 font-medium">Provider:</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $provider->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $provider->specialty }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Date & Time -->
                        @if($scheduled_date_time)
                            <div class="flex items-start border-t border-blue-200 dark:border-blue-800/30 pt-4">
                                <div class="w-24 text-gray-600 dark:text-gray-400 font-medium">When:</div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $scheduled_date_time->format('l, F j, Y') }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $scheduled_date_time->format('g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Optional Notes -->
                <div class="mb-6">
                    <x-input-label for="notes" value="Additional Notes (Optional)" />
                    <textarea
                        id="notes"
                        wire:model="notes"
                        rows="4"
                        class="mt-1 block w-full dark:bg-white/5 dark:focus:bg-black/50 dark:text-white border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        placeholder="Any special requests or information for your appointment..."
                    ></textarea>
                </div>

                <!-- Important Information -->
                <div class="bg-yellow-50 dark:bg-yellow-950/20 border border-yellow-200 dark:border-yellow-800/30 rounded-lg p-4 mb-6">
                    <h4 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">Important Information</h4>
                    <ul class="text-sm text-yellow-700 dark:text-yellow-300 space-y-1 list-disc list-inside">
                        <li>Please arrive 10 minutes early for your appointment</li>
                        <li>Bring any relevant documents or information</li>
                        <li>If you need to cancel, please do so at least 24 hours in advance</li>
                    </ul>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center border-t dark:border-white/10 pt-6">
                    <x-secondary-button wire:click="goBack">
                        Back to Time Selection
                    </x-secondary-button>

                    <x-primary-button wire:click="confirmAppointment">
                        Confirm Appointment
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>
