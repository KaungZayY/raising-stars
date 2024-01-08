<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Schedules for ') }}{{$course->course}} ({{$session}})
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap mx-auto w-3/4">
                @if ($schedules->count())
                    @foreach ($schedules as $schedule)
                        
                    @endforeach
                @else
                    <div class="flex mx-auto justify-center">
                        <p class="text-lg text-center text-black dark:text-white">No Available Courses</p>
                    </div>                
                @endif
            </div>
        </div>
    </div>
</x-app-layout>