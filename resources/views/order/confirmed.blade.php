<x-app-layout>
    <div class="py-12">
        <div class="relative w-full max-w-xl mx-auto">
            <div class="-z-0 absolute inset-x-0 inset-y-14 mx-auto top-0 bg-gradient-to-br from-blue-500/30 to-pink-600/20 dark:from-indigo-600 dark:to-pink-600 blur-3xl"></div>

            <div class="relative z-10 bg-white/50 dark:bg-neutral-950 backdrop-filter backdrop-blur-md dark:backdrop-blur-none text-zinc-900 dark:text-white border border-zinc-300/60 dark:border-none rounded-2xl p-2 overflow-clip shadow-[0px_11px_21px_0px_rgba(0,_0,_0,_0.07)] motion-scale-in-75 motion-duration-300 motion-blur-in-sm">
                <div class="p-6 text-gray-900">
                    <!-- Success Icon -->
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Order Confirmed!</h2>
                        <p class="text-gray-600">{{ session('order_success', 'Your order has been successfully placed!') }}</p>
                    </div>

                    <!-- Order Details -->
                    @if(session('order_number'))
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg p-6 mb-6">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Order Details</h3>

                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-700 font-medium">Order Number:</span>
                                    <span class="text-gray-900 dark:text-white font-bold">{{ session('order_number') }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-700 font-medium">Order Date:</span>
                                    <span class="text-gray-900 dark:text-white">{{ now()->format('F j, Y g:i A') }}</span>
                                </div>

                                @if(session('order_id'))
                                    <div class="flex justify-between">
                                        <span class="text-gray-700 font-medium">Order ID:</span>
                                        <span class="text-gray-900 dark:text-white">#{{ session('order_id') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- What's Next -->
                    <div class="bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">What happens next?</h3>
                        <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>You will receive an order confirmation email shortly</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Your order will be processed within 1-2 business days</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Estimated delivery: 3-5 business days</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>You can track your order status in your account dashboard</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Support Information -->
                    <div class="border border-gray-200 dark:border-gray-800 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Need Help?</h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-3">
                            If you have any questions about your order, please don't hesitate to contact us.
                        </p>
                        <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                            <p>
                                <strong>Email:</strong> support@example.com
                            </p>
                            <p>
                                <strong>Phone:</strong> 1-800-123-4567
                            </p>
                            <p>
                                <strong>Hours:</strong> Monday - Friday, 9am - 5pm EST
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="relative z-20 mt-9 w-full flex flex-col sm:flex-row gap-4 justify-center xl:justify-between pt-6">
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-zinc-800 dark:border-white rounded-md font-semibold text-xs text-zinc-900 dark:text-white uppercase tracking-widest hover:bg-zinc-700 dark:hover:bg-zinc-100/10"
                >
                    Go to Dashboard
                </a>

                <a
                    href="{{ route('index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
