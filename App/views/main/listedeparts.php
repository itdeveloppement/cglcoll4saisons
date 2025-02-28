<?php
/**
 * rôle : met en forme l'affichage de la litse des depart d'un utilisateur
 *  param : {array objet} $listeDeparts
 *  param : {array objet} $listeLocations
 */

use App\Modeles\User;

include_once __DIR__ . "/../layout/header.php";

$user = new User($_SESSION['FORM_4_SAISONS_ID']);

echo '<main class="liste-depart">';
    // verif données
    echo "<h2>" . $langs->trans("bonjour") . " " . $langs->trans("civilite") . " " . formatString($user->get("nom")) . $langs->trans("intitule-liste-depart")  . "</h2>";
   
    // if (!empty($listeDeparts)) {
    //     echo "<h3 class='h3detaildepart'>" . $langs->trans("activite-accompagnee") . "</h3>";
    // }
    foreach ($listeDeparts as $depart) {
        if ($depart->get('affichageActivite')==1) {
        echo "<article class='card-liste-depart'>";
            echo "<p>" . formatDateAffichage ($depart->get("dateDepart")) . "</p>";
            echo "<h3>" . $depart->get("intituleDepart") . "</h3>";
            // echo "<p>" . $depart->get("lieuDepart") . "</p>";
            echo '<div class="btn-container flex"><a href="/custom/cglcoll4saisons/App/controleurs/afficherdetaildepart.php?session=' . $depart->get("rowidDepart") . '">' . $langs->trans("btn-info") .' </a></div>';
        echo "</article>";
        } else {
            echo "<article class='card-liste-depart bagroudGrise'>";
                echo "<p>" . formatDateAffichage ($depart->get("dateDepart")) . "</p>";
                echo "<h3>" . $depart->get("intituleDepart") . "</h3>";
                // echo "<p>" . $depart->get("lieuDepart") . "</p>";
                echo '<div class="messageGrise">'. $langs->trans("messageContact") .'</div>';
                echo '<div class="messageGrise">'. $langs->trans("messageContact2") .'</div>';
            echo "</article>";
        }
    }
    // if (!empty($listeLocations)) {
    //     echo "<h3 class='h3detaildepart'>" . $langs->trans("activite-location") . "</h3>";
    // }
   
    foreach ($listeLocations as $location) {
        if ($location->get('affichageActivite')==1) {
            echo "<article class='card-liste-depart'>";
                echo "<p>" . formatDateAffichage ($location->get("dateRetrait")) . "</p>";
                echo "<h3>" . $location->get("ref") . "</h3>";
                // echo "<p>" . $location->get("lieuRetrait") . "</p>";
                echo '<div class="btn-container flex"><a href="/custom/cglcoll4saisons/App/controleurs/afficherdetaillocation.php?product=' . $location->get("rowidBulDet") . '">' . $langs->trans("btn-info") . '</a></div>';
            echo "</article>";
        } else {
            echo "<article class='card-liste-depart bagroudGrise'>";
                echo "<p>" . formatDateAffichage ($location->get("dateRetrait")) . "</p>";
                echo "<h3>" . $location->get("ref") . "</h3>";
                // echo "<p>" . $location->get("lieuRetrait") . "</p>";
                echo '<div class="messageGrise">'. $langs->trans("messageContact") .'</div>';
                echo '<div class="messageGrise">'. $langs->trans("messageContact2") .'</div>';
            echo "</article>";
        }
    }
echo '</main>';

include_once __DIR__ . "/../layout/footer.php";
