1. Créer un conteneur pour la "console"

On va créer un élément <div> dans la page HTML qui servira à afficher des messages de débogage.

html

<div id="console"></div>

Cet élément est juste un bloc vide pour l'instant, mais il sera utilisé pour afficher du texte, comme les messages que tu envoies habituellement à la console.
2. Styliser le conteneur (optionnel)

Tu peux ajouter un peu de style pour que cette "console" ressemble à un véritable log de messages.

html

<style>
    #console {
        border: 1px solid #ccc; /* Une bordure grise */
        padding: 10px;          /* Espacement intérieur */
        height: 150px;          /* Hauteur de la console */
        overflow-y: scroll;     /* Permet de défiler si le contenu dépasse */
        font-family: monospace; /* Police d'écriture de type console */
        background-color: #f0f0f0; /* Fond gris clair */
    }
</style>

3. Ajouter une fonction JavaScript pour envoyer des messages à la "console"

Ensuite, on va créer une fonction JavaScript qui ajoutera du texte dans ce conteneur <div>. Cette fonction remplacera les appels à console.log() et affichera les messages à l'intérieur du div.

javascript

<script>
    function logToConsole(message) {
        var consoleDiv = document.getElementById('console');
        consoleDiv.innerHTML += message + '<br>';  // Ajoute le message dans le div "console"
    }

    // Exemple d'utilisation
    logToConsole("Bienvenue à la console sur mobile !");
</script>

Cette fonction récupère l'élément <div id="console"> et y ajoute des messages. Par exemple, au lieu d'utiliser console.log("Message"), tu appelles logToConsole("Message") pour afficher ce message dans la page.
4. Tester avec un exemple complet

Voici un exemple complet d'une page HTML avec cette console visible, prête à être utilisée sur mobile.

html

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Console</title>
    <style>
        #console {
            border: 1px solid #ccc;
            padding: 10px;
            height: 150px;
            overflow-y: scroll;
            font-family: monospace;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <!-- debug -->
    <h1>Test de la Console</h1>
    <div id="console"></div>

    <script>
        function logToConsole(message) {
            var consoleDiv = document.getElementById('console');
            consoleDiv.innerHTML += message + '<br>';
        }

        // Exemple d'utilisation de la "console" visible
        logToConsole("Bienvenue à la console sur mobile !");
        logToConsole("Ceci est un message de test.");

        // On peut également ajouter des messages conditionnels
        if (5 > 2) {
            logToConsole("Condition 5 > 2 est vraie.");
        } else {
            logToConsole("Condition 5 > 2 est fausse.");
        }
    </script>
</body>
</html>

5. Comment ça marche

    Console visible : Le <div> avec id="console" devient une sorte de zone de texte où tu vois les messages en temps réel.
    logToConsole() : Cette fonction est utilisée pour ajouter des messages dans ce div. C'est comme utiliser console.log(), mais au lieu d'afficher dans la console des développeurs, les messages s'affichent directement dans la page web.

Avantages :

    Pas besoin d'outils de développement : Tu peux voir les messages ou les erreurs directement dans la page sur mobile.
    Facile à tester sur mobile : Charge simplement cette page dans ton navigateur mobile pour voir les messages apparaître.

Quand l'utiliser :

    Débogage mobile : Lorsque tu n'as pas accès à la console des outils de développement sur mobile, cette méthode te permet de suivre ce qui se passe en affichant les messages directement sur la page web.

Si tu as besoin d'aide pour intégrer cette solution dans ton projet ou pour un cas particulier, n'hésite pas à me donner plus de détails !