<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Groups') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap mx-auto w-3/4">
                @if ($groups->count())
                    @foreach ($groups as $group)
                        <div class="w-1/2 text-center">
                            <div class="flex flex-col justify-center m-3 bg-fuchsia-400 dark:bg-fuchsia-200 rounded-lg border border-gray-200" onclick="">
                                <h2 class="font-bold mt-2 mb-2">{{$group->name}}</h2>
                                <p class="mb-2">Description : {{$group->description}}</p>
                                <p class="mb-2">Participants : {{$group->users_count}}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="flex mx-auto justify-center">
                        <p class="text-lg text-center text-black dark:text-white">You are not in a group</p>
                    </div>                
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function viewGroup(route_url)
    {
        window.location.href = route_url;
    }
</script>