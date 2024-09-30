
import { afficheErreur, enleveErreur } from './errorDisplay.js';

// fonction

/**
 * role : tester le champ prenom du formulaire
 * @param {Sting} prenom : la valeur du champ à tester
 * @param {String} idInput : id du champ à tester
 * @returns true si le teste est validé
 */
export function testPrenom (prenom, idInput) {
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
export function testAge (age,idInput) {
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
export function testTaille(taille, idInput) {
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
export function testPoids(poids, idInput) {
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


/** NOMBRE COMPARAISON : compare si la valeur du champ est superieure à une valeur (logueur voulue) passée en parametre
 * @param {number} string la chaine de caractere du champ
 * @param {number} longueurMax la longueur max que peut prendre la chaine
 * @returns true si la chaine de caractere du camps est plus longue que le parametre sinon retourne false
 */
export function maxLength (valueField, longueurMax){
    if(valueField.length >= longueurMax) {
    return true;
    } return false
}
/** TEXTE CODE : verifie si la valeur du champ contient du code
 * @param {string} valueField la chaine de caractere du champ
 * @returns  true si il y a du code 
 * @returns false si il n'y a pas de code
 */
export function hasCode(valueField){
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
export function onlyTwoNumber (valueField) {
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
export function onlyThreeNumber (valueField) {
    // let reg=/^\d+$/;
    let reg = /^(?:[1-9]|[1-9][0-9]|[12][0-9]{2})$/;
    valueField = String(valueField);
    if (reg.test(valueField) || valueField.trim() == "") {
        return true;
    } return false
}

