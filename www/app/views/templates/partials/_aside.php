<?php include_once '../app/controllers/tagsController.php'; ?>
<?php include_once '../app/controllers/creatifsController.php'; ?>
<div class="col-lg-4">
          <!-- Widget Créa'tifs -->
          <?php \App\Controllers\CreatifsController\indexAction($conn); ?>

          <!-- Widget Tags -->
          <?php \App\Controllers\TagsController\indexAction($conn); ?>
        </div>