<?php
namespace App\Controllers\CreatifsController;

use \PDO;
use \App\Models\CreatifsModel;

// Widget affiche tous les creatifs
function indexAction(PDO $conn){
    include_once '../app/models/creatifsModel.php';
    $creatifs = CreatifsModel\findAll($conn);
    include '../app/views/creatifs/index.php';
}