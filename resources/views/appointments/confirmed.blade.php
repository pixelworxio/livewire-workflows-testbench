<x-app-layout>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-green-500/5 dark:border dark:border-white/5 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    <!-- Success Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            Appointment Confirmed!
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            Your appointment has been successfully scheduled.
                        </p>
                    </div>

                    <!-- Appointment Details -->
                    @if(session()->get('appointment_id'))
                        @php
                            $appointment = \App\Models\Appointment::with(['service', 'provider'])->find(session()->get('appointment_id'));
                        @endphp

                        @if($appointment)
                            <div class="bg-blue-50 dark:bg-white/5 border border-blue-200 dark:border-white/10 rounded-lg p-6 mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 pb-4 dark:border-b dark:border-white/10">Appointment Details</h3>

                                <div class="space-y-3">
                                    <div class="flex justify-between items-start">
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Service:</span>
                                        <span class="text-gray-900 dark:text-white font-semibold text-right">{{ $appointment->service->name }}</span>
                                    </div>

                                    <div class="flex justify-between items-start">
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Provider:</span>
                                        <span class="text-gray-900 dark:text-white font-semibold text-right">{{ $appointment->provider->name }}</span>
                                    </div>

                                    <div class="flex justify-between items-start">
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Date:</span>
                                        <span class="text-gray-900 dark:text-white font-semibold text-right">
                                            {{ $appointment->scheduled_at->format('l, F j, Y') }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-start">
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Time:</span>
                                        <span class="text-gray-900 dark:text-white font-semibold text-right">
                                            {{ $appointment->scheduled_at->format('g:i A') }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-start">
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Duration:</span>
                                        <span class="text-gray-900 dark:text-white font-semibold text-right">
                                            {{ $appointment->service->duration_minutes }} minutes
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-start">
                                        <span class="text-gray-600 dark:text-gray-400 font-medium">Price:</span>
                                        <span class="text-gray-900 dark:text-white font-semibold text-right">
                                            ${{ number_format($appointment->service->price, 2) }}
                                        </span>
                                    </div>

                                    @if($appointment->notes)
                                        <div class="border-t border-blue-200 pt-3 mt-3">
                                            <span class="text-gray-600 dark:text-gray-400 font-medium block mb-2">Your Notes:</span>
                                            <p class="text-gray-900 dark:text-white text-sm">{{ $appointment->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Next Steps -->
                    <div class="bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 rounded-lg p-6 mb-6">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Next Steps</h3>
                        <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>A confirmation email has been sent to your registered email address</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Please arrive 10 minutes early for your appointment</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>To reschedule or cancel, please contact us at least 24 hours in advance</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-between">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                            Go to Dashboard
                        </a>
                        <a href="{{ route('appointment.book-again') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                            Book Another Appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
