
// fonction

function testPrenom (prenom, idInput) {
    console.log(prenom);
    console.log(idInput);
    // longueur maximale
    if(maxLength(prenom, 40)){
        afficheErreur("prenom",idInput, `err-longueur-prenom`);
        return false
    } else if(hasCode(prenom)){ 
        afficheErreur("prenom",idInput, 'err-insert-code');
        return false
    }
    enleveErreur("prenom", idInput)
   
    return true
}

function testAge (age,idInput) {
    console.log(age);
    console.log(idInput);
   if(hasCode(age)){ 
        afficheErreur("age",idInput, "err-insert-code");
        return false
    // si la valeur du champ n'est pas un nombre
    } else if (onlyTwoNumber (age)=== false) {
        afficheErreur("age",idInput, "err-nombre-age");
        return false
    }
    
    enleveErreur("age", idInput)
    return true
}

function testTaille(taille, idInput) {
    console.log(taille);
    console.log(idInput);
   if(hasCode(taille)){ 
        afficheErreur("taille",idInput, "err-insert-code");
        return false
    // si la valeur du champ n'est pas un nombre
    } else if (onlyThreeNumber (taille)=== false) {
        afficheErreur("taille",idInput, "err-nombre");
        return false
    }
    enleveErreur("taille", idInput)
    return true
}

function testPoids(poids, idInput) {
    console.log(poids);
    console.log(idInput);
    if(hasCode(poids)){ 
        afficheErreur("poids",idInput, "err-insert-code");
        return false
    // si la valeur du champ n'est pas un nombre
    } else if (onlyThreeNumber (poids)=== false) {
        afficheErreur("poids",idInput, "err-nombre");
        return false
    }
    
    enleveErreur("poids", idInput)
    return true
}

/*
// AFFICHAGE DU MESSAGE ERREUR

/** affiche un message d'erreur
 * @param {string} id 
 * @param {string} messageErreur 
 */
/*
function afficheErreur(id,idInput, messageErreur){
    console.log(id)
    // Role : Afficher une erreur : mettre une bordure sur le bon input, et remplir le paragraphe d'erreur associé
    // Parametres : id l'id de l'input dans le quel il y a une erreur
    // messageErreur : le message a afficher
    // retour: rien !
    let input = document.querySelector(`.${id}`);
    input.classList.add("input-error");
    let p = document.getElementById("error-"+id);
    
    let messageEr = erreurMessage[messageErreur];
    p.innerText = messageEr;
    p.classList.remove("d-none");
}
/** efface le message d'erreur
 * @param {string} id 
 * 
 */
/*
function enleveErreur(id){
    // Role: eneleve l'erreur sur l'input et cache le paragraphe associé
    let input = document.querySelector(`.${id}`);
    input.classList.remove("input-error");
    let p = document.getElementById("error-"+id);
    p.innerText ="";
    p.classList.add("d-none");
}
*/

// AFFICHAGE DU MESSAGE ERREUR

/** affiche un message d'erreur
 * @param {string} id 
 * @param {string} messageErreur 
 */
function afficheErreur(id,idInput, messageErreur){
    
    // Role : Afficher une erreur : mettre une bordure sur le bon input, et remplir le paragraphe d'erreur associé
    // Parametres : id l'id de l'input dans le quel il y a une erreur
    // messageErreur : le message a afficher
    // retour: rien !
    let input = document.getElementById(idInput);
    input.classList.add("input-error");
    let p = document.querySelector(`.p-error[data-id="${idInput}"]`);
    let messageEr = erreurMessage[messageErreur];
    p.innerText = messageEr;
    p.classList.remove("d-none");
}
/** efface le message d'erreur
 * @param {string} id 
 * 
 */

function enleveErreur(id, idInput){
    // Role: eneleve l'erreur sur l'input et cache le paragraphe associé
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

          // verifier la valeur de la saisie du champ
          let prenom = document.querySelector(".prenom");
          let age = document.querySelector(".age");
          let taille= document.querySelector(".taille");
              
          // verification des champs à la saisie
          prenom.addEventListener("input", () => { testPrenom(prenom.value) });
          age.addEventListener("input", () => {testAge(age.value)});
          taille.addEventListener("input", () => {testTaille(taille.value)});

        formLocation.addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(formLocation);

            // verification et soumission
            let test1 = testPrenom(prenom.value);
            let test2 = testAge(age.value.slice(0, -4));
            let test3 = testTaille(taille.value.slice(0, -3));
    
            if(test1===true && 
                test2 === true &&
                test3 ===true ){
                // formDepart.submit();

                // Vérifie le contenu de formData
                formData.forEach((value, key) => {
                    console.log(`${key}: ${value}`);
                });

                fetch('../controleurs/updateparticipantlocation.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                        return; 
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error.message);
                    window.location.href = '../../App/views/error/errtech.php'
                });
            }
        });
    }
    /*
    // formulaire BU
    let formDepart = document.getElementById("participantFormDepart");

    // 

    if (formDepart) {

        // verifier la valeur de la saisie du champ
        let prenom = document.querySelector(".prenom");
        let age = document.querySelector(".age");
        let taille= document.querySelector(".taille");
        let poids = document.querySelector(".poids");
           
        
        // verification des champs à la saisie
        prenom.addEventListener("input", () => { testPrenom(prenom.value) });
        age.addEventListener("input", () => {testAge(age.value)});
        taille.addEventListener("input", () => {testTaille(taille.value)});
        poids.addEventListener("input", () => {testPoids(poids.value)});

          formDepart.addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(formDepart);
       
            // verification et soumission
            let test1 = testPrenom(prenom.value);
            let test2 = testAge(age.value.slice(0, -4));
            let test3 = testTaille(taille.value.slice(0, -3));
            let test4 = testPoids(poids.value.slice(0, -3));

            if(test1===true && 
                test2 === true &&
                test3 ===true && 
                test4 ===true ){
                // formDepart.submit();
           
                // Vérifie le contenu de formData
                formData.forEach((value, key) => {
                    console.log(`${key}: ${value}`);
                });

                // modifier les donnée en bdd
                fetch('../controleurs/updateparticipantdepart.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                        return;
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error.message);
                    window.location.href = '../../App/views/error/errtech.php'
                });
            }

          });
    }

*/

// formulaire BU
let formDepart = document.getElementById("participantFormDepart");

if (formDepart) {

    // Fonction pour ajouter des écouteurs d'événements
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

    formDepart.addEventListener("submit", function(event) {
        event.preventDefault();
        

        resultTest = [];
        document.querySelectorAll("input").forEach((input) => {

            // Vérification des champs avant la soumission
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
            
console.log(resultTest)
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

