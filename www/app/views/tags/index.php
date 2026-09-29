<?php
/** @var array $tags */

?>
<div class="ct-side-card">
    <h5 class="ct-side-card__head">Tags</h5>
    <div class="ct-side-card__body">
        <ul class="ct-tags">
            <?php foreach ($tags as $tag): ?>
                <li><a class="ct-tag" href="#"><?php echo $tag['nom']; ?></a></li>
            <?php endforeach; ?>
            
        </ul>
    </div>
</div>