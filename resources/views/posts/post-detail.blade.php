@push('scripts')
    <!-- JScroll CDN links -->
    <!-- '@'push to push to master layout, '@'stack('scripts')in master to fetch this script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-row justify-start">
                <a href="{{ route('home') }}" class="dark:bg-red-500 text-white px-2 py-1 mb-6 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="30" viewBox="0 0 512 512"><path d="M512 256A256 256 0 1 0 0 256a256 256 0 1 0 512 0zM231 127c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-71 71L376 232c13.3 0 24 10.7 24 24s-10.7 24-24 24l-182.1 0 71 71c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L119 273c-9.4-9.4-9.4-24.6 0-33.9L231 127z"/></svg>
                </a>
            </div>
            <x-post-detail-card :post="$post">
            </x-post-detail-card>
        </div>
    </div>
</x-app-layout>

<script>
    
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
                location.reload();
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

    function showEditCommentBox(button)
    {
        const commentDiv = button.parentNode.parentNode.previousElementSibling.children[1];
        const editCommentBox = button.parentNode.parentNode.previousElementSibling.lastElementChild;
        commentDiv.classList.toggle('hidden');
        editCommentBox.classList.toggle('hidden');
    }
</script>