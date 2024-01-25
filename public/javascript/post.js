//menu toggle
function toggleDropdownMenu(button) {
    const dropdownMenu = button.nextElementSibling;
    dropdownMenu.classList.toggle('hidden');
}

function toggleCommentBox(button) {
    const commentBox = button.parentNode.parentNode.nextElementSibling;
    commentBox.classList.toggle('hidden');
}

document.addEventListener('click', function (event) {
    const dropdownMenus = document.querySelectorAll('.hidden');
    dropdownMenus.forEach(function (menu) {
        if (!menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
});


//like post
function postLiked(post_id) {
    const flashMessageContainer = $('#flash-message-container');
    $.ajax({
        url: likeRoute,
        method: 'POST',
        data: {
            '_token': csrf,
            'post_id': post_id,
        },
        beforeSend: function () {
            // Show the flash message container before the request is sent
            flashMessageContainer.empty();
            flashMessageContainer.show();
        },
        success: function () {
            // Handle the success response, e.g., update the UI
            $('#flash-message-container').html('<div style="background-color: #48bb78; color: #fff; padding: 0.5rem 1rem;">Post Liked</div>');
            // Toggle between like and unlike buttons
            $('#like-button-' + post_id).hide();
            $('#unlike-button-' + post_id).show();
            setTimeout(function () {
                flashMessageContainer.hide();
            }, 2000);
        },
        error: function () {
            // Handle the error response
            $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Cannot Do this Action</div>');
            // console.log("custom error");
            setTimeout(function () {
                flashMessageContainer.hide();
            }, 2000);
        }
    });
}

//Unlike Post JS Mechanic
function postUnLiked(post_id) {
    const flashMessageContainer = $('#flash-message-container');
    $.ajax({
        url: unlikeRoute,
        method: 'DELETE',
        data: {
            '_token': csrf,
            'post_id': post_id,
        },
        beforeSend: function () {
            // Show the flash message container before the request is sent
            flashMessageContainer.empty();
            flashMessageContainer.show();
        },
        success: function () {
            // Handle the success response, e.g., update the UI
            $('#flash-message-container').html('<div style="background-color: #48bb78; color: #fff; padding: 0.5rem 1rem;">Like Removed</div>');
            // Toggle between like and unlike buttons
            $('#like-button-' + post_id).show();
            $('#unlike-button-' + post_id).hide();
            setTimeout(function () {
                flashMessageContainer.hide();
            }, 2000);
        },
        error: function (error) {
            // Handle the error response
            $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Cannot Do this Action, Unlike</div>');
            // console.error(error);
            setTimeout(function () {
                flashMessageContainer.hide();
            }, 2000);
        }
    });
}

function postCommented(button, post_id) {
    const comment = button.previousElementSibling.value;
    const commentBoxSection = button.parentNode;

    const flashMessageContainer = $('#flash-message-container');
    flashMessageContainer.empty();

    //Validate
    if (comment.trim() === '') {
        flashMessageContainer.show();
        $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Type in Comment First</div>');
        setTimeout(function () {
            flashMessageContainer.hide();
        }, 2000);
        return;//Exit
    }
    //Ajax Request
    $.ajax({
        url: commentRoute,
        method: 'POST',
        data: {
            '_token': csrf,
            'post_id': post_id,
            'comment': comment
        },
        beforeSend: function () {
            // Show the flash message container before the request is sent
            flashMessageContainer.empty();
            flashMessageContainer.show();
        },
        success: function () {
            button.previousElementSibling.value = '';
            //Hide the comment box again
            setTimeout(() => {
                commentBoxSection.classList.add('hidden');
            }, 500);
            // Handle the success response, e.g., update the UI
            $('#flash-message-container').html('<div style="background-color: #48bb78; color: #fff; padding: 0.5rem 1rem;">Comment Posted</div>');
            setTimeout(function () {
                flashMessageContainer.hide();
            }, 4000);
        },
        error: function () {
            // Handle the error response
            $('#flash-message-container').html('<div style="background-color: #e40f0f; color: #fff; padding: 0.5rem 1rem;">Cannot Do this Action</div>');
            // console.log("custom error");
            setTimeout(function () {
                flashMessageContainer.hide();
            }, 2000);
        }
    });


}

