import * as funciones from './funcionesValidaciones.js';
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
const $rtn = document.getElementById('rnt-cliente');
const $nombre = document.getElementById('nombre-cliente');
const $telefono = document.getElementById('telefono-cliente');
const $correo = document.getElementById('correo-cliente');
const $direccion = document.getElementById('direccion-cliente');
const $clasificacion = document.getElementById('clasificacion-lead');
const $origen = document.getElementById('origen-lead');
const $rubro = document.getElementById('rubrocomercial');
const $razon = document.getElementById('razonsocial');

$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputRtn = funciones.validarCampoVacio($rtn);
    let estadoInputNombre =  funciones.validarCampoVacio($nombre);
    let estadoInputTelefono = funciones.validarCampoVacio($telefono);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    let estadoInputDireccion = funciones.validarCampoVacio($direccion);
    let estadoInputClasificacion = funciones.validarCampoVacio($clasificacion);
    let estadoInputOrigen = funciones.validarCampoVacio($origen);
    let estadoInputRubro = funciones.validarCampoVacio($rubro);
    let estadoInputRazon = funciones.validarCampoVacio($razon);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputRtn == false || estadoInputNombre  == false || estadoInputTelefono == false || 
        estadoInputCorreo == false || estadoInputDireccion == false || estadoInputClasificacion == false
        || estadoInputOrigen == false || estadoInputRubro == false || estadoInputRazon == false) {
        e.preventDefault();
    }
});

$rtn.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioRtn = funciones.validarEspacios($rtn);
    //Validación con jQuery inputlimiter
    // $("#usuario").inputlimiter({
    //     limit: 15
    // });
});