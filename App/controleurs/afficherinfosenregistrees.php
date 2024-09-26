<?php
/**
 * Role : afficher page message infos bien enregistrées
 */

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
require_once __DIR__ . "/../views/main/infosenregistrees.php";
