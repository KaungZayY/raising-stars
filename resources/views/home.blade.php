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
                <a href="{{ route('post.create') }}" class="bg-green-500 text-white px-2 py-1 mb-6 rounded-md">Create Post</a>
            </div>
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="posts-container" class="text-white scrolling-pagination">
                    @if ($posts->count())
                        @foreach($posts as $post)
                        <div class="post bg-grey-200 dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-400">
                            <div class="flex flex-row bg-gray-300 dark:bg-gray-800 justify-between border border-dotted border-gray-300 p-4 rounded-md">
                                <div class="flex flex-col flex-grow" onclick="postDetail('{{ route('post.detail', $post) }}')">
                                    <h2 class="text-xl text-green-600 dark:text-green-400 font-semibold">{{ $post->user->name }}</h2>
                                    <br>
                                    <h3 class="text-lg font-bold mb-2 text-black dark:text-white">{{ $post->title }}</h3>
                                    <p class="text-black dark:text-gray-300 mb-4">{{ $post->content }}</p>
                                    <!-- Post Category Tags -->
                                    @if ($post->categories->isNotEmpty())
                                    <p class="text-gray-700 dark:text-gray-500">Categories: 
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
                                    @can('isOwnerOrAdmin',$post)
                                        <button onclick="toggleDropdownMenu(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="4" viewBox="0 0 128 512" style="margin-left: auto">
                                                <path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/>
                                            </svg>
                                        </button>
                                        <div class="hidden flex-row-reverse">
                                            @can('isOwner', $post)
                                                <form action="{{route('post.edit',$post->id)}}" method="GET">
                                                    <button class="bg-green-500 text-white px-2 py-1 mb-2 rounded-md w-full">Edit</button>
                                                </form>
                                            @endcan
                                            <form action="{{route('post.delete',$post->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="bg-red-500 text-white px-2 py-1 mb-2 rounded-md w-full">Delete</button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                            <div class="flex flex-row mt-2 ml-2 justify-between">
                                <div class="basis-1/2 mb-4 flex items-center justify-center">
                                    <button id="like-button-{{ $post->id }}" onclick="postLiked({{ $post->id }})" @if ($post->liked(auth()->user())) style="display:none" @endif>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 512 512" class="dark:fill-white">
                                            <path dark:fill="#000000" d="M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2H464c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48H294.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V320 272 247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192H96c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32z"/>
                                        </svg>
                                    </button>
                                    <button id="unlike-button-{{ $post->id }}" onclick="postUnLiked({{ $post->id }})" @if (!$post->liked(auth()->user())) style="display:none" @endif>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 512 512">
                                            <path fill="#22C55E" d="M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2H464c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48H294.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V320 272 247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192H96c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="basis-1/2 mb-4 flex items-center justify-center">
                                    <button onclick="toggleCommentBox(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 512 512" class="dark:fill-white">
                                            <path dark:fill="#000000" d="M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4l0 0 0 0 0 0 0 0 .3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex-row flex hidden">
                                <textarea name="comment" id="comment" rows="4" class="w-full ml-8 mb-4 px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 text-black"></textarea>
                                <button class=" mb-4 mr-2 ml-1 rounded-md" onclick="postCommented(this,{{$post->id}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 512 512">
                                        <path fill="#22C55E" d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480V396.4c0-4 1.5-7.8 4.2-10.7L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        <div style="display:none">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-lg text-center text-black dark:text-white">No Posts Here</p>
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

    function toggleCommentBox(button)
    {
        const commentBox = button.parentNode.parentNode.nextElementSibling;
        commentBox.classList.toggle('hidden');
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

    function postDetail(route_url)
    {
        window.location.href = route_url;
    }

    //like post
    function postLiked(post_id)
    {
        const flashMessageContainer = $('#flash-message-container');
        $.ajax({
            url: "{{ route('post.like') }}",
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'post_id': post_id,
            },
            beforeSend: function() {
                // Show the flash message container before the request is sent
                flashMessageContainer.empty();
                flashMessageContainer.show();
            },
            success: function() {
                // Handle the success response, e.g., update the UI
                $('#flash-message-container').html('<div style="background-color: #48bb78; color: #fff; padding: 0.5rem 1rem;">Post Liked</div>');
                // Toggle between like and unlike buttons
                $('#like-button-' + post_id).hide();
                $('#unlike-button-' + post_id).show();
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            },
            error: function() {
                // Handle the error response
                $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Cannot Do this Action</div>');
                // console.log("custom error");
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            }
        });
    }

    //Unlike Post JS Mechanic
    function postUnLiked(post_id)
    {
        const flashMessageContainer = $('#flash-message-container');
        $.ajax({
            url: "{{ route('post.unlike') }}",
            method: 'DELETE',
            data: {
                '_token': '{{ csrf_token() }}',
                'post_id': post_id,
            },
            beforeSend: function() {
                // Show the flash message container before the request is sent
                flashMessageContainer.empty();
                flashMessageContainer.show();
            },
            success: function() {
                // Handle the success response, e.g., update the UI
                $('#flash-message-container').html('<div style="background-color: #48bb78; color: #fff; padding: 0.5rem 1rem;">Like Removed</div>');
                // Toggle between like and unlike buttons
                $('#like-button-' + post_id).show();
                $('#unlike-button-' + post_id).hide();
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            },
            error: function(error) {
                // Handle the error response
                $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Cannot Do this Action, Unlike</div>');
                // console.error(error);
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            }
        });
    }

    function postCommented(button, post_id)
    {        
        const comment = button.previousElementSibling.value;
        const commentBoxSection = button.parentNode;

        const flashMessageContainer = $('#flash-message-container');
        flashMessageContainer.empty();

        //Validate
        if (comment.trim() === '') {
            flashMessageContainer.show();
            $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Type in Comment First</div>');
            setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            return;//Exit
        }

        //Ajax Request
        $.ajax({
            url: "{{ route('post.comment') }}",
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                'post_id': post_id,
                'comment': comment
            },
            beforeSend: function() {
                // Show the flash message container before the request is sent
                flashMessageContainer.empty();
                flashMessageContainer.show();
            },
            success: function() {
                button.previousElementSibling.value = '';
                //Hide the comment box again
                setTimeout(() => {
                    commentBoxSection.classList.add('hidden');
                }, 500);
                // Handle the success response, e.g., update the UI
                $('#flash-message-container').html('<div style="background-color: #48bb78; color: #fff; padding: 0.5rem 1rem;">Comment Posted</div>');
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 4000);
            },
            error: function() {
                // Handle the error response
                $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Cannot Do this Action</div>');
                // console.log("custom error");
                setTimeout(function() 
                {
                    flashMessageContainer.hide();
                }, 2000);
            }
        });


    }
</script>
