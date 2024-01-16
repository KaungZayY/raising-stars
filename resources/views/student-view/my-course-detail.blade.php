<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$course->course}}{{ __(' Course Detail') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-8">
        <form action="{{route('myCourses')}}" method="GET">
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded mb-4">
                Back
            </button>
        </form>
    </div>
    <div>
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="mx-auto">
                @if ($course->count())
                    <div class="flex flex-row justify-between">
                        <div class="flex flex-col">
                            <h1 class="text-black dark:text-white mb-4 text-xl">Course Information</h1>
                            <h1 class="text-gray-700 dark:text-gray-300 mb-2">Age between</h1>
                            <p class="text-green-600 dark:text-green-400 mb-2">{{ $course->from_age }} -
                                {{ $course->to_age }}</p>
                            <h1 class="text-gray-700 dark:text-gray-300 mb-2">Course Description</h1>
                            <p class="text-green-600 dark:text-green-400 mb-2">{{ $course->description }}</p>
                        </div>

                        <!-- Modules -->
                        <div class="flex flex-col">
                            <h1 class="text-black dark:text-white mb-4 text-xl text-center">Modules</h1>
                            <table class="min-w-full bg-white border border-gray-300 border-separate">
                                <thead class="with-larasort">
                                    <tr>
                                        <th class="py-2 px-4 border-b bg-pink-300">No</th>
                                        <th class="py-2 px-4 border-b bg-pink-300">Module Number</th>
                                        <th class="py-2 px-4 border-b bg-pink-300">Subject</th>
                                        <th class="py-2 px-4 border-b bg-pink-300">Lecturers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($course->modules->count())
                                        @foreach ($course->modules as $module)
                                            <tr>
                                                <td class="py-2 px-4 border-b text-center">{{ $loop->iteration }}</td>
                                                <td class="py-2 px-4 border-b text-center">{{ $module->module_number }}
                                                </td>
                                                <td class="py-2 px-4 border-b text-center">
                                                    {{ $module->subject->subject }}</td>
                                                <!-- Lecturers -->
                                                <td class="py-2 px-4 border-b text-center">
                                                    <p>
                                                        @foreach ($module->lecturers as $lecturer)
                                                            {{ $lecturer->name }}
                                                            @unless ($loop->last)
                                                                ,
                                                            @endunless
                                                            <br>
                                                        @endforeach
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="py-2 px-4 text-center" colspan="4">No Data found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- Module Ends -->
                    </div>
                    <!-- Course Info and Modules Ends -->
                @else
                    <div class="flex mx-auto justify-center">
                        <p class="text-lg text-center text-black dark:text-white">No Available Courses</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
