<?php
namespace App\Models\ProjectsModel;

use \PDO;
// Les projets d'une page (limit et offset)
function findAll(PDO $conn, int $limit = 10, int $offset = 0): array{
    $sql = "SELECT p.*, c.pseudo AS creatif_pseudo
            FROM projets p
            JOIN creatifs c ON p.creatif = c.id
            ORDER BY dateCreation DESC, id DESC
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
// Supprime un projet et ses tags associés
function delete(PDO $conn, int $id): bool{
    // 1. On supprime d'abord les liaisons dans la table pivot
    $rs = $conn->prepare(
        "DELETE
        FROM projets_has_tags
        WHERE projet = :id;");
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    $rs->execute();

    // 2. On peut maintenant supprimer le projet
    $rs = $conn->prepare(
        "DELETE
        FROM projets
        WHERE id = :id;");
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    return $rs->execute();
}
// Insère un nouveau projet et renvoie son id
function insert(PDO $conn, string $titre, string $texte, string $image, int $creatif): int{
    $sql = "INSERT INTO projets (titre, texte, dateCreation, image, creatif)
            VALUES (:titre, :texte, NOW(), :image, :creatif);";
    $rs = $conn->prepare($sql);
    $rs->bindValue(':titre', $titre);
    $rs->bindValue(':texte', $texte);
    $rs->bindValue(':image', $image);
    $rs->bindValue(':creatif', $creatif, PDO::PARAM_INT);
    $rs->execute();
    return (int) $conn->lastInsertId();
}

// Associe une liste de tags à un projet
function addTags(PDO $conn, int $projetId, array $tagIds): void{
    $sql = "INSERT INTO projets_has_tags (projet, tag) VALUES (:projet, :tag);";
    $rs = $conn->prepare($sql);
    foreach ($tagIds as $tagId) {
        $rs->bindValue(':projet', $projetId, PDO::PARAM_INT);
        $rs->bindValue(':tag', (int) $tagId, PDO::PARAM_INT);
        $rs->execute();
    }
}
// Met à jour un projet existant
function update(PDO $conn, int $id, string $titre, string $texte, string $image, int $creatif): bool{
    // Si aucune nouvelle image n'est envoyée, on ne touche pas à l'image existante
    if ($image === '') {
        $sql = "UPDATE projets SET titre = :titre, texte = :texte, creatif = :creatif WHERE id = :id;";
    } else {
        $sql = "UPDATE projets SET titre = :titre, texte = :texte, image = :image, creatif = :creatif WHERE id = :id;";
    }
    $rs = $conn->prepare($sql);
    $rs->bindValue(':titre', $titre);
    $rs->bindValue(':texte', $texte);
    $rs->bindValue(':creatif', $creatif, PDO::PARAM_INT);
    $rs->bindValue(':id', $id, PDO::PARAM_INT);
    if ($image !== '') {
        $rs->bindValue(':image', $image);
    }
    return $rs->execute();
}