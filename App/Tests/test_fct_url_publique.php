<?php
/**
 * role : test fonction pour la creation de l'url
 */

 use App\Modeles\Depart;
 use App\Modeles\Location;
 use App\Modeles\User;
use App\Services\Bdd;

require_once __DIR__ . "/../Utils/init.php";



// attention 
// il faut faire une verification de tous les tiers pour voir si il exste bien un code client
// modifier les tiers dont le code cleint contient le rowid

/**
 * role : creer l'url du formulaire avec les parametres et les valeurs des parametres
 * @param : {integer} : $rowid : rowid tiers
 * @return : si un ou des departs ou un ou des LO existent return {string} url sinon return vide
 */
function createURL ($rowidTiers){
    $user = new User($rowidTiers);
    $user->listeDeparts();
    $user->listeLocations();
    $listeDeparts = $user->get("liste_departs");
    $listeLocations = $user->get("liste_locations");
    if (!empty($listeDeparts) || !empty($listeLocations)) {
        $url = "/custom/cglcoll4saisons/public/index.php?client=" . $user->get("rowid") . "&code=" . $user->get("code_client") . "date=" . $user->get("datec") ."";
        return $url;
   } else { 
        $url ='';
        return $url;
   }
}/*

*/
/**
 * role : afficher ou pas l'url client du formulaire dans un BU pour un id tier et un id bulletin
 * attention : ici on parle d'un BU et pas de tous les BU du client
 * conditions : celle de l'objet depart
 * @param : id du tiers
 * @param : id du bulletin
 * @return : {array} liste des departs pour chaque BU avec l'url (avec )parametre et valeur)
 * id du depart => url du client
 */
function affichageURL_BU($rowidTiers, $rowidBulletinBU) {
    $user = new User($rowidTiers);
    $departObj = new Depart($rowidTiers, null, $rowidBulletinBU);
    $depart = $departObj->loadDeparts();

    if (!empty($depart)) {
        $arrayUrl = [];
        // parcourir le tableau de tableau
        foreach ($depart as $value) {
            if (isset($value["id_session"])) {
            $arrayUrl[$value["id_session"]] = "/custom/cglcoll4saisons/public/index.php?client=" . $user->get("rowid") . "&code=" . $user->get("code_client") . "date=" . $user->get("datec") ."";
            }
        }
        
        return $arrayUrl;
    } else {
        $arrayUrl = [];
        return $arrayUrl;
    }
}

/**
 * role : afficher ou pas l'url client du formulaire dans un LO pour un tiers et un LO
 * conditions : celle de l'objet location
 * @param : {integer} : $rowidTiers : id du tiers
 * @param : {integer} : $rowidBulletin : id du bulletin/LO
 * @return : {string} url si locations existe sinon vide
 */
function affichageURL_LO($rowidTiers, $rowidBulletinLO) {
    $user = new User($rowidTiers);
    $bulletinObj = new Location($rowidTiers, null, $rowidBulletinLO);
    $bulletin = $bulletinObj->loadLocations();
    if (!empty($bulletin)) {
       $url = "/custom/cglcoll4saisons/public/index.php?client=" . $user->get("rowid") . "&code=" . $user->get("code_client") . "date=" . $user->get("datec") ."";
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
    try {
        Bdd::setUserName($dolibarr_main_db_user);
        Bdd::setPassword($dolibarr_main_db_pass);
        $host ="mysql:host=$dolibarr_main_db_host;dbname=$dolibarr_main_db_name;charset=UTF8";
        Bdd::setDsn($host);
    } catch (PDOException $e) {
        dol_syslog("Message : init.php - Erreur lors du chargement des variable d'environnement de la bdd. Exception : " . $e->getMessage(), LOG_ERR, 0, "_cglColl4Saisons" );
    }
}

// tiers 15007 possede BO et LU
$rowidTiers = 15007;
// $rowidBulletinLO = 7530;
$rowidBulletinBU = 7528;
$rowidBulletinBU = 7526; // deux depart

// tiers 15003 ne possede pas de LO / possede un BU
// $rowidTiers = 15003;
// $rowidBulletinLO = null;
// $rowidBulletinBU = 7510;

// test creation url
// var_dump (createURL ($rowidTiers));
// client avec tiesr possedent un LO 15007
    // resultat attentut : /custom/cglcoll4saisons/public/index.php?client=15007&code=CL2024-00008864date=2024-09-16 04:46:22
    // resutat obtenu : /custom/cglcoll4saisons/public/index.php?client=15007&code=CL2024-00008864date=2024-09-16 04:46:22
    // validation : OK
// client avec tiers ne possedant pas de LO 15003
    // resultat string vide : OK

// test affichage URL pour un depart d'un client
// var_dump (affichageURL_BU($rowidTiers, $rowidBulletinBU));
// client 15007 -  BU 7526
    // resultat : array(2) {
    // [5018]=> string(98) "/custom/cglcoll4saisons/public/index.php?client=15007&code=CL2024-00008864date=2024-09-16 04:46:22"
    // [5017]=>  string(98) "/custom/cglcoll4saisons/public/index.php?client=15007&code=CL2024-00008864date=2024-09-16 04:46:22"
    // }
    // validation : OK

// test affichage URL pour location d'un client
// var_dump (affichageURL_LO($rowidTiers, $rowidBulletinLO));
// client 15007 -  LO 7530
    // resultat attentut : /custom/cglcoll4saisons/public/index.php?client=15007&code=CL2024-00008864date=2024-09-16 04:46:22
    // resutat obtenu : /custom/cglcoll4saisons/public/index.php?client=15007&code=CL2024-00008864date=2024-09-16 04:46:22
    // validation : OK
    // validation ok si id tiers faut ou / et  id bulletin faut 
