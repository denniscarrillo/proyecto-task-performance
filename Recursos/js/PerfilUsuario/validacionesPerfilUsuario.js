import * as funciones from '../funcionesValidaciones.js';

//Objeto con expresiones regulares para los inptus



const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9]*$/
}
//VARIABLES GLOBALES


let estadoMasdeUnEspacio = {
    estadoMasEspacioNombre: true
    
}
let estadoSoloNumeros = {
    estadoNumerortn :true,
    estadoNumerotelefono :true
}

let estadoCorreo = true;
let estadoDireccion= true;
let estadoTelefono= true;
let estadoRtn= true;
let estadoLetrasName = true;



const $form = document.getElementById('form-Edit-PerfilUsuario');
const $name = document.getElementById('E_nombre');
const $rtn = document.getElementById('E_rtn');
const $correo = document.getElementById('E_email');
const $telefono = document.getElementById('E_telefono');
const $direccion= document.getElementById('E_direccion');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    //Validamos que algún campo no esté vacío.
    let estadoInputNombre = funciones.validarCampoVacio($name);
    let estadoInputRtn = funciones.validarCampoVacio($rtn);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    
    let estadoInputTelefono = funciones.validarCampoVacio($telefono);
    let estadoInputDireccion = funciones.validarCampoVacio($direccion);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputNombre == false || estadoInputRtn == false ||  estadoInputCorreo == false || estadoInputTelefono == false || estadoInputDireccion == false) {
        e.preventDefault();
    } else{
        if(estadoLetrasName == false){
            e.preventDefault();
            estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
           
        }
         if(estadoSoloNumeros.estadoNumerortn == false ){
            e.preventDefault();
            estadoSoloNumeros.estadoNumerortn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
            estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
        } 
        else {
            if(estadoRtn == false ||estadoCorreo == false || estadoTelefono == false || estadoDireccion == false || estadoMasdeUnEspacio.estadoMasEspacioNombre == true){
                e.preventDefault();
                estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
                estadoDireccion = funciones.validarCampoVacio($direccion);
                //estadoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($name);
            } else {
                estadoValidado = true; // 
            }
      }
    }
});
$name.addEventListener('keyup', ()=>{
    estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_nombre", 50);
});
$rtn.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerortn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
   funciones.limitarCantidadCaracteres("E_rtn", 14);
});

$telefono.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
   funciones.limitarCantidadCaracteres("E_telefono", 14);
});

$name.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioNombre){
        funciones.validarMasdeUnEspacio($name);
    }
    let usuarioMayus = $name.value.toUpperCase();
    $name.value = usuarioMayus;
});
$correo.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
});

$direccion.addEventListener('change', ()=>{
    estadoDireccion = funciones.validarCampoVacio($direccion);
});