import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    soloNumeros: /^\d+(\.\d+)?$/
}
//VARIABLES GLOBALES


const $form = document.getElementById('form-Edit-Porcentaje');
const $estado = document.getElementById('E_estadoPorcentaje');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputEstado = funciones.validarCampoVacio($estado);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputEstado == false) {
        e.preventDefault();
    } 
                        estadoValidado = true;
});