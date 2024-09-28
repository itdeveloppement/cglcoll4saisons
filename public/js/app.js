
// fonction

/**
 * role : tester le champ prenom du formulaire
 * @param {Sting} prenom : la valeur du champ à tester
 * @param {String} idInput : id du champ à tester
 * @returns true si le teste est validé
 */
function testPrenom (prenom, idInput) {
    // longueur maximale
    if(maxLength(prenom, 40)){
        afficheErreur(idInput, `err-longueur-prenom`);
        return false
    } else if(hasCode(prenom)){ 
        afficheErreur(idInput, 'err-insert-code');
        return false
    }
    enleveErreur(idInput)
    return true
}

/**
 * role : tester le champ prenom du formulaire
 * @param {Sting} age : la valeur du champ à tester
 * @param {String} idInput : id du champ à tester
 * @returns true si le teste est validé
 */
function testAge (age,idInput) {
   if(hasCode(age)){ 
        afficheErreur(idInput, "err-insert-code");
        return false
    // si la valeur du champ n'est pas un nombre
    } else if (onlyTwoNumber (age)=== false) {
        afficheErreur(idInput, "err-nombre-age");
        return false
    }
    enleveErreur(idInput)
    return true
}

/**
 * role : tester le champ prenom du formulaire
 * @param {Sting} taille : la valeur du champ à tester
 * @param {String} idInput : id du champ à tester
 * @returns true si le teste est validé
 */
function testTaille(taille, idInput) {
   if(hasCode(taille)){ 
        afficheErreur(idInput, "err-insert-code");
        return false
    // si la valeur du champ n'est pas un nombre
    } else if (onlyThreeNumber (taille)=== false) {
        afficheErreur(idInput, "err-nombre");
        return false
    }
    enleveErreur(idInput)
    return true
}

/**
 * role : tester le champ prenom du formulaire
 * @param {Sting} poids : la valeur du champ à tester
 * @param {String} idInput : id du champ à tester
 * @returns true si le teste est validé
 */
function testPoids(poids, idInput) {
    if(hasCode(poids)){ 
        afficheErreur(idInput, "err-insert-code");
        return false
    // si la valeur du champ n'est pas un nombre
    } else if (onlyThreeNumber (poids)=== false) {
        afficheErreur(idInput, "err-nombre");
        return false
    }
    enleveErreur(idInput)
    return true
}

// AFFICHAGE DU MESSAGE ERREUR

/** role : Afficher une erreur : mettre une bordure sur le bon input, et remplir le paragraphe d'erreur associé
 * @param {string} idInput - id l'id de l'input dans le quel il y a une erreur
 * @param {string} messageErreur - le message a afficher
 */
function afficheErreur(idInput, messageErreur){
    console.log(messageErreur)
    let input = document.getElementById(idInput);
    input.classList.add("input-error");
    let p = document.querySelector(`.p-error[data-id="${idInput}"]`);
    let messageEr = erreurMessage[messageErreur];
    p.innerText = messageEr;
    p.classList.remove("d-none");
}

/** Role: eneleve l'erreur sur l'input et cache le paragraphe associé
 * @param {string} idInput - id l'id de l'input dans le quel il y a une erreur
 */
function enleveErreur(idInput){
    console.log(idInput)
    let input = document.getElementById(idInput);
    input.classList.remove("input-error");
    let p = document.querySelector(`.p-error[data-id="${idInput}"]`);
    p.innerText ="";
    p.classList.add("d-none");
    // message erreur submit 
    let btn_form = document.getElementById("btn-form");
    btn_form.classList.add("d-none");
}

/** NOMBRE COMPARAISON : compare si la valeur du champ est superieure à une valeur (logueur voulue) passée en parametre
 * @param {number} string la chaine de caractere du champ
 * @param {number} longueurMax la longueur max que peut prendre la chaine
 * @returns true si la chaine de caractere du camps est plus longue que le parametre sinon retourne false
 */
function maxLength (valueField, longueurMax){
    if(valueField.length >= longueurMax) {
    return true;
    } return false
}
/** TEXTE CODE : verifie si la valeur du champ contient du code
 * @param {string} valueField la chaine de caractere du champ
 * @returns  true si il y a du code 
 * @returns false si il n'y a pas de code
 */
function hasCode(valueField){
    // cette fonction cherche dans une chaine s'il y a une balise script
    // retour true : y'a du code
    // false :y'a pas de code
    let reg = /[<>]/;
    if (reg.test(valueField)) {
    return true;
    } return false;
}

/** NOMBRE : verifie si la valeur du champ est un nombre entre 1 et 99 inclus
 * @param {number} valueField valeur du champs
 * @returns true si la valeur du champs validé
 * @returns false sinon
 */
function onlyTwoNumber (valueField) {
    // let reg=/^\d+$/;
    let reg = /^(?:[1-9]|[1-9][0-9])$/;
    if (reg.test(valueField) || valueField.trim() == "") {
        return true;
    } return false
}

/** NOMBRE : verifie si la valeur du champ est un nombre entre 1 et 299 inclus
 * @param {number} valueField valeur du champs
 * @returns true si la valeur du champs validé
 * @returns false sinon
 */
function onlyThreeNumber (valueField) {
    // let reg=/^\d+$/;
    let reg = /^(?:[1-9]|[1-9][0-9]|[12][0-9]{2})$/;
    valueField = String(valueField);
    if (reg.test(valueField) || valueField.trim() == "") {
        return true;
    } return false
}

// ----- FORMULAIRE PARTICIPANT ------------------

document.addEventListener("DOMContentLoaded", function() {
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

            // Vérification des champs avant la soumission
            resultTest = [];
            document.querySelectorAll("input").forEach((input) => {
                if (input.classList.contains("prenom")) {
                let test = testPrenom(input.value, input.id);
                    if (test == false) {
                        resultTest.push("false")
                    }
                }
                    if (input.classList.contains("age")) {
                    let test = testAge(input.value.slice(0, -4), input.id);
                    if (test == false) {
                        resultTest.push("false")
                    }
                }
                    if (input.classList.contains("taille")) {
                    let test = testTaille(input.value.slice(0, -3), input.id);
                    if (test == false) {
                        resultTest.push("false")
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
                    if (response.redirected) {
                        // window.location.href = response.url;
                        return;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error.message);
                    window.location.href = '../../App/views/error/errtech.php';
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

         // Vérification des champs avant la soumission
        resultTest = [];
        document.querySelectorAll("input").forEach((input) => {
            if (input.classList.contains("prenom")) {
            let test = testPrenom(input.value, input.id);
                if (test == false) {
                    resultTest.push("false")
                }
            }
                if (input.classList.contains("age")) {
                let test = testAge(input.value.slice(0, -4), input.id);
                if (test == false) {
                    resultTest.push("false")
                }
            }
                if (input.classList.contains("taille")) {
                let test = testTaille(input.value.slice(0, -3), input.id);
                if (test == false) {
                    resultTest.push("false")
                }
            }
                if (input.classList.contains("poids")) {
                    let test = testPoids(input.value.slice(0, -3), input.id);
                if (test == false) {
                    resultTest.push("false")
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
                if (response.redirected) {
                    // window.location.href = response.url;
                    return;
                }
            })
            .catch(error => {
                console.error('Erreur:', error.message);
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

