import * as funciones from './funcionesValidaciones.js';
/* VALIDACIONES FORMULARIO PREGUNTAS */
//objeto con expresiones regulares para los inptus
/* let estadoValidacionesEspacio = {
    estadoEspacioUsuario: true
} */
let estadoSelect = true;
let estadoEspacioVacioRespuesta = true;

const validaciones = {
    user: /^[Z0-9-a-zA\_\-]{4,16}$/,
    repuesta: /^[a-zA\_\-\s\s]$/,
    //expresion regular que me impida colocar mas de un espacio en blanco

    //password: /^(?=.*\d)(?=.*[a-z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/
}

// CAMPOS
const $form = document.getElementById('formPreguntasRes');
const $pregunta = document.getElementById('pregunta');
const $respuestas = document.getElementById('Respuesta');
/* const $mensaje = document.querySelectorAll('.mensaje'); */

//Cuando se quiera enviar el formulario de login, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {

    let estadoInputPregunta = funciones.validarCampoVacio($pregunta);
    let estadoInputRespuesta = funciones.validarCampoVacio($respuestas);

    if (estadoInputPregunta == false || estadoInputRespuesta == false) {
        e.preventDefault();
    } else {
        if (estadoSelect == false || estadoEspacioVacioRespuesta == false) {
            e.preventDefault();
            estadoSelect = funciones.validarCampoVacio($pregunta);
            estadoEspacioVacioRespuesta = funciones.validarEspacios($respuestas);
        } 
    }
});
$pregunta.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($pregunta);
});
$respuestas.addEventListener('keyup', ()=>{
    estadoEspacioVacioRespuesta = funciones.validarEspacios($respuestas);
    funciones.limitarCantidadCaracteres("Respuesta", 50);
});




/* $form.addEventListener('submit', e => {   
    if ($user.value.trim() === ''){
        let div = $user.parentElement 
        let mensaje = div.querySelector('p');
        mensaje.innerText = '*Campo vacio';
        $user.classList.add('mensaje_error');
    } else {
        let div = $user.parentElement 
        let mensaje = div.querySelector('p');
        $user.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
    if ($user.value.trim() === ''){
        e.preventDefault();
   }

}); */

// USUARIO EN MAYUSCULAS
/* $user.addEventListener('focusout', () => {
    let usuarioMayus = $user.value.toUpperCase();
    $user.value = usuarioMayus;
});

// NO PERMITIR ESPACIOS
$user.addEventListener('keyup', () => {
    funciones.validarEspacios($user);
    funciones.limitarCantidadCaracteres("user", 16);
}); */

/* //NO PERMITIR ESPACIOS
const validarEspacios = (input, elemento) => {
    let mensaje;
    let cadena = input.target.value;
    let regex = /\s/g; //Expresión literal para saber si existen espacios en la cadena
    if (regex.test(cadena.trim())){ //Evaluamos expresion vs la cadena
        //Si existen especios mostramos mensaje de error
        mensaje = elemento.parentElement.querySelector('p');
        mensaje.innerText = '*No se permiten espacios';
        elemento.classList.add('mensaje_error');
    } else {
        mensaje = elemento.parentElement.querySelector('p');
        elemento.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
}; */