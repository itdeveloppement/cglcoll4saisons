<?php
namespace App\Modeles;

use App\Modeles\Modele;
use App\Services\Bdd;
use PDO;
use PDOException;

/**
 * Role : gestion des locations c'est à dire LO. On concidere une location par LO
 * Table : en reference à la table llx_cglinscription_bull de Dolibarr
 * */

class Location extends Modele {
     /**
     * Id du tiers
     */
    protected $rowidTiers;
    /**
     * Id du bull det
     */
    protected $rowidBulDet;
    /**
     * Id de la prestation de location (product)
     */
    protected $rowidProduct;
    /**
     * Id du bulletin table  llx_cglinscription_bull
     */
    protected $rowidBulletin;
    /**
     * {datetime} : date de debut de la prestation de location.
     * $dateRetrait = valeur du champ dateretrait de la table llx_cglinscription_bull
     */
    protected $dateRetrait;
    /**
     * Nom de la prestaion de location
     */
    protected $intituleDepart;
    /**
     * {string} : lieu de retrait du materiel.
     * $lieuRetrait = valeur du champ lieuretrait de la table llx_agefodd_session_calendrier
     */
    protected $lieuRetrait;
    /**
     * {string} : reference de l'activité - type de materiel loué.
     * $ref = valeur du champ ref de la table llx_product
     */
    protected $ref;
    /**
     * {boolean} : 0 - non affichage grisé, 1 - affichage grisé.
     */
    protected $affichageActivite;
    /**
    * {array d'objet} : liste de tous les participants pour la location
    */
    protected $listeParticipants =[];
    
    
    // ---------------- CONSTRUCT ---------------------------
    /**
     * role : initialise l'aubjet à l'intentiation
     */
    public function __construct($rowidTiers, $rowidProduct, $rowidBulletin) {
       
        $this->rowidTiers=$rowidTiers;
        $this->rowidProduct=$rowidProduct;
        $this->rowidBulletin=$rowidBulletin;
    }

