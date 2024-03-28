import * as funciones from './funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES
let estadoLetrasName = true;

let estadoSelect = {
    estadoSelectRol: true,
    estadoSelectEstado: true,
}
let estadoMasdeUnEspacio = {
    estadoMasEspacioNombre: true
}

let estadoCorreo = true;

const $form = document.getElementById('form-Edit-Usuario');
const $name = document.getElementById('E_nombre');
const $correo = document.getElementById('E_correo');
const $rol = document.getElementById('E_rol');
const $estado = document.getElementById('E_estado');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    //Validamos que algún campo no esté vacío.
    let estadoInputNombre = funciones.validarCampoVacio($name);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    let estadoInputRol = funciones.validarCampoVacio($rol);
    let estadoInputEstado = funciones.validarCampoVacio($estado);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputNombre == false || estadoInputCorreo == false || estadoInputRol == false || estadoInputEstado == false) {
        e.preventDefault();
    } else{
        if(estadoLetrasName == false){
            e.preventDefault();
            estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
        } else {
            estadoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($name);
            if(estadoMasdeUnEspacio.estadoMasEspacioNombre == false){
                e.preventDefault();
            } else{

            if(estadoCorreo == false || estadoSelect.estadoSelectEstado == false || estadoSelect.estadoSelectRol == false){
                e.preventDefault();
                estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
                estadoSelect.estadoSelectEstado = funciones.validarCampoVacio($estado);
                estadoSelect.estadoSelectRol = funciones.validarCampoVacio($rol);
            } else {
                estadoValidado = true; // 
            }
        }
      }
    }
});
$name.addEventListener('keyup', ()=>{
    estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_nombre", 100);
});
$name.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioNombre){
        funciones.validarMasdeUnEspacio($name);
    }
    let usuarioMayus = $name.value.toUpperCase();
    $name.value = usuarioMayus;
});
$estado.addEventListener('focusout', ()=>{
    
    let usuarioMayus = $estado.value.toUpperCase();
    $estado.value = usuarioMayus;
});
$correo.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
    funciones.limitarCantidadCaracteres("E_correo", 50);
});
$rol.addEventListener('change', ()=>{
    estadoSelect.estadoSelectRol = funciones.validarCampoVacio($rol);
});
$estado.addEventListener('change', ()=>{
    estadoSelect.estadoSelectEstado = funciones.validarCampoVacio($estado);
});
// || estadoMasdeUnEspacio.estadoMasEspacioNombre == true