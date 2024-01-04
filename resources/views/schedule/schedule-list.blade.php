<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Scheduled Courses') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-between">
                <form action="#" method="GET">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" height="32" width="24" viewBox="0 0 448 512">
                            <path fill="#fde047" d="M163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3C140.6 6.8 151.7 0 163.8 0zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm192 64c-6.4 0-12.5 2.5-17 7l-80 80c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V408c0 13.3 10.7 24 24 24s24-10.7 24-24V273.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-4.5-4.5-10.6-7-17-7z"/>
                        </svg>
                    </button>
                </form>
                <a href="{{route('schedule.create')}}" class="bg-green-500 text-white px-2 py-1 mb-6 rounded-md">Schedule New Course</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 border-separate">
                  <thead class="with-larasort">
                    <tr>
                        <th class="py-2 px-4 border-b bg-orange-400">No</th>
                        <th class="py-2 px-4 border-b bg-orange-400">@sortableLink('start_date', 'Start Date')</th>
                        <th class="py-2 px-4 border-b bg-orange-400">@sortableLink('end_date', 'End Date')</th>
                        <th class="py-2 px-4 border-b bg-orange-400">@sortableLink('duration', 'Duration')</th>
                        <th class="py-2 px-4 border-b bg-orange-400">Course</th>
                        <th class="py-2 px-4 border-b bg-orange-400">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                @if ($schedules->count())
                    @foreach ($schedules as $schedule)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{$loop->iteration}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$schedule->start_date}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$schedule->end_date}}</td>
                        <!-- Duration Calculation -->
                        <td class="py-2 px-4 border-b text-center">
                            @php
                                $startDate = new \DateTime($schedule->start_date);
                                $endDate = new \DateTime($schedule->end_date);
                                $dateDiff = date_diff($startDate,$endDate);
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
                        </td>
                        <!-- Duration Calculation Ends-->
                        <td class="py-2 px-4 border-b text-center">{{$schedule->course->course}}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="inline-block">
                                <form action="#" method="GET">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#000000" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <span class="ml-2 mr-2">|</span>
                            <div class="inline-block">
                                <form action="#" method="GET">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#22C55E" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <span class="ml-2 mr-2">|</span>
                            <div class="inline-block">
                                <form action="#" method="POST" onsubmit="return confirm('Move this Data to Archives?');">
                                    @csrf
                                    @method('DELETE')
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                            <path fill="#EF4444" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="py-2 px-4 text-center" colspan="6">No Data found</td>
                    </tr>
                @endif
                  </tbody>
                </table>
              </div>

        </div>
    </div>
</x-app-layout>