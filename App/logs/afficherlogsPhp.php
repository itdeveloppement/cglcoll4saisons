<?php
// fichier log
// le fichier de log est dans /fourmitest2.cigaleaventure.com/dolibarr_documents/dolibarr_cglColl4Saisons.log
// l'editer avec par exemple note pad pour le lire

// require_once __DIR__ . "/../App/Utils/init.php";
header("Cache-Control: no-cache");

$fichierLogs = '/home/customer/www/fourmitest2.cigaleaventure.com/dolibarr_documents/dolibarr_cglColl4Saisons.log';

// pour vider le fichier de log
// file_put_contents($fichierLogs, '');
// var_dump($fichierLogs);

// si fichier existe afficher les logs
date_default_timezone_set('Europe/Paris');
echo "Date actuelle : " . date("l d F Y, H:i:s") . '<br><br>';

if (file_exists($fichierLogs)){
    $logs = file($fichierLogs);
    foreach($logs as $erreur) {
        echo '<div>' . htmlentities($erreur) . '</div>';
    }
}

