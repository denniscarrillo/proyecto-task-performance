import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus


const $form = document.getElementById('form-Pregunta');
const $pregunta = document.getElementById('pregunta');

//Validar inputs
$form.addEventListener('submit', (e) => {
    let estadoInputPregunta = funciones.validarCampoVacio($pregunta);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputPregunta == false) {
        e.preventDefault();
    } else {
            estadoValidado = true; // 
            }
});

$pregunta.addEventListener('keyup', ()=>{
    funciones.validarCampoVacio($pregunta);
    funciones.limitarCantidadCaracteres($pregunta, 100);
});
/* $pregunta.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasPregunta = funciones.validarSoloLetras($pregunta, validaciones.soloLetras);
}); */