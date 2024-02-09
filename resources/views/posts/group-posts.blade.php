@push('scripts')
    <!-- JScroll CDN links -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            "{{$group->name}}" Group Discussion
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-end">
                <a href="{{ route('post.create',$group->id) }}" class="bg-green-500 text-white px-2 py-1 mb-6 rounded-md">Create Post</a>
            </div>
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div id="posts-container" class="text-white scrolling-pagination">
                    @if ($posts->count())
                        @foreach($posts as $post)
                        <div class="post bg-grey-200 dark:bg-gray-800 shadow-sm sm:rounded-lg border border-gray-400 mb-3 mt-3">
                            <x-post-card :post="$post" :showGpName="false">
                            </x-post-card>
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