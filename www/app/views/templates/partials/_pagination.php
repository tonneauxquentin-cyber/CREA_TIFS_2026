<?php
/** @var int $page        Page courante */
/** @var int $totalPages  Nombre total de pages */
?>
<nav aria-label="Navigation entre les pages de projets">
    <ul class="pagination ct-pagination" style="justify-content: center">
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">Précédent</a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">Suivant</a>
        </li>
    </ul>
</nav>