    // ----------------- SQL LISTE DES LO--------------------------
    /**
     * role :  slectionne la liste des location LO d'un tiers
     * return : {array} liste des locations
     * conditions :
        * voir dans la requette
     
     * conditions  CASE affichage de l'activité grisée ou pas:
        * Si l'heure de la date courante est âpres 16h ET si la date du départ est inférieure à j+1 minuit il faut griser
        * OU si l'heure de la date courante est avant 16h ET si la date du départ est inférieur à la date du jour minuit il faut griser
        * return : {$activité} valeur 0 si doit etre grisé sinon 1
    */
    public function loadLocations () {
        $sql = "SELECT distinct
            pro.rowid AS id_product,
            /* date de debut de la prestation de location */
            bul.dateretrait AS dateRetrait,
            /* lieu de depart la prestation de location */
            bul.lieuretrait AS lieuRetrait,
            /* refrerence de la location = type de materiel loué, avec suppression des underscores et mise en minuscule sauf le premier caractère */
            CONCAT(UPPER(SUBSTRING(REPLACE(pro.ref, '_', ''), 1, 1)), LOWER(SUBSTRING(REPLACE(pro.ref, '_', ' '), 2))) AS ref,
            /* affichage de l'activité grisée ou pas */
            CASE
                WHEN ((HOUR(NOW()) >= 16 AND CURRENT_TIMESTAMP < CAST(CONCAT(DATE_ADD(DATE(bul.dateretrait), INTERVAL -1 DAY), ' 00:00:00') AS DATETIME))
                OR (HOUR(NOW()) < 16 AND CURRENT_TIMESTAMP < CAST(CONCAT(DATE_ADD(DATE(bul.dateretrait), INTERVAL -1 DAY), ' 00:00:00') AS DATETIME)))
                THEN 1
                ELSE 0
            END AS affichageActivite
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
            /* seulement les LO au statut actif et qui ne sont pas archivés ou abandonnés (table bulletin -> statut) */
            AND bul.statut < 9
            /* seulement les LO au statut actif et qui ne sont pas brouillons (table bulletin -> statut) */
            AND bul.statut > 0
            /*seulement les activités de la location affichable (table llx_product_extrafields -> affichage == 1) */
            AND pro_extra.s_status = 1
            /* seulement les départs de aujourd'hui à partir de l'heure courante (table session calendar -> dated) */
            AND par.dateretrait >= NOW()
            /* seulement les inscriptions de type = 0 (dans table participant) */
            AND par.type = 0
            /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
            AND par.action NOT IN ('X', 'S')
        ";

        $param = [":id_societe" => $this->rowidTiers];
        // verification si $rowidBulletinn'est pas null
        if (!is_null($this->rowidBulletin)){
            $sql .=" AND bul.rowid = :id_bulletin";
            $param [":id_bulletin"] = $this->rowidBulletin;
        }
        
        $sql .= " ORDER BY bul.dateretrait DESC";
         // log stocker dans dolibar_document/dolibar_.log
        dol_syslog("Module form4saison - Requette sql SELECT -  Classe Location - Methode loadLocations : " . $sql, LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
        dol_syslog("------------------------------------------------------------------------------------------------------------------", LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
        
        // preparation et execution requette
        $bdd = Bdd::connexion();
        $req = $bdd->prepare($sql);
        $req->execute($param);
        try {
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            dol_syslog("Message : Classe Location.php - Erreur lors de la recuperation de la liste des locations. Exception : " . $e->getMessage(), LOG_ERR, 0, "_cglColl4Saisons" );
            require_once __DIR__ . "/../views/error/errtech.php";
            exit;
        }
    }

     // ----------------- SQL LISTE DES LO--------------------------
    /**
     * role :  slectionne le LO d'un tiers pour une prestation de location
     * return : {objet} LO
     * conditions :
        * voir dans la requette
    */
    public function loadLocation() {
        $sql = "SELECT distinct
            pro.rowid AS id_product, /* date de debut de la prestation de location */
            bul.dateretrait AS dateRetrait, /* lieu de depart la prestation de location */
            bul.lieuretrait AS lieuRetrait,
            /* refrerence de la location = type de materiel loué, avec suppression des underscores et mise en minuscule sauf le premier caractère */
            CONCAT(UPPER(SUBSTRING(REPLACE(pro.ref, '_', ''), 1, 1)), LOWER(SUBSTRING(REPLACE(pro.ref, '_', ' '), 2))) AS ref
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
            par.fk_produit = :id_societe
            /* seulement les bulletins les BU / table bulletin -> typebull = Insc */
            AND bul.typebull = 'Loc'
            /* seulement les LO au statut actif et qui ne sont pas archivé ou abandonné (table bulletin -> statut) */
            AND bul.statut < 9
            /* seulement les LO au statut actif et qui ne sont pas brouillon (table bulletin -> statut) */
            AND bul.statut > 0
            /*seulement les activités de la location affichable (table llx_product_extrafields -> affichage == 1) */
            AND pro_extra.s_status = 1
            /* seulement les départs de aujourd'hui  à partir de l'heure courante (table session calendar -> dated) */
            AND par.dateretrait >= NOW()
            /* seulement les inscriptions de type = 0 (dans table participant) */
            AND par.type = 0
            /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
            AND par.action NOT IN ('X', 'S')
        ";

        // log stocker dans dolibar_document/dolibarreq_Sql_CglColl4Saisons.log
        dol_syslog("Module form4saison - Requette sql SELECT -  Classe Location - Methode loadLocation : " . $sql, LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
        dol_syslog("------------------------------------------------------------------------------------------------------------------", LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
         
        // preparation et execution requette
        $param = [":id_societe" => $this->rowidProduct];
        $bdd = Bdd::connexion();
        $req = $bdd->prepare($sql);
        $req->execute($param);
        try {
            return $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            dol_syslog("Message : Classe Location.php - Erreur lors de la recuperation d'un LO. Exception : " . $e->getMessage(), LOG_ERR, 0, "_cglColl4Saisons" );
            require_once __DIR__ . "/../views/error/errtech.php";
            exit;
        }
    }
    
}