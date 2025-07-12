var $grid = $('.album').masonry({
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
})

