<?php
namespace App\Models\TagsModel;

use \PDO;

// Tous les tags d'un projet (page détail)
function findAllByProjectId(PDO $conn, int $id): array{
    $sql = "SELECT t.*
            FROM tags t
            JOIN projets_has_tags pht ON pht.tag = t.id
            WHERE pht.projet = :id;";
    $rs = $conn->prepare($sql);
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}

// Tous les tags
function findAll(PDO $conn): array{
    $sql = "SELECT *
            FROM tags
            ORDER BY nom ASC;";
    $rs = $conn->prepare($sql);
    $rs->execute();
    return $rs->fetchAll(PDO::FETCH_ASSOC);
}