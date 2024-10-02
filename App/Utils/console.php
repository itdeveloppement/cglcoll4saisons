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


