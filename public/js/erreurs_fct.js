
/**
 * role : transmettre les erreurs au back-end
 * @param {} errorMessage 
 */
export function logErrorToServer(errorMessage) {
    fetch('../logs/logErreursJs.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ error: errorMessage })
    })
}

/**
 * role : afficher les eereur en console / ecran
 */

export function afficherErreursEcran(message) {
    let consoleDiv = document.getElementById('console');
    if (consoleDiv !== null) {
    consoleDiv.innerHTML += message + '<br>';
}
}

