<?php
/**
 * rôle : met en forme la page info enregistrées
 */

 include_once __DIR__ . "/../layout/header.php";

?>
<main class="flex message-confirmation">
    <div class="flex container-message-confirmation">
        <h2><?= htmlspecialchars(html_entity_decode($langs->trans("intitlule-infos-enregistrees"))) ?></h2>
        <a href="/custom/cglcoll4saisons/public/index.php"><?= $langs->trans("btn-retour") ?></a>
    </div>
</main>

<?php
include_once __DIR__ . "/../layout/footer.php";
?>


    