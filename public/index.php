<?php
use App\Services\Authentification;
use App\Services\Session;

    require_once __DIR__ . "/../App/Utils/init.php";

    // require_once __DIR__ . "/../App/Utils/email.php";
   
    ?>

    <?php

        // var_dump($_SESSION["lang"]);
    $lang = $_SESSION["lang"];
    changeLang ($db, $conf,  $lang);
   
    $session = new Session();
    // session connectée
    if ($session->isConnected()) {

        $listeDeparts = afficherListeDeparts($session->getIdConnected());
        $listeLocations = afficherListeLocations($session->getIdConnected());

        // si liste des activites vide ou pleine
        if (empty($listeLocations) && empty($listeDeparts)) {
            require_once __DIR__ . "/../App/views/main/aucuneactivite.php";
            exit;
        } else {
            require_once __DIR__ . "/../App/views/main/listedeparts.php";
            exit;
        }
        
    // session non connectée
    } else {
        // recuperation des donnes de l'url et verification format et type
        if(empty($_GET["client"]) ||  !filter_var($_GET["client"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])  || empty ($_GET["code"]) || !filter_var($_GET["date"], FILTER_VALIDATE_INT)) {
            dol_syslog("Message : index.php - Parametre url GET non valide  - Url : " . $_SERVER['REQUEST_URI'], LOG_ERR, 0, "_cglColl4Saisons" );
            require_once __DIR__ . "/../App/views/error/errdroit.php";
            exit;
        };
        // chargement des données
        $rowid = (int)$_GET["client"];
        $code_client = htmlspecialchars($_GET["code"], ENT_QUOTES, 'UTF-8');
        $datec = htmlspecialchars($_GET["date"], ENT_QUOTES, 'UTF-8');

        // authentification
        $auth = new Authentification($rowid, $code_client, $datec);
        
        if ($auth->authentification()) {
            // connexion session
            $session->connect($rowid);
            // chargement liste depart et location
            $listeDeparts = afficherListeDeparts($session->getIdConnected());
            $listeLocations = afficherListeLocations($session->getIdConnected());
       
            // si liste des activites vide ou pleine
            if (empty($listeLocations) && empty($listeDeparts)) {
                require_once __DIR__ . "/../App/views/main/aucuneactivite.php";
                exit;
            } else {
                require_once __DIR__ . "/../App/views/main/listedeparts.php";
                exit;
            }

        } else {
            dol_syslog("Message : index.php - Échec de l'authentification pour client ID: $rowid", LOG_ERR, 0, "_cglColl4Saisons");
            require_once __DIR__ . "/../App/views/error/errdroit.php";
            exit;
        }
    }


