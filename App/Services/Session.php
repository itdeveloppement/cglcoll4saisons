<?php
/**
 * role : organise la session
 */
namespace App\Services;

class Session {

    private $prefix = 'FORM_4_SAISONS_';

    /** 
     * rôle : verifier si la session est connectée
     * @param : no
     * @return : si la session est connectée return true, sion false 
     */
    public function isConnected () {
        return !empty($_SESSION[$this->prefix . "ID"]) ? true : false;
    }

    /** 
     * rôle : charger l'id de l'utilisateur connecté dans la session
     * @param {string}: $id - id de l'utilisateur connecté
     * @return: 
    */
    public function connect($id) {
        $_SESSION[$this->prefix . "ID"] = $id;
    }

    /** 
     * role : retourne l'id de la session connecté
     * @param : no
     * @return : si la session est connectée retourne l'id de la session sinon retourne 0
     */
    public function getIdConnected() {
        return $this->isConnected() ? $_SESSION[$this->prefix . "ID"] : 0;
    }

    /** 
     * role : deconnecter la session
     * @param : no
     * @return : true si la session est deconectée
     */
    public function deconnect() {
        $_SESSION[$this->prefix . "ID"] = 0;
        return true;
    }
    /**
     * role : détruire complètement la session et les cookies
     * @param : no
     * @return : void
     */
    public function destroySession() {
        // Détruire uniquement les variables de session spécifiques à votre module
        unset($_SESSION[$this->prefix . "ID"]);
        // Optionnel : détruire la session complète si nécessaire
        // session_unset();
        // session_destroy();
        // Supprimer le cookie de session spécifique à votre module
        setcookie($this->prefix . 'SESSION', '', time() - 3600, '/');
    }
}