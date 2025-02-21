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
        * seulement les bulletins de type LO ( typebull = Loc  dans table bulletin)
        * seulement les LO avec un statut actif c a dire inferieur ou égale à 1 (table bulletin)
        * seulement le materiel loué de aujourd'hui à j+1 (dateretrait table bull_det)
        * seulement le materiel loué de type = 0 (type dans bull_det)
        * seulement le materiel loué dont le champ action est different de X et different de S (action - bull det)
        * seulement le materiel loué affichable c a dire necessitant un champ taille et age (s_status = valeur 1 dans llx_product_extrafields)
     
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
                WHEN (HOUR(NOW()) >= 16 AND bul.dateretrait < DATE_ADD(CURDATE(), INTERVAL 1 DAY))
                OR (HOUR(NOW()) < 16 AND bul.dateretrait < CURDATE())
                THEN 0
                ELSE 1
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
            /* seulement les departs actifs (non annulés) (status = 1 dans table session ) */
            AND bul.statut <= 1
            /*seulement les activités de la location affichable (table llx_product_extrafields -> affichage == 1) */
            AND pro_extra.s_status = 1
            /* seulement les départs à partir de hier c'est a dire j-1 d'aujourd'hui)  (table session calendar -> dated)*/
            AND par.dateretrait >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)
            /* seulement les inscriptions de type = 0 (dans table participant) */
            AND par.type = 0
            /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
            AND par.action NOT IN ('X', 'S')
        ORDER BY bul.dateretrait ASC";

        $param = [":id_societe" => $this->rowidTiers];
        // verification si $rowidBulletinn'est pas null
        if (!is_null($this->rowidBulletin)){
            $sql .=" AND bul.rowid = :id_bulletin";
            $param [":id_bulletin"] = $this->rowidBulletin;
        }
        
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
        * seulement les bulletins de type LO ( typebull = Loc  dans table bulletin)
        * seulement les LO avec un statut actif c a dire inferieur ou égale à 1 (table bulletin)
        * seulement le materiel loué  de aujourd'hui à j+1 (dateretrait table bull_det)
        * seulement le materiel loué de type = 0 (type dans bull_det)
        * seulement le materiel loué dont le champ action est different de X et different de S (action - bull det)
        * seulement le materiel loué affichable c a dire necessitant un champ taille et age (s_status = valeur 1 dans llx_product_extrafields)
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
            /* seulement les departs actifs (non annulés) (status = 1 dans table session ) */
            AND bul.statut <= 1
            /*seulement les activités de la location affichable (table llx_product_extrafields -> affichage == 1) */
            AND pro_extra.s_status = 1
           /* seulement les départs à partir de hier c'est a dire j-1 d'aujourd'hui)  (table session calendar -> dated)*/
            AND par.dateretrait >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)
            /* seulement les inscriptions de type = 0 (dans table participant) */
            AND par.type = 0
            /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
            AND par.action NOT IN ('X', 'S')
        ";
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