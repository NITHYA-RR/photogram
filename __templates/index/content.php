<?php
include_once __DIR__ . "/../../libs/includes/UserSession.class.php";
include_once __DIR__ . "/../../libs/includes/User.class.php";

session::ensurelogin();
if (isset($_POST['post_text']) && isset($_FILES['post_image'])) {
  $image_tmp = $_FILES['post_image']['tmp_name'];
  $text = $_POST['post_text'];
  Post::registerPost($text, $image_tmp);
}
?>
<section class="py-5 text-center container">
  <div class="row py-lg-5">
    <form method="post" action="" enctype="multipart/form-data">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 id="greeting" class="fw-light">what are you upto?
          <?php
          // $user = Session::getUser();
          ?>
        </h1>
        <!-- <h1 class="fw-light">What$ are you upto? -->
        <p class="lead text-muted">Share a photo that talks about it.</p>
        <textarea id="post_text" name="post_text" class="form-control" placeholder="What are you upto?" rows="3"></textarea>
        <div class="input-group mb-3">
          <input type="file" accept="image/*" class="form-control" name="post_image" id="inputGroupFile02">
        </div>
        <p>
          <button class="btn btn-success my-2" type="submit">Share memory</button>
          <!-- <a href="#" class="btn btn-secondary my-2">clear</a> -->
        </p>
      </div>
    </form>
  </div>
</section>