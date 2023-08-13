import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus


const $form = document.getElementById('form-Pregunta-Editar');
const $pregunta = document.getElementById('pregunta_E');

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
});