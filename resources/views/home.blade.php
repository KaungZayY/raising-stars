@push('scripts')
    <!-- JScroll CDN links -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-end">
                <a href="{{ route('post.create') }}" class="bg-red-500 text-white px-2 py-1 mb-6 rounded-md">Create Post</a>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="posts-container" class="text-white scrolling-pagination">
                    @if ($posts->count())
                        @foreach($posts as $post)
                            <div class="post flex flex-row justify-between border-b border-dotted border-gray-300 p-4 rounded-md">
                                <div class="flex flex-col">
                                    <br>
                                    <h2 class="text-xl font-semibold">{{ $post->user->name }}</h2>
                                    <h3 class="text-lg font-bold mb-2">{{ $post->title }}</h3>
                                    <p class="text-gray-300 mb-4">{{ $post->content }}</p>
                                    <!-- Post Category Tags -->
                                    @if ($post->categories->isNotEmpty())
                                    <p class="text-gray-500">Categories: 
                                        @foreach ($post->categories as $category)
                                            {{$category->category}}
                                            @unless ($loop->last), @endunless
                                            {{-- above line adding coma after each loop, unless for the last item --}}
                                        @endforeach
                                    </p>
                                    @endif
                                    <br>
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-sm text-gray-500" style="margin-left: auto">{{ $post->created_at->diffForHumans() }}</p>
                                    <br>
                                    <button onclick="toggleDropdownMenu(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="4" viewBox="0 0 128 512" style="margin-left: auto">
                                            <path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/>
                                        </svg>
                                    </button>
                                    <div class="hidden flex-row-reverse">
                                        <br>
                                        <form action="{{route('post.edit',$post->id)}}" method="GET">
                                            <button class="bg-green-500 text-white px-2 py-1 mb-2 rounded-md w-full">Edit</button>
                                        </form>
                                        <form action="{{route('post.delete',$post->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-500 text-white px-2 py-1 mb-2 rounded-md w-full">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div style="display:none">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-lg text-center">No Posts Here</p>
                    @endif
                </div>                
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    $(document).ready(function() //jquery ready func
    {
        //jscroll 
        $('.scrolling-pagination').jscroll(
        {
            autoTrigger: true,
            padding: 0,
            nextSelector: 'a[rel="next"]',
            contentSelector: '.post',
            callback: function() {
                $('ul.pagination').remove();
            },
            errorCallback: function() {
                console.log('Error loading next page.');
            }
        });
    });

    //menu toggle
    function toggleDropdownMenu(button) 
    {
        const dropdownMenu = button.nextElementSibling;
        dropdownMenu.classList.toggle('hidden');
    }

    document.addEventListener('click', function (event) 
    {
        const dropdownMenus = document.querySelectorAll('.hidden');
        dropdownMenus.forEach(function (menu) {
            if (!menu.contains(event.target)) 
            {
                menu.classList.add('hidden');
            }
        });
    });
</script>
