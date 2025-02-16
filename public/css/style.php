<?php
// Définir les en-têtes pour désactiver la mise en cache
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
header("Pragma: no-cache");

// Envoyer les en-têtes CSS
header("Content-Type: text/css; charset=UTF-8");

// Ajouter un timestamp unique pour éviter la mise en cache
$timestamp = time();

// Ajouter tous les imports CSS avec le timestamp dynamique
echo "@import url('/custom/cglcoll4saisons/public/css/reset.css?v={$timestamp}');\n";
echo "@import url('/custom/cglcoll4saisons/public/css/typo.css?v={$timestamp}');\n";
echo "@import url('/custom/cglcoll4saisons/public/css/root.css?v={$timestamp}');\n";
echo "@import url('/custom/cglcoll4saisons/public/css/titles.css?v={$timestamp}');\n";
echo "@import url('/custom/cglcoll4saisons/public/css/buttons.css?v={$timestamp}');\n";
echo "@import url('/custom/cglcoll4saisons/public/css/header.css?v={$timestamp}');\n";
echo "@import url('/custom/cglcoll4saisons/public/css/footer.css?v={$timestamp}');\n";
echo "@import url('/custom/cglcoll4saisons/public/css/messages_erreur.css?v={$timestamp}');\n";
echo "@import url('/custom/cglcoll4saisons/public/css/img.css?v={$timestamp}');\n";
echo "@import url('/custom/cglcoll4saisons/public/css/input.css?v={$timestamp}');\n";

// Ajouter le CSS propre à `main.css` après les imports
echo "
/* console écran pour debug smartphone */
#console {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    border: 1px solid #ccc;
    padding: 10px;
    height: 150px;
    overflow-y: scroll;
    font-family: monospace;
    background-color: rgba(240, 240, 240, 0.5);
}

/* structure des pages */
body {
    font-family: var(--fonte);
    font-size: 14px;
    background-color: var(--quatriemeColor);
}
.flex {
    display: flex;
    flex-wrap: wrap;
}

.container {
    max-width: 600px;
    margin: auto;
    background-color: var(--cinquiemeColor);
}

/* liste des départs */
.liste-depart {
    padding: 0 20px;
}
.card-liste-depart {
    border-radius: var(--borderRadius);
    border: 1px solid var(--quatriemeColor);
    margin-bottom: 10px;
    padding: 10px;
    line-height: 1.5;
}

/* détail départ et détail location */
.detail-depart, .detail-location {
    padding: 0 20px;
}
.activite {
    flex-direction: column;
    line-height: 1.5;
}
.activite p {
    padding-left: 10px;
}
.activite .date, .activite .lieu {
    font-weight: 300;
}

/* à bientôt / infos enregistrées */
.message-confirmation {
    height: 70vh;
    flex-direction: column;
    align-items: center;
}
.message-confirmation .container-message-confirmation {
    position: fixed;
    top: 250px;
    max-width: 400px;
    justify-content: center;
}
.message-confirmation footer {
    position: fixed;
    bottom: 0px;
    left: 50%;
    transform: translateX(-50%);
    max-width: 600px;
}

/* errtech / errdroit */
.message-conf-err {
    flex-direction: column; 
    align-items: center; 
    justify-content: center;
}

.message-conf-text {
    margin: 100px 0;
    max-width: 400px;
    justify-content: center;
}
";
?>
