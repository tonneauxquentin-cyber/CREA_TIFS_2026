<?php
namespace App\Controllers\TagsController;

use \PDO;
use \App\Models\TagsModel;

// Widget affiche tous les tags
function indexAction(PDO $conn){
    include_once '../app/models/tagsModel.php';
    $tags = TagsModel\findAll($conn);
    include '../app/views/tags/index.php';
}