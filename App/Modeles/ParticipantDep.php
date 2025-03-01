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

class ParticipantDep extends Modele {

    // propriétés
    /**
    * {integer} : id du tiers
    */
    protected $rowid_societe;
    /**
     * {integer} : id de la session (depart)
    */
    protected $rowid_session;
     /**
     * {integer} : id d'un participant table bull_det'
    */
    protected $rowid_participant;
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
     * {boolean} : 0 ou 1
     * $saisie_taille = valeur du champ saisie_taille de la table llx_cfqs_c_categorieactivite (cat_act)
    */
    protected $saisie_taille;
     /**
     * {boolean} : 0 ou 1
     * $saisie_taille = valeur du champ saisie_poids de la table llx_cfqs_c_categorieactivite (cat_act)
    */
    protected $saisie_poids;
     /**
     * {boolean} : 0 ou 1
     * $saisie_taille = valeur du champ saisie_age de la table llx_cfqs_c_categorieactivite (cat_act)
    */
    protected $saisie_age;
   
   /**
     * role : initialise l'objet à l'intentiation
     */
    public function __construct ($rowid_societe, $rowidSession) {
        $this->rowid_societe = $rowid_societe;
        $this->rowid_session = $rowidSession;
    }

    /**
     * role : selectionner la liste des participants d'un depart
     * return : {array objet} : $result liste des participants
     */
    public function listeParticipantsDep() {

        $sql = "SELECT
            /* id session */
            par.rowid AS id_participant,
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
            par.agereel AS age,
            par.taille AS taille,
            par.poids AS poids,
            cat_act.saisie_age AS saisie_age,
            cat_act.saisie_taille AS saisie_taille,
            cat_act.saisie_poids AS saisie_poids
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
            ":id_session" => $this->rowid_session,
            ":id_societe" => $this->rowid_societe
        ];

        // log stocker dans dolibar_document/dolibar_req_Sql_CglColl4Saisons.log
        dol_syslog("Module form4saison - Requette sql SELECT -  Classe ParticipantDep - Methode ListeParticipantsDep : " . $sql, LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
        dol_syslog("------------------------------------------------------------------------------------------------------------------", LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
      
        try {
            $bdd = Bdd::connexion();
            $req = $bdd->prepare($sql);
            $req->execute($param);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            dol_syslog("Message : ParticipantDep.php - Erreur SQL liste des participant depart. Requette : " . $sql, LOG_ERR, 0, "_cglColl4Saisons" );
            require_once __DIR__ . "/../views/error/errtech.php";
            exit;
        }
    }

    /**
     * modifier un participant d'un depart
     */
    public function updateParticipantsDepart() {
        $sql ="UPDATE
            llx_cglinscription_bull_det AS bul
        SET
            NomPrenom = :id_prenom,
            agereel = :id_age,
            taille = :id_taille,
            poids = :id_poids
        WHERE rowid = :rowid
        ";

        $param = [
            ":id_prenom" => $this->prenom,
            ":id_age" => $this->age,
            ":id_taille" => $this->taille,
            ":id_poids" => $this->poids,
            ":rowid" => $this->rowid_participant
        ];

        // log stocker dans dolibar_document/dolibar.log
        dol_syslog("Module form4saison - Requette sql UPDATE -  Classe ParticipantDep - Methode UpdateListeParticipantsDep : " . $sql, LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
        dol_syslog("------------------------------------------------------------------------------------------------------------------", LOG_DEBUG, 0, "_req_Sql_CglColl4Saisons" );
               
        try {
            $bdd = Bdd::connexion();
            $req = $bdd->prepare($sql);
            $req->execute($param);
            return$req->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            dol_syslog("Message : ParticipantDep.php - Erreur SQL update participant depart. Requette : " . $sql, LOG_ERR, 0, "_cglColl4Saisons" );
            require_once __DIR__ . "/../views/error/errtech.php";
            exit;
        }
    }
}
