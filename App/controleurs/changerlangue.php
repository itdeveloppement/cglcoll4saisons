<?php
/**
 * Role : afficher la page à biento
 */

use App\Services\Session;

require_once __DIR__ . "/../Utils/init.php";

// chargement langue
$lang = $_SESSION["lang"];
changeLang ($db, $conf,  $lang);

// verifier la connexion
$session = new Session();
if (!$session->isConnected()) { 
    require_once __DIR__ . "/../views/error/errdroit.php";
    exit;
}

// verifier la langue
if (!isset($_GET["lang"]) || empty($_GET["lang"])) {
    require_once __DIR__ . "/../views/error/errtech.php";
exit;
}

$lang = $_GET["lang"];
// changer la langue
if ($lang == "en_US") {
    $_SESSION["lang"] = "en_US";
    require_once __DIR__ . "/../../public/index.php";
    exit;
} else {
    $_SESSION["lang"] = "fr_FR";
    require_once __DIR__ . "/../../public/index.php";
    exit;
}
