@push('scripts')
    <!-- JQuery Ajax -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Requested Forms') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="mb-3 flex flex-row justify-center">
                <input type="text" name="search" id="search" class="w-1/3 px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" placeholder="Search by Student Name..&#x1F50E;&#xFE0F; "/>
            </div> --}}
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 border-separate">
                  <thead>
                    <tr>
                        <th class="py-2 px-4 border-b bg-gray-300">No</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Course</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Start Date</th>
                        <th class="py-2 px-4 border-b bg-gray-300">End Date</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Session</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Submitted At</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Updated At</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Status</th>
                        <th class="py-2 px-4 border-b bg-gray-300">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                @if ($courses->count())
                    @foreach ($courses as $course)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{$loop->iteration}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$course->course}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$course->start_date}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$course->end_date}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$course->session}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$course->created_at}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$course->updated_at}}</td>
                        <td class="py-2 px-4 border-b text-center text-white" style="background-color: {{$course->status === 'rejected' ? 'red' : ($course->status === 'approved' ? 'green' : 'yellow')}}">{{$course->status}}</td>
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
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="py-2 px-4 text-center" colspan="9">No New Pending Lists</td>
                    </tr>
                @endif
                  </tbody>
                </table>
              </div>

        </div>
    </div>
</x-app-layout>

<script>
    $('#search').on('keyup',function(){
        $value = $(this).val();
        $.ajax({
            url: "{{route('pending.search')}}",
            method: 'GET',
            data: {
                '_token': '{{ csrf_token() }}',
                'search': $value,
            },
            success: function(data) {
                $('tbody').html(data);
            },
        });
    });
</script>