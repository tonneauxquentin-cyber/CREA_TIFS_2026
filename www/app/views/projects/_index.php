
<?php 
/** @var array $projet*/

use Core\Helpers;

?>
        <article class="ct-card">
            <div class="row">
              <div class="col-md-4">
                <a href="<?= PUBLIC_BASE_URL ?>projects/<?php echo $projet['id']; ?>/<?php echo Helpers\slugify($projet['titre']); ?>.html">
                  <img class="img-fluid mb-3 mb-md-0" src="<?= PUBLIC_BASE_URL ?>assets/images/<?php echo $projet['image']; ?>" alt="<?php echo $projet['creatif_pseudo']; ?>" />
                </a>
              </div>
              <div class="col-md-8">
                <h3><a href="<?= PUBLIC_BASE_URL ?>projects/<?php echo $projet['id']; ?>/<?php echo Helpers\slugify($projet['titre']); ?>.html"><?php echo $projet['titre']; ?></a></h3>
                <p class="ct-byline">par <a href="#"><?php echo $projet['creatif_pseudo']; ?></a> · <?php echo Helpers\dateFormator($projet['dateCreation'], 'd'); ?> <?php echo Helpers\dateFormator($projet['dateCreation'], 'M'); ?> <?php echo Helpers\dateFormator($projet['dateCreation'], 'Y'); ?></p>
                    <p><?php echo Helpers\truncate($projet['texte'],100); ?></p>
                <a class="ct-btn ct-btn--primary ct-btn--sm" href="<?= PUBLIC_BASE_URL ?>projects/<?php echo $projet['id']; ?>/<?php echo Helpers\slugify($projet['titre']); ?>.html">Voir le projet</a>
              </div>
            </div>
          </article>