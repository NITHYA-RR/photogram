
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
$('.btn-like').on('click', function(){
  post_id = $(this).parent().attr('data-id');
  $this = $(this);
  $(this).html() == "Like" ? $(this).html("Liked") : $(this).html("Like");
  $(this).hasClass('btn-outline-primary') ? $(this).removeClass('btn-outline-primary').addClass('btn-primary') : $(this).removeClass('btn-primary').addClass('btn-outline-primary');
  $.post('/api/posts/like', {
      id: post_id
  }, function(data, textSuccess, xhr){
      if(textSuccess == "success"){
          if(data.liked){
              $($this).html("Liked");
              $($this).removeClass('btn-outline-primary').addClass('btn-primary');
          } else {
              $($this).html("Like");
              $($this).removeClass('btn-primary').addClass('btn-outline-primary');
          }
      }
  });
});
$('.btn-delete').on('click', function(){
  post_id = $(this).parent().attr('data-id');
  d = new Dialog("Delete Post", "Are you sure want to remove this post");
  d.setButtons([
      {
          'name': "Delete",
          "class": "btn-danger",
          "onClick": function(event){
              console.log(`Assume this post ${post_id} is deleted`);
              // $(`#post-${post_id}`).remove();
              
              $.post('/libs/posts/delete.php',
              {
                  id: post_id
              }, function(data, textSuccess, xhr){
                  console.log(textSuccess);
                  console.log(data);
                  if(textSuccess =="success" ){ //means 200
                      $(`#post-${post_id}`).remove();
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
// $('.btn-delete').on('click', function(){
//   post_id = $(this).parent().attr('data-id');
//   d = new Dialog("Delete Post", "Are you sure want to remove this post");
//   d.setButtons([
//       {
//           'name': "Delete",
//           "class": "btn-danger",
//           "onClick": function(event){
//               console.log(`Assume this post ${post_id} is deleted`);
//               // $(`#post-${post_id}`).remove();
              
//               $.post('/api/posts/delete',
//               {
//                   id: post_id
//               }, function(data, textSuccess, xhr){
//                   console.log(textSuccess);
//                   console.log(data);
//                   if(textSuccess =="success" ){ //means 200
//                       $(`#post-${post_id}`).remove();
//                   }
//               });
//               $(event.data.modal).modal('hide')
//           }
//       },
//       {
//           'name': "Cancel",
//           "class": "btn-secondary",
//           "onClick": function(event){
//               $(event.data.modal).modal('hide');
//           }
//       }
//   ]);
//   d.show();
// });


// $(document).on('click', '.btn-delete', function () {
//   let postId = $(this).parent().attr('data-id'); // OR: $(this).attr('data-id')
  
//   let content = "Are you sure you want to delete this post?";
//   let bt_name = "Delete";

//   let d = new Dialog(content, "Delete Post");
//   d.setButtons([
//     {
//       name: "Cancel",
//       class: 'btn-secondary',
//       onClick: function(event){
//         $(event.data.modal).modal('hide');
//       }
//     },
//     {
//       name: bt_name,
//       class: 'btn-danger btn-loading',
      
//       onClick: function(event){
//         console.log("Post deleted:", postId);
//         $.post('/libs/posts/delete.php',
//           {
//             id : postId
//           }, function(data) {
//             // Try to parse JSON if needed
//             if (typeof data === "string") {
//               try { data = JSON.parse(data); } catch(e) {}
//             }
//             if (data && data.message === "success") {
//               $('#post-' + postId).remove();
//               // $grid.masonry('layout');
//               // let count = parseInt($('#post-total').text().replace("Total posts: ", ""));
//               // $('#post-total').html("Total posts: " + (count - 1));
//             } else {
//               alert("Delete failed: " + (data && data.message ? data.message : "Unknown error"));
//             }
//           }
//         ).fail(function(xhr, status, error) {
//           alert("Delete request failed: " + error);
//         });

//         $(event.data.modal).modal('hide');
//       }
//     }
//   ]);
//   d.show("danger");
// });
// // init Masonry
// var $grid = $('#masonry-area').masonry({
//   // itemSelector: '.col',
//   // columnWidth: '.col',
//   percentPosition: true
// });
// // layout Masonry after each image loads
// $grid.imagesLoaded().progress( function() {
//   $grid.masonry('layout');
// });
// //
// $.post('/api/posts/count', {
//   id: 10
// }, function(data) {
//   console.log(data);
//   $('#total-posts').html("Total posts: " + data.count);
// });
// // Function to set a cookie
// function setCookie(name, value, daysToExpire) {
// var expires = "";

// if (daysToExpire) {
//   var date = new Date();
//   date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));
//   expires = "; expires=" + date.toUTCString();
// }
// document.cookie = name + "=" + value + expires + "; path=/";
// }

// $('.btn-delete').on('click', function(){
//   post_id = $(this).parent().attr('data-id');
//   d = new Dialog("Delete Post", "Are you sure want to remove this post");
//   d.setButtons([
//       {
//           'name': "Delete",
//           "class": "btn-danger",
//           "onClick": function(event){
//               console.log(`Assume this post ${post_id} is deleted`);
//               // $(`#post-${post_id}`).remove();
              
//               $.post('/api/posts/delete',
//               {
//                   id: post_id
//               }, function(data, textSuccess, xhr){
//                   console.log(textSuccess);
//                   console.log(data);
//                   if(textSuccess =="success" ){ //means 200
//                       $(`#post-${post_id}`).remove();
//                   }
//               });
//               $(event.data.modal).modal('hide')
//           }
//       },
//       {
//           'name': "Cancel",
//           "class": "btn-secondary",
//           "onClick": function(event){
//               $(event.data.modal).modal('hide');
//           }
//       }
//   ]);
//   d.show();
// });
