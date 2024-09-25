<?php
/**
 * rôle : met en forme la page à bientot
 */

include_once __DIR__ . "/../layout/header.php";
?>

    <h2><?= $langs->trans("intitlule-abientot") ?></h2>
    <a href="/custom/cglcoll4saisons/public/index.php"><?= $langs->trans("btn-retour") ?></a>
 
<?php 
include_once __DIR__ . "/../layout/footer.php";