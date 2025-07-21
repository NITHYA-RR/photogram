var $grid = $('#masonry-area').masonry({
  itemSelector: '.col-sm-6',
      percentPosition: true
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

$(document).on('click', '.btn-delete', function () {
  let postId = $(this).parent().attr('data-id'); // OR: $(this).attr('data-id')
  
  let content = "Are you sure you want to delete this post?";
  let bt_name = "Delete";

  let d = new Dialog(content, "Delete Post");
  d.setButtons([
    {
      name: "Cancel",
      class: 'btn-secondary',
      onClick: function(event){
        $(event.data.modal).modal('hide');
      }
    },
    {
      name: bt_name,
      class: 'btn-danger btn-loading',
      
      onClick: function(event){
        console.log("Post deleted:", postId);
        //$('#post-' + postId).remove();
        $.post('/libs/posts/delete.php',
          {
            id : postId
          },function(data, textSuccessed){
            console.log(textSuccessed);
            console.log(data);
            if(textSuccessed === "success") {
              $('#post-' + postId).remove();
              // $grid.masonry('layout');
              // let count = parseInt($('#post-total').text().replace("Total posts: ", ""));
              // $('#post-total').html("Total posts: " + (count - 1));
            }
          }

        );

        $(event.data.modal).modal('hide');
      }
    }
  ]);
  d.show("danger");
});
