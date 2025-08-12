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
  // Session::load_templates('footer');
  ?>

  <div id="modalsGarbage">
    <div class="modal fade animate__animated" id="dummy-dialog-modal" tabindex="-1" role="dialog" aria-labelledby=""
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content blur" style="box-shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px">
          <div class="modal-header">
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="/assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
  <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
  <!-- <script src="/Js/app.min.js"></script> -->
  <!-- or -->
  <script src="/Automation/js/templates/plugins/dialog.js"></script>
  <script src="/Automation/js/templates/index.js"></script>
  <script src="/Automation/js/toast.js"></script>


</body>

</html>