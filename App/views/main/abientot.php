<?php
/**
 * rôle : met en forme la page à bientot
 */

include_once __DIR__ . "/../layout/header.php";
?>
<main class="flex message-confirmation">
    <div class="flex container-message-confirmation">
        <h2><?= htmlspecialchars(html_entity_decode($langs->trans("intitlule-abientot"), ENT_QUOTES, 'UTF-8')) ?></h2>
        <a href="/custom/cglcoll4saisons/public/index.php"><?= htmlspecialchars(html_entity_decode($langs->trans("btn-retour"), ENT_QUOTES, 'UTF-8')) ?></a>
    </div>
<main>
<?php 
include_once __DIR__ . "/../layout/footer.php";