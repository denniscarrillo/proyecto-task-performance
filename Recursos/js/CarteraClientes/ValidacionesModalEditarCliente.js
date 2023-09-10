import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES
let estadoLetrasName = true;
let estadoCorreo = true;

let estasdoMasdeUnEspacio = {
    estadoMasEspacioNombre: true,
    estadoMasEspacioDireccion: true
}

const $form = document.getElementById('form-editar-carteraCliente');
const $name = document.getElementById('E_Nombre');
const $rtn = document.getElementById('E_Rtn');
const $telefono = document.getElementById('E_Telefono');
const $correo = document.getElementById('E_Correo');
const $direccion = document.getElementById('E_Direccion');
const $estadoContacto = document.getElementById('E_estadoContacto');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    //Validamos que algún campo no esté vacío.
    let estadoInputNombre = funciones.validarCampoVacio($name);
    let estadoInputRtn = funciones.validarCampoVacio($rtn);
    let estadoInputTelefono = funciones.validarCampoVacio($telefono);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    let estadoInputDireccion = funciones.validarCampoVacio($direccion);
    let estadoInputEstadoContacto = funciones.validarCampoVacio($estadoContacto);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputNombre == false || estadoInputRtn ==false || estadoInputTelefono == false ||
        estadoInputCorreo == false || estadoInputDireccion == false || estadoInputEstadoContacto == false) {
        e.preventDefault();
    } else {
        if(estadoLetrasName == false){
            e.preventDefault();
            estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
        } else {
            if(estadoCorreo == false){
                e.preventDefault();
                estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
            } else {
                if(estasdoMasdeUnEspacio.estadoMasEspacioNombre == false || estasdoMasdeUnEspacio.estadoMasEspacioDireccion == false){
                    e.preventDefault();
                    estasdoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($name);
                    estasdoMasdeUnEspacio.estadoMasEspacioDireccion = funciones.validarMasdeUnEspacio($direccion);
                } else {
                estadoValidado = true; // 
            }
          }
        }
    }
});
$name.addEventListener('keyup', ()=>{
    estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("E_nombre", 50);
});
$name.addEventListener('focusout', ()=>{
    if(estasdoMasdeUnEspacio.estadoMasEspacioNombre){
        estasdoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($name);
    }
    let usuarioMayus = $name.value.toUpperCase();
    $name.value = usuarioMayus;
});
$correo.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
});
$rtn.addEventListener('keyup', ()=>{
    funciones.limitarCantidadCaracteres("E_rtn", 14);
});
$telefono.addEventListener('keyup', ()=>{
    funciones.limitarCantidadCaracteres("E_telefono", 18);
});
$direccion.addEventListener('keyup', ()=>{
    funciones.limitarCantidadCaracteres("E_direccion", 100);
});
$direccion.addEventListener('focusout', ()=>{
    if(estasdoMasdeUnEspacio.estadoMasEspacioDireccion){
        estasdoMasdeUnEspacio.estadoMasEspacioDireccion = funciones.validarMasdeUnEspacio($direccion);
    }
});
