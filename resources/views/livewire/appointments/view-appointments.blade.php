<div class="py-12">
    <div class="w-full max-w-7xl mx-auto bg-white dark:bg-white/[2%] dark:border dark:border-white/5 p-6 overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="text-3xl font-bold mb-2 dark:text-white">Scheduled Appointments</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-8">List of appointment requests scheduled through <a href="{{ route('appointment.start') }}" class="underline underline-offset-4 font-medium text-blue-400">Book Appointment Example</a>.</p>

        <table class="mt-6 w-full whitespace-nowrap text-left">
            <colgroup>
                <col class="w-full sm:w-1/12" />
                <col class="lg:w-3/12" />
                <col class="lg:w-3/12" />
                <col class="lg:w-3/12" />
                <col class="lg:w-1/12" />
                <col class="lg:w-1/12" />
            </colgroup>
            <thead class="border-b border-gray-200 text-sm/6 text-gray-900 dark:border-white/15 dark:text-white">
            <tr class="dark:bg-black/25">
                <th scope="col" class="hidden sm:table-cell py-2 pl-4 pr-8 font-semibold sm:pl-6 lg:pl-8">#</th>
                <th scope="col" class="py-2 pl-0 pr-8 font-semibold">User</th>
                <th scope="col" class="py-2 pl-0 pr-8 font-semibold">Service</th>
                <th scope="col" class="py-2 pl-0 pr-8 font-semibold">Provider</th>
                <th scope="col" class="py-2 pl-0 pr-4 text-right font-semibold sm:pr-8 sm:text-left lg:pr-20">Status</th>
                <th scope="col" class="hidden py-2 pl-0 pr-4 text-right font-semibold sm:table-cell sm:pr-6 lg:pr-8">Time Ordered</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/10">

            @forelse($appointments as $appointment)
                <tr>
                    <td class="hidden sm:table-cell py-4 pl-4 pr-8 sm:pl-6 lg:pl-8">
                        <div class="flex items-center gap-x-4">
                            <div class="font-mono text-sm/6 text-gray-500 dark:text-gray-400">{{ $appointment->id }}</div>
                        </div>
                    </td>
                    <td class="py-4 pl-0 pr-4 sm:pr-8">
                        <div class="flex gap-x-3">
                            <div class="truncate text-sm/6 font-medium text-gray-900 dark:text-white">{{ $appointment->user?->name ?? 'Missing User' }}</div>
                        </div>
                    </td>
                    <td class="py-4 pl-0 pr-4 sm:pr-8">
                        <div class="flex gap-x-3">
                            <div class="truncate text-sm/6 font-medium text-gray-900 dark:text-white">{{ $appointment->service?->name ?? 'Missing Service' }}</div>
                        </div>
                    </td>
                    <td class="py-4 pl-0 pr-4 sm:pr-8">
                        <div class="flex gap-x-3">
                            <div class="truncate text-sm/6 font-medium text-gray-900 dark:text-white">{{ $appointment->provider?->name ?? 'Missing Provider' }}</div>
                        </div>
                    </td>
                    <td class="py-4 pl-0 pr-4 text-sm/6 sm:pr-8 lg:pr-20">
                        <div class="flex items-center justify-end gap-x-2 sm:justify-start">
                            <time datetime="2023-01-23T11:00" class="sm:hidden text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($appointment->created_at)->diffForHumans(now(), 2) }}</time>
                            <div class=" text-gray-900 dark:text-white">{{ $appointment->status }}</div>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell py-4 pl-0 pr-4 text-right text-sm/6 text-gray-500 sm:pr-6 lg:pr-8 dark:text-gray-400">
                        <time datetime="2023-01-23T11:00" class="hidden sm:block">{{ \Carbon\Carbon::parse($appointment->created_at)->diffForHumans(now(), 2) }}</time>
                    </td>
                </tr>
            @empty
            @endforelse

            </tbody>
        </table>

    </div>

    <div class="mt-9 w-full max-w-7xl mx-auto ">
        {{ $appointments->links() }}
    </div>
</div>
