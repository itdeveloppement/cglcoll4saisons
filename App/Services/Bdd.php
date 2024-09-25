<?php
/**
 * role : se connecter à la base de données
 * 
 */

namespace App\Services;

use PDO;
use PDOException;

class Bdd {


    // attributs
    protected static $dsn;
    protected static $userName;
    protected static $password;
    protected static $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING];
    protected static $bdd = null;


    // ---------- setter et getter --------------------------
    public static function setUserName($name) {
        self::$userName = $name;
    }
    public static function setPassword($password) {
        self::$password = $password;
    }
    public static function setDsn($dsn) {
        self::$dsn = $dsn;
    }

   


    /** 
     * Role : connecter la base de donnée
     * @param {string} : $userName - nom d'utilisateur
     * @param {string} : $password -  password de connexion à la base
     * @param {string} : $dns - chaine de connexion selon le type de base de données
     * @param {array} : $option - tableau associatif pour gerer notamant les erreurs et exception
     * @return : l'objet de connexion ou l'erreur d'exception 
     */
    public static function connexion() {
        // var_dump(self::$userName);
        // var_dump( self::$password);
        
        try 
        { 
        self::$bdd = new PDO (self::$dsn, self::$userName, self::$password, self::$options); 
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return  self::$bdd;
        }
        catch (PDOException $exception ) {
            dol_syslog("Message : Class Bdd.php - Erreur SQL select user Erreur de connexion à la BDD : " . $exception->getMessage() . " Code message : " . $exception->getCode(), LOG_ERR, 0, "_cglColl4Saisons");
            require_once __DIR__ . "/../views/error/errtech.php";
            exit;
        }
    }

    /**
     *  role : deconnecter la connexion a la base de donnees
     * @param : neant
     * @return : no
     */
    public static function deconnexion() {
        self::$bdd = null;
    }
}
