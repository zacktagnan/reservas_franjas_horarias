<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Mis Reservas') }}
        </h2>
    </x-slot>

    <div class="p-6 m-2 mt-5 overflow-hidden bg-white shadow-sm dark:bg-gray-900 sm:rounded-lg">
        @if ($bookings->isEmpty())
            <div class="p-6 m-2 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <p class="p-4 text-center text-white bg-red-500 rounded-md">
                    {{ __('No dispones de reservas') }}
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
                @foreach ($bookings as $booking)
                    <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg {{ $booking->slot->slot_date->isPast() ? 'opacity-50' : '' }}">
                        <div class="p-6 text-gray-900 dark:text-yellow-100">
                            <h3 class="mb-2 text-lg font-semibold">{{ $booking->slot->barberShop->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-white">{{ $booking->slot->barberShop->address }}</p>
                            <p class="mb-2 text-sm text-gray-600 dark:text-white">{{ $booking->slot->barberShop->phone }}</p>
                            <p class="text-sm text-gray-600 dark:text-white">{{ $booking->slot->start_time }} - {{ $booking->slot->end_time }}</p>
                            <p class="text-sm text-gray-600 dark:text-white">{{ $booking->slot->slot_date->isoFormat('dddd, D [de] MMMM [de] YYYY')
                                }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</x-app-layout>
