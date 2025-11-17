<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-3xl font-bold mb-2">Book an Appointment</h2>
                <p class="text-gray-600 mb-8">Step 3 of 4: Select Date & Time</p>

                <div class="space-y-6">
                    <!-- Date Selection -->
                    <div>
                        <x-input-label for="selectedDate" value="Select Date" />
                        <x-text-input
                            id="selectedDate"
                            wire:model.live="selectedDate"
                            type="date"
                            class="mt-1 block w-full"
                            :min="date('Y-m-d')"
                            required
                        />
                        <x-input-error :messages="$errors->get('selectedDate')" class="mt-2" />
                    </div>

                    <!-- Time Slot Selection -->
                    @if(!empty($availableTimeSlots))
                        <div>
                            <x-input-label value="Select Time Slot" class="mb-3" />
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                                @foreach($availableTimeSlots as $timeSlot)
                                    <button
                                        type="button"
                                        wire:click="$set('selectedTime', '{{ $timeSlot }}')"
                                        class="px-4 py-3 text-center border rounded-lg transition-all
                                            {{ $selectedTime === $timeSlot
                                                ? 'bg-blue-600 text-white border-blue-600 font-semibold'
                                                : 'bg-white text-gray-700 border-gray-300 hover:border-blue-500 hover:bg-blue-50' }}"
                                    >
                                        {{ \Carbon\Carbon::parse($timeSlot)->format('g:i A') }}
                                    </button>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('selectedTime')" class="mt-2" />
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-600">Please select a date to view available time slots.</p>
                        </div>
                    @endif

                    <!-- Selected Time Display -->
                    @if($selectedDate && $selectedTime)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-blue-800 font-semibold">
                                Selected: {{ \Carbon\Carbon::parse($selectedDate . ' ' . $selectedTime)->format('l, F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center border-t pt-6 mt-8">
                    <x-secondary-button wire:click="goBack">
                        Back to Providers
                    </x-secondary-button>

                    <x-primary-button
                        wire:click="confirmTimeSlot"
                        :disabled="!$selectedDate || !$selectedTime"
                    >
                        Continue to Confirmation
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>
