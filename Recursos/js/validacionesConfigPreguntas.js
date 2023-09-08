import * as funciones from './funcionesValidaciones.js';
/* VALIDACIONES FORMULARIO PREGUNTAS */
let estadoSelect = true;

const $form = document.getElementById('formConfig');
const $pregunta = document.getElementById('id_pregunta');
const $respuesta = document.getElementById('respuesta');

//Cuando se quiera enviar el formulario de login, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {
    
        let estadoInputPregunta = funciones.validarCampoVacio($pregunta);
        let estadoInputRespuesta = funciones.validarCampoVacio($respuesta);
    
        if (estadoInputPregunta == false || estadoInputRespuesta == false) {
            e.preventDefault();
        } else {
            if (estadoSelect == false || estadoEspacioVacioRespuesta == false) {
                e.preventDefault();
                estadoSelect = validaciones.validarCampoVacio($pregunta);
            } 
        }
    });
    $pregunta.addEventListener('change', ()=>{
        estadoSelect = funciones.validarCampoVacio($pregunta);
    });
    $respuesta.addEventListener('keyup', ()=>{
        funciones.limitarCantidadCaracteres("respuesta", 50);
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