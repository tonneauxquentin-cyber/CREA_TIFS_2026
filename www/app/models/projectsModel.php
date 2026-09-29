<?php
namespace App\Models\ProjectsModel;

use \PDO;
// Les projets d'une page (limit et offset)
function findAll(PDO $conn, int $limit = 10, int $offset = 0): array{
    $sql = "SELECT p.*, c.pseudo AS creatif_pseudo
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            ORDER BY titre DESC
            LIMIT :limit OFFSET :offset;";
    $rs = $conn->prepare($sql);
    $rs->bindValue(':limit', $limit, PDO::PARAM_INT);
    $rs->bindValue(':offset', $offset, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}

// Nombre total de projets (pour calculer le nombre de pages)
function countAll(PDO $conn): int{
    return (int) $conn->query("SELECT COUNT(*) FROM projets;")->fetchColumn();
}
//Le projet en fonction de son Id
function findOneById(PDO $conn, int $id): array|false{
    $sql = "SELECT p.*, c.pseudo AS creatif_pseudo
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            WHERE p.id =:id";
    $rs = $conn->prepare($sql);
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetch(PDO::FETCH_ASSOC);
}