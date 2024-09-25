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
    protected static $dsn = 'mysql:host=localhost;dbname=dbetxgjwagullv;charset=UTF8';
    protected static $userName = 'cigaleav_dolites';
    protected static $password  = 'CglAvt30120';
    protected static $options = [PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING];
    protected static $bdd = null;

    /** 
     * Role : connecter la base de donnée
     * @param {string} : $userName - nom d'utilisateur
     * @param {string} : $password -  password de connexion à la base
     * @param {string} : $dns - chaine de connexion selon le type de base de données
     * @param {array} : $option - tableau associatif pour gerer notamant les erreurs et exception
     * @return : l'objet de connexion ou l'erreur d'exception 
     */
    public static function connexion() {
        try 
        { 
        self::$bdd = new PDO (self::$dsn, self::$userName, self::$password, self::$options); 
        self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return  self::$bdd;
        }
        catch (PDOException $exception ) {
        // include "app/controleurs/index.php"
        echo "Erreur de connexion à la BDD : " . $exception->getMessage() . "Code message : " . $exception->getCode();;
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
