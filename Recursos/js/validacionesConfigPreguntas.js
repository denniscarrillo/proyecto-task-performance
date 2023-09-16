import * as funciones from './funcionesValidaciones.js';
/* VALIDACIONES FORMULARIO PREGUNTAS */

let estadoMasdeUnEspacioRespuesta = true;

let estadoPregunta = true;
const $form = document.getElementById('formConfig');
const $pregunta = document.getElementById('id_pregunta');
const $respuesta = document.getElementById('respuesta');

//Cuando se quiera enviar el formulario de login, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {
    
        let estadoInputRespuesta = funciones.validarCampoVacio($respuesta);
    
        if (estadoInputRespuesta == false) {
            e.preventDefault();
        } else {
            if (estadoMasdeUnEspacioRespuesta == false) {
                e.preventDefault();
                estadoMasdeUnEspacioRespuesta = funciones.validarMasdeUnEspacio($respuesta);
            // } else {
            //     if(estadoPregunta == false){
            //         e.preventDefault();
            //         estadoPregunta = funciones.validarCampoVacio($pregunta);
            //     }
            }
        }
    });
    $pregunta.addEventListener('change', ()=>{
        funciones.validarCampoVacio($pregunta);
    });
    $respuesta.addEventListener('focusout', ()=>{
        estadoMasdeUnEspacioRespuesta = funciones.validarMasdeUnEspacio($respuesta);
    });
    $respuesta.addEventListener('keyup', ()=>{
        funciones.limitarCantidadCaracteres("respuesta", 100);
    });
    
    /* $form.addEventListener('submit', e => {
        let estado;
        let mensaje = $respuesta.parentElement.querySelector('p');
        if ($respuesta.value.trim() === ''){
            mensaje.innerText = '*Campo vacio';
            $respuesta.classList.add('mensaje_error');
            estado = false;
        } else {
            $respuesta.classList.remove('mensaje_error');
            mensaje.innerText = '';
            estado = true;
        }
        if ($respuesta.value.trim() === '') {
            e.preventDefault();
        }
        return estado;
    }); */