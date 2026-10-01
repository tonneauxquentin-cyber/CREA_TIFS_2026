<?php 

namespace App\Controllers\ProjectsController;

use \PDO;
use Core\Helpers;
use \App\Models\ProjectsModel;
use \App\Models\TagsModel;
use \App\Models\CreatifsModel;

//Prépare la vue index
function indexAction(PDO $conn, int $page = 1){
    include_once '../app/models/projectsModel.php';
    //On fixe la limit à 10
    $limit = 10;
    $totalPages = (int) ceil(ProjectsModel\countAll($conn) / $limit);

    // On garde la page entre 1 et le nombre total de pages
    $page = max(1, min($page, $totalPages));
    $offset = ($page - 1) * $limit;

    $projets = ProjectsModel\findAll($conn, $limit, $offset);
    global $content, $showHeader;
    $showHeader = true;
    ob_start();
    include '../app/views/projects/index.php';
    $content = ob_get_clean();
}
//Prépare la vue d'un seul projet
function showAction(PDO $conn, int $id){
    include_once '../app/models/projectsModel.php';
    include_once '../app/models/tagsModel.php';
    $projet = ProjectsModel\findOneById($conn, $id);
    if ($projet === false) {
        header('Location: ' . PUBLIC_BASE_URL);
        exit;
    }
    $tags = TagsModel\findAllByProjectId($conn, $id);

    global $title, $content;
    $title = $projet['titre'];
    ob_start();
    include '../app/views/projects/show.php';
    $content = ob_get_clean();
}
// Supprime un projet puis redirige vers l'accueil
function deleteAction(PDO $conn, int $id){
    include_once '../app/models/projectsModel.php';
    ProjectsModel\delete($conn, $id);
    header('Location: ' . PUBLIC_BASE_URL);
    exit;
}
// Affiche le formulaire d'ajout d'un projet
function addFormAction(PDO $conn){
    include_once '../app/models/creatifsModel.php';
    include_once '../app/models/tagsModel.php';

    $creatifs = CreatifsModel\findAll($conn);
    $tags = TagsModel\findAll($conn);

    global $title, $content;
    $title = "Nouveau projet - CREA'TIFS";
    ob_start();
    include '../app/views/projects/form.php';
    $content = ob_get_clean();
}
// Traite le formulaire d'ajout, enregistre le projet, puis redirige vers l'accueil
function insertAction(PDO $conn){
    include_once '../app/models/projectsModel.php';
    include_once '../app/models/creatifsModel.php';
    include_once '../app/models/tagsModel.php';
    $titre = trim($_POST['title'] ?? '');
    $texte = trim($_POST['text'] ?? '');
    $creatifId = (int) ($_POST['category_id'] ?? 0);
    $tagIds = $_POST['tags'] ?? [];
    // Validation des champs obligatoires
    $errors = [];
    if ($titre === '') {
        $errors[] = "Le titre est obligatoire.";
    } elseif (strlen($titre) > 45) {
        $errors[] = "Le titre ne doit pas dépasser 45 caractères.";
    }
    if ($texte === '') {
        $errors[] = "La description est obligatoire.";
    }
    if ($creatifId <= 0) {
        $errors[] = "Vous devez sélectionner un créa'tif.";
    }
    // En cas d'erreur : on réaffiche le formulaire avec les valeurs saisies
    if (!empty($errors)) {
        $creatifs = CreatifsModel\findAll($conn);
        $tags = TagsModel\findAll($conn);
        global $title, $content;
        $title = "Nouveau projet - CREA'TIFS";
        $formTitle = "Ajouter un projet";
        $old = $_POST; // pour pré-remplir les champs
        ob_start();
        include '../app/views/projects/form.php';
        $content = ob_get_clean();
        return;
    }
    // Gestion de l'image envoyée (optionnelle)
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = uniqid() . '.' . $extension;
        move_uploaded_file($_FILES['image']['tmp_name'], '../public/assets/images/' . $image);
    }
    $projetId = ProjectsModel\insert($conn, $titre, $texte, $image, $creatifId);
    if (!empty($tagIds)) {
        ProjectsModel\addTags($conn, $projetId, $tagIds);
    }
    header('Location: ' . PUBLIC_BASE_URL);
    exit;
}
// Affiche le formulaire de modification d'un projet, pré-rempli
function editFormAction(PDO $conn, int $id){
    include_once '../app/models/projectsModel.php';
    include_once '../app/models/creatifsModel.php';
    include_once '../app/models/tagsModel.php';
    $projet = ProjectsModel\findOneById($conn, $id);
    if ($projet === false) {
        header('Location: ' . PUBLIC_BASE_URL);
        exit;
    }
    $creatifs = CreatifsModel\findAll($conn);
    $tags = TagsModel\findAll($conn);
    $projetTags = TagsModel\findAllByProjectId($conn, $id);
    // On pré-remplit le formulaire avec les valeurs actuelles du projet
    $old = [
        'title' => $projet['titre'],
        'text' => $projet['texte'],
        'category_id' => $projet['creatif'],
        'tags' => array_column($projetTags, 'id'),
    ];
    global $title, $content;
    $title = "Modifier " . $projet['titre'] . " - CREA'TIFS";
    $formTitle = "Modifier le projet";
    $formAction = PUBLIC_BASE_URL . 'projects/' . $id . '/' . Helpers\slugify($projet['titre']) . '/edit/update.html';
    ob_start();
    include '../app/views/projects/form.php';
    $content = ob_get_clean();
}
// Traite le formulaire de modification, enregistre, puis redirige vers l'accueil
function updateAction(PDO $conn, int $id){
    include_once '../app/models/projectsModel.php';
    include_once '../app/models/creatifsModel.php';
    include_once '../app/models/tagsModel.php';
    $titre = trim($_POST['title'] ?? '');
    $texte = trim($_POST['text'] ?? '');
    $creatifId = (int) ($_POST['category_id'] ?? 0);
    $tagIds = $_POST['tags'] ?? [];
    $errors = [];
    if ($titre === '') {
        $errors[] = "Le titre est obligatoire.";
    } elseif (strlen($titre) > 45) {
        $errors[] = "Le titre ne doit pas dépasser 45 caractères.";
    }
    if ($texte === '') {
        $errors[] = "La description est obligatoire.";
    }
    if ($creatifId <= 0) {
        $errors[] = "Vous devez sélectionner un créa'tif.";
    }
    if (!empty($errors)) {
        $creatifs = CreatifsModel\findAll($conn);
        $tags = TagsModel\findAll($conn);
        global $title, $content;
        $title = "Modifier le projet - CREA'TIFS";
        $formTitle = "Modifier le projet";
        $formAction = PUBLIC_BASE_URL . 'projects/' . $id . '/' . Helpers\slugify($titre) . '/edit/update.html';
        $old = $_POST;
        ob_start();
        include '../app/views/projects/form.php';
        $content = ob_get_clean();
        return;
    }
    // Gestion d'une nouvelle image envoyée (optionnelle)
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = uniqid() . '.' . $extension;
        move_uploaded_file($_FILES['image']['tmp_name'], '../public/assets/images/' . $image);
    }
    ProjectsModel\update($conn, $id, $titre, $texte, $image, $creatifId);
    TagsModel\replaceTags($conn, $id, $tagIds);
    header('Location: ' . PUBLIC_BASE_URL);
    exit;
}