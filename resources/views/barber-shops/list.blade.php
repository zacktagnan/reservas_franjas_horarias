<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Barberías') }}
        </h2>
    </x-slot>

    <div class="p-6 m-2 mt-5 overflow-hidden bg-white shadow-sm dark:bg-gray-900 sm:rounded-lg">
        {{-- <div class="grid grid-cols-4 gap-4">
            <div>01</div>
            <!-- ... -->
            <div>09</div>
        </div>
        <div class="container grid grid-cols-3 m-auto">
            <div class="bg-teal-500 tile">
                <h1 class="tile-marker">ONE</h1>
            </div>
            <div class="tile bg-amber-500">
                <h1 class="tile-marker">TWO</h1>
            </div>
            <div class="bg-yellow-500 tile">
                <h1 class="tile-marker">THREE</h1>
            </div>
            <div class="tile bg-lime-600">
                <h1 class="tile-marker">FOUR</h1>
            </div>
            <div class="bg-green-600 tile">
                <h1 class="tile-marker">FIVE</h1>
            </div>
            <div class="tile bg-emerald-500">
                <h1 class="tile-marker">SIX</h1>
            </div>
            <div class="bg-teal-500 tile">
                <h1 class="tile-marker">SEVEN</h1>
            </div>
            <div class="bg-purple-500 tile">
                <h1 class="tile-marker">EIGHT</h1>
            </div>
            <div class="bg-pink-500 tile">
                <h1 class="tile-marker">NINE</h1>
            </div>
        </div> --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($barberShops as $barberShop)
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-700 sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-yellow-100">
                        <img src="{{ $barberShop->image }}" alt="{{ $barberShop->name }}" class="object-cover w-full h-32 mb-4">
                        <h3 class="mb-2 text-lg font-semibold">{{ $barberShop->name }}</h3>
                        <p class="mb-2 text-sm text-gray-600 dark:text-white">{{ $barberShop->address }}</p>
                        <p class="text-sm text-gray-600 dark:text-white">{{ $barberShop->phone }}</p>

                        <ul class="mt-4 space-y-2">
                            @foreach ($barberShop->schedules as $schedule)
                                <li>
                                    <span class="font-semibold">{{ $schedule->day_of_week_string }}:</span>

                                    @if (!$schedule->is_closed)
                                        {{ $schedule->open_time }} - {{ $schedule->close_time }}
                                    @else
                                        {{ __('Cerrado') }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>

                        <div class="pt-4 mt-4 text-center border-t border-gray-200 dark:border-gray-600">
                            <a
                                href="{{ route('slots.show', [
                                    'barberShop' => $barberShop,
                                    'year' => now()->year,
                                    'month' => now()->month,
                                    'day' => now()->day,
                                ]) }}"
                                class="text-blue-600 dark:text-blue-400 hover:underline"
                            >
                                @php
                                    // echo now()->dayName . ', ' . now()->day . ' de ' .now()->monthName. ' de ' .now()->year;
                                    // echo '<br><br>';
                                @endphp
                                {{ __('Ver horarios disponibles para HOY') . ' ' . date('d-m-Y') }}
                                <br>
                                {{ __('y posteriores días') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>
