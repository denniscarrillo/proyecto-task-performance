import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloNumeros: /^[0-9]*$/
    // soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    // correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    
}
let estasdoMasdeUnEspacio = {
    estadoMasEspacioValor: true
   
}

const $form = document.getElementById('form-Edit-Parametro');
const $valor = document.getElementById('E_valor');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputValor = funciones.validarCampoVacio($valor);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputValor == false) {
        e.preventDefault();
    } else {
        if (estasdoMasdeUnEspacio.estadoMasEspacioValor == false) {
            e.preventDefault();
            estasdoMasdeUnEspacio.estadoMasEspacioValor = funciones.validarMasdeUnEspacio($valor);
        } else {
        estadoValidado = true;    
       }
    }
    
});