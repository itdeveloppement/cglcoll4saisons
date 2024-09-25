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
    <link rel="stylesheet" href="/custom/cglcoll4saisons/public/css/style.css">
    <meta name="description" content="Formulaire de collecte d'information pour la préparation des activités de l'agence Cigale Aventure">
    <title>Cigale Aventure</title>
    <link rel="icon" href="/favicon.ico">
</head>
<body>
<header class="flex">
    <div class="container-img">
        <img src="/custom/cglcoll4saisons/public/images/banniere.png" alt="image logo Cigale Aventure">
    </div>
    <?php 
    
    if ( $_SESSION["lang"] == "en_US") {
        $lang = "fr_FR";
        $btn = "French";
    } else if  ($_SESSION["lang"] == "fr_FR"){
        $lang = "en_US";
        $btn = "English";
    } else {
        
    }
   
    
    ?>
    <div>
        <button><a href="/custom/cglcoll4saisons/public/index.php">Accueil</a></button>
        <button><a href="/custom/cglcoll4saisons/App/controleurs/changerlangue.php?lang=<?= $lang ?>"><?= $btn ?></a></button>
        <button><a href="/custom/cglcoll4saisons/App/controleurs/afficherabientot.php">Quitter</a></button>
    </div>

</header>
