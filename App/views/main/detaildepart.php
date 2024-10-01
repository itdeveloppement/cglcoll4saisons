<?php
/**
 * rôle : met en forme le detail d'un depart
 * param : {array objet} : liste des participants d'un depart
 */

include_once __DIR__ . "/../layout/header.php";

echo "<main class='detail-depart'>";
    // depart
    echo "<h2 id='btn' >" . $langs->trans("intitule-detail-depart") . "</h2>";
    echo "<div class='flex activite'>";
        echo "<h3>" . htmlspecialchars(html_entity_decode($langs->trans("activite")), ENT_QUOTES, 'UTF-8') . "</h3>";
        echo "<p>" . htmlspecialchars($depart->get("intituleDepart")) . "</p>";
        echo "<p>" . htmlspecialchars(formatDateAffichage ($depart->get("dateDepart"))) . "</p>";
        echo "<p>" . htmlspecialchars($depart->get("lieuDepart")) . "</p>";
    echo "</div>";
    // form participants
    echo '<form id="participantFormDepart">';
        foreach ($listeParticipants as $index => $participant) {
            $index=$index+1;
            echo "<h3>" . htmlspecialchars(html_entity_decode($langs->trans("participant")), ENT_QUOTES, 'UTF-8') . " $index</h3>";
            echo "<div class='flex container-input'>";
                echo "<div class='flex container-input'>";
                    echo '<label for="nom">' . htmlspecialchars(html_entity_decode($langs->trans("label-prenom")), ENT_QUOTES, 'UTF-8') . '</label>';
                    echo '<input class="prenom" type="text" id="prenom_depart_' . htmlspecialchars($participant->get("rowid_participant")) . '" name="prenom[' . htmlspecialchars($participant->get("rowid_participant")) . ']" value="' . (htmlspecialchars($participant->get("prenom")) !== null ? htmlspecialchars($participant->get("prenom")) : '' ) . '" placeholder="' . htmlspecialchars(html_entity_decode($langs->trans("label-prenom")), ENT_QUOTES, 'UTF-8') . '">';
                    echo '<p class="p-error d-none" id="error-prenom" data-id="prenom_depart_' . $participant->get("rowid_participant") . '"></p>';
                echo "</div>";

                echo "<div class='flex container-input'>";
                    echo '<label for="nom">' . htmlspecialchars(html_entity_decode($langs->trans("label-age")), ENT_QUOTES, 'UTF-8') . '</label>';
                    echo '<input class="age age-field" type="text" id="age_depart_' . htmlspecialchars($participant->get("rowid_participant")) . '" name="age[' . htmlspecialchars($participant->get("rowid_participant")) . ']" value="' . (htmlspecialchars($participant->get("age")) !== null ? htmlentities($participant->get("age")) : '' ). '" placeholder=' . htmlspecialchars(html_entity_decode($langs->trans("label-age")), ENT_QUOTES, 'UTF-8') . '>';
                    echo '<p class="p-error d-none" id="error-age" data-id="age_depart_' . htmlspecialchars($participant->get("rowid_participant")) . '"></p>';
                echo "</div>";

                echo "<div class='flex container-input'>";
                    echo '<label for="nom">' . htmlspecialchars(html_entity_decode($langs->trans("label-taille")), ENT_QUOTES, 'UTF-8') . '</label>';
                    echo '<input class="taille taille-field" type="text" id="taille_depart_' . htmlspecialchars($participant->get("rowid_participant")) . '" name="taille[' . htmlspecialchars($participant->get("rowid_participant")) . ']" value="' . (htmlspecialchars($participant->get("taille")) !== null ? htmlentities($participant->get("taille")) : '' ). '" placeholder=' . htmlspecialchars(html_entity_decode($langs->trans("label-taille")), ENT_QUOTES, 'UTF-8') . '>';
                    echo '<p class="p-error d-none" id="error-taille" data-id="taille_depart_' . htmlspecialchars($participant->get("rowid_participant")) . '"></p>';
                echo "</div>";

                echo "<div class='flex container-input'>";
                    echo '<label for="nom">' . htmlspecialchars(html_entity_decode($langs->trans("label-poids"))) . '</label>';
                    echo '<input class="poids poids-field" type="text" id="poids_depart_' . htmlspecialchars($participant->get("rowid_participant")) . '" name="poids[' . $participant->get("rowid_participant") . ']" value="' . (htmlspecialchars($participant->get("poids")) !== null ? htmlentities($participant->get("poids")) : '' ). '" placeholder=' . htmlspecialchars(html_entity_decode($langs->trans("label-poids"),  ENT_QUOTES)) . '>';
                    echo '<p class="p-error d-none" id="error-poids" data-id="poids_depart_' . htmlspecialchars($participant->get("rowid_participant")) . '"></p>';
                echo "</div>";
            echo "</div>";
        }
        echo '<div class="flex container-btn">';
            echo '<p class="p-error d-none" id="btn-form">' .  htmlspecialchars(html_entity_decode($langs->trans("err_sumit-form"), ENT_QUOTES, 'UTF-8')). '</p>';
            echo '<button type="submit">' . htmlspecialchars(html_entity_decode($langs->trans("btn-valider"), ENT_QUOTES, 'UTF-8')) . '</button>';
        echo '</div>';
        echo '</form>';
echo '</main>';

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
