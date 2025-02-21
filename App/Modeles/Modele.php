<?php
namespace App\Modeles;

class Modele {

// ------------------ GETERS  ----------------------------------
    /**
     * lire une propriété
     * param : {}string} $field nom de la proprieté
     */
    public function get($field) {
        return $this->$field;
    }

    // ------------------ SETTERS  ----------------------------------
    /**
     * role : charger une propriété
     * param : $field {string} nom de la proprieté
     * param : $value {string} valeur de la propriété
     */
    public function set($field, $value) {
        $this->$field = $value;
    }
}