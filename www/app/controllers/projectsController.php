<?php 

namespace App\Controllers\ProjectsController;

use \PDO;
use \App\Models\ProjectsModel;
use \App\Models\TagsModel;

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