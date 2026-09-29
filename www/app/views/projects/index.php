<?php 
/** @var array $projets */ 
?>
<?php foreach ($projets as $projet): ?>
    <?php include '../app/views/projects/_index.php'; ?>
<?php endforeach; ?>

<!-- Pagination : 10 projets par page -->
 <?php include '../app/views/templates/partials/_pagination.php'; ?>