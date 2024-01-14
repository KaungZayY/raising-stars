@push('scripts')
    <!-- JQuery Ajax -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Moderator List') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-3 flex flex-row justify-center">
                <input type="text" name="search" id="search" class="w-1/3 px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500" placeholder="Search by Name... &#x1F50E;&#xFE0F; "/>
            </div>
            <div class="flex flex-row justify-between">
                <form action="{{route('moderator.archives')}}" method="GET">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" height="32" width="24" viewBox="0 0 448 512">
                            <path fill="#fde047" d="M163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3C140.6 6.8 151.7 0 163.8 0zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm192 64c-6.4 0-12.5 2.5-17 7l-80 80c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V408c0 13.3 10.7 24 24 24s24-10.7 24-24V273.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-4.5-4.5-10.6-7-17-7z"/>
                        </svg>
                    </button>
                </form>
                <a href="{{route('moderator.create')}}" class="bg-green-500 text-white px-2 py-1 mb-6 rounded-md">Add New Moderator</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 border-separate">
                  <thead class="with-larasort">
                    <tr>
                        <th class="py-2 px-4 border-b bg-fuchsia-400">No</th>
                        <th class="py-2 px-4 border-b bg-fuchsia-400">@sortableLink('name', 'Name')</th>
                        <th class="py-2 px-4 border-b bg-fuchsia-400">@sortableLink('email', 'Email')</th>
                        <th class="py-2 px-4 border-b bg-fuchsia-400">@sortableLink('phone_number', 'Phone Number')</th>
                        <th class="py-2 px-4 border-b bg-fuchsia-400">@sortableLink('address', 'Address')</th>
                        <th class="py-2 px-4 border-b bg-fuchsia-400">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                @if ($moderators->count())
                    @foreach ($moderators as $moderator)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{$loop->iteration}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$moderator->name}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$moderator->email}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$moderator->phone_number}}</td>
                        <td class="py-2 px-4 border-b text-center">{{$moderator->address}}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="inline-block">
                                <form action="{{route('moderator.edit',$moderator->id)}}" method="GET">
                                    <button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#22C55E" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <span class="ml-2 mr-2">|</span>
                            <div class="inline-block">
                                <form action="{{route('moderator.delete',$moderator->id)}}" method="POST" onsubmit="return confirm('Move this Data to Archives?');">
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
            <div class="flex flex-row justify-end mt-3">
                <form action="{{route('moderator.export')}}" method="GET">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 active:bg-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="18" viewBox="0 0 384 512" class="mr-2">
                            <path fill="#ffffff" d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z"/>
                        </svg>
                        Excel Download
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>

<script>
    $('#search').on('keyup',function(){
        $value = $(this).val();
        $.ajax({
            url: "{{route('moderator.search')}}",
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