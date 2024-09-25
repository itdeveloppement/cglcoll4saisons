
// ----- FORMULAIRE PARTICIPANT ------------------

document.addEventListener("DOMContentLoaded", function() {
    // formulaire LO
    let formLocation = document.getElementById("participantFormLocation");

    if (formLocation) {
        formLocation.addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(formLocation);

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
        });
    }

    // formulaire BU
    let formDepart = document.getElementById("participantFormDepart");
    
    if (formDepart) {
          formDepart.addEventListener("submit", function(event) {
            event.preventDefault();
            let formData = new FormData(formDepart);
       
            // Vérifie le contenu de formData
            formData.forEach((value, key) => {
                console.log(`${key}: ${value}`);
            });
  
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

// soumission formulaire

