<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Franjas Disponibles') }}
        </h2>
    </x-slot>

    <div class="p-6 m-2 mt-5 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
        <div class="flex items-center justify-between">{{-- en vez de justify-around --}}
            {{-- @dateNotIsToday($date)
                @php
                    $copy = $date->copy()->subDay();
                @endphp
                <a
                    href="{{ route('slots.show', ['barberShop' => $barberShop, 'year' => $copy->year, 'month' => $copy->month, 'day' => $copy->day]) }}"
                    class="px-4 py-2 font-semibold text-white bg-blue-600 rounded dark:bg-blue-400 dark:text-gray-900 hover:bg-blue-500 dark:hover:bg-blue-300"
                >
                    {{ __('Día anterior') }}
                </a>
            @enddateNotIsToday --}}

            @php
                $copy = $date->copy()->subDay();
            @endphp
            @if (!$date->isToday())
                <a
                    href="{{ route('slots.show', ['barberShop' => $barberShop, 'year' => $copy->year, 'month' => $copy->month, 'day' => $copy->day]) }}"
                    class="px-4 py-2 font-semibold text-white bg-blue-600 rounded dark:bg-blue-400 dark:text-gray-900 hover:bg-blue-500 dark:hover:bg-blue-300"
                >
                    {{ __('Día anterior') }}
                </a>
            @else
                <span
                    class="px-4 py-2 font-semibold text-white bg-gray-600 rounded cursor-default dark:bg-gray-400 dark:text-gray-900"
                >
                    {{ __('Día anterior') }}
                </span>
            @endif

            <div class="text-center">
                <h2 class="mb-2 text-lg font-semibold dark:text-white">{{ $barberShop->name }}</h2>
                <p class="mb-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ $date->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                </p>
            </div>

            {{-- @dateWithinMaxFutureDays($date, $barberShop)
                @php
                    $copy = $date->copy()->addDay();
                @endphp
                <a
                    href="{{ route('slots.show', ['barberShop' => $barberShop, 'year' => $copy->year, 'month' => $copy->month, 'day' => $copy->day]) }}"
                    class="px-4 py-2 font-semibold text-white bg-blue-600 rounded dark:bg-blue-400 dark:text-gray-900 hover:bg-blue-500 dark:hover:bg-blue-300"
                >
                    {{ __('Día siguiente') }}
                </a>
            @enddateWithinMaxFutureDays --}}

            @php
                $copy = $date->copy()->addDay();
            @endphp
            @if ($date->dayOfYear < (now()->dayOfYear + $barberShop->max_future_days))
                <a
                    href="{{ route('slots.show', ['barberShop' => $barberShop, 'year' => $copy->year, 'month' => $copy->month, 'day' => $copy->day]) }}"
                    class="px-4 py-2 font-semibold text-white bg-blue-600 rounded dark:bg-blue-400 dark:text-gray-900 hover:bg-blue-500 dark:hover:bg-blue-300"
                >
                    {{ __('Día siguiente') }}
                </a>
            @else
                <span
                    class="px-4 py-2 font-semibold text-white bg-gray-600 rounded cursor-default dark:bg-gray-400 dark:text-gray-900"
                >
                    {{ __('Día siguiente') }}
                </span>
            @endif
        </div>
    </div>

    @if ($barberShop->slots->isEmpty())
        <div class="p-6 m-2 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
            <p class="p-4 text-center text-white bg-red-500 rounded-md">
                {{ __('No hay horarios disponibles para este día') }}
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 p-2 text-center sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
        @foreach ($barberShop->slots as $slot)
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $slot->start_time . ' - ' . $slot->end_time }}
                    </p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 {{ $slot->isBooked() ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                        @if ($slot->isBooked())
                            @if ($slot->isMyBooking())
                                {{ __('Reservado por mí') }}
                            @else
                                {{ __('Reservado por otr@') }}
                            @endif
                        @else
                            {{ __('Disponible') }}
                        @endif
                    </p>
                </div>

                @if ($slot->canBeBooked())
                    <div class="mb-6 bg-white dark:bg-gray-800">
                        @if (auth()->user()->hasCredits())
                            <form action="{{ route('slots.book', ['barberShop' => $barberShop, 'slot' => $slot]) }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="px-4 py-2 font-semibold text-white bg-green-600 rounded dark:bg-green-400 dark:text-gray-900 hover:bg-green-500 dark:hover:bg-green-300"
                                >
                                    {{ __('Reservar') }}
                                </button>
                            </form>
                        @else
                            <button
                                class="px-4 py-2 font-semibold text-white bg-gray-600 rounded cursor-not-allowed dark:bg-gray-400 dark:text-gray-900"
                                disabled
                            >
                                {{ __('Sin créditos') }}
                            </button>
                        @endif
                    </div>
                @else
                    <div class="mb-6 bg-white dark:bg-gray-800">
                        <button
                            class="px-4 py-2 font-semibold text-white bg-gray-600 rounded cursor-not-allowed dark:bg-gray-400 dark:text-gray-900"
                            disabled
                        >
                            {{ __('IMPOSIBLE reservar') }}
                        </button>
                    </div>
                @endif

                @if ($slot->isMyBooking())
                    <div class="mb-6 bg-white dark:bg-gray-800">
                        @if ($slot->canCancelBook())
                            <form action="{{ route('bookings.cancel', ['barberShop' => $barberShop, 'booking' => $slot->booking]) }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="px-4 py-2 font-semibold text-white bg-red-600 rounded dark:bg-red-400 dark:text-gray-900 hover:bg-red-500 dark:hover:bg-red-300"
                                >
                                    {{ __('Cancelar') }}
                                </button>
                            </form>
                        @else
                            <button
                                class="px-4 py-2 font-semibold text-white bg-gray-600 rounded cursor-not-allowed dark:bg-gray-400 dark:text-gray-900"
                                disabled
                            >
                                {{ __('No se puede cancelar') }}
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
