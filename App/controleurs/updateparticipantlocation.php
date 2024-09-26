<?php
/**
 * Role : inserer les modificatons des participants d'une loication en bdd
 * POST : 
 *  $prenom {array} tableau des prenoms des particpants indexé par l'id du participant
 *  $age {array} tableau des ages des particpants indexé par l'id du participant
 *  $taille {array} tableau des taille des particpants indexé par l'id du participant
 * INTEGRITE DES DONNEES
 *  $prenom[index] doit etre une chaine de caractere de longueur inferieur à 40
 *  $age[index] doit etre numerique de 1 à 99
 *  $taille[index] doit etre numerique de  1 à 299
 */

use App\Modeles\ParticipantLoc;
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
    // Initialiser les tableaux pour stocker les données
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : [];
    $age = isset($_POST['age']) ? $_POST['age'] : [];
    $taille = isset($_POST['taille']) ? $_POST['taille'] : []; 

    // Vérifier si les tableaux sont vides
    if (empty($prenom) || empty($age) || empty($taille)) {
        dol_syslog("Message : updatparticipant.php - Parametre ct1 url GET non valide  - Url : " . $_SERVER['REQUEST_URI'], LOG_ERR, 0, "_cglColl4Saisons" );
        header('Location: ../views/error/errtech.php');
        exit;
    }
} else {
    dol_syslog("Message : updatparticipant.php - La methode n'est pas POST - Url : " . $_SERVER['REQUEST_URI'], LOG_ERR, 0, "_cglColl4Saisons" );
    header('Location: ../views/error/errtech.php');
    exit;
}

// charger et insserer l'objet partiicpant
foreach($prenom as $idBullDet => $value) {
    // affectation valeur vide si null
    $valuePrenom = !empty($value) ? htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8') : null;
    $valueAge = !empty($age[$idBullDet]) ? htmlentities(extractNumber($age[$idBullDet]), ENT_QUOTES, 'UTF-8') : null;
    $valueTaille = !empty($taille[$idBullDet]) ? htmlentities(extractNumber($taille[$idBullDet]), ENT_QUOTES, 'UTF-8') : null;
 
    // Validation du type des données
    if (
        ($valuePrenom !==null && !is_string($valuePrenom) || (is_string($valuePrenom) && strlen($valuePrenom)>40 )) ||
        (($valueAge !== null && !is_numeric($valueAge)) || ($valueAge !== null && !comprisEntre($valueAge, 0, 100)))|| 
        ($valueTaille !== null && !is_numeric($valueTaille) || ($valueTaille !== null && !comprisEntre($valueTaille, 0, 300)))
    ) {
        dol_syslog("Message : updatparticipant.php - Parametre ct3 POST non valide. Le format des données est incorecte  - Url : " . $_SERVER['REQUEST_URI'], LOG_ERR, 0, "_cglColl4Saisons" );
        header('Location: ../views/error/errtech.php');
        exit;
    }

    // charger et inserer l'objet participant
    if (isset($age[$idBullDet]) && isset($taille[$idBullDet])) {
        try {
            $participant = new ParticipantLoc(null, null);
            $participant->set("rowid_product", $idBullDet);
            $participant->set("prenom",  $valuePrenom);
            $participant->set("age", $valueAge);
            $participant->set("taille", $valueTaille);
            $participant->updateParticipants();
        } catch (PDOException $e) {
            dol_syslog("Message : updatparticipant.php - Erreur lors du cchargement de l'objet participant. Exception : " . $e->getMessage(), LOG_ERR, 0, "_cglColl4Saisons" );
            header('Location: ../views/error/errtech.php');
            exit;
        }
    } else {
         dol_syslog("Message : updatparticipant.php - Erreur lors du cchargement de l'objet participant. id utilisateur ou id bull det inexistant", LOG_ERR, 0, "_cglColl4Saisons" );
         header('Location: ../views/error/errtech.php');
         exit;
    }

    header('Location: ./afficherinfosenregistrees.php');
}

