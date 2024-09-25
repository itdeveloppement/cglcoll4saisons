<?php
namespace App\Modeles;

use App\Services\Bdd;
use App\Modeles\Modele;
use App\Modeles\Depart;
use App\Modeles\Location;
use PDO;
use PDOException;

/**
 * Role : gestion des utilisisateur c'est à dire un tiers Dolibarr qui à contractualisé des activité BU ou LO
 * Table : en reference à la table  llx_societe de Dolibarr
 * */

class User extends Modele {

    // propriétés

    /**
     * Id du tiers
    */
    protected $rowid;
    /**
     * {string} : nom du tiers
    */
    protected $nom;
    /**
     * {datetime} : date de creation du tiers
    */
    protected $datec;
    /**
     * {string} : code unique du tiers
    */
    protected $code_client;
    /**
     * {string} : langue par defaut
    */
    protected $default_lang;
    /**
     * {array d'objet} : liste de tous les departs affichables et de ses caracteristiques pour un ou plusieurs BU d'un client
    */
    protected $liste_departs =[];
    /**
     * {array d'objet} : liste de tous les location affichables et de ses caracteristiques pour chauqe LO d'un client
    */
    protected $liste_locations =[];

        // ------------------ CONSTRUCT -----------------------------------
    /**
     * Role : intitialise automatique l'objet user et chargement des proprietes
     * Param : {integer} $rowid : id du user
     */
    function __construct($rowId){
        $this->rowid = $rowId;
        $this->loadUser();
    }
    
     // ------------------ LOADING -----------------------------------

    // loading user
        // recuperer les données de la table user : id / nom / datec / code client
        // charger les données dans les propriété
    public function loadUser() {

        $sql = "SELECT `nom`, `datec`, `code_client`, `default_lang` FROM `llx_societe` WHERE `rowid` = :id";
        $param = [ ":id" => $this->rowid];

        $bdd = Bdd::connexion();
        $req = $bdd->prepare($sql);
        try {
            $req->execute($param);
            $result = $req->fetchAll(PDO::FETCH_ASSOC);
            // Vérification des données
            if (!empty($result) && isset($result[0])) {
                    $this->nom = $result[0]['nom'];
                    $this->datec = $result[0]['datec'];
                    $this->code_client = $result[0]['code_client'];
                    $this->default_lang = $result[0]['default_lang'];
              
            } else {
                $this->nom = '';
                $this->datec = '';
                $this->code_client = '';
                $this->default_lang = '';
            }    
        } catch (PDOException $e) {
            echo "Erreur lors de la recuperation des caracteristique de l'utilisateur : " . $e->getMessage();
        }
    }
    
    // loading liste des departs
        // instentier objet depart pour recuperer la lsite des departs du user
        // charger les objets dans la proprété liste des departs
    public function listeDeparts() {
        $departObj = new Depart($this->rowid, null, null);
        $departData = $departObj->loadDeparts();

        $departList = [];
        foreach ($departData as $data) {
            $depart = new Depart($this->rowid, null, null);
            $depart->set('rowidDepart', $data['id_session']);
            $depart->set('intituleDepart', $data['intituleDepart']);
            $depart->set('dateDepart', $data['dateDepart']);
            $depart->set('lieuDepart', $data['lieuDepart']);
            $departList[] = $depart;
        }
        
        $this->liste_departs = $departList;
    }
    
    // loading loaction
        // instentier objet location pour recuperer la lsite des location du user
        // charger les objets dans la proprété liste des location
        public function listeLocations() {
            $locationObj = new Location ($this->rowid, null, null);
            $locationData = $locationObj->loadLocations();

            $locationList = [];
            foreach ($locationData as $data) {
                $location = new Location($this->rowid, null, null);
                $location->set('rowidBulDet', $data['id_product']);
                $location->set('intituleDepart', "Location de vélo");
                $location->set('dateRetrait', $data['dateRetrait']);
                $location->set('lieuRetrait', $data['lieuRetrait']);
                $locationList[] = $location;
            }
            $this->liste_locations = $locationList;
        }
}