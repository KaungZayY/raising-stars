<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Application Form ') }}
        </h2>
    </x-slot>
    <div class="py-8">
        <div class="text-center">
            <h1 class="text-black dark:text-white mb-4 text-2xl">Course Overview</h1>
        </div>
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg-gray-200 dark:bg-gray-700 rounded-lg">
            <div class="flex flex-col">
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center mt-2">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">Course Name </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4 mt-2">:</span>
                    <div class="w-1/2 text-center mt-2">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">{{ $schedule->course->course }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">From </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4">:</span>
                    <div class="w-1/2 text-center">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">{{ $schedule->start_date }}</p>
                    </div>
                </div>
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">To </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4">:</span>
                    <div class="w-1/2 text-center">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">{{ $schedule->end_date }}</p>
                    </div>
                </div>
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">Duration </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4">:</span>
                    <div class="w-1/2 text-center">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">
                            @php
                                $startDate = new \DateTime($schedule->start_date);
                                $endDate = new \DateTime($schedule->end_date);
                                $dateDiff = date_diff($startDate, $endDate);
                            @endphp
                            @if ($dateDiff->y > 0)
                                {{ $dateDiff->format('%y year' . ($dateDiff->y > 1 ? 's' : '')) }}
                                @if ($dateDiff->m > 0)
                                    {{ $dateDiff->format(', %m month' . ($dateDiff->m > 1 ? 's' : '')) }}
                                @endif
                            @elseif ($dateDiff->m > 0)
                                {{ $dateDiff->format('%m month' . ($dateDiff->m > 1 ? 's' : '')) }}
                            @else
                                {{ $dateDiff->format('%d day' . ($dateDiff->d > 1 ? 's' : '')) }}
                            @endif
                        </p>
                    </div>
                </div>
                <!-- Flex Row -->
                <div class="flex flex-row flex-grow">
                    <div class="w-1/2 text-center">
                        <h1 class="text-gray-700 dark:text-gray-300 mb-4 text-lg">Session </h1>
                    </div>
                    <span class="text-lg text-gray-700 dark:text-gray-300 mb-4">:</span>
                    <div class="w-1/2 text-center">
                        <p class="text-green-600 dark:text-green-400 ml-1 mb-4 text-lg">{{ $schedule->session }}</p>
                    </div>
                </div>
                <!-- Flex Row Ends -->
            </div>
        </div>
    </div>
    <!-- Course Over View Ends -->
    <div class="text-center">
        <h1 class="text-black dark:text-white mb-4 text-2xl">Student Information</h1>
    </div>
    <!-- Apply Form -->
    <form action="#" method="POST">
        @csrf
        @method('POST')
        <x-student-info>
        </x-student-info>
    </form>
    <!-- Apply Form Ends -->
</x-app-layout>
