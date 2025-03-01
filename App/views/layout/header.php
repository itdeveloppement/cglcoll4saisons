<?php
/*
* Template de page : balise <!DOCTYPE html> et header
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/custom/cglcoll4saisons/public/css/main.css">
    <meta name="description" content="Formulaire de collecte d'information pour la préparation des activités de l'agence Cigale Aventure">
    <title>Cigale Aventure</title>
    <link rel="icon" href="/favicon.ico">
</head>
<body>
    <div class="container container-validation">
        <header class="header flex">
            <div class="container-img">
                <img src="/custom/cglcoll4saisons/public/images/banniere.png" alt="image logo Cigale Aventure">
            </div>
            
            <?php
            // contenu du bouton langue et parametre $lang url
            
            if ( $_SESSION["lang"] == "en_US") {
                $lang = "fr_FR";
                $btn = "Français";
            } else {
                $lang = "en_US";
                $btn = "English";
            }
        
            ?>
            <div class="flex btn-container">
            <?php
            if (isset($langs) && is_object($langs)) {
                if ($langs->trans("btn-accueil")!= null) {
                    echo '<a href="/custom/cglcoll4saisons/public/index.php">' . htmlspecialchars(html_entity_decode($langs->trans("btn-accueil")), ENT_QUOTES, 'UTF-8') . '</a>';
                } else {
                    echo '';
                }
                if ($langs->trans("btn-accueil")!= null) {
                    echo '<a href="/custom/cglcoll4saisons/App/controleurs/changerlangue.php?lang=' . $lang . '">' . $btn . '</a>';
                } else {
                    echo '';
                }
            
                if ($langs->trans("btn-accueil")!= null) {
                    echo '<a href="/custom/cglcoll4saisons/App/controleurs/afficherabientot.php">' . htmlspecialchars(htmlspecialchars($langs->trans("btn-quitter")), ENT_QUOTES, 'UTF-8') . '</a>';
                } else {
                    echo '';
                }
            }
            ?>
            </div>
        </header>
