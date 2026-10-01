<?php

namespace Core\Helpers;

function truncate(string $text, int $limit = 100): string{
    if (strlen($text) <= $limit) return $text;
    // Coupe à la limite
    $text = substr($text, 0, $limit);
    // Recherche la position du dernier espace dans la chaîne tronquée
    $last_space = strrpos($text, ' ');
    // Recoupe la chaîne à cet espace
    $text = substr($text, 0, $last_space);
    // On retire un éventuel signe de ponctuation final avant d'ajouter "..."
    $text = rtrim($text, '.,;:!?');
    return $text . '...';
}
function dateFormator (string $date, string $format = "d/m/Y") : string{
    return date($format, strtotime($date));
}
function slugify(string $string): string {
    //Remplacer les carctères accentués par leur équivalent non accentué
    $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    //Mettre en minuscule
    $string = strtolower($string);
    //Remplacer tout ce qui n'est pas une lettre, un chiffre ou un tiret par un tiret
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    //Supprimer les tirets en début et fin de chaîne
    $string = trim($string, '-');
    return $string;
}