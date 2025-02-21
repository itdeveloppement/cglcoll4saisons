<?php
/**
 * role : test des requettes sql
 */

use App\Services\Bdd;

require_once __DIR__ . "/../Utils/init.php";

// --------------------- LOCATION ----------------------------------

    /**
     * liste des departs
     * param : id d'un utilisateur
     */
    function loadLocations() {
        $rowidTiers = 15007;

        $sql = "SELECT distinct
            pro.rowid AS id_product,
            bul.rowid,
            bul.ref,
            /* date de debut de la prestation de location */
            bul.dateretrait AS dateRetrait,
            /* lieu de depart la prestation de location */
            bul.lieuretrait AS lieuRetrait,

            par.NomPrenom AS prenom,
            par.agereel AS age,
            par.taille AS taille


        FROM
            llx_cglinscription_bull as bul
        LEFT JOIN
            llx_societe AS soc ON bul.fk_soc = soc.rowid
        LEFT JOIN
            llx_cglinscription_bull_det AS par ON bul.rowid = par.fk_bull
        LEFT JOIN
            llx_product AS pro ON par.fk_produit = pro.rowid
        LEFT JOIN
            llx_product_extrafields AS pro_extra ON pro.rowid = pro_extra.fk_object
        
        WHERE
            /*seulement les LO du client*/
            soc.rowid = :id_societe
            /* seulement les bulletins les BU / table bulletin -> typebull = Insc */
            AND bul.typebull = 'Loc'
            /* seulement les departs actifs (non annulés) (status = 1 dans table session ) */
            AND bul.statut <= 1
            /*seulement les activités de la location affichable (table llx_product_extrafields -> affichage == 1) */
            AND pro_extra.s_status = 1
            /* seulement les départs à partir d'aujourd'hui  (table session calendar -> dated)  supprimer et triter en php (à j+1)*/ 
            AND par.dateretrait >= CONCAT(CURDATE(), ' 00:00:00')
            /* seulement les inscriptions de type = 0 (dans table participant) */
            AND par.type = 0
            /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
            AND par.action NOT IN ('X', 'S')
        ";
        // preparation et execution requette
        $param = [":id_societe" => $rowidTiers];
        $bdd = Bdd::connexion();
        $req = $bdd->prepare($sql);
        $req->execute($param);
        try {
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
         
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la recuperation de la liste des locations : " . $e->getMessage();
        }
    }
    
    // var_dump(loadLocation());

    function listeParticipantLocProduct () {
        $rowid_product = 137;
        $sql = "SELECT 
            bul.ref,
            pro_extra.s_status,
            par.dateretrait,
            par.type,
            par.action,
            par.NomPrenom AS prenom,
            par.agereel AS age,
            par.taille AS taille
            
        FROM
            llx_cglinscription_bull_det AS par
        LEFT JOIN
             llx_cglinscription_bull AS bul ON par.fk_bull = bul.rowid
        LEFT JOIN
            llx_product AS pro ON par.fk_produit = pro.rowid
        LEFT JOIN
            llx_product_extrafields AS pro_extra ON pro.rowid = pro_extra.fk_object
        WHERE
            pro.rowid = :id_product
        /*seulement les activités de la location affichable (table llx_product_extrafields -> affichage == 1) */
        AND pro_extra.s_status = 1
        /* seulement les départs à partir d'aujourd'hui  (table session calendar -> dated)  supprimer et triter en php (à j+1)*/ 
        AND par.dateretrait >= CONCAT(CURDATE(), ' 00:00:00')
        /* seulement les inscriptions de type = 0 (dans table participant) */
        AND par.type = 0
        /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
        AND par.action NOT IN ('X', 'S')
        ";

        // preparation et execution requette
        $param = [":id_product" => $rowid_product];
        $bdd = Bdd::connexion();
        $req = $bdd->prepare($sql);
        $req->execute($param);
        try {
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la recuperation de la liste des participant d'une location : " . $e->getMessage();
        }
    }

    // var_dump(listeParticipantLocProduct());

    function listeParticipantLocBull () {
        $rowid_product = 137;
        $rowid_societe = 15007;

        $sql = "SELECT 
            bul.ref,
            pro_extra.s_status,
            par.dateretrait,
            par.type,
            par.action,
            par.NomPrenom AS prenom,
            par.agereel AS age,
            par.taille AS taille
            
        FROM
            llx_cglinscription_bull AS bul
        LEFT JOIN
            llx_societe AS soc ON bul.fk_soc = soc.rowid
        LEFT JOIN
              llx_cglinscription_bull_det AS par ON par.fk_bull = bul.rowid
        LEFT JOIN
            llx_product AS pro ON par.fk_produit = pro.rowid
        LEFT JOIN
            llx_product_extrafields AS pro_extra ON pro.rowid = pro_extra.fk_object
        WHERE
            pro.rowid = :id_product
        AND soc.rowid = :id_societe
        /*seulement les activités de la location affichable (table llx_product_extrafields -> affichage == 1) */
        AND pro_extra.s_status = 1
        /* seulement les départs à partir d'aujourd'hui  (table session calendar -> dated)  supprimer et triter en php (à j+1)*/ 
        AND par.dateretrait >= CONCAT(CURDATE(), ' 00:00:00')
        /* seulement les inscriptions de type = 0 (dans table participant) */
        AND par.type = 0
        /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
        AND par.action NOT IN ('X', 'S')
        ";

        // preparation et execution requette
        $param = [
            ":id_product" => $rowid_product,
            ":id_societe" => $rowid_societe
        ];
        $bdd = Bdd::connexion();
        $req = $bdd->prepare($sql);
        $req->execute($param);
        try {
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la recuperation de la liste des participant d'une location : " . $e->getMessage();
        }
    }

    // var_dump(listeParticipantLocBull());

    function loadLocation() {
        
       
        $sql = "SELECT
                    /* date de debut de la prestation de location */
                    bul.dateretrait AS dateRetrait,
                    /* lieu de depart la prestation de location */
                    bul.lieuretrait AS lieuRetrait
                FROM 
                    llx_cglinscription_bull_det AS par
                LEFT JOIN
                    llx_cglinscription_bull AS bul ON par.fk_bull = bul.rowid
                WHERE
                    par.rowid = :id_participant
            
            ";
        // preparation et execution requette
        $param =
        [
            ":id_participant" => 17
        ];
        try {
            $bdd = Bdd::connexion();
            $req = $bdd->prepare($sql);
            $req->execute($param);
            $result = $req->fetch(PDO::FETCH_ASSOC);
            // var_dump($result);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la recuperation de la liste des deprts : " . $e->getMessage();
        }
    }

    // loadLocation();

    function updateParticipants() {

        $prenom = "marti";
        $age = 50;
        $taille = 175;
        $rowid_product = 38662;

        $sql ="UPDATE
            llx_cglinscription_bull_det AS bul
        SET
            NomPrenom = :id_prenom,
            age = :id_age,
            taille = :id_taille
        WHERE rowid = :rowid
        ";

        $param = [
            ":id_prenom" => $prenom,
            ":id_age" => $age,
            ":id_taille" => $taille,
            ":rowid" => $rowid_product
        ];
        try {
            $bdd = Bdd::connexion();
            $req = $bdd->prepare($sql);
            $req->execute($param);
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors l'insertion d'un participant dans la base : " . $e->getMessage();
        }
    }

    // updateParticipants();

