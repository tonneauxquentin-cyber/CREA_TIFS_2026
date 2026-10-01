<?php
/** @var array $creatifs */
/** @var array $tags */
/** @var string|null $formTitle */
/** @var array $errors */
/** @var array|null $old */
$old = $old ?? [];
$errors = $errors ?? [];
?>
<h1 class="mb-4"><?= $formTitle ?? "Ajouter un projet" ?></h1>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $erreur): ?>
                <li><?= $erreur ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= $formAction ?? PUBLIC_BASE_URL . 'projects/add/insert.html' ?>" method="post" enctype="multipart/form-data" class="ct-form-card">
    <label for="title">Titre du projet</label>
    <input
        type="text"
        name="title"
        id="title"
        class="form-control"
        placeholder="Ex : Frange Kamikaze"
        value="<?= htmlspecialchars($old['title'] ?? '') ?>"
    />

    <label for="text">Description</label>
    <textarea
        id="text"
        name="text"
        class="form-control"
        rows="5"
        placeholder="Racontez l'histoire (courageuse) de ce projet..."
    ><?= htmlspecialchars($old['text'] ?? '') ?></textarea>

    <label for="creatif-file">Photo du résultat</label>
    <div class="ct-dropzone">
        ✂️ Glissez une image ou choisissez-la ci-dessous
        <input type="file" class="form-control-file" id="creatif-file" name="image" />
    </div>

    <label for="category">Créa'tif</label>
    <select id="category" name="category_id" class="form-control">
        <option disabled <?= empty($old['category_id']) ? 'selected' : '' ?>>Sélectionnez le créa'tif</option>
        <?php foreach ($creatifs as $creatif): ?>
            <option value="<?= $creatif['id'] ?>" <?= (($old['category_id'] ?? null) == $creatif['id']) ? 'selected' : '' ?>>
                <?= $creatif['pseudo'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Tags <span style="font-weight:400;font-size:.8rem;color:#4a3a5a">(facultatif)</span></label>
    <div class="ct-tag-choice">
        <?php foreach ($tags as $tag): ?>
            <label>
                <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" <?= in_array($tag['id'], $old['tags'] ?? []) ? 'checked' : '' ?> />
                <?= $tag['nom'] ?>
            </label>
        <?php endforeach; ?>
    </div>

    <div>
        <input class="ct-btn ct-btn--primary" type="submit" value="Enregistrer" />
        <input class="ct-btn ct-btn--ghost" type="reset" value="Réinitialiser" />
    </div>
</form>