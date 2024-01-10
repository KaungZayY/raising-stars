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
    @php
        $courseId = $schedule->course->id;
        $userId = Auth::user()->id;
        $courseAlreadyApplied = \App\Models\Schedule::where('course_id', $courseId)
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->exists();
    @endphp
    <!-- Course Over View Ends -->
    @if (Auth::user()->schedules()->where('schedule_id', $schedule->id)->exists())
        <div class="text-center">
            <h1 class="text-yellow-500 mb-4 text-2xl">You already Have Applied for {{$schedule->course->course}} {{$schedule->session}} Course</h1>
        </div>
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-20">
            <x-button-cancel :cancelRoute="route('courses.bysession', [
                'course' => $schedule->course->id,
                'session' => $schedule->session,
            ])">
                {{ __('Cancel') }}
            </x-button-cancel>
        </div>
    @elseif($courseAlreadyApplied)
        <div class="text-center">
            <h1 class="text-red-500 mb-4 text-2xl">You already Have Applied for {{$schedule->course->course}} Course</h1>
        </div>
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 mt-20">
            <x-button-cancel :cancelRoute="route('courses.bysession', [
                'course' => $schedule->course->id,
                'session' => $schedule->session,
            ])">
                {{ __('Cancel') }}
            </x-button-cancel>
        </div>
    @else
        <div class="text-center">
            <h1 class="text-black dark:text-white mb-4 text-2xl">Student Information</h1>
        </div>

        <!-- Apply Form -->
        <form action="{{ route('schedule.apply', $schedule->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if (Auth::user()->studentInfo()->exists())
                <x-student-info-data-exists :studentInfo="$studentInfo">
                </x-student-info-data-exists>
            @else
                <x-student-info>
                </x-student-info>
            @endif

            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 bg-gray-200 dark:bg-gray-700 rounded-lg mt-8">
                <div class="flex flex-col">
                    <!-- Receipt -->
                    <div class="flex flex-row border border-gray-400 dark:border-gray-600">
                        <div class="flex flex-row w-full mb-2 mt-2 items-center">
                            <div class="w-1/2 text-right mt-2 mb-2 mr-4">
                                <label for="receipt" class="block dark:text-white text-lg font-bold">Receipt
                                    Screenshot</label>
                                @error('receipt')
                                    <br>
                                @enderror
                            </div>
                            <div class="w-1/2 text-left ml-4">
                                <input type="file" name="receipt" id="receipt"
                                    class="w-3/5 border rounded-sm focus:outline-none focus:border-blue-500" required>
                                @error('receipt')
                                    <p class="text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- Receipt Ends -->
                    <div class="flex flex-row">
                        <div class="flex flex-row flex-grow w-full mb-2 mt-2 items-center">
                            <div class="w-1/2 text-center mt-2">
                                <x-button-cancel :cancelRoute="route('courses.bysession', [
                                    'course' => $schedule->course->id,
                                    'session' => $schedule->session,
                                ])">
                                    {{ __('Cancel') }}
                                </x-button-cancel>
                            </div>
                            <div class="w-1/2 text-center">
                                <x-button class="ms-4">
                                    {{ __('Register') }}
                                </x-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <br>
        <!-- Apply Form Ends -->
    @endif


</x-app-layout>
