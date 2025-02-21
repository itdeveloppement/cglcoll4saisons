<?php
// Récupérer les données de la requête POST
$data = file_get_contents('php://input');
$request = json_decode($data, true);
// var_dump($request);
// Extraire le message d'erreur
if (isset($request['error'])) {
    $errorMessage = $request['error'];
    
    // Format du message avec l'horodatage
    $logMessage = "Date : " . date('Y-m-d H:i:s') . " Message : " . $errorMessage . "\n";
    // Écrire l'erreur dans un fichier log
    file_put_contents('./erreursLogsJs.log', "$logMessage", FILE_APPEND);
    
    // Réponse au client
    echo "Erreur loggée avec succès";
} else {
    echo "Aucune erreur à enregistrer";
}

