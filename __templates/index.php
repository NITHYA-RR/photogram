<?php
if (Session::isAuthenticated()) {
  Session::load_templates('index/content');
} else {
  Session::load_templates('index/login');
}

$posts = Post::getAllPosts();
?>


<div class="album">
  <div class="container">
    <div class="row" id="masonry-area">
      <?php foreach ($posts as $p): ?>
        <?php $created_at = $p->getCreatedAt(); ?>
        <div class="col-sm-6 col-lg-4 mb-4">
          <div class="card shadow-sm">
            <img src="<?php echo htmlspecialchars($p->getImageUrl()); ?>" class="bd-placeholder-img card-img-top" width="100%">
            <div class="card-body">
              <p class="card-text"><?php echo htmlspecialchars($p->getPostText()); ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-primary">Like</button>
                  <button type="button" class="btn btn-sm btn-outline-success">Share</button>
                  <?php
                  // $user = Session::getUser();
                  // if(Session::isOwnerOf($p->getOwner())){
                  ?>
                  <button type="button" class="btn btn-sm btn-outline-danger">Delete</button>
                  <?php
                  // }
                  ?>
                </div>
                <small class="text-muted"><?php echo htmlspecialchars($created_at); ?></small>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>