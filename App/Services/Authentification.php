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
     *  $rowid {string} : id de l'utilisateur
     *  $code_client {string} : code unique de l'utilisateur
     *  $datec {string} : date de creation de l'utilisateur
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
        // si user connecté est vide
        if (empty($user->get("rowid")) || empty($user->get("code_client")) || empty($user->get("datec"))){
            return false;
        // autentification user connecté
        } else if(
            $user->get("rowid") == $this->rowid &&
            $user->get("code_client") == $this->code_client &&
            $user->get("datec") == $this->datec
        ){
            return true;
         } else {
            return false;
         }      
    }
 }

