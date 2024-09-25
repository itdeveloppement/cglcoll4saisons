<?php

/**
 * role : charge une lague autre que celle par defaut
 * @param : $db objet base de données de Dolibarr
 * @param : $conf instense de la class Conf qui contien plusieurs parametrage de configuration de Dolibarr
 * @param : $lang : la langue à charger ex en_Us ou en_FR
 */
function changeLang ($db, $conf,  $lang) { 
    if (!empty($lang)) { 
        $newLang =$lang;
        dolibarr_set_const($db, "MAIN_LANG_DEFAULT", $newLang, 'chaine', 0, '', $conf->entity);
    }
}