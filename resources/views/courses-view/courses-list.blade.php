<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Available Courses') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap mx-auto w-3/4">
                @foreach ($courses as $course)
                    <div class="w-1/2 text-center">
                        <div class="flex flex-col justify-center m-3 bg-green-400 dark:bg-green-200 rounded-lg border border-gray-200">
                            <h2 class="font-bold mt-2 mb-2">{{$course->course}}</h2>
                            <p class="mb-2">Age : {{$course->from_age}} to {{$course->to_age}}</p>
                            <p class="mb-2">Fees : <u>{{$course->fees}}</u> mmk</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>