<?php
/**
 * rôle : met en forme l'affichage de la litse des depart d'un utilisateur
 *  param : {array objet} $listeDeparts
 *  param : {array objet} $listeLocations 
 */

include_once __DIR__ . "/../layout/header.php";

// verif données
echo "<h2>" . $langs->trans("intitule-liste-depart") . "</h2>";
foreach ($listeDeparts as $depart) {
    echo "<div>";
        echo "<div>" . $depart->get("rowidDepart") . "</div>";
        echo "<div>" . $depart->get("intituleDepart") . "</div>";
        echo "<div>" . formatDateAffichage ($depart->get("dateDepart")) . "</div>";
        echo "<div>" . $depart->get("lieuDepart") . "</div>";
        echo '<a href="/custom/cglcoll4saisons/App/controleurs/afficherdetaildepart.php?session=' . $depart->get("rowidDepart") . '">' . $langs->trans("btn-info") .' </a><br><br>';
    echo "</div>";
}

foreach ($listeLocations as $location) {
    echo "<div>";
        echo "<div>" . $location->get("rowidBulDet") . "</div>";
        echo "<div>" . $location->get("intituleDepart") . "</div>";
        echo "<div>" . formatDateAffichage ($location->get("dateRetrait")) . "</div>";
        echo "<div>" . $location->get("lieuRetrait") . "</div>";
        echo '<a href="/custom/cglcoll4saisons/App/controleurs/afficherdetaillocation.php?product=' . $location->get("rowidBulDet") . '">' . $langs->trans("btn-info") . '</a><br><br>';
    echo "</div>";
}
?>

<?php 
include_once __DIR__ . "/../layout/footer.php";