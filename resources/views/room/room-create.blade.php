@push('scripts')
    <!-- JQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{route('room.store')}}" method="POST">
                    @csrf

                    <!-- Room Number -->
                    <div class="mb-4">
                        <label for="room_number" class="block dark:text-white text-lg font-bold mb-2">Room Number</label>
                        <input type="number" name="room_number" id="room_number" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required placeholder="Enter Number Only">
                        <input type="hidden" name="hidden_room_number" id="hidden_room_number" readonly>
                    </div>

                    <!-- Floor Number -->
                    <div class="mb-4">
                        <label for="floor_number" class="block dark:text-white text-lg font-bold mb-2">Floor Number</label>
                        <input type="number" name="floor_number" id="floor_number" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required placeholder="Enter Number Only">
                    </div>

                    <!-- Seat Capacity -->
                    <div class="mb-4">
                        <label for="seat_capacity" class="block dark:text-white text-lg font-bold mb-2">Seat Capacity</label>
                        <input type="number" name="seat_capacity" id="seat_capacity" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" required placeholder="Enter Number Only">
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-row justify-between">
                        <x-button-cancel :cancelRoute="route('room')">
                            {{__('Cancel')}}
                        </x-button-cancel>
                        <x-button class="ms-4">
                            {{ __('Add') }}
                        </x-button>                                            
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function(){

        //Prefix Room Number
        $('#room_number').on("keyup",function(){
            $room_number = $('#room_number').val()
            $padded_number = $room_number.padStart(3,'0');
            $updated_room_number = "R-"+$padded_number;
            $('#hidden_room_number').val($updated_room_number);
            // console.log($updated_room_number);
        })
    });
</script>