// --------------------------- DEPART -----------------------------------------
/**
 * liste des departs
 * param : id d'un utilisateur
 */
function loadDeparts() {
    $rowid = 15007;

    $sql = "SELECT distinct
                /* id de la session/depart */
                ses.rowid AS id_session,
                /* nom de la session/depart */
                CASE 
                    WHEN cat.intitule = 'AUTRES' THEN ses.intitule_custo
                    ELSE cat.intitule
                END AS intituleDepart,
                /* date de debut de la session/depart */
                cal.heured AS dateDepart,
                /* lieu de depart de la session/depart */
                pla.ref_interne AS lieuDepart

            FROM
                llx_cglinscription_bull as bul
            LEFT JOIN
                llx_societe AS soc ON bul.fk_soc = soc.rowid
            LEFT JOIN
                llx_cglinscription_bull_det AS par ON bul.rowid = par.fk_bull
            LEFT JOIN
                llx_agefodd_session AS ses ON par.fk_activite = ses.rowid
            LEFT JOIN
                llx_agefodd_place AS pla ON ses.fk_session_place = pla.rowid
            LEFT JOIN
                llx_agefodd_session_calendrier AS cal ON ses.rowid = cal.fk_agefodd_session
            LEFT JOIN
                llx_agefodd_formation_catalogue AS cat ON ses.fk_formation_catalogue = cat.rowid
            LEFT JOIN
                llx_cfqs_c_categorieactivite AS cat_act ON ses.fk_categorieactivites = cat_act.rowid
      
            WHERE
                /*seulement les BU du client*/
                soc.rowid = :id_societe
                /* seulement les bulletins les BU / table bulletin -> typebull = Insc */
                AND bul.typebull = 'Insc'
                /* seulement les BU au statut actif c a dire inferieur à la valeur 9 (table bulletin -> statut) */
                AND bul.statut < 9
                /* seulement les departs actifs (non annulés) (status = 1 dans table session ) */
                AND ses.status = 1
                /*seulement les activités du depart affichable (table categorie -> affichage == 1) */
                AND cat_act.affichage = 1
                /* seulement les départs à partir d'aujourd'hui  (table session calendar -> dated)  supprimer et triter en php (à j+1)*/ 
                AND cal.heured >= CONCAT(CURDATE(), ' 00:00:00')
                /* seulement les inscriptions de type = 0 (dans table participant) */
                AND par.type = 0
                /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
                AND par.action NOT IN ('X', 'S')
    ";
    // preparation et execution requette
    $param = [ ":id_societe" => $rowid];
    $bdd = Bdd::connexion();
    $req = $bdd->prepare($sql);
    $req->execute($param);
    try {
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo "Erreur lors de la recuperation de la liste des deprts : " . $e->getMessage();
    }
}

