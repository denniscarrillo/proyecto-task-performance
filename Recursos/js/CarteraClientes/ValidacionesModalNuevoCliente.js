import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9]*$/
}
//VARIABLES GLOBALES
let estadoSoloLetras = {
    estadoLetrasName: true,
}
let estadoSoloNumeros = {
    estadoNumerosRtn: true,
}

let estadoSelect = true;
let estadoCorreo = true;

const $form = document.getElementById('form-CarteraClientes');
const $name = document.getElementById('nombre');
const $rtn = document.getElementById('rtn');
const $correo = document.getElementById('correo');
const $estadoContacto = document.getElementById('estadoContacto');

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
    let estadoInputeEstado = funciones.validarCampoVacio($estadoContacto);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputNombre == false || estadoInputRtn == false || estadoInputCorreo == false || estadoInputeEstado == false) {
        e.preventDefault();
    } else {
            if(estadoSoloLetras.estadoLetrasName == false){
                e.preventDefault();
                estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);           
            } else{
                if(estadoSoloNumeros.estadoNumerosRtn == false){
                    e.preventDefault();
                    estadoSoloNumeros.estadoNumerosRtn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
                } else {
                    if(estadoCorreo == false || estadoSelect == false){
                        e.preventDefault();
                        estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
                        estadoSelect = funciones.validarCampoVacio($estadoContacto);
                    } else {
                        estadoValidado = true;
                        console.log(estadoValidado); // 
                    }
                }
            
            }       
            
        }
});
$name.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    $("#nombre").inputlimiter({
        limit: 50
    });
});
$name.addEventListener('focusout', ()=>{
    let usuarioMayus = $name.value.toUpperCase();
    $name.value = usuarioMayus;
});

$rtn.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerosRtn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
    $("#rtn").inputlimiter({
        limit: 14
    });
});

$correo.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
});
$estadoContacto.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($estadoContacto);
});