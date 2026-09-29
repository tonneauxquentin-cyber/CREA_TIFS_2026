<?php
/** @var array $creatifs*/; ?>
<div class="ct-side-card">
    <h5 class="ct-side-card__head">Les créa'tifs</h5>
    <div class="ct-side-card__body">
        <ul class="ct-creatif-list">
            <?php foreach ($creatifs as $creatif): ?>
                <li>
                    <img class="ct-avatar" src="<?= PUBLIC_BASE_URL ?>assets/images/<?php echo $creatif['image']; ?>" alt="<?php echo $creatif['pseudo']; ?>" />
                    <a href="#"><?php echo $creatif['pseudo']; ?></a>
                    <span class="ct-count"><?php echo $creatif['nb_projets']; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>