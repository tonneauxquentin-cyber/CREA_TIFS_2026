<?php
namespace App\Models\CreatifsModel;

use \PDO;

// Tous les creatifs avec leur nombre de projets
function findAll(PDO $conn): array{
    $sql = "SELECT c.*, COUNT(p.id) AS nb_projets
            FROM creatifs c
            LEFT JOIN projets p ON p.creatif = c.id
            GROUP BY c.id
            ORDER BY c.pseudo ASC;";
    $rs = $conn->prepare($sql);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}