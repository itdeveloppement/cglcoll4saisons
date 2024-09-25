Pour afficher une page dans une langue différente dans Dolibarr sans modifier la langue par défaut dans la base de données (sans changer la configuration utilisateur ou les paramètres globaux), vous pouvez utiliser des méthodes spécifiques pour changer temporairement la langue au niveau de la session ou directement dans le code.
1. Changer la langue via l'URL

Dolibarr permet de modifier la langue en utilisant un paramètre dans l'URL. Vous pouvez ajouter le paramètre lang pour charger la page dans une langue spécifique, par exemple :

bash

https://votre-dolibarr.com/htdocs/index.php?lang=en_US

    Remplacez en_US par le code de langue désiré (par exemple, fr_FR pour le français, de_DE pour l'allemand, etc.).

2. Changer la langue par la session PHP

Vous pouvez forcer le changement de langue dans une page spécifique en modifiant la variable de session $_SESSION["dol_default_lang"] dans Dolibarr. Cela n’affectera que la session courante et ne modifiera pas les paramètres globaux ou de la base de données.
Exemple :

Ajoutez ce code dans votre page avant toute sortie HTML, par exemple dans un contrôleur ou un fichier inclus :

php

// Charger la langue française temporairement
$_SESSION["dol_default_lang"] = 'fr_FR';

// Ou bien pour l'anglais
$_SESSION["dol_default_lang"] = 'en_US';

// Rafraîchir les traductions en fonction de la langue choisie
$langs->loadLangs(array("main", "other_language_files"));

3. Utilisation d’un switch pour les langues

Si vous souhaitez permettre à l’utilisateur de changer la langue via une interface (par exemple, un menu déroulant), vous pouvez capturer le changement via un formulaire et modifier la langue dans la session.
Exemple de code pour un sélecteur de langue :

php

if (isset($_POST['lang'])) {
    $lang = $_POST['lang'];
    $_SESSION["dol_default_lang"] = $lang;
    $langs->setDefaultLang($lang);
    $langs->loadLangs(array("main", "other_language_files"));
}

Dans votre HTML, vous pouvez ajouter un formulaire simple pour changer de langue :

html

<form method="post" action="">
    <select name="lang" onchange="this.form.submit()">
        <option value="fr_FR">Français</option>
        <option value="en_US">English</option>
        <option value="de_DE">Deutsch</option>
    </select>
</form>

4. Charger une langue en fonction du contexte

Si vous souhaitez changer la langue automatiquement en fonction du contexte (par exemple, en fonction du pays de l'utilisateur), vous pouvez utiliser une logique pour définir $_SESSION["dol_default_lang"] en fonction de conditions spécifiques (comme une variable GET, une session utilisateur, ou l'adresse IP).

5. Utilisation des fichiers de langue

Si vous avez des fichiers de langue personnalisés dans Dolibarr, assurez-vous de bien charger les fichiers de langue dans votre code pour que les chaînes spécifiques soient traduites dans la langue choisie.

php

$langs->load("mycustomfile"); // Charger les traductions pour un fichier personnalisé

Conclusion

La méthode la plus simple est d’utiliser le paramètre lang dans l’URL ou de modifier la variable de session $_SESSION["dol_default_lang"]. Cela vous permet de changer la langue pour une page spécifique sans affecter les paramètres globaux dans la base de données ni changer la configuration utilisateur.