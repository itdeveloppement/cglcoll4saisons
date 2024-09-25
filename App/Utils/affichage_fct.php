<?php
/**
 * role : affichage des departs et des details des departs
 */

use App\Modeles\Location;
use App\Modeles\User;

/**
 * role : afficher la liste des departs d'un utilisateur
 * param : id de l'utilisateur
 * return : {arrray objet} $listeDeparts
 */
function afficherListeDeparts($idUser) {
    $user = new User($idUser);
    $user->listeDeparts();
    $listeDeparts = $user->get("liste_departs");
    return $listeDeparts;
}

/**
 * role : afficher la liste des locations d'un utilisateur
 * param : id de l'utilisateur
 * return : {arrray objet} $listeLocations
 */
function afficherListeLocations($idUser) {
    $user = new User($idUser);
    $user->listeLocations();
    $listeLocations = $user->get("liste_locations");
    return $listeLocations;
}



