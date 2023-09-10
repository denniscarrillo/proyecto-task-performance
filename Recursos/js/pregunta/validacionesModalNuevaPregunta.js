import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
let estadoMasdeUnEspacioPregunta = true;

const $form = document.getElementById('form-Pregunta');
const $pregunta = document.getElementById('pregunta');

//Validar inputs
$form.addEventListener('submit', (e) => {
    let estadoInputPregunta = funciones.validarCampoVacio($pregunta);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputPregunta == false) {
        e.preventDefault();
    } else {
    if (estadoMasdeUnEspacioPregunta == false) {
                e.preventDefault();
                estadoMasdeUnEspacioPregunta = funciones.validarMasdeUnEspacio($pregunta);
            } else {
            estadoValidado = true; // 
            }
    }
});

$pregunta.addEventListener('keyup', ()=>{
    funciones.validarCampoVacio($pregunta);
    funciones.limitarCantidadCaracteres($pregunta, 100);
});
$pregunta.addEventListener('focusout', ()=>{
    estadoMasdeUnEspacioPregunta = funciones.validarMasdeUnEspacio($pregunta);
});
/* $pregunta.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasPregunta = funciones.validarSoloLetras($pregunta, validaciones.soloLetras);
}); */