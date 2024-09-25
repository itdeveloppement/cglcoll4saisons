<?php
/**
 * rôle : met en forme le detail d'un depart
 * param : {array objet} : liste des participants d'un depart
 */

include_once __DIR__ . "/../layout/header.php";

// location
echo "<h2 id='btn' >" . $langs->trans("intitule-liste-depart") . "</h2>";
echo "<div>";
    echo "<div>" . $depart->get("intituleDepart") . "</div>";
    echo "<div>" . formatDateAffichage ($depart->get("dateDepart")) . "</div>";
    echo "<div>" . $depart->get("lieuDepart") . "</div>";
echo "</div>";
// form participants
echo '<form id="participantFormDepart">';
    foreach ($listeParticipants as $index => $participant) {
        $index=$index+1;
        echo "<h3>" . $langs->trans("participant") . " $index</h3>";
        echo "<div class='flex'>";

            echo '<input type="text" id="prenom_depart_' . $participant->get("rowid_participant") . '" name="prenom[' . $participant->get("rowid_participant") . ']" value="' . ($participant->get("prenom") !== null ? htmlspecialchars($participant->get("prenom")) : '' ). '" placeholder="Prenom">';

            echo '<input class="age-field" type="text" id="age_depart_' . $participant->get("rowid_participant") . '" name="age[' . $participant->get("rowid_participant") . ']" value="' . ($participant->get("age") !== null ? htmlentities($participant->get("age")) : '' ). '" placeholder="Age">';

            echo '<input class="taille-field" type="text" id="taille_depart_' . $participant->get("rowid_participant") . '" name="taille[' . $participant->get("rowid_participant") . ']" value="' . ($participant->get("taille") !== null ? htmlentities($participant->get("taille")) : '' ). '" placeholder="Taille en cm">';

            echo '<input class="poids-field" type="text" id="poids_depart_' . $participant->get("rowid_participant") . '" name="poids[' . $participant->get("rowid_participant") . ']" value="' . ($participant->get("poids") !== null ? htmlentities($participant->get("poids")) : '' ). '" placeholder="Poids en kg">';

        echo "</div>";
    }
    echo '<button  type="submit">' . $langs->trans("btn-valider") . '</button>';
echo '</form>';

include_once __DIR__ . "/../layout/footer.php";

?>

<script src="../../public/js/app.js" defer></script>
