<?php
require_once __DIR__ . '/../../libs/app/like.class.php';
$posts = Post::getAllPosts();
?>

<h3 id="post-count"><span id="post-total">Loading...</span></h3>
<div class="album">
    <div class="container">
        <div class="row" id="masonry-area">
            <?php foreach ($posts as $p):
                $created_at = $p->getCreatedAt();
                $owner = new User($p->getOwner());

            ?>
                <div class="col-sm-6 col-lg-4 mb-4"
                    id="post-<?php echo $p->getId(); ?>">
                    <div class="card shadow-sm">
                        <img src="<?php echo htmlspecialchars($p->getImageUrl()); ?>" class="bd-placeholder-img card-img-top" width="100%">
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($p->getPostText()); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group" data-id="<?php echo $p->getId(); ?>">
                                    <?php
                                    // Check if current user has liked this post
                                    $like = new Like($p);
                                    $isLiked = $like->isLiked();
                                    $buttonClass = $isLiked ? 'btn-primary' : 'btn-outline-primary';
                                    $buttonText = $isLiked ? 'Liked' : 'Like';
                                    ?>
                                    <button type="button" class="btn btn-sm <?php echo $buttonClass; ?> btn-like"><?php echo $buttonText; ?></button>
                                    <!-- <button type="button" class="btn btn-sm btn-outline-success">Share</button> -->
                                    <?php
                                    if (Session::isAuthenticated()):
                                        // if (Session::isOwnerOf($p->getOwner())) {
                                    ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                                    <?php
                                    endif;
                                    //}
                                    ?>
                                    <!-- <button type="button" class="btn btn-sm btn-outline-danger">Delete</button> -->
                                </div>
                                <small class="text-muted"><?php echo htmlspecialchars($created_at); ?> by <?php echo $owner->getUsername() ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>