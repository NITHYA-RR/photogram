
var $grid = $('#masonry-area').masonry({
  itemSelector: '.col-sm-6',
  percentPosition: true,
  columnWidth: '.col-sm-6'
})
    $grid.imagesLoaded().progress(function() {
      $grid.masonry('layout');
    });

$.post('/libs/posts/count.php',function(data) {
    console.log(data);
    $('#post-total').html("Total posts: " + data.count);
}).fail(function(error) {
    console.error('Error:', error);
});

// Use event delegation for better handling of dynamically added elements
$(document).on('click', '.btn-like', function(){
    var post_id = $(this).parent().attr('data-id');
    var $this = $(this);
    $(this).html() == "Like" ? $(this).html("Liked") : $(this).html("Like");
    $(this).hasClass('btn-outline-primary') ? $(this).removeClass('btn-outline-primary').addClass('btn-primary') : $(this).removeClass('btn-primary').addClass('btn-outline-primary');
    $.post('/libs/posts/like.php', {
        id: post_id
    }, function(data, textSuccess, xhr){
        // Try to parse JSON if needed
        if (typeof data === "string") {
            try { data = JSON.parse(data); } catch(e) {}
        }
        if(textSuccess == "success" && data && data.liked !== undefined){
            if(data.liked){
                $($this).html("Liked");
                $($this).removeClass('btn-outline-primary').addClass('btn-primary');
            } else {
                $($this).html("Like");
                $($this).removeClass('btn-primary').addClass('btn-outline-primary');
            }
        }
    }).fail(function(xhr, status, error) {
        console.error('Like request failed:', error);
    });
});

$(document).on('click', '.btn-delete', function(){
    var post_id = $(this).parent().attr('data-id');
    var d = new Dialog("Delete Post", "Are you sure want to remove this post");
    d.setButtons([
        {
            'name': "Delete",
            "class": "btn-danger",
            "onClick": function(event){
                console.log(`Assume this post ${post_id} is deleted`);
                
                $.post('/libs/posts/delete.php',
                {
                    id: post_id
                }, function(data, textSuccess, xhr){
                    console.log(textSuccess);
                    console.log(data);
                    if(textSuccess =="success" ){ //means 200
                        // Remove the element and update Masonry layout properly
                        var $item = $(`#post-${post_id}`);
                        $item.remove();
                        $grid.masonry('reloadItems');
                        $grid.masonry('layout');
                        updatePostCount();
                    }
                });
                $(event.data.modal).modal('hide')
            }
        },
        {
            'name': "Cancel",
            "class": "btn-secondary",
            "onClick": function(event){
                $(event.data.modal).modal('hide');
            }
        }
    ]);
    d.show();
});

// Handle post form submission via AJAX
console.log('Setting up form submit handler...');
console.log('Form element found:', $('#post-form').length);

if ($('#post-form').length === 0) {
    console.error('Post form not found!');
} else {
    console.log('Post form found, attaching submit handler...');
}

$('#post-form').on('submit', function(e) {
    e.preventDefault();
    console.log('Form submitted!');
    console.log('Form data:', $(this).serialize());
    
    var formData = new FormData(this);
    console.log('FormData created:', formData);
    
    // Test if we can access form fields
    console.log('Post text value:', $('#post_text').val());
    console.log('File input:', $('#inputGroupFile02')[0].files[0]);
    
    // Check if form has required data
    var postText = formData.get('post_text');
    var postImage = formData.get('post_image');
    console.log('Post text:', postText);
    console.log('Post image:', postImage);
    
    if (!postText || !postImage) {
        showToast('Please fill in both text and image fields.', 'error');
        return;
    }
    
    var $submitBtn = $('#share-btn');
    var originalText = $submitBtn.text();
    
    // Disable submit button and show loading state
    $submitBtn.prop('disabled', true).text('Sharing...');
    
    console.log('Sending AJAX request to:', '/libs/posts/add.php');
    $.ajax({
        url: '/libs/posts/add.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Success response:', response);
            
            // Check if response is a string and try to parse it
            if (typeof response === 'string') {
                try {
                    response = JSON.parse(response);
                } catch(e) {
                    console.error('Failed to parse response:', e);
                }
            }
            
            if (response && response.success && response.post) {
                console.log('Post created successfully:', response.post);
                // Create new post HTML
                var $newElem = $(createPostHtml(response.post));
                
                // Add to the beginning of the grid
                $('#masonry-area').prepend($newElem);
                
                // Wait for images to load, then update Masonry
                $newElem.imagesLoaded(function() {
                    $grid.masonry('reloadItems');
                    $grid.masonry('layout');
                });
                
                // Clear the form
                $('#post-form')[0].reset();
                // Show success message
                showToast('Post shared successfully!', 'success');
                // Update post count
                updatePostCount();
            } else {
                console.log('Response indicates failure:', response);
                showToast('Failed to share post. Please try again.', 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            console.error('Response:', xhr.responseText);
            
            var errorMessage = 'Failed to share post. Please try again.';
            if (xhr.responseText) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch(e) {
                    // If not JSON, use the raw response
                    errorMessage = xhr.responseText;
                }
            }
            
            showToast(errorMessage, 'error');
        },
        complete: function() {
            // Re-enable submit button
            $submitBtn.prop('disabled', false).text(originalText);
        }
    });
});

// Test button click handler
$('#share-btn').on('click', function() {
    console.log('Share button clicked!');
});

// Function to create post HTML
function createPostHtml(post) {
    return `
        <div class="col-sm-6 col-lg-4 mb-4" id="post-${post.id}">
            <div class="card shadow-sm">
                <img src="${post.image_url}" class="bd-placeholder-img card-img-top" width="100%">
                <div class="card-body">
                    <p class="card-text">${post.post_text}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group" data-id="${post.id}">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-like">Like</button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                        </div>
                        <small class="text-muted">${post.created_at} by You</small>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Function to update post count
function updatePostCount() {
    $.post('/libs/posts/count.php', function(data) {
        $('#post-total').html("Total posts: " + data.count);
    }).fail(function(error) {
        console.error('Error:', error);
    });
}

// Function to show toast messages
function showToast(message, type) {
    // You can implement this with your existing toast system
    console.log(type + ': ' + message);
    // If you have a toast system, use it here
    // showToastMessage(message, type);
}

// Attach event handlers to existing posts when page loads
$(document).ready(function() {
    attachEventHandlers($('#masonry-area'));
});
