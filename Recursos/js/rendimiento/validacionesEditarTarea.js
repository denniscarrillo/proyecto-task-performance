import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES
let estadoEspacioInput = {
    estadoEspacioRtn: true,
    estadoEspacioTelefono: true, 
} 
let estadoSoloLetras = {
    estadoLetrasNombre: true,
    estadoLetrasRubro: true,
    estadoLetrasRazonSocial: true,
}
let estadoSelect = {
    estadoSelectClasificacion: true,
    estadoSelectOrigen: true
}  
const $form = document.getElementById('form-Edit-Tarea'); 
const $estadoTarea = document.getElementById('estados-tarea');
let inputsEditarTarea = {
    titulo: document.getElementById('input-titulo-tarea'),
    rtn: document.getElementById('rnt-cliente'),
    nombre: document.getElementById('nombre-cliente'),
    telefono: document.getElementById('telefono-cliente'),
    correo: document.getElementById('correo-cliente'),
    direccion: document.getElementById('direccion-cliente'),
    rubroComercial: document.getElementById('rubrocomercial'),
    razonSocial: document.getElementById('razonsocial'), 
    clasificacionLead: document.getElementById('clasificacion-lead'),
    origenLead: document.getElementById('origen-lead')
  }

$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    // let estadoInputRtn = funciones.validarCampoVacio($rtn);
    // let estadoInputNombre =  funciones.validarCampoVacio($nombre);
    // let estadoInputTelefono = funciones.validarCampoVacio($telefono);
    // let estadoInputCorreo = funciones.validarCampoVacio($correo);
    // let estadoInputDireccion = funciones.validarCampoVacio($direccion);
    // let estadoInputClasificacion = funciones.validarCampoVacio($clasificacion);
    // let estadoInputOrigen = funciones.validarCampoVacio($origen);
    // let estadoInputRubro = funciones.validarCampoVacio($rubro);
    // let estadoInputRazon = funciones.validarCampoVacio($razon);
    switch ($estadoTarea.value){
        case "2":{
            funciones.validarCampoVacio(inputsEditarTarea.va);
            funciones.validarCampoVacio(inputsEditarTarea);
            break;
        }  
        default:{
    
            break;
        }   
    }

    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputRtn == false || estadoInputNombre  == false || estadoInputTelefono == false || 
        estadoInputCorreo == false || estadoInputDireccion == false || estadoInputClasificacion == false
        || estadoInputOrigen == false || estadoInputRubro == false || estadoInputRazon == false) {
        e.preventDefault();
    }
});







// $rtn.addEventListener('keyup', () => {
//     estadoEspacioInput.estadoEspacioRtn = funciones.validarEspacios($rtn);
// });