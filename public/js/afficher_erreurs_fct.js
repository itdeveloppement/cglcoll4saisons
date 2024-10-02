// AFFICHAGE DU MESSAGE ERREUR

/** role : Afficher une erreur : mettre une bordure sur le bon input, et remplir le paragraphe d'erreur associé
 * @param {string} idInput - id l'id de l'input dans le quel il y a une erreur
 * @param {string} messageErreur - le message a afficher
 */
export function afficheErreur(idInput, messageErreur){
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
export function enleveErreur(idInput){
    let input = document.getElementById(idInput);
    input.classList.remove("input-error");
    let p = document.querySelector(`.p-error[data-id="${idInput}"]`);
    p.innerText ="";
    p.classList.add("d-none");
    // message erreur submit 
    let btn_form = document.getElementById("btn-form");
    btn_form.classList.add("d-none");
}