<?php
/** @var array $projet */
/** @var array $tags */

use Core\Helpers;
?>

          <h1><?php echo $projet['titre']; ?></h1>
          <p class="ct-byline">par <a href="<?= PUBLIC_BASE_URL ?>"><?php echo $projet['creatif_pseudo']; ?></a> · <?php echo Helpers\dateFormator($projet['dateCreation'], 'd'); ?> <?php echo Helpers\dateFormator($projet['dateCreation'], 'M'); ?> <?php echo Helpers\dateFormator($projet['dateCreation'], 'Y'); ?></p>

          <div class="mb-4">
            <!-- routes: /projets/id/slug/edit/form.html — /projets/delete/id/slug.html -->
            <a href="<?= PUBLIC_BASE_URL ?>projects/<?= $projet['id'] ?>/<?php echo Helpers\slugify($projet['titre']); ?>/edit/form.html" class="ct-btn ct-btn--primary">Éditer le projet</a>
            <a href="<?= PUBLIC_BASE_URL ?>projects/delete/<?php echo $projet['id']; ?>/<?php echo Helpers\slugify($projet['titre']); ?>.html" class="ct-btn ct-btn--danger" onclick="return confirm('Supprimer définitivement ce projet ?');">Supprimer le projet</a>
          </div>

          <article class="ct-card">
            <div class="row">
              <div class="col-md-6">
                <img class="img-fluid mb-3 mb-md-0" src="<?= PUBLIC_BASE_URL ?>assets/images/<?php echo $projet['image']; ?>" alt="<?php echo $projet['titre']; ?>" />
              </div>
              <div class="col-md-6">
                <p class="lead" style="font-weight: 600">
                  <?php echo $projet['chapo']; ?>
                </p>
                <hr />
                <p>
                  <?php echo $projet['texte']; ?>
                </p>
                <hr />
                <ul class="ct-tags">
                  <?php foreach ($tags as $tag): ?>
                    <li><a class="ct-tag" href="<?= PUBLIC_BASE_URL ?>"><?php echo $tag['nom']; ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </article>