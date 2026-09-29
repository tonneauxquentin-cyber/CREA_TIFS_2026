<!DOCTYPE html>
<html lang="fr">
  <head>
    <?php include '../app/views/templates/partials/_head.php'; ?>
  </head>

  <body>
    <!-- Navigation -->
    <?php include '../app/views/templates/partials/_nav.php'; ?>

    <!-- Bandeau d'intro -->
    <?php if (!empty($showHeader)): ?>
        <?php include '../app/views/templates/partials/_header.php'; ?>
    <?php endif; ?>
    <!-- Contenu -->
    <?php include '../app/views/templates/partials/_main.php'; ?>
    <!-- /.container -->

    <!-- Footer -->
    <?php include '../app/views/templates/partials/_footer.php'; ?>

    <!-- Bootstrap core JavaScript -->
    <?php include '../app/views/templates/partials/_scripts.php'; ?>
  </body>
</html>