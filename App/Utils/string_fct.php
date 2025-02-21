<?php

/**
 * role : transformer une chaine de caractere
    * Remplacer les tirets et les underscores par des espaces
    * Mettre toute la chaîne en minuscule
    * Mettre la première lettre de chaque mot en majuscule
    * Retourner la chaîne formatée
 * Return : {string} $string
 */
function formatString($string) {
    $string = str_replace(['-', '_'], ' ', $string);
    $string = strtolower($string);
    $string = ucwords($string);
    return $string;
}
