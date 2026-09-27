<?php

namespace Core\Helpers;

function truncate($text, $limit = 100)
{
    if (strlen($text) <= $limit) return $text;

    // Coupe à la limite
    $text = substr($text, 0, $limit);
    // Recherche la position du dernier espace dans la chaîne tronquée
    $last_space = strrpos($text, ' ');
    // Recoupe la chaîne à cet espace
    return substr($text, 0, $last_space) . '...';
}