<?php
/**
 * Role : afficher le detail d'un depart
 * GET
 *  {intger} : id de la session (depart) (llx_agefodd_session)
 */

use App\Modeles\Depart;
use App\Modeles\ParticipantDep;
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
if(empty($_GET['session'])) {
    dol_syslog("Message : afficherdetaildepart.php - Parametre ct1 url GET non valide  - Url : " . $_SERVER['REQUEST_URI'], LOG_ERR, 0, "_cglColl4Saisons" );
    require_once __DIR__ . "/../views/error/errtech.php";
    exit;
}

// recuper des données GET
$id_session = intval($_GET['session']);
$id_societe = $session->getIdConnected();

if(!filter_var($id_session, FILTER_VALIDATE_INT)) {
    dol_syslog("Message : afficherdetaildepart.php - Parametre ct2 url GET non valide  - id prodcut n'est pas de type integer", LOG_ERR, 0, "_cglColl4Saisons" );
    require_once __DIR__ . "/../views/error/errtech.php";
    exit;
}

// instentiation
$depart = new Depart ($id_societe, $id_session, null);

// verifier si l'id du type de prestation (table  llx_product appartient) bien à id de l'utilisateur connecté
$departs = $depart->loadDeparts();

if(empty($departs) || !is_array($departs)) {
    dol_syslog("Message : afficherdetaildepart.php - la liste ct1 des locations est vide ou n'est pas au format d'un tableau", LOG_ERR, 0, "_cglColl4Saisons" );
    require_once __DIR__ . "/../views/error/errtech.php";
    exit;
}
$id_sessions = array_column($departs, 'id_session');
if (!in_array($id_session, $id_sessions)) {
    require_once __DIR__ . "/../views/error/errdroit.php";
    exit;
}

// charger la liste des particpants depart
$listeParticipants = new ParticipantDep($id_societe, $id_session);
$listeParticipantsDep = $listeParticipants->listeParticipantsDep();
if(empty($listeParticipantsDep) || !is_array($listeParticipantsDep)) {
    dol_syslog("Message : afficherdetailldepart.php - la liste ct2 des participants est vide ou n'est pas au format d'un tableau", LOG_ERR, 0, "_cglColl4Saisons" );
    require_once __DIR__ . "/../views/error/errtech.php";
    exit;
}

// recuperer les information des champs saise_age, saisie, taille, saisie_poids via la requette sql participant participant-set
// voir fichier wiew  / main / detaildepart
$participantsList = [];
foreach ($listeParticipantsDep as $data) {
    $participant = new ParticipantDep($id_societe, $id_session);
    $participant->set('rowid_participant', $data['id_participant']);
    $participant->set('prenom', $data['prenom']);
    $age = comprisEntre($data['age'], 0, 99) ? $data['age'] : null;
    $participant->set('age', $age);
    $taille = comprisEntre($data['taille'], 0, 300) ? $data['taille'] : null;
    $participant->set('taille',  $taille);
    $poids = comprisEntre($data['poids'], 0, 200) ? $data['poids'] : null;
    $participant->set('poids',$poids);
    $participantsList[] = $participant;
}
$depart->set("listeParticipants", $participantsList);
$listeParticipants = $depart->get("listeParticipants");

// charger le detail (lieu de depart, date, intitulé) du depart
$bul = $depart->loadDepart();
$depart->set("rowidDepart", $bul["id_session"]);
$depart->set("intituleDepart", $bul["intituleDepart"]);
$depart->set("dateDepart", $bul["dateDepart"]);
$depart->set("lieuDepart", $bul["lieuDepart"]);

require_once __DIR__ . "/../views/main/detaildepart.php";