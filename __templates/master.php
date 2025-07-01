<!doctype html>
<html lang="en">
<?php
Session::load_templates('head');
?>

<body>
  <?php
  Session::load_templates('header');
  ?>
  <main>
    <?php
    load_templates(Session::currentScript());
    ?>
  </main>
  <?php
  Session::load_templates('footer');

  ?>
  <script src="/website/assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
  <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
  <!-- <script src="/Js/app.min.js"></script> -->
  <!-- or -->
  <script src="/Automation/js/templates/index.js"></script>

</body>

</html>