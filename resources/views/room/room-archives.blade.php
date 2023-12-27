<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Deleted Rooms') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-between">
                <form action="{{route('room')}}" method="GET">
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded mb-4">
                        Back
                    </button>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 border-separate">
                  <thead>
                    <tr>
                        <th class="py-2 px-4 border-b bg-gray-300">No</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Room Number</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Floor Number</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Seat Capacity</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Deleted At</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($rooms->count())
                        @foreach ($rooms as $room)
                        <tr>
                            <td class="py-2 px-4 border-b text-center">{{$loop->iteration}}</td>
                            <td class="py-2 px-4 border-b text-center">{{$room->room_number}}</td>
                            <td class="py-2 px-4 border-b text-center">{{$room->floor_number}}</td>
                            <td class="py-2 px-4 border-b text-center">{{$room->seat_capacity}}</td>
                            <td class="py-2 px-4 border-b text-center">{{$room->deleted_at}}</td>
                            <td class="py-2 px-4 border-b text-center">
                                <div class="inline-block">
                                    <form action="{{route('room.restore',$room->id)}}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                                <path d="M48.5 224H40c-13.3 0-24-10.7-24-24V72c0-9.7 5.8-18.5 14.8-22.2s19.3-1.7 26.2 5.2L98.6 96.6c87.6-86.5 228.7-86.2 315.8 1c87.5 87.5 87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3c-62.2-62.2-162.7-62.5-225.3-1L185 183c6.9 6.9 8.9 17.2 5.2 26.2s-12.5 14.8-22.2 14.8H48.5z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                <span class="ml-2 mr-2">|</span>
                                <div class="inline-block">
                                    <form action="{{route('room.forcedelete',$room->id)}}" method="POST" onsubmit="return confirm('Are You Sure to Remove this Data?');">
                                        @csrf
                                        @method('DELETE')
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                                <path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z"/>
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