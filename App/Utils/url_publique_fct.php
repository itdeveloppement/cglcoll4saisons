<?php
/**
 * rôle : organiser les fonctions de creation et de verification de l'url qui est envoyée à un tiers pour l'ouverture du formulaire de collecte d'information (taille / poids / age)
 * exemple : /custom/cglcoll4saisons/public/index.php?client=15007&code=CL2024-00008864&date=2024-09-16 04:46:22
 * param de l'url
 *      - client = rowid tiers
 *      - code = code client du tiers
 *      - date de creation (format yyyy mm jj :hh mm ss)
 */

use App\Modeles\Depart;
use App\Modeles\Location;
use App\Modeles\User;
use App\Services\Bdd;

/**
 * rôle : creer l'url du formulaire avec les parametres et les valeurs des parametres pour un tiers
 * @param : {integer} : $rowid : rowid tiers
 * @return : si un ou des departs ou un ou des LO existent return {string} url avec param sinon return vide
 */
function createURL ($rowidTiers){
    $user = new User($rowidTiers);
    $user->listeDeparts();
    $user->listeLocations();
    $listeDeparts = $user->get("liste_departs");
    $listeLocations = $user->get("liste_locations");


    if (!empty($listeDeparts) || !empty($listeLocations)) {
         if (formatDateEntier($user->get("datec"))) {
            $date = formatDateEntier($user->get("datec"));
        } else {
            $date = '';
        }
    $url = "/custom/cglcoll4saisons/public/index.php?client=" . $user->get("rowid") . "&code=" . $user->get("code_client") . "&date=" . $date ."";
    return $url;
   } else { 
        $url ='';
        return $url;
   }
}

/**
 * rôle : afficher pour un tiers et un BU l'url du formulaire de collecte de données
 * conditions de selection des données : celles de l'objet Depart methode loadDeparts
 * @param : id du tiers
 * @param : id du bulletin
 * @return : {array} liste des departs indexés par le rowid du depart et pour valeur l'url(parametre et valeur du tiers)
 * exemple array = [50501 => /custom/cglcoll4saisons/public/index.php?client=15007&code=CL2024-00008864&date=2024-09-16 04:46:22, ...]
 */
function affichageURL_BU($rowidTiers, $rowidBulletinBU) {
    $user = new User($rowidTiers);
    $departObj = new Depart($rowidTiers, null, $rowidBulletinBU);
    $depart = $departObj->loadDeparts();
    if (!empty($depart)) {
        $arrayUrl = [];
        // parcourir le tableau de tableau
        foreach ($depart as $value) {

            if (formatDateEntier($user->get("datec"))) {
                $date = formatDateEntier($user->get("datec"));
            } else {
                $date = '';
            }

            if (isset($value["id_session"])) {
            $arrayUrl[$value["id_session"]] = "/custom/cglcoll4saisons/public/index.php?client=" . $user->get("rowid") . "&code=" . $user->get("code_client") . "&date=" . $date ."";
            }
        }
        return $arrayUrl;
    } else {
        $arrayUrl = [];
        return $arrayUrl;
    }
}

/**
 * rôle : afficher pour un tiers et un LO l'url du formulaire de collecte de données
 * conditions de selection des données : celles de l'objet lOCATION methode loadLocations
 * @param : {integer} : $rowidTiers : id du tiers
 * @param : {integer} : $rowidBulletin : id du bulletin/LO
 * @return : {string} url si le LO location existe sinon vide
 */
function affichageURL_LO($rowidTiers, $rowidBulletinLO) {
    $user = new User($rowidTiers);
    $bulletinObj = new Location($rowidTiers, null, $rowidBulletinLO);
    $bulletin = $bulletinObj->loadLocations();

    if (formatDateEntier($user->get("datec"))) {
        $date = formatDateEntier($user->get("datec"));
    } else {
        $date = '';
    }

    if (!empty($bulletin)) {
       $url = "/custom/cglcoll4saisons/public/index.php?client=" . $user->get("rowid") . "&code=" . $user->get("code_client") . "&date=" . $date ."";
       return $url;
    } else {
        $url ='';
        return $url;
    }
}

/**
 * role : parametrage base de donnée
 */
function parametrageBdd() {
    global $dolibarr_main_db_user;
    global $dolibarr_main_db_pass;
    global $dolibarr_main_db_host;
    global $dolibarr_main_db_name;

    Bdd::setUserName($dolibarr_main_db_user);
    Bdd::setPassword($dolibarr_main_db_pass);
    $host ="mysql:host=$dolibarr_main_db_host;dbname=$dolibarr_main_db_name;charset=UTF8";
    Bdd::setDsn($host);
}