// var_dump(loadDeparts());


function loadListeParticipantsDep() {

    $rowid_session = 5021;
    $rowid_societe = 15007;

    $sql = "SELECT
            /* intitule du depart */
            CASE
                WHEN cat.intitule = 'AUTRES' THEN ses.intitule_custo
                ELSE cat.intitule
            END AS intituleDepart,
            /* date de debut de la session/depart */
            cal.heured AS dateDepart,
            /* lieu de depart de la session/depart */
            pla.ref_interne AS lieuDepart,
            par.NomPrenom AS prenom,
            par.age AS age,
            par.taille AS taille
        FROM
            llx_cglinscription_bull as bul
        LEFT JOIN
            llx_societe AS soc ON bul.fk_soc = soc.rowid
        LEFT JOIN
            llx_cglinscription_bull_det AS par ON bul.rowid = par.fk_bull
        LEFT JOIN
            llx_agefodd_session AS ses ON par.fk_activite = ses.rowid
        LEFT JOIN
            llx_agefodd_place AS pla ON ses.fk_session_place = pla.rowid
        LEFT JOIN
            llx_agefodd_session_calendrier AS cal ON ses.rowid = cal.fk_agefodd_session
        LEFT JOIN
            llx_agefodd_formation_catalogue AS cat ON ses.fk_formation_catalogue = cat.rowid
        LEFT JOIN
            llx_cfqs_c_categorieactivite AS cat_act ON ses.fk_categorieactivites = cat_act.rowid
        WHERE
            ses.rowid = :id_session
        AND soc.rowid = :id_societe
        
        /* seulement les inscriptions de type = 0 (dans table participant) */
        AND par.type = 0
        /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
        AND par.action NOT IN ('X', 'S')
        ";

        // preparation et execution requette
        $param = [
            ":id_session" => $rowid_session,
            ":id_societe" => $rowid_societe
        ];
        try {
            $bdd = Bdd::connexion();
            $req = $bdd->prepare($sql);
            $req->execute($param);
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la recuperation de la liste des participant d'une location : " . $e->getMessage();
        }

    }

    // var_dump(loadListeParticipantsDep());
    
    function loadDepart() {

        $rowidDepart = 5018;

        $sql = "SELECT distinct
            /* id session */
            ses.rowid AS id_session,
            /* intitule du depart */
            CASE 
                WHEN cat.intitule = 'AUTRES' THEN ses.intitule_custo
                ELSE cat.intitule
            END AS intituleDepart,
            /* date de debut de la session/depart */
            cal.heured AS dateDepart,
            /* lieu de depart de la session/depart */
            pla.ref_interne AS lieuDepart
        FROM
                llx_agefodd_session  as ses
            LEFT JOIN
                llx_agefodd_place AS pla ON ses.fk_session_place = pla.rowid
            LEFT JOIN 
                llx_agefodd_session_calendrier AS cal ON ses.rowid = cal.fk_agefodd_session
            LEFT JOIN
                llx_agefodd_formation_catalogue AS cat ON ses.fk_formation_catalogue = cat.rowid
            LEFT JOIN
                llx_cfqs_c_categorieactivite AS cat_act ON ses.fk_categorieactivites = cat_act.rowid
        WHERE
            /*seulement les BU du client*/
            ses.rowid = :id_session
            
        ";
        // preparation et execution requette
        $param = [":id_session" => $rowidDepart];
        $bdd = Bdd::connexion();
        $req = $bdd->prepare($sql);
        $req->execute($param);
        try {
            $result = $req->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la recuperation de la liste des deprts : " . $e->getMessage();
        }
    }

    var_dump (loadDepart());