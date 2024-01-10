import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
let estadoExisteRtn = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9]*$/
}
//VARIABLES GLOBALES
let estadoSoloLetras = {
    estadoLetrasName: true
}

let estadoCorreo = true;

let estasdoMasdeUnEspacio = {
    estadoMasEspacioNombre: true,
    estadoMasEspacioDireccion: true
}
let estadoSoloNumeros = {
    estadoNumerortn :true,
    estadoNumerotelefono :true,
}
let estadoMayorCero = {
    estadoMayorCeroRTN: true,
    estadoMayorCeroTelefono: true
}


const $form = document.getElementById('form-carteraCliente');
const $name = document.getElementById('nombre');
const $rtn = document.getElementById('rtn');
const $telefono = document.getElementById('telefono');
const $correo = document.getElementById('correo');
const $direccion = document.getElementById('direccion');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    estadoValidado = false; 
    //Validamos que algún campo no esté vacío.
    let estadoInputNombre = funciones.validarCampoVacio($name);
    let estadoInputRtn = funciones.validarCampoVacio($rtn);
    let estadoInputTelefono = funciones.validarCampoVacio($telefono)
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    let estadoInputDireccion = funciones.validarCampoVacio($direccion);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputNombre == false || estadoInputRtn == false || estadoInputTelefono ==false || 
        estadoInputCorreo == false || estadoInputDireccion == false) {
        e.preventDefault();
    } else {
            if(estadoSoloLetras.estadoLetrasName == false){
                e.preventDefault();
                estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);  
            }
            if(estadoSoloNumeros.estadoNumerotelefono == false || estadoSoloNumeros.estadoNumerortn == false ){
                e.preventDefault();
                estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
                estadoSoloNumeros.estadoNumerortn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);         
            } else{
                if(estadoCorreo == false){
                    e.preventDefault();
                    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
                } else {
                    if(estasdoMasdeUnEspacio.estadoMasEspacioNombre == false || estasdoMasdeUnEspacio.estadoMasEspacioDireccion == false){
                        e.preventDefault();
                        estasdoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($name);
                        estasdoMasdeUnEspacio.estadoMasEspacioDireccion = funciones.validarMasdeUnEspacio($direccion);
                    } else {
                        if(estadoExisteRtn == false){
                            e.preventDefault();
                            estadoExisteRtn = obtenerRtnExiste($('#rtn').val());
                        } else {
                            if(estadoMayorCero.estadoMayorCeroRTN == false || estadoMayorCero.estadoMayorCeroTelefono == false){
                                e.preventDefault();
                                estadoMayorCero.estadoMayorCeroRTN = funciones.MayorACero($rtn);
                                estadoMayorCero.estadoMayorCeroTelefono = funciones.MayorACero($telefono);
                            } else {
                    estadoValidado = true;
                   }
                 }
              }
            }       
        } 
    }
});



$name.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("nombre", 50);
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
    funciones.limitarCantidadCaracteres("rtn", 14);
});

$rtn.addEventListener('keyup', ()=>{
    estadoMayorCero.estadoMayorCeroRTN = funciones.MayorACero($rtn);
});
$rtn.addEventListener('focusout', ()=>{
    estadoMayorCero.estadoMayorCeroRTN = funciones.MayorACero($rtn);
});

$telefono.addEventListener('keyup', ()=>{
    estadoMayorCero.estadoMayorCeroTelefono  = funciones.MayorACero($telefono);
    funciones.limitarCantidadCaracteres("telefono", 18);
});

$telefono.addEventListener('focusout', ()=>{
    estadoMayorCero.estadoMayorCeroTelefono  = funciones.MayorACero($telefono);
});

$direccion.addEventListener('keyup', ()=>{
    funciones.limitarCantidadCaracteres("direccion", 300);
});
$direccion.addEventListener('focusout', ()=>{
    if(estasdoMasdeUnEspacio.estadoMasEspacioDireccion){
        estasdoMasdeUnEspacio.estadoMasEspacioDireccion = funciones.validarMasdeUnEspacio($direccion);
    }
    let direccionMayus = $direccion.value.toUpperCase();
    $direccion.value = direccionMayus; 
});
$rtn.addEventListener('focusout', ()=>{
    let rtn = $('#rtn').val();
    estadoExisteRtn = obtenerRtnExiste(rtn);
});

$telefono.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
   funciones.limitarCantidadCaracteres("telefono", 20);
});

$rtn.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerortn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
   funciones.limitarCantidadCaracteres("rtn", 20);
});

let obtenerRtnExiste = ($rtn) => {
  
    $.ajax({
        url: "../../../Vista/crud/carteraCliente/rtnExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            rtn: $rtn
        },
        success: function (rtn) {
            let $objRtn = JSON.parse(rtn);
            if ($objRtn.estado == 'true') {
                document.getElementById('rtn').classList.add('mensaje_error');
                document.getElementById('rtn').parentElement.querySelector('p').innerText = '*Este rtn ya existe';
                estadoExisteRtn = false; // Rtn es existente, es false
            } else {
                document.getElementById('rtn').classList.remove('mensaje_error');
                document.getElementById('rtn').parentElement.querySelector('p').innerText = '';
                estadoExisteRtn = true; // Rtn no existe, es true
            }
        }
        
    });
}