<?php
/**
 * role : organise la session
 */
namespace App\Services;

class Session {

    /** 
     * rôle : verifier si la session est connectée
     * @param : no
     * @return : si la session est connectée return true, sion false 
     */
    public function isConnected () {
        return !empty($_SESSION["id"]) ? true : false;
    }

    /** 
     * rôle : charger l'id de l'utilisateur connecté dans la session
     * @param {string}: $id - id de l'utilisateur connecté
     * @return: 
    */
    public function connect($id) {
        $_SESSION["id"] = $id;
    }

    /** 
     * role : retourne l'id de la session connecté
     * @param : no
     * @return : si la session est connectée retourne l'id de la session sinon retourne 0
     */
    public function getIdConnected() {
        return $this->isConnected() ? $_SESSION["id"] : 0;
    }

    /** 
     * role : deconnecter la session
     * @param : no
     * @return : true si la session est deconectée
     */
    public function deconnect() {
        $_SESSION["id"] = 0;
        return true;
    }
}