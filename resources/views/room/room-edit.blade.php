<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{route('room.update',$room->id)}}" method="POST">
                    @csrf

                    <!-- Room Number -->
                    <div class="mb-4">
                        <label for="room_number" class="block dark:text-white text-lg font-bold mb-2">Room Number</label>
                        <input type="text" name="room_number" id="room_number" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required value="{{$room->room_number}}" readonly>
                    </div>

                    <!-- Floor Number -->
                    <div class="mb-4">
                        <label for="floor_number" class="block dark:text-white text-lg font-bold mb-2">Floor Number</label>
                        <input type="number" name="floor_number" id="floor_number" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required value="{{$room->floor_number}}">
                    </div>

                    <!-- Seat Capacity -->
                    <div class="mb-4">
                        <label for="seat_capacity" class="block dark:text-white text-lg font-bold mb-2">Seat Capacity</label>
                        <input type="number" name="seat_capacity" id="seat_capacity" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required value="{{$room->seat_capacity}}">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-row justify-between">
                        <x-button-cancel :cancelRoute="route('room')">
                            {{__('Cancel')}}
                        </x-button-cancel>
                        <x-button class="ms-4">
                            {{ __('Update') }}
                        </x-button>                                            
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
