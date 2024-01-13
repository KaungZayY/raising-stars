<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Courses') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap mx-auto w-3/4">
                @if ($courses->count())
                    @foreach ($courses as $course)
                        <div class="w-1/2 text-center">
                            <div class="flex flex-col justify-center m-3 bg-green-400 dark:bg-green-200 rounded-lg border border-gray-200"
                                onclick="">
                                <h2 class="font-bold mt-2 mb-2">{{ $course->course }}</h2>
                                <p class="mb-2 font-semibold">{{$course->session}} Session</p>
                                <p class="mb-2 font-semibold"><i>{{ $course->start_date }}</i> -To-
                                    <i>{{ $course->end_date }}</i></p>
                                <p class="mb-2">
                                    @php
                                        $startDate = new \DateTime($course->start_date);
                                        $endDate = new \DateTime($course->end_date);
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

{{-- <script>
    //Update On Click Function
    function courseDetail(route_url)
    {
        window.location.href = route_url;
    }
</script> --}}
