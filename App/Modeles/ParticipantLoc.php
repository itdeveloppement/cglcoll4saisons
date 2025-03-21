<?php
/**
 * Role : gestion des participant à une acitivté (session / depart) ou à une location
 * Table : en reference à la table  llx_cglinscription_bull_det de Dolibarr
 * */
namespace App\Modeles;

use App\Modeles\Modele;
use App\Services\Bdd;
use PDO;
use PDOException;

class ParticipantLoc extends Modele {

    // propriétés
    /**
    * {integer} : id de la prestation de location (table bull det)
    */
    protected $rowid_product;
    /**
     * {integer} : id du client
    */
    protected $rowid_societe;
    /**
     * {string} : prenom du participant
     * $prenom = valeur du champ NomPrenom de la table llx_cglinscription_bull_det
    */
    protected $prenom;
     /**
     * {string} : age du participant
     * $prenom = valeur du champ agereel de la table llx_cglinscription_bull_det
    */
    protected $age;
     /**
     * {integer} : poids du participant
     * $prenom = valeur du champ poids de la table llx_cglinscription_bull_det
    */
    protected $poids;
     /**
     * {integer} : taille du participant
     * $prenom = valeur du champ taille de la table llx_cglinscription_bull_det
    */
    protected $taille;
    /**
     * {string} : label de la location
     *
    */
    protected $label;
   
    /**
     * role : initialise l'aubjet à l'intentiation
     */
    public function __construct ($rowid_societe, $rowidBulDet) {
        $this->rowid_societe = $rowid_societe;
        $this->rowid_product = $rowidBulDet;
    }
  
    /**
     * role : selectionner la liste des participants d'une prestation de location de velo
     * return : {array objet} : $result liste des participants
     */
    public function listeParticipantsLoc() {

        $sql = "SELECT
            /* date de debut de la prestation de location */
            bul.dateretrait AS dateRetrait,
            /* lieu de depart la prestation de location */
            bul.lieuretrait AS lieuRetrait,
            par.rowid AS rowidBulDet,
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
        /* seulement les départs de aujourd'hui  à partir de l'heure courante (table session calendar -> dated) */
        AND par.dateretrait >= NOW()
        /* seulement les inscriptions de type = 0 (dans table participant) */
        AND par.type = 0
        /* seulement les inscriptions dont le champ action est different de X et different de S (table particpant) */
        AND par.action NOT IN ('X', 'S')
        ";

        // preparation et execution requette
        $param = [
            ":id_product" => $this->rowid_product,
            ":id_societe" => $this->rowid_societe
        ];

        // log stocker dans dolibar_document/dolibar.log
        dol_syslog("Module form4saison - Requette sql SELECT -  Classe ParticipantLoc - Methode listeParticipantsLoc : " . $sql, LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons");
        dol_syslog("------------------------------------------------------------------------------------------------------------------", LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
        
        try {
            $bdd = Bdd::connexion();
            $req = $bdd->prepare($sql);
            $req->execute($param);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            dol_syslog("Message : ParticipantLoc.php - Erreur SQL liste des participant loacation. Requette : " . $sql, LOG_ERR, 0, "_cglColl4Saisons" );
            require_once __DIR__ . "/../views/error/errtech.php";
            exit;
        }
    }

    /**
     * modifier un participant
     */
    public function updateParticipants() {
        $sql ="UPDATE
            llx_cglinscription_bull_det AS bul
        SET
            NomPrenom = :id_prenom,
            agereel = :id_age,
            taille = :id_taille
        WHERE rowid = :rowid
        ";

        $param = [
            ":id_prenom" => $this->prenom,
            ":id_age" => $this->age,
            ":id_taille" => $this->taille,
            ":rowid" => $this->rowid_product
        ];

        // log stocker dans dolibar_document/dolibar.log
        dol_syslog("Module form4saison - Requette sql UPDATE -  Classe ParticipantLoc - Methode updateParticipants : " . $sql, LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons");
        dol_syslog("------------------------------------------------------------------------------------------------------------------", LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
        
        try {
            $bdd = Bdd::connexion();
            $req = $bdd->prepare($sql);
            $req->execute($param);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            dol_syslog("Message : ParticipantLoc.php - Erreur SQL liste des participant location. Requette : " . $sql, LOG_ERR, 0, "_cglColl4Saisons" );
            require_once __DIR__ . "/../views/error/errtech.php";
            exit;
        }
    }
}
