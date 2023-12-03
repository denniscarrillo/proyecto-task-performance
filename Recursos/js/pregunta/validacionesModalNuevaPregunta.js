import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus

let estadoExistePregunta = false;
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
                if(estadoExistePregunta == false){
                    e.preventDefault();
                    estadoExistePregunta = obtenerPreguntaExiste($('#pregunta').val());
            } else {
                   estadoValidado = true; // 
            }
        }
    }
});

$pregunta.addEventListener('keyup', ()=>{
    funciones.validarCampoVacio($pregunta);
    funciones.limitarCantidadCaracteres('pregunta', 100);
});

$pregunta.addEventListener('focusout', ()=>{
    funciones.validarCampoVacio($pregunta);
    funciones.limitarCantidadCaracteres('pregunta', 100);
});
$pregunta.addEventListener('focusout', ()=>{
   let preguntas = estadoMasdeUnEspacioPregunta = funciones.validarMasdeUnEspacio($pregunta);
   if(preguntas){
         let pregunta = $('#pregunta').val();
         estadoExistePregunta = obtenerPreguntaExiste(pregunta);
   }
   let preguntaMayus = $pregunta.value.toUpperCase();
   $pregunta.value = preguntaMayus;  
});

/* $pregunta.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasPregunta = funciones.validarSoloLetras($pregunta, validaciones.soloLetras);
}); */

let obtenerPreguntaExiste = ($pregunta) => {
    $.ajax({
        url: "../../../Vista/crud/pregunta/preguntaExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            pregunta: $pregunta
        },
        success: function (pregunta) {
            let $objpregunta = JSON.parse(pregunta);
            if ($objpregunta.estado == 'true') {
                document.getElementById('pregunta').classList.add('mensaje_error');
                document.getElementById('pregunta').parentElement.querySelector('p').innerText = '*La pregunta ya existe';
                estadoExistePregunta = false; // Pregunta es existente, es false
            } else {
                document.getElementById('pregunta').classList.remove('mensaje_error');
                document.getElementById('pregunta').parentElement.querySelector('p').innerText = '';
                estadoExistePregunta = true; // Preunta no existe, es true
            }
        }
        
    });
}