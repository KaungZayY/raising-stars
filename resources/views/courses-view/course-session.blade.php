<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Available Courses') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap mx-auto justify-between">
                <form action="{{route('courses')}}" method="GET">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded mb-4">
                        Back
                    </button>
                </form>
            </div>
            <div class="flex flex-wrap mx-auto w-3/4 mt-5">
                @if ($sessions->count())
                    @foreach ($sessions as $session)
                        <div class="w-1/2 text-center">
                            <div class="flex flex-col justify-center m-6 bg-green-400 dark:bg-green-200 rounded-lg border border-gray-200 flex-grow" onclick="viewCourses('{{route('courses.bysession',['course'=>$course->id,'session'=>$session])}}')">
                                <h2 class="font-bold mt-5 mb-5 text-xl">{{$session}}</h2>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex mx-auto justify-center">
                        <p class="text-lg text-center text-black dark:text-white">No Schedule Available for this Course Right Now</p>
                    </div>                
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function viewCourses(route_url)
    {
        window.location.href = route_url;
    }
</script>