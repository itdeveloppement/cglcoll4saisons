<?php
/**
 * Role : autentification du user
 */

namespace App\Services;

use App\Modeles\User;

 class Authentification {

    /**
     * {string} : id du user
     */
    protected $rowid;
    /**
     * {string} : code unique de l'utilisateur
     */
    protected $code_client;
    /**
     *  {string} date de creation de l'utilisateur
     */
    protected $datec;

    // ------------------ CONSTRUCT -----------------------------------

    /**
     * role : charge les proprietes de l'objet autentifciation et verifie l'autentification
     * param :
     *  $rowid {string} : id de l'utilisateur dans url de connexion
     *  $code_client {string} : code unique de l'utilisateur dans url de connexion
     *  $datec {string} : date de creation de l'utilisateur dans url de connexion
     */
    function __construct($rowid, $code_client, $datec) {
        $this->rowid = $rowid;
        $this->code_client = $code_client;
        $this->datec = $datec;
    }

    // ------------------ AUTENTIFICATION -----------------------------------

    /**
     * role : verifier l'autenification de l'utilisateur
     */
    function authentification () {
        
        $user = new User($this->rowid);
        
        // date user => au format entier
        if (formatDateEntier($user->get("datec"))) {
            $dateUser = formatDateEntier($user->get("datec"));
        } else {
            $dateUser = '';
        }

        // si user connecté est vide
        if (empty($user->get("rowid")) || empty($user->get("code_client")) || empty($dateUser)){
            return false;
            
        // autentification user connecté (user == user url)
        } else if(
            $user->get("rowid") == $this->rowid &&
            $user->get("code_client") == $this->code_client &&
            $dateUser == $this->datec
        ){
            echo "true";
            return true;
         } else {
            echo "false";
            return false;
         }
    }
 }

