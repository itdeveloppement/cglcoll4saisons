<?php
/**
 * rôle : met en forme le detail d'un depart
 * param : {array objet} : liste des participants d'un depart
 */

include_once __DIR__ . "/../layout/header.php";

// location
echo "<h2 id='btn' >" . $langs->trans("intitule-detail-depart") . "</h2>";
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

            echo '<input class="prenom" type="text" id="prenom_depart_' . $participant->get("rowid_participant") . '" name="prenom[' . $participant->get("rowid_participant") . ']" value="' . ($participant->get("prenom") !== null ? htmlspecialchars($participant->get("prenom")) : '' ). '" placeholder="Prenom">';
            echo '<p class="p-error d-none" id="error-prenom" data-id="prenom_depart_' . $participant->get("rowid_participant") . '"></p>';

            echo '<input class="age age-field" type="text" id="age_depart_' . $participant->get("rowid_participant") . '" name="age[' . $participant->get("rowid_participant") . ']" value="' . ($participant->get("age") !== null ? htmlentities($participant->get("age")) : '' ). '" placeholder="Age">';
            echo '<p class="p-error d-none" id="error-age" data-id="age_depart_' . $participant->get("rowid_participant") . '"></p>';

            echo '<input class="taille taille-field" type="text" id="taille_depart_' . $participant->get("rowid_participant") . '" name="taille[' . $participant->get("rowid_participant") . ']" value="' . ($participant->get("taille") !== null ? htmlentities($participant->get("taille")) : '' ). '" placeholder="Taille en cm">';
            echo '<p class="p-error d-none" id="error-taille" data-id="taille_depart_' . $participant->get("rowid_participant") . '"></p>';

            echo '<input class="poids poids-field" type="text" id="poids_depart_' . $participant->get("rowid_participant") . '" name="poids[' . $participant->get("rowid_participant") . ']" value="' . ($participant->get("poids") !== null ? htmlentities($participant->get("poids")) : '' ). '" placeholder="Poids en kg">';
            echo '<p class="p-error d-none" id="error-poids" data-id="poids_depart_' . $participant->get("rowid_participant") . '"></p>';

        echo "</div>";
    }
    echo '<p class="p-error d-none" id="btn-form">' .  $langs->trans("err_sumit-form"). '</p>';
    echo '<button type="submit">' . $langs->trans("btn-valider") . '</button>';
echo '</form>';

include_once __DIR__ . "/../layout/footer.php";

?>

<script>
    // Crée un tableau JavaScript contenant des messages d'erreur
    let erreurMessage = {
       'err-nombre': <?= json_encode($langs->trans("err-nombre")) ?>,
        'err-longueur-prenom': <?= json_encode($langs->trans("err-longueur-prenom")) ?>,
        'err-nombre-age': <?= json_encode($langs->trans("err-nombre-age")) ?>,
        'err-insert-code': <?= json_encode($langs->trans("err-insert-code")) ?>
    };
</script>

<script type="module" src="../../public/js/app.js" defer></script>
