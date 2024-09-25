<?php
/**
 * role : verifier le contenu des champs input
 */

/**
 * role : verifier la longueur de la chaine de caractere
* @param string $chaine
* @param integer $longueur : longueur maximum
* @return boolean : true si longeur validée sinon false
*/
function longueurChaine ($chaine, $longueur) {
    if (strlen($chaine) <= $longueur) {
        return true;
    } else {
        return false;
    }
}

/**
 * role : verifier si un nombre est compris entre deux limtes
 * @param integer $value : nombre a tester
 * @param integer $max : limite haute non incluse
 * @param integer $min : limite basse non incluse
 * @return boolean : true si compris dans les limite sinon false
*/
function comprisEntre($value, $min, $max) {
    if (is_numeric($value) && $value > $min && $value < $max) {
        return true;
    } else {
        return false;
    }
}

/**
 * role : extraire un nombre de la chaine de caractere XX string
 * @param string $chaine : la chaine de caractere a tester
 * @return integer : le nombre entier extrait
*/
function extractNumber($chaine) {
    $number = preg_replace('/\D/', '', $chaine);
    $resultat = (int)$number;
    return $resultat;
}
