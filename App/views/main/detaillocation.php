<?php
/**
 * rôle : met en forme le detail d'une location
 * param : {array objet} : liste des participants d'une prestation de location
 */

include_once __DIR__ . "/../layout/header.php";

// location
echo "<h2 id='btn' >" . $langs->trans("intitule-detail-depart") . "</h2>";
echo "<div>";
    echo "</div>" . $langs->trans("loc-velo") . "<div>";
    echo "<div>" . formatDateAffichage ($location->get("dateRetrait")) . "</div>";
    echo "<div>" . $location->get("lieuRetrait") . "</div>";
echo "</div>";

// form participants
echo '<form id="participantFormLocation">';
    foreach ($listeParticipants as $index => $participant) {
        $index=$index+1;
        echo "<h3>Participant $index</h3>";
        echo "<div class='flex'>";

        echo '<input class="prenom" type="text" id="prenom_location_' . $participant->get("rowid_product") . '" name="prenom[' . $participant->get("rowid_product") . ']" value="' . ($participant->get("prenom") !== null ? htmlspecialchars($participant->get("prenom")) : '' ). '" placeholder="Prenom">';
        echo '<p class="p-error d-none" id="error-prenom" data-id="prenom_location_' . $participant->get("rowid_product") . '"></p>';

        echo '<input class="age age-field" type="text" id="age_location_' . $participant->get("rowid_product") . '" name="age[' . $participant->get("rowid_product") . ']" value="' . ($participant->get("age") !== null ? htmlentities($participant->get("age")) : '' ). '" placeholder="Age">';
        echo '<p class="p-error d-none" id="error-age" data-id="age_location_' . $participant->get("rowid_product") . '"></p>';

        echo '<input class="taille taille-field" type="text" id="taille_location_' . $participant->get("rowid_product") . '" name="taille[' . $participant->get("rowid_product") . ']" value="' . ($participant->get("taille") !== null ? htmlentities($participant->get("taille")) : '' ). '" placeholder="Taille en cm">';
        echo '<p class="p-error d-none" id="error-taille" data-id="taille_location_' . $participant->get("rowid_product") . '"></p>';

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
