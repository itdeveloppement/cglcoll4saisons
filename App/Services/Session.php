<?php
/**
 * rôle : organise la session
 */
namespace App\Services;

class Session {

    private $prefix = 'FORM_4_SAISONS_';

    /**
     * rôle : vérifier si la session est connectée
     * @param : no
     * @return : si la session est connectée return true, sinon false
     */
    public function isConnected() {
        return !empty($_SESSION[$this->prefix . "ID"]) ? true : false;
    }

    /**
     * rôle : charger l'id de l'utilisateur connecté dans la session
     * @param {string}: $id - id de l'utilisateur connecté
     * @return:
     */
    public function connect($id) {
        $_SESSION[$this->prefix . "ID"] = $id;
        // Générer un identifiant unique pour la session
        $sessionId = uniqid($this->prefix, true);
        // Stocker l'identifiant unique dans la session
        $_SESSION[$this->prefix . "SESSION_ID"] = $sessionId;
    }

    /**
     * rôle : retourne l'id de la session connectée
     * @param : no
     * @return : si la session est connectée retourne l'id de la session sinon retourne 0
     */
    public function getIdConnected() {
        return $this->isConnected() ? $_SESSION[$this->prefix . "ID"] : 0;
    }

    /**
     * rôle : retourne l'identifiant unique de la session
     * @param : no
     * @return : l'identifiant unique de la session
     */
    public function getSessionId() {
        return isset($_SESSION[$this->prefix . "SESSION_ID"]) ? $_SESSION[$this->prefix . "SESSION_ID"] : null;
    }

    /**
     * rôle : déconnecter la session
     * @param : no
     * @return : true si la session est déconnectée
     */
    public function deconnect() {
        $_SESSION[$this->prefix . "ID"] = 0;
        return true;
    }

    /**
     * rôle : détruire complètement la session et les cookies
     * @param : no
     * @return : void
     */
    public function destroySession() {
        // Détruire uniquement les variables de session spécifiques à votre module
        unset($_SESSION[$this->prefix . "ID"]);
        unset($_SESSION[$this->prefix . "SESSION_ID"]);
        // Supprimer le cookie de session spécifique à votre module
        setcookie($this->prefix . 'SESSION', '', time() - 3600, '/');
    }
}
?>
