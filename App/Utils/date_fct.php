<?php
/**
 * role : formatage et verification des dates
 */

/**
 * role : verifier les donnée et le format de la date
 * @param : {string} $dateTime la date à verifier
 * @param : le format recherché
 * @return : true si la date est validé, sinon false
 */
function validationDate($dateTime, $format = 'Y-m-d H:i:s') {
    // Crée un objet DateTime et retourne true si format validé
    $d = DateTime::createFromFormat($format, $dateTime);
    // Vérifie format et données et retourne true si les deux sont validés
    return $d && $d->format($format) === $dateTime;
}

/**
 * role : formate la date pour afficher jour numero moi heure minute
 * @param : {string} $dateTime la date à verifier
 * @param : le format recherché
 * @return : true si la date est validé, sinon false
 */
function formatDateAffichage ($date) {
    $date = new DateTime($date);
    // Crée un formateur de date en français
    $formatter = new IntlDateFormatter(
    'fr_FR',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    null,
    IntlDateFormatter::GREGORIAN,
    'EEEE dd MMMM HH:mm'
);
    // Formater la date
    $formattedDate = $formatter->format($date);
    $formattedDate = ucfirst($formattedDate); // majuscule
    $formattedDate = str_replace(':', 'h', $formattedDate);
    $timePos = strpos($formattedDate, ' ', -6); // position heure mois 6 caractere
    if ($timePos !== false) {  // Ajouter le texte "à"
        $formattedDate = substr_replace($formattedDate, ' à ', $timePos, 0); // Insère " à " après le mois
    }
    return $formattedDate;
}

/**
 * role : transforme une date au format Y-m-d H:i:s en entier
 * @param : $format Y-m-d H:i:s
 * @param : $date : date au format Y-m-d H:i:s
 * @return : la date au format entier
 */
function formatDateEntier ($date, $format = "Y-m-d H:i:s"){
    
    $dateTime = DateTime::createFromFormat($format, $date);
    if ($dateTime !== false){
    return $dateTime->getTimestamp();
    } else {
        return false;
    }
}
