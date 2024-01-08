<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Available Courses') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap mx-auto w-3/4 mt-9">
                @if ($sessions->count())
                    @foreach ($sessions as $session)
                        <div class="w-1/2 text-center">
                            <div class="flex flex-col justify-center m-6 bg-green-400 dark:bg-green-200 rounded-lg border border-gray-200">
                                <h2 class="font-bold mt-5 mb-5 text-xl">{{$session}}</h2>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex mx-auto justify-center">
                        <p class="text-lg text-center text-black dark:text-white">No Sessions Available Right Now</p>
                    </div>                
                @endif
            </div>
        </div>
    </div>
</x-app-layout>