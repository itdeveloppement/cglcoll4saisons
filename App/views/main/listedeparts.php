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
    echo "<h2>" . $langs->trans("bonjour") . " " . $langs->trans("civilite") . " " . $user->get("nom") . $langs->trans("intitule-liste-depart")  . "</h2>";
    foreach ($listeDeparts as $depart) {
        echo "<article class='card-liste-depart'>";
            // echo "<div>" . $depart->get("rowidDepart") . "</div>";
            echo "<p>" . formatDateAffichage ($depart->get("dateDepart")) . "</p>";
            echo "<h3>" . $depart->get("intituleDepart") . "</h3>";
            echo "<p>" . $depart->get("lieuDepart") . "</p>";
            echo '<div class="btn-container flex"><a href="/custom/cglcoll4saisons/App/controleurs/afficherdetaildepart.php?session=' . $depart->get("rowidDepart") . '">' . $langs->trans("btn-info") .' </a></div>';
        echo "</article>";
    }
    
    foreach ($listeLocations as $location) {
        echo "<article class='card-liste-depart'>";
            // echo "<div>" . $location->get("rowidBulDet") . "</div>";
            echo "<p>" . formatDateAffichage ($location->get("dateRetrait")) . "</p>";
            echo "<h3>" . $location->get("ref") . "</h3>";
            echo "<p>" . $location->get("lieuRetrait") . "</p>";
            echo '<div class="btn-container flex"><a href="/custom/cglcoll4saisons/App/controleurs/afficherdetaillocation.php?product=' . $location->get("rowidBulDet") . '">' . $langs->trans("btn-info") . '</a></div>';
            
        echo "</article>";
    }
echo '</main>';
?>

<?php
include_once __DIR__ . "/../layout/footer.php";