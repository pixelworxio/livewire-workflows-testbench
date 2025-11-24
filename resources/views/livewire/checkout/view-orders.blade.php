<div class="py-12">
    <div class="relative w-full max-w-7xl mx-auto">
        <div class="-z-0 absolute inset-x-16 inset-y-32 mx-auto top-16 bg-gradient-to-br from-blue-500/30 to-pink-600/20 dark:from-indigo-600 dark:to-pink-600 blur-3xl transition-all duration-200 ease-in-out"></div>

        <x-custom-card title="checkout" class="z-20">
            <x-slot:tableHeader>
                <div class="p-4">
                    <div class="w-full flex justify-between items-start gap-6">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">Orders Submitted</h2>
                            <p class="mb-2 text-zinc-600 dark:text-zinc-400">pending description</p>
                        </div>
                    </div>
                </div>
            </x-slot:tableHeader>

                <!-- Cart Items Table -->
                <div class="">
                    <div class="w-full grid grid-cols-6 bg-zinc-200 dark:bg-pink-950/50 rounded-lg overflow-clip">
                        <div class="text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Order No</div>
                        <div class="text-center py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Item Count</div>
                        <div class="text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Ship To</div>
                        <div class="text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Pay Method</div>
                        <div class="text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Status</div>
                        <div class="text-right py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">Total</div>
                    </div>

                    <div class="mt-1 flex flex-col gap-1">
                        @foreach($orders as $order)

                            <div class="w-full grid grid-cols-6 items-center {{ $loop->even ? 'bg-black/10 dark:bg-black/30' : '' }} hover:bg-zinc-50 dark:hover:bg-white/[2%] rounded-xl py-1" wire:key="cart-item-{{ $order->id }}">
                                <div class="text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">{{ $order->order_number }}</div>
                                <div class="text-center py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">{{ $order->items()->sum('quantity') }}</div>
                                <div class="text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">{{ $order->shipping_address['city'] ?? 'Missing City' }}, {{ $order->shipping_address['state'] ?? 'Missing State' }}</div>
                                <div class="text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">{{ $order->payment_method }}</div>
                                <div class="text-left py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">{{ $order->status }}</div>
                                <div class="text-right py-2 px-4 font-semibold text-zinc-700 dark:text-white/70">${{ number_format($order->items()->sum('subtotal'),2) }}</div>
                            </div>

                        @endforeach
                    </div>
                </div>
        </x-custom-card>

        <div class="mt-9 relative z-10">
            <!-- Navigation Buttons -->
            @if($orders->links() ?? false)
                {{ $orders->links() }}
            @endif
        </div>
    </div>
</div>
