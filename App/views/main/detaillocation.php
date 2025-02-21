<?php
/**
 * rôle : met en forme le detail d'une location
 * param : {array objet} : liste des participants d'une prestation de location
 */

use App\Modeles\User;

include_once __DIR__ . "/../layout/header.php";

$user = new User($_SESSION['FORM_4_SAISONS_ID']);

echo "<main class='detail-location'>";
    // location
    echo "<h2 id='btn' >" . $langs->trans("civilite") . " " . $user->get("nom") . htmlspecialchars(html_entity_decode($langs->trans("intitule-detail-depart")), ENT_QUOTES, 'UTF-8') . "</h2>";
    echo "<div class='flex activite'>";
        echo "<h3>" . htmlspecialchars($location->get("ref")) . "</h3>";
        echo "<p>" . htmlspecialchars($location->get("ref")) . "</p>";
        echo "<p class='date'>" . htmlspecialchars(formatDateAffichage ($location->get("dateRetrait"))) . "</p>";
        echo "<p class='lieu'>" . htmlspecialchars($location->get("lieuRetrait")) . "</p>";
    echo "</div>";

    // form participants
    echo '<form class="formLocation" id="participantFormLocation">';
        foreach ($listeParticipants as $index => $participant) {
            $index=$index+1;
            echo "<h3>" . $location->get("ref"). " : participant " . $index ."</h3>";
                echo "<div class='flex container-input'>";

                    echo "<div class='flex container-input'>";

                        echo '<label for="nom">' . htmlspecialchars(html_entity_decode($langs->trans("label-prenom")), ENT_QUOTES, 'UTF-8') . '</label>';

                        echo '<input class="prenom" type="text" id="prenom_location_' . htmlspecialchars($participant->get("rowid_product"), ENT_QUOTES, 'UTF-8') . '" name="prenom[' . htmlspecialchars($participant->get("rowid_product"), ENT_QUOTES, 'UTF-8') . ']" value="' . ($participant->get("prenom") !== null ? htmlspecialchars($participant->get("prenom"), ENT_QUOTES, 'UTF-8') : '' ). '" placeholder="' . htmlspecialchars(html_entity_decode($langs->trans("label-prenom")), ENT_QUOTES, 'UTF-8') . '">';

                        echo '<p class="p-error d-none" id="error-prenom" data-id="prenom_location_' . htmlspecialchars($participant->get("rowid_product"), ENT_QUOTES, 'UTF-8') . '"></p>';

                    echo "</div>";

                    echo "<div class='flex container-input'>";   

                        echo '<label for="nom">' . htmlspecialchars(html_entity_decode($langs->trans("label-age")), ENT_QUOTES, 'UTF-8') . '</label>';

                        echo '<input class="age age-field" type="text" id="age_location_' . htmlspecialchars($participant->get("rowid_product")) . '" name="age[' . htmlspecialchars($participant->get("rowid_product")) . ']" value="' . (htmlspecialchars($participant->get("age")) !== null ? htmlentities($participant->get("age")) : '' ). '" placeholder="' . htmlspecialchars(html_entity_decode($langs->trans("label-age")), ENT_QUOTES, 'UTF-8') . '">';

                        echo '<p class="p-error d-none" id="error-age" data-id="age_location_' . htmlspecialchars($participant->get("rowid_product")) . '"></p>';

                    echo "</div>";

                    echo "<div class='flex container-input'>";

                        echo '<label for="nom">' . htmlspecialchars(html_entity_decode($langs->trans("label-taille")), ENT_QUOTES, 'UTF-8') . '</label>';

                        echo '<input class="taille taille-field" type="text" id="taille_location_' . htmlspecialchars($participant->get("rowid_product")) . '" name="taille[' . htmlspecialchars($participant->get("rowid_product")) . ']" value="' . (htmlspecialchars($participant->get("taille")) !== null ? htmlentities($participant->get("taille")) : '' ). '" placeholder="' . htmlspecialchars(html_entity_decode($langs->trans("label-taille")), ENT_QUOTES, 'UTF-8') . '">';
                        
                        echo '<p class="p-error d-none" id="error-taille" data-id="taille_location_' . htmlspecialchars($participant->get("rowid_product")) . '"></p>';
                        
                    echo "</div>";

            echo "</div>";
        }
        echo '<div class="flex container-btn">';
            echo '<p class="p-error d-none" id="btn-form">' .  htmlspecialchars(html_entity_decode($langs->trans("err_sumit-form"))) . '</p>';
            echo '<button type="submit">' . htmlspecialchars(html_entity_decode($langs->trans("btn-valider"))) . '</button>';
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
