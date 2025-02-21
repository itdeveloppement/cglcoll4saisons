<?php
namespace App\Modeles;

use App\Modeles\Modele;
use App\Services\Bdd;
use PDO;
use PDOException;

/**
 * Role : gestion des departs c'est à dire des sessions d'un BU. Un BU peut avoir plusieurs departs(sessions)
 * Table : en reference à la table llx_agefodd_session de Dolibarr
 * */

class Depart extends Modele {
 /**
     * Id du tiers
     */
    protected $rowidTiers;
    /*
    * Id du depart
    */
    protected $rowidDepart;
    /*
    * Id du bulletin
    */
    protected $rowidBulletin;
    /**
     * {string} : nom de la session (depart). Condition :
     * si valeur du champ intitule de la table llx_agefodd_formation_catalogue == AUTRES
     * alors $intituleDepart = valeur du champ intitule_custo de la table llx_agefodd_session
     * sinon $intituleDepart = valeur du champ intitule de la table llx_agefodd_formation_catalogue
     */
    protected $intituleDepart;
    /**
     * {datetime} : date de debut de la session (depart).
     * $dateDepart = valeur du champ heured de la table llx_agefodd_session_calendrier
     */
    protected $dateDepart;
    /**
     * {string} : lieu de le la session (depart)
     *  $lieuDepart = valeur du champ ref_interne de la table llx_agefodd_place
     */
    protected $lieuDepart;
    /**
     * {array d'objet} : liste de tous les departs affichables et de ses caracteristiques pour un ou plusieurs BU d'un client
    */
    protected $listeParticipants;
     /**
     * {boolean} : 0 - non affichage grisé, 1 - affichage grisé.
     */
    protected $affichageActivite;
    /**
     * {array d'objet} : liste de tous les participants pour la session (depart)
    */

    /**
     * role : initialise l'aubjet à l'intentiation
     */
    public function __construct($rowidTiers, $id_session, $rowidBulletin) {
        $this->rowidTiers=$rowidTiers;
        $this->rowidDepart = $id_session;
        $this->rowidBulletin = $rowidBulletin;
    }

    /*
     * role : slectionne la liste des departs des BU d'un tiers
     * return : {array} liste des daparts
     * conditions :
        * table bulletin
            * - seulement les BU du client :
            * - seulement les bulletins detype Insc/ table bulletin -> typebull = Insc :
            * - seulement les BU au statut actif c a dire inferieur à la valeur 9 (table bulletin -> statut) :
        * table session
            * - seulement les departs actifs (non annulés) (status = 1 dans table session )
        * table categorie
            * - seulement les activités du depart affichable (table categorie -> affichage)
        * table session calendar
            * - seulement les départs de aujourd'hui à j+1 (table session calendar -> dated)
        * table participant
            * - seulement les inscriptions de type = 0 (dans table participant)
            * - seulement les inscriptions dont le champ action est different de X et different de S (table particpant)
            
        * {string} : nom de la session (depart). Condition :
            * si valeur du champ intitule de la table llx_agefodd_formation_catalogue == AUTRES
            * alors $intituleDepart = valeur du champ intitule_custo de la table llx_agefodd_session
            * sinon $intituleDepart = valeur du champ intitule de la table llx_agefodd_formation_catalogue
     
        * conditions  CASE affichage de l'activité grisée ou pas:
            * Si l'heure de la date courante est âpres 16h ET si la date du départ est inférieure à j+1 minuit il faut griser
            * OU si l'heure de la date courante est avant 16h ET si la date du départ est inférieur à la date du jour minuit il faut griser
            * return : {$activité} valeur 0 si doit etre grisé sinon 1
     */
    public function loadDeparts () {
        global $conf;
      
        $intitule = $conf->global->CGL_ACTIVITE_INDETERMINE;

        $sql = "SELECT distinct
                    /* id de la session/depart */
                    ses.rowid AS id_session,
                    /* nom de la session/depart */
                    CASE
                        WHEN cat.rowid = :intitule THEN ses.intitule_custo
                        ELSE cat.intitule
                    END AS intituleDepart,
                    /* date de debut de la session/depart */
                    cal.heured AS dateDepart,
                    /* lieu de depart de la session/depart */
                    pla.ref_interne AS lieuDepart,
                    /* affichage de l'activité grisée ou pas */
                    CASE
                        WHEN (HOUR(NOW()) >= 16 AND cal.heured < DATE_ADD(CURDATE(), INTERVAL 1 DAY))
                             OR (HOUR(NOW()) < 16 AND cal.heured < CURDATE())
                        THEN 0
                        ELSE 1
                    END AS affichageActivite
                FROM
                    llx_cglinscription_bull AS bul
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
                    /* seulement les BU du client */
                    soc.rowid = :id_societe
                    /* seulement les bulletins les BU / table bulletin -> typebull = 'Insc' */
                    AND bul.typebull = 'Insc'
                    /* seulement les BU au statut actif, c'est-à-dire inférieur à 9 (table bulletin -> statut) */
                    AND bul.statut < 9
                    /* seulement les départs actifs (non annulés) (status = 1 dans table session ) */
                    AND ses.status = 1
                    /* seulement les activités du départ affichable (table catégorie -> affichage == 1) */
                    AND cat_act.affichage = 1
                    /* seulement les départs à partir de hier, c'est-à-dire J-1 d'aujourd'hui (table session calendar -> dated) */
                    AND cal.heured >= DATE_ADD(CURDATE(), INTERVAL -1 DAY)
                    /* seulement les inscriptions de type = 0 (dans table participant) */
                    AND par.type = 0
                    /* seulement les inscriptions dont le champ action est différent de X et S (table participant) */
                    AND par.action NOT IN ('X', 'S')
        ";

        $param = [ ":id_societe" => $this->rowidTiers, ":intitule" => $intitule]; // Ajout de ":intitule" comme paramètre pour sécuriser la requête

        // Vérification si $rowidBulletin n'est pas null
        if (!is_null($this->rowidBulletin)) {
            $sql .= " AND bul.rowid = :id_bulletin";
            $param[":id_bulletin"] = $this->rowidBulletin;
        }

        // Préparation et exécution de la requête
        $bdd = Bdd::connexion();
        $req = $bdd->prepare($sql);
        $req->execute($param);

        try {
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            dol_syslog("Message : Classe Depart.php - Erreur lors de la recuperation de la liste des departs. Exception : " . $e->getMessage(), LOG_ERR, 0, "_cglColl4Saisons" );  
            require_once __DIR__ . "/../views/error/errtech.php";
            exit;
        }
    }

    // ----------------- SQL LISTE DES SESSION--------------------------
    /**
     * role :  slectionner le detail d'un depart
     * return : {objet} Depart / session
    */
    public function loadDepart() {

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
        $param = [":id_session" => $this->rowidDepart];
        $bdd = Bdd::connexion();
        $req = $bdd->prepare($sql);
        $req->execute($param);
        try {
            $result = $req->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            dol_syslog("Message : Classe Depart.php - Erreur lors de la recuperation dd'un departs. Exception : " . $e->getMessage(), LOG_ERR, 0, "_cglColl4Saisons" );
            require_once __DIR__ . "/../views/error/errtech.php";
            exit;
        }
    }

    }
