<?php
/**
 * Role : afficher le detail d'une location
 * GET
 *  {intger} : id du type de prestation (table llx_product)
 */

use App\Modeles\Location;
use App\Modeles\ParticipantLoc;
use App\Services\Session;

require_once __DIR__ . "/../Utils/init.php";

// chargement langue
$lang = $_SESSION["lang"];
changeLang ($db, $conf,  $lang);

// verifier la connexion session
$session = new Session();
if (!$session->isConnected()) { 
    require_once __DIR__ . "/../views/error/errdroit.php";
    exit;
}

// verifier les données GET
if(empty($_GET['product'])) {
    dol_syslog("Message : afficherdetaillocation.php - Parametre ct1 url GET non valide  - Url : " . $_GET['product'], LOG_ERR, 0, "_cglColl4Saisons" );
    require_once __DIR__ . "/../views/error/errtech.php";
    exit;
}

// recuper des données GET
$id_product = intval($_GET['product']);
$id_societe = $session->getIdConnected();

if(!filter_var($id_product, FILTER_VALIDATE_INT)) {
    dol_syslog("Message : afficherdetaillocation.php - Parametre ct2 url GET non valide  - id prodcut n'est pas de type integer", LOG_ERR, 0, "_cglColl4Saisons" );
    require_once __DIR__ . "/../views/error/errtech.php";
    exit;
}

// instentiation
$location = new Location ($id_societe, $id_product, null);

// verifier si l'id du type de prestation (table  llx_product appartient) bien à id de l'utilisateur connecté
$locations = $location->loadLocations();

if(empty($locations) || !is_array($locations)) {
    dol_syslog("Message : afficherdetaillocation.php - la liste des locations est vide ou n'est pas au format d'un tableau", LOG_ERR, 0, "_cglColl4Saisons" );
    require_once __DIR__ . "/../views/error/errtech.php";
    exit;
}
$id_products = array_column($locations, 'id_product');
if (!in_array($id_product, $id_products)) {
    require_once __DIR__ . "/../views/error/errdroit.php";
    exit;
}

// charger la liste des particpants location
    $listeParticipants = new ParticipantLoc($id_societe, $id_product);
    $listeParticipantsLoc = $listeParticipants->listeParticipantsLoc();
    if(empty($listeParticipantsLoc) || !is_array($listeParticipantsLoc)) {
        dol_syslog("Message : afficherdetaillocation.php - la liste des participants est vide ou n'est pas au format d'un tableau", LOG_ERR, 0, "_cglColl4Saisons" );
        require_once __DIR__ . "/../views/error/errtech.php";
        exit;
    }

    $participantsList = [];
    foreach ($listeParticipantsLoc as $data) {
        $participant = new ParticipantLoc($id_societe, $id_product);
        
        $participant->set('rowid_product', $data['rowidBulDet']);
        $participant->set('prenom', $data['prenom']);
        $participant->set('age', $data['age']);
        $participant->set('taille', $data['taille']);
        $participantsList[] = $participant;
    }
    $location->set("listeParticipants", $participantsList);
    $listeParticipants = $location->get("listeParticipants");
   
// charger le detail (lieu de depart, date, activité/type de materiel loué) du LO
$bul = $location->loadLocation();
echo "---------------- afficher detail location php ";
var_dump($bul);
$location->set("dateRetrait", $bul["dateRetrait"]);
$location->set("lieuRetrait", $bul["lieuRetrait"]);
$location->set("ref", $bul["ref"]);
    
require_once __DIR__ . "/../views/main/detaillocation.php";