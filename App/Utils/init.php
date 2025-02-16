<?php
/**
 * projet : module de Dolibarr
 * Role : recuperer aupres des utilisateur les information (exemple : age, taille, poids) necessaire à la preparation d'une activité (canyoning, spéleo, location de velo ...)
 * Editeur : Société Cigale Aventure
 */

use App\Services\Bdd;
use App\Services\Session;

// Activer l'affichage des erreurs
ini_set('display_errors', 1);   // Afficher les erreurs
ini_set('display_startup_errors', 1); // Afficher les erreurs de démarrage
error_reporting(E_ALL); // Afficher toutes les erreurs

// DEVELOPPEMENT : Affichage des erreurs
ini_set('display_errors', 1);// Aficher les erreurs
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Toutes les erreurs

// supression cahce coté client
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");


// ------------------------- INIT ACCES EXTERIEUR A DOLIBARR--------------------------------

// define('NOTOKENRENEWAL', 1); // Pour éviter de renouveler le token
// define('NOCSRFCHECK', 1);    // Pour éviter le check CSRF
define('NOLOGIN', 1);        // Pour bypasser la vérification de login
// define('NOREQUIREMENU', 1);  // Pour désactiver les menus (haut et gauche)
// define('NOREQUIREHTML', 1);  // Pour désactiver les en-têtes et pieds de page HTML
// define('NOREQUIREAJAX', 1);  // Pour désactiver AJAX

// ------------------------- INIT MAIN DOLIBARR --------------------------------


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

// ------------------------- INIT LANG --------------------------------

// initialisation langue dans la session par default francais
$langs->loadLangs(array("cglcoll4saisons@cglcoll4saisons"));

if (!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "fr_FR"; // Langue par défaut
}

// gestion du cache
// Désactiver le cache dans Dolibarr
clearstatcache();
$conf->global->USE_CACHE = 0;// Désactiver le cache

//----------------------- AUTRES -------------------------------------

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

// ------------------------- INIT CLASSES ET FONCTIONS ----------------

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
    require_once __DIR__ . '/../Utils/langs_fct.php';
    require_once __DIR__ . '/../Utils/verification_champs.php';
    require_once __DIR__ . '/../Utils/url_publique_fct.php';

 

// ------------------------- INIT VARIABLES ENVIRONNEMENT .ENV --------------------------------  
    // $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    try {
        // $dolibarr_main_db_type
        Bdd::setUserName($dolibarr_main_db_user);
        Bdd::setPassword($dolibarr_main_db_pass);
        $host ="mysql:host=$dolibarr_main_db_host;dbname=$dolibarr_main_db_name;charset=UTF8";
        Bdd::setDsn($host);
    } catch (PDOException $e) {
        dol_syslog("Message : init.php - Erreur lors du chargement des variable d'environnement. Exception : " . $e->getMessage(), LOG_ERR, 0, "_cglColl4Saisons" );
    }

// ------------------------- INIT SESSION -------------------------------- 

// Vérification si une session est déjà active
if (session_status() == PHP_SESSION_NONE) {
    // Définir un nom de cookie unique pour la session
    session_name('FORM_4_SAISONS_SESSION');
    // Définir les paramètres du cookie de session
    session_set_cookie_params([
        'lifetime' => 0, // Le cookie expire à la fin de la session
        'path' => '/', // Le cookie est valide pour tout le domaine
        'domain' => '', // Le cookie est valide pour le domaine courant
        'secure' => true, // Le cookie est envoyé uniquement via HTTPS
        'httponly' => true, // Le cookie est accessible uniquement via HTTP
        'samesite' => 'Strict', // Le cookie est envoyé uniquement dans des requêtes de même site
    ]);

 

    // session_start();
}

// Afficher le contenu de la variable de session
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

// Pour debugage session

// // Lire les paramètres d'URL
// $client = isset($_GET['client']) ? $_GET['client'] : null;
// $code = isset($_GET['code']) ? $_GET['code'] : null;
// $date = isset($_GET['date']) ? $_GET['date'] : null;

// // Utilisez ces variables pour générer le contenu spécifique
// if ($client && $code && $date) {
//     // Générer le contenu en fonction des paramètres
//     echo "Client: $client, Code: $code, Date: $date";
// } else {
//     echo "Paramètres manquants";
// }

// // Détruire la session après l'envoi du contenu
// register_shutdown_function(function() {
//      $session = new Session();
//      $session->destroySession();
// });
?>




