<?php
/**
 * Role : inserer les modificatons des participants d'un depart en bdd
 * POST : 
 *  $prenom {array} tableau des prenoms des particpants indexé par l'id du participant
 *  $age {array} tableau des ages des particpants indexé par l'id du participant
 *  $taille {array} tableau des taille des particpants indexé par l'id du participant
 *  $taille {poids} tableau des poids des particpants indexé par l'id du participant
 * INTEGRITE DES DONNEES
 *  $prenom[index] doit etre une chaine de caractere de longueur inferieur à 40
 *  $age[index] doit etre numerique de 1 à 99
 *  $taille[index] doit etre numerique de  1 à 299
 *  $age[index] doit etre numerique de 1 à 300
 */

use App\Modeles\ParticipantDep;
use App\Services\Session;

require_once __DIR__ . "/../Utils/init.php";

// chargement langue
$lang = $_SESSION["lang"];
changeLang ($db, $conf,  $lang);

// verifier la connexion
$session = new Session();
if (!$session->isConnected()) { 
    header('Location: ../views/error/errdroit.php');
    exit;
}

// verifier et recuperer les données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  /*
    dol_syslog(
        " id prenom : " . $_POST['prenom'][38632] .
        " id prenom : " . $prenom[38633] .
        " id prenom : " . $prenom[38634] .
        " id prenom : " . $prenom[38635] .
        " id prenom : " . $prenom[38636]
        , LOG_ERR, 0, "_cglColl4Saisons" );
*/
    // Initialiser les tableaux pour stocker les données
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : [];
    $age = isset($_POST['age']) ? $_POST['age'] : [];
    $taille = isset($_POST['taille']) ? $_POST['taille'] : [];
    $poids = isset($_POST['poids']) ? $_POST['poids'] : [];  

    // Vérifier si les tableaux sont vides
    if (empty($prenom) || empty($age) || empty($taille) || empty($poids)) {
        dol_syslog("Message : updatparticipantdepart.php - Parametre ct1 POST non valide", LOG_ERR, 0, "_cglColl4Saisons" );
        header('Location: ../views/error/errtech.php');
        exit;
    }

} else {
    dol_syslog("Message : updatparticipantdepart.php - Parametre ct2 POST non valide", LOG_ERR, 0, "_cglColl4Saisons" );
    header('Location: ../views/error/errtech.php');
    exit;
}

// charger et insserer l'objet partiicpant
foreach($prenom as $idBullDet => $value) {

    // affectation valeur vide si null
    $valuePrenom = !empty($value) ? htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8') : null;
    $valueAge = !empty($age[$idBullDet]) ? htmlentities(extractNumber($age[$idBullDet]), ENT_QUOTES, 'UTF-8') : null;
    $valueTaille = !empty($taille[$idBullDet]) ? htmlentities(extractNumber($taille[$idBullDet]), ENT_QUOTES, 'UTF-8') : null;
    $valuePoids = !empty($poids[$idBullDet]) ? htmlentities(extractNumber($poids[$idBullDet]), ENT_QUOTES, 'UTF-8') : null;

    // Validation du type des données
    if (
        ($valuePrenom !==null && !is_string($valuePrenom) || (is_string($valuePrenom) && strlen($valuePrenom)>40 )) ||
        (($valueAge !== null && !is_numeric($valueAge)) || ($valueAge !== null && !comprisEntre($valueAge, 0, 99)))|| 
        ($valueTaille !== null && !is_numeric($valueTaille) || ($valueTaille !== null && !comprisEntre($valueTaille, 0, 300))) || 
        ($valuePoids !== null && !is_numeric($valuePoids) || ($valuePoids !== null && !comprisEntre($valuePoids, 0, 200)))
    ) {
        dol_syslog("Message : updatparticipantdepart.php - Parametre ct3 POST non valide. Le format des données est incorecte  - Url : " . $_SERVER['REQUEST_URI'], LOG_ERR, 0, "_cglColl4Saisons" );
        header('Location: ../views/error/errtech.php');
        exit;
    }

    // charger et inserer l'objet participant
    if (isset($age[$idBullDet]) && isset($taille[$idBullDet]) && isset($poids[$idBullDet])) {
        try {
            $participant = new ParticipantDep(null, null);
            $participant->set("rowid_participant", $idBullDet);
            $participant->set("prenom",  $valuePrenom);
            $participant->set("age", $valueAge);
            $participant->set("taille", $valueTaille);
            $participant->set("poids", $valuePoids);
            $participant->updateParticipantsDepart();
        } catch (PDOException $e) {
            dol_syslog("Message : updatparticipantdepart.php - Erreur lors du chargement de l'objet participant. Exception : " . $e->getMessage(), LOG_ERR, 0, "_cglColl4Saisons" );
            header('Location: ../views/error/errtech.php');
            exit;
        }
    } else {
         dol_syslog("Message : updatparticipantdepart.php - Erreur lors du cchargement de l'objet participant. id utilisateur ou id bull det inexistant", LOG_ERR, 0, "_cglColl4Saisons" );
         header('Location: ../views/error/errtech.php');
         exit;
    }

    header('Location: ./afficherinfosenregistrees.php');
}