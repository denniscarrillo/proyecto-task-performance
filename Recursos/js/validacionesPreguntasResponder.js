import * as funciones from './funcionesValidaciones.js';
/* VALIDACIONES FORMULARIO PREGUNTAS */

let estadoMasdeUnEspacioRespuesta = true;

// CAMPOS
const $form = document.getElementById('formPreguntasRes');
const $pregunta = document.getElementById('pregunta');
const $respuestas = document.getElementById('Respuesta');
/* const $mensaje = document.querySelectorAll('.mensaje'); */

//Cuando se quiera enviar el formulario de login, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {

    let estadoInputRespuesta = funciones.validarCampoVacio($respuestas);

    if (estadoInputRespuesta == false) {
        e.preventDefault();
    } else {
        if (estadoMasdeUnEspacioRespuesta == false) {
            e.preventDefault();
            estadoMasdeUnEspacioRespuesta = funciones.validarMasdeUnEspacio($respuestas);
        } 
    }
});
$pregunta.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($pregunta);
});
$respuestas.addEventListener('keyup', ()=>{
    estadoMasdeUnEspacioRespuesta = funciones.validarMasdeUnEspacio($respuestas);
    funciones.limitarCantidadCaracteres("Respuesta", 50);
});
