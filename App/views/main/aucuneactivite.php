<?php
/**
 * Template : met en forme la page aucune activite
 */
//Template de page : header
include __DIR__ . "/../layout/header.php";
?>
    <main class="flex message-conf-err">
        <div class="flex message-conf-text">
            <h2><?= htmlspecialchars(html_entity_decode($langs->trans("aucunes-activites")), ENT_QUOTES, 'UTF-8') ?></h2>
        </div>
    </main>
<?php
// Template de page : footer
include __DIR__ . "/../layout/footer.php";

