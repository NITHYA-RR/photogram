<?php
include 'libs/load.php';
?>
<pre>
    <?php

    // $image_temp = $_FILES['post_image']['tmp_name'];
    // $text = $_POST['post_text'];
    // Post::registerPost($text, $image_tmp);
    $author = Session::getUser()->getEmail();
    ?>
    $author = Session::getUser()->getEmail();
</pre>




?>
// if(Session::isAuthenticated()){
// Session::load_templates('index/content');
// }
// else{
// Session::load_templates('index/login');
// }
// $posts = Post::getAllPosts();
// foreach($posts as $p){
// $created_at = $p->getCreatedAt();

// ?>

<!-- // <div class="album">
//     <div class="container">

//       <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
//         <div class="col">
//           <div class="card shadow-sm">
//             <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
//             <img src="<?php var_dump($p->getImageUrl()); ?>" width="100%" height="225">
//             <div class="card-body">
//               <p class="card-text"><?php var_dump($p->getPostText()); ?></p>
//               <div class="d-flex justify-content-between align-items-center">
//                 <div class="btn-group">
//                   <button type="button" class="btn btn-sm btn-outline-secondary">Like</button>
//                   <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
//                 </div>
//                 <small class="text-muted"><?php var_dump($created_at); ?></small>
//               </div>
//             </div>
//           </div>
//         </div>
//        
    // }



    <?php echo htmlspecialchars($p->getImageUrl()); ?>