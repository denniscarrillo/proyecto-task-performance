import * as funciones from './funcionesValidaciones.js';
//Objeto manejo estado de validaciones
let estadoValidaciones = {
    MasdeUnEspacioEntrePalabras: false,
    campoVacioPregunta: false,
    campoVacioRespuesta: false
}
const $form = document.getElementById('formConfig');
const $pregunta = document.getElementById('id_pregunta');
const $respuesta = document.getElementById('respuesta');
let $spanEstadoPregunta = document.querySelector('.estado-p-guardada');
let $numPreguntaContestada = document.querySelector('.info-content');

//Cuando se quiera enviar el formulario de login, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {
    if (estadoValidaciones.campoVacioPregunta == false || estadoValidaciones.campoVacioRespuesta == false) {
        //Si no se han cumplido las validaciones volvemos a aplicarlas y evitamos que envie el formulario
        estadoValidaciones.campoVacioRespuesta = funciones.validarCampoVacio($respuesta);
        estadoValidaciones.campoVacioPregunta = funciones.validarCampoVacio($pregunta);
        e.preventDefault();
    } 
    if (estadoValidaciones.MasdeUnEspacioEntrePalabras == false && estadoValidaciones.campoVacioRespuesta == true) {
        e.preventDefault();
        estadoValidaciones.MasdeUnEspacioEntrePalabras = funciones.validarMasdeUnEspacio($respuesta);
    }
});
//Otros eventos
$pregunta.addEventListener('focusout', ()=>{
    estadoValidaciones.campoVacioPregunta = funciones.validarCampoVacio($pregunta);
});
$respuesta.addEventListener('focusout', ()=>{
    estadoValidaciones.campoVacioRespuesta = funciones.validarCampoVacio($respuesta);
    if(estadoValidaciones.campoVacioRespuesta){
        estadoValidaciones.MasdeUnEspacioEntrePalabras = funciones.validarMasdeUnEspacio($respuesta);
    }
});
$respuesta.addEventListener('keyup', ()=>{
    funciones.limitarCantidadCaracteres("respuesta", 100);
});

let preguntaGuardada = (elemento) => {
    if(elemento.id == '1'){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            customClass: { //Para agregar clases propias
                popup: 'customizable-toast'
              },
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });  
        Toast.fire({
            icon: 'success',
            title: 'Tu Pregunta N°'+$numPreguntaContestada.id+' ha sido configurada'
        });
    }
}
preguntaGuardada($spanEstadoPregunta);
 