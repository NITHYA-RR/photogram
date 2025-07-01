var $grid = $('.album').masonry({
  itemSelector: '.col-sm-6',
      // itemSelector: 'col',
      // columnWidth: 'col',
      percentPosition: true
    })
    $grid.imagesLoaded().progress(function() {
      $grid.masonry('layout');
    })