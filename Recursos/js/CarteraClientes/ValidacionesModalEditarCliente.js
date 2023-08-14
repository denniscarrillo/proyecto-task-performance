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

const $form = document.getElementById('form-editar-carteraCliente');
const $name = document.getElementById('E_Nombre');
const $rtn = document.getElementById('E_Rtn');
const $telefono = document.getElementById('E_Telefono');
const $correo = document.getElementById('E_Correo');
const $direccion = document.getElementById('E_Direccion');

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
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputNombre == false || estadoInputRtn ==false || estadoInputTelefono == false ||
        estadoInputCorreo == false || estadoInputDireccion == false) {
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
                estadoValidado = true; // 
            }
        }
    }
});
$name.addEventListener('keyup', ()=>{
    estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    $("E_nombre").inputlimiter({
        limit: 50
    });
});
$name.addEventListener('focusout', ()=>{
    let usuarioMayus = $name.value.toUpperCase();
    $name.value = usuarioMayus;
});
$correo.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
});