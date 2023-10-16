
import * as funciones from '../funcionesValidaciones.js';

export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
}


let estadoEspacioInput = {
    estadoEspacioMotivo: true,
  
} 
let estadoSoloLetras = {
    estadoLetrasMotivo: true,
  

}

let estadoMasdeUnEspacio = {
    estadoMasEspacioMotivo: true,
  
}

let estadoSelect = true;

const $form = document.getElementById('form-Solicitud');
const $MotivoCancelacion = document.getElementById('E_MotivoCancelacion');



/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    //Validamos que algún campo no esté vacío.
    let estadoInputMotivo = funciones.validarCampoVacio($MotivoCancelacion);
   
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputMotivo == false ) {
        e.preventDefault();
    } else{
        if(estadoEspacioInput.estadoEspacioMotivo == false){ 
            e.preventDefault();  
            estadoEspacioInput.estadoEspacioMotivo = funciones.validarEspacios($MotivoCancelacion);
        } 
        estadoMasdeUnEspacio.estadoMasEspacioMotivo = funciones.validarMasdeUnEspacio($MotivoCancelacion);
        console.log(estadoMasdeUnEspacio.estadoMasEspacioMotivo);
        if(estadoMasdeUnEspacio.estadoMasEspacioMotivo == false){
            e.preventDefault();
        } else{
        if(estadoSoloLetras.estadoLetrasMotivo == false){
            e.preventDefault();
            estadoLetrasMotivo = funciones.validarSoloLetras($MotivoCancelacion, validaciones.soloLetras);
        } else {
         if(estadoSelect == false ){
                e.preventDefault();           
                estadoSelect = funciones.validarCampoVacio($MotivoCancelacion);
            } else {
                estadoValidado = true; // 
            }
        }
      }
    }
});

$MotivoCancelacion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasMotivo = funciones.validarSoloLetras($MotivoCancelacion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_MotivoCancelacion", 50);
});

$MotivoCancelacion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioMotivo){
        funciones.validarMasdeUnEspacio($MotivoCancelacion);
    }
    let usuarioMayus = $MotivoCancelacion.value.toUpperCase();
    $MotivoCancelacion.value = usuarioMayus;
});

$MotivoCancelacion.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($MotivoCancelacion);
});







