import * as funciones from './funcionesValidaciones.js';
/* VALIDACIONES FORMULARIO PREGUNTAS */

let estadoMasdeUnEspacioRespuesta = true;
let estadoSelect = true;

// CAMPOS
const $form = document.getElementById('formPreguntasRes');
const $preguntas = document.getElementById('preguntas');
const $respuestas = document.getElementById('Respuesta');
/* const $mensaje = document.querySelectorAll('.mensaje'); */

//Cuando se quiera enviar el formulario de login, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {

    let estadoInputRespuesta = funciones.validarCampoVacio($respuestas);

    if (estadoInputRespuesta == false) {
        e.preventDefault();
    // } else {
    //     if (estadoMasdeUnEspacioRespuesta == true) {
    //         e.preventDefault();
    //         estadoMasdeUnEspacioRespuesta = funciones.validarMasdeUnEspacio($respuestas);
    //     } 
    }
});
$preguntas.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($preguntas);
});
$respuestas.addEventListener('keyup', ()=>{
    estadoMasdeUnEspacioRespuesta = funciones.validarMasdeUnEspacio($respuestas);
    funciones.limitarCantidadCaracteres("Respuesta", 50);
});
