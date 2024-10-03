
import {testPrenom, testAge, testTaille, testPoids } from './valider_champs_fct.js';
import {logErrorToServer, afficherErreursEcran } from './erreurs_fct.js';
// ----- FORMULAIRE PARTICIPANT ------------------

document.addEventListener("DOMContentLoaded", function() {
   
    // debug ---------------------------------------------------------
    // afficherErreursEcran("Entrée dans la page");
    // logErrorToServer("test log entrée de la page");
 
    // formulaire LO
    let formLocation = document.getElementById("participantFormLocation");

    if (formLocation) {
        // ajouter des écouteurs d'événements
        const ajouterEcouteurs = (input) => {
            input.addEventListener("input", () => {
                switch (input.classList[0]) {
                    case "prenom":
                        testPrenom(input.value, input.id);
                        break;
                    case "age":
                        testAge(input.value, input.id);
                        break;
                    case "taille":
                        testTaille(input.value, input.id);
                        break;
                }
            });
        };

        // Sélectionnez tous les champs d'entrée et ajoutez les écouteurs
        document.querySelectorAll(".prenom, .age, .taille").forEach(ajouterEcouteurs);

        // à la soumission du formulaire
        formLocation.addEventListener("submit", function(event) {
            event.preventDefault();

            // debug ---------------------------------------------------
            // afficherErreursEcran("Entrée dans la soumission form loc");

            // Vérification des champs avant la soumission
            let resultTest = [];
            document.querySelectorAll("input").forEach((input) => {
                if (input.classList.contains("prenom")) {
                let test = testPrenom(input.value, input.id);
                    if (test == false) {
                        resultTest.push("false")
                    }
                }

                if (input.classList.contains("age")) {
                    if (input.value.slice(-3) == "ans") {
                    let test = testAge(input.value.slice(0, -4), input.id);
                        if (test == false) {
                            resultTest.push("false")
                        }
                    } else {
                        let test = testAge(input.value, input.id);
                        if (test == false) {
                            resultTest.push("false")
                        }
                    }
                }
    
                if (input.classList.contains("taille")) {
                    if (input.value.slice(-2) == "cm") { 
                    let test = testTaille(input.value.slice(0, -3), input.id);
                        if (test == false) {
                            resultTest.push("false")
                        }
                    } else {
                        let test = testTaille(input.value, input.id);
                        if (test == false) {
                            resultTest.push("false")
                        }
                    }
                }
            })
            let allTrue = true;
                resultTest.forEach((value) => {
                    if (value !== true) {
                        allTrue = false;
                    }
                });

            if (allTrue) {
                // Vérifie le contenu de formData
                let formData = new FormData(formLocation);
                
                formData.forEach((value, key) => {
                    console.log(`${key}: ${value}`);
                    
                });

                // Modifier les données en BDD
                fetch('../controleurs/updateparticipantlocation.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    // Vérifiez le statut de la réponse
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();  // Essayez de parser la réponse en JSON
                })
                .then(data => {
                    console.log("Réponse reçue :", data);
                    console.log("Réponse reçue :", data.redirect);
                    console.log("Réponse reçue :", data.url);

                    if (data.redirect) {  // Vérifie si une redirection est nécessaire
                        console.log("Redirection vers :", data.url);
                        window.location.href = data.url;  // Redirige vers l'URL reçue du serveur
                    } else {
                        console.error("Erreur lors de la mise à jour:", data.message);
                    }

    
                })
                .catch(error => {
                    console.error('Erreur:', error.message);
                    // logErrorToServer("Erreur lors de la soumission form Location. Fetch." . error.message)
                    // window.location.href = '../../App/views/error/errtech.php';
                });
            } else {
                // message erreur submit
                let btn_form = document.getElementById("btn-form");
                btn_form.classList.remove("d-none");
            }
        });

    }

// formulaire BU
let formDepart = document.getElementById("participantFormDepart");
if (formDepart) {
    // ajouter des écouteurs d'événements
    const ajouterEcouteurs = (input) => {
        input.addEventListener("input", () => {
            switch (input.classList[0]) {
                case "prenom":
                    testPrenom(input.value, input.id);
                    break;
                case "age":
                    testAge(input.value, input.id);
                    break;
                case "taille":
                    testTaille(input.value, input.id);
                    break;
                case "poids":
                    testPoids(input.value, input.id);
                    break;
            }
        });
    };

    // Sélectionnez tous les champs d'entrée et ajoutez les écouteurs
    document.querySelectorAll(".prenom, .age, .taille, .poids").forEach(ajouterEcouteurs);

    // à la soumission du formulaire
    formDepart.addEventListener("submit", function(event) {
        event.preventDefault();

        // debug -------------------------------------------------------
        // afficherErreursEcran("Entrée dans la soumission form depart");

         // Vérification des champs avant la soumission
        let resultTest = [];
        document.querySelectorAll("input").forEach((input) => {
            
            if (input.classList.contains("prenom")) {
                let test = testPrenom(input.value, input.id);
                if (test == false) {
                    resultTest.push("false")
                }
            }
            if (input.classList.contains("age")) {
                if (input.value.slice(-3) == "ans") {
                let test = testAge(input.value.slice(0, -4), input.id);
                    if (test == false) {
                        resultTest.push("false")
                    }
                } else {
                    let test = testAge(input.value, input.id);
                    if (test == false) {
                        resultTest.push("false")
                    }
                }
            }

            if (input.classList.contains("taille")) {
                if (input.value.slice(-2) == "cm") { 
                let test = testTaille(input.value.slice(0, -3), input.id);
                    if (test == false) {
                        resultTest.push("false")
                    }
                } else {
                    let test = testTaille(input.value, input.id);
                    if (test == false) {
                        resultTest.push("false")
                    }
                }
            }

            if (input.classList.contains("poids")) {
                if (input.value.slice(-2) == "kg") { 
                    let test = testPoids(input.value.slice(0, -3), input.id);
                    if (test == false) {
                        resultTest.push("false")
                    }
                } else {
                    let test = testPoids(input.value, input.id);
                    if (test == false) {
                        resultTest.push("false")
                    }
                }
            }
        })
        let allTrue = true;
            resultTest.forEach((value) => {
                if (value !== true) {
                    allTrue = false;
                }
            });

        if (allTrue) {
            // Vérifie le contenu de formData
            let formData = new FormData(formDepart);
            
            formData.forEach((value, key) => {
                console.log(`${key}: ${value}`);
                
            });

            // Modifier les données en BDD
            fetch('../controleurs/updateparticipantdepart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log(response)
                console.log("test")
                console.log(response.redirect)
                if (response.redirected) {
                    window.location.href = response.url;
                    console.log(response.url)
                    // afficherErreursEcran(response.url);
                    return;
                } else {
                    logErrorToServer("Erreur : l'url de redirection n'a pas était trouvée. Fetch depart.");
                }
            })
            .catch(error => {
                console.error('Erreur:', error.message);
                logErrorToServer("Erreur lors de la soumission form Depart. Fetch." . error.messsage);
                window.location.href = '../../App/views/error/errtech.php';
            });
            
        } else {
            // message erreur submit
            let btn_form = document.getElementById("btn-form");
            btn_form.classList.remove("d-none");
        }
    });
}
});



// Champ âge
document.querySelectorAll('.age-field').forEach(function(input) {
    // Vérifier au chargement si le champ est rempli
    if (input.value !== '' && !input.value.endsWith('ans')) {
        input.value += ' ans';
    }
    input.addEventListener('input', function() {
        // Si le champ est vide, laisser le placeholder
        if (this.value === '') {
            this.placeholder = 'Age';
        }
    });
    // Lors du "focus", ajouter " cm" si la valeur est un chiffre
    input.addEventListener('focus', function() {
        if (this.value.endsWith(' ans')) {
            this.value = this.value.replace(' ans', '');
        }
    });

    // Lors du "blur" (perte de focus), ajouter " ans" si la valeur est un chiffre
    input.addEventListener('blur', function() {
        if (this.value !== '' && !isNaN(this.value)) {
            this.value = this.value.replace(/\D/g, '') + ' ans';
        }
    });
});


// Champ taille
document.querySelectorAll('.taille-field').forEach(function(input) {
    // Vérifier au chargement si le champ est rempli
    if (input.value !== '' && !input.value.endsWith('cm')) {
        input.value += ' cm';
    }

    input.addEventListener('input', function() {
    // Si le champ est vide, laisser le placeholder
    if (this.value === '') {
        this.placeholder = 'Taille en cm';
    }
    });
    // Lors du "focus", ajouter " cm" si la valeur est un chiffre
    input.addEventListener('focus', function() {
        if (this.value.endsWith(' cm')) {
            this.value = this.value.replace(' cm', '');
        }
    });

    // Lors du "blur" (perte de focus), ajouter " cm" si la valeur est un chiffre
    input.addEventListener('blur', function() {
        if (this.value !== '' && !isNaN(this.value)) {
            this.value = this.value.replace(/\D/g, '') + ' cm';
        }
    });
});   

// champ poids
document.querySelectorAll('.poids-field').forEach(function(input) {
      // Vérifier au chargement si le champ est rempli
     if (input.value !== '' && !input.value.endsWith('kg')) {
        input.value += ' kg';
    }

    input.addEventListener('input', function() {
        // Si le champ est vide, laisser le placeholder
        if (this.value === '') {
            this.placeholder = 'Poids en kg';
        }
    });
    // Lors du "focus", ajouter " cm" si la valeur est un chiffre
    input.addEventListener('focus', function() {
        if (this.value.endsWith(' kg')) {
            this.value = this.value.replace(' kg', '');
        }
    });

    // Lors du "blur" (perte de focus), ajouter " cm" si la valeur est un chiffre
    input.addEventListener('blur', function() {
        if (this.value !== '' && !isNaN(this.value)) {
            this.value = this.value.replace(/\D/g, '') + ' kg';
        }
    });
});

