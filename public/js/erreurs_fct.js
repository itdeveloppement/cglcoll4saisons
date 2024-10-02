
/**
 * role : transmettre les erreurs au back-end
 * @param {} errorMessage 
 */
export function logErrorToServer(errorMessage) {
    console.log("test");
    fetch('../logs/logErreursJs.php', {
        
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ error: errorMessage })
    })
    .then(response => response.text())
    .then(data => console.log('Erreur enregistrée côté serveur :', data))
    .catch(error => console.error('Erreur lors de l\'envoi de l\'erreur au serveur :', error));
}