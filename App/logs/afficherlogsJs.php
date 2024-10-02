<?php
//role : recuperer le fichier de log pour les erreur js
// afficher les erreur

// ne pas mettre en chache pour cette page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT"); // Date passée
header("Pragma: no-cache"); // Pour les anciens navigateurs


$fichierLogs = './erreursLogsJs.log';

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