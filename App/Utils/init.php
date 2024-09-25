<?php
/**
 * projet : module de Dolibarr
 * Role : recuperer aupres des utilisateur les information (exemple : age, taille, poids) necessaire à la preparation d'une activité (canyoning, spéleo, location de velo ...)
 * Editeur : Société Cigale Aventure
 */

/**
 * role : initialiser le projet
 */


// DEVELOPPEMENT : Affichage des erreurs
ini_set('display_errors', 1);// Aficher les erreurs
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Toutes les erreurs

//DEVELOPPEMENT : gestion du cache dynamiqe SITE GROUND 
// header("Cache-Control: max-age=6000"); // limiter le temps de durée du cache par defaut 12h
header("Cache-Control: no-cache"); // ne pas mettre en cache 

//Parametrage module pour Dolibarr pour acces exterieur et non affichage des menus

// define('NOTOKENRENEWAL', 1); // Pour éviter de renouveler le token
// define('NOCSRFCHECK', 1);    // Pour éviter le check CSRF
define('NOLOGIN', 1);        // Pour bypasser la vérification de login
// define('NOREQUIREMENU', 1);  // Pour désactiver les menus (haut et gauche)
// define('NOREQUIREHTML', 1);  // Pour désactiver les en-têtes et pieds de page HTML
// define('NOREQUIREAJAX', 1);  // Pour désactiver AJAX

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--;
	$j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res && file_exists("../../../../main.inc.php")) {
    $res = @include "../../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

require_once DOL_DOCUMENT_ROOT.'/core/class/html.formfile.class.php';
require_once DOL_DOCUMENT_ROOT . '/core/lib/admin.lib.php';
// Load translation files required by the page

// initialisation langue dans la session par default francais
$langs->loadLangs(array("cglcoll4saisons@cglcoll4saisons"));

if (!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "fr_FR"; // Langue par défaut
}

function changeLang ($db, $conf,  $lang) { 
    if (!empty($lang)) { 
        $newLang =$lang;
        dolibarr_set_const($db, "MAIN_LANG_DEFAULT", $newLang, 'chaine', 0, '', $conf->entity);
    }
}

$action = GETPOST('action', 'aZ09');
$max = 5;
$now = dol_now("tzuser");

// Security check (enable the most restrictive one)
//if (!isModEnabled('cglcoll4saisons')) {
//	accessforbidden('Module not enabled');
//}
//if (! $user->hasRight('cglcoll4saisons', 'myobject', 'read')) {
//	accessforbidden();
//}
//restrictedArea($user, 'cglcoll4saisons', 0, 'cglcoll4saisons_myobject', 'myobject', '', 'rowid');

// $db->close();

// BASE URL
define('BASE_URL', '/custom/cglcoll4saisons/');

// chargement des classes
    require_once __DIR__ . '/../Services/Bdd.php';
    require_once __DIR__ . '/../Services/Session.php';
    require_once __DIR__ . '/../Services/Authentification.php';
    require_once __DIR__ . '/../Modeles/Modele.php';
    require_once __DIR__ . '/../Modeles/User.php';
    require_once __DIR__ . '/../Modeles/Depart.php';
    require_once __DIR__ . '/../Modeles/Location.php';
    require_once __DIR__ . '/../Modeles/ParticipantLoc.php';
    require_once __DIR__ . '/../Modeles/ParticipantDep.php';
    require_once __DIR__ . '/../Utils/date_fct.php';
    require_once __DIR__ . '/../Utils/affichage_fct.php';
    require_once __DIR__ . '/../Utils/verification_champs.php';

// initialisation de la session
session_start();
