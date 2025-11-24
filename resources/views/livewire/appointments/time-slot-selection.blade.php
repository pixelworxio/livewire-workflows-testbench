<div class="py-12">
    <div class="w-full max-w-7xl mx-auto">
        <div class="bg-white dark:bg-white/[2%] dark:border dark:border-white/5 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-white">
                <h2 class="text-3xl font-bold mb-2">Book an Appointment</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">Step 3 of 4: Select Date & Time</p>

                <div class="space-y-6">
                    <!-- Date Selection -->
                    <div>
                        <x-input-label for="selected_date" value="Select Date" />
                        <x-text-input
                            id="selected_date"
                            wire:model.live="selected_date"
                            type="date"
                            class="mt-1 block w-full"
                            :min="date('Y-m-d')"
                            required
                        />
                        <x-input-error :messages="$errors->get('selected_date')" class="mt-2" />
                    </div>

                    <!-- Time Slot Selection -->
                    @if(!empty($available_time_slots))
                        <div>
                            <x-input-label value="Select Time Slot" class="mb-3" />
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                                @foreach($available_time_slots as $time_slot)
                                    <button
                                        type="button"
                                        wire:click="$set('selected_time', '{{ $time_slot }}')"
                                        class="px-4 py-3 text-center border rounded-lg transition-all
                                            {{ $selected_time === $time_slot
                                                ? 'bg-blue-600 text-white border-blue-600 font-semibold'
                                                : 'bg-white dark:bg-white/10 text-gray-700 dark:text-white/70 border-gray-300 dark:border-transparent hover:border-blue-500 hover:bg-blue-500 hover:text-white' }}"
                                    >
                                        {{ \Carbon\Carbon::parse($time_slot)->format('g:i A') }}
                                    </button>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('selected_time')" class="mt-2" />
                        </div>
                    @else
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-600">Please select a date to view available time slots.</p>
                        </div>
                    @endif

                    <!-- Selected Time Display -->
                    @if($selected_date && $selected_time)
                        <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <p class="text-blue-800 dark:text-blue-200 font-semibold">
                                Selected: {{ \Carbon\Carbon::parse($selected_date . ' ' . $selected_time)->format('l, F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center border-t dark:border-white/10 pt-6 mt-8">
                    <x-secondary-button wire:click="goBack">
                        Back to Providers
                    </x-secondary-button>

                    <x-primary-button
                        wire:click="confirmTimeSlot"
                        :disabled="!$selected_date || !$selected_time"
                    >
                        Continue to Confirmation
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</div>
