import * as funciones from '../funcionesValidaciones.js';

//Objeto con expresiones regulares para los inptus



const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s,])/,//Lentras, acentos y Ñ //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 -]*$/
}
//VARIABLES GLOBALES



let estadoEspacioInput = {
    estadoEspacioName: true,
    estadoEspaciotelefono: true,
    estadoEspacioDireccion: true,
    estadoEspacioRtn: true,
    estadoEspacioCorreo: true,
}
  


let estadoSelect = {
    estadoSelectCorreo: true,
    estadoSelecttelefono: true,
    estadoSelectDireccion: true,
    estadoSelectName: true,
    estadoSelectRtn:true,
}
let estadoMasdeUnEspacio = {
        estadoMasEspacioCorreo:true,
        estadoMasEspacioDireccion:true,
        estadoMasEspaciotelefono:true,
        estadoMasEspacioRtn:true,
        estadoMasEspacioName:true,

}

let estadoSoloLetras = {
    estadoLetrasDireccion:true,
    estadoLetrasName:true,
  

}
let estadoSoloNumeros = {
    estadoNumerortn :true,
    estadoNumerotelefono :true,
}

let estadoCorreo = true;


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
    let estadoInputName = funciones.validarCampoVacio($name);
    let estadoInputtelefono = funciones.validarCampoVacio($telefono);
    let estadoInputDireccion = funciones.validarCampoVacio($direccion);
    let estadoInputRtn = funciones.validarCampoVacio($rtn);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputName == false || estadoInputtelefono  == false || estadoInputRtn == false || estadoInputCorreo == false  || estadoInputDireccion == false) {
        e.preventDefault();
    }else{
        if(estadoEspacioInput.estadoEspacioName == false || estadoEspacioInput.estadoEspaciotelefono  == false || estadoEspacioInput.estadoEspacioRtn== false || estadoEspacioInput.estadoEspacioCorreo == false || estadoEspacioInput.estadoEspacioDireccion == false){ 
            e.preventDefault();
            estadoEspacioInput.estadoEspacioName = funciones.validarEspacios($name);  
            estadoEspacioInput.estadoEspaciotelefono= funciones.validarEspacios($telefono);  
            estadoEspacioInput.estadoEspacioDireccion = funciones.validarEspacios($direccion);  
            estadoEspacioInput.estadoEspacioCorreo = funciones.validarEspacios($correo); 
            estadoEspacioInput.estadoEspacioRtn = funciones.validarEspacios($rtn);   
        }
        estadoMasdeUnEspacio.estadoMasEspacioName= funciones.validarMasdeUnEspacio($name);
        estadoMasdeUnEspacio.estadoMasEspaciotelefono= funciones.validarMasdeUnEspacio($telefono);
        estadoMasdeUnEspacio.estadoMasEspacioDireccion= funciones.validarMasdeUnEspacio($direccion);
        estadoMasdeUnEspacio.estadoMasEspacioCorreo = funciones.validarMasdeUnEspacio($correo);
        estadoMasdeUnEspacio.estadoMasEspacioRtn = funciones.validarMasdeUnEspacio($rtn);
       
        if(estadoMasdeUnEspacio.estadoMasEspacioName == false || estadoMasdeUnEspacio.estadoMasEspaciotelefono == false || estadoMasdeUnEspacio.estadoMasEspacioDireccion== false || estadoMasdeUnEspacio.estadoMasEspacioRtn == false|| estadoMasdeUnEspacio.estadoMasEspacioCorreo == false){
            e.preventDefault();
            console.log(estadoMasdeUnEspacio.estadoMasEspacioDireccion);
            console.log(estadoMasdeUnEspacio.estadoMasEspacioubicacion);
        }else{
            if(estadoSoloLetras.estadoLetrasName == false ||  estadoSoloLetras.estadoLetrasDireccion == false ){
                e.preventDefault();
                estadoLetrasdescripcion = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
                estadoLetrasubicacion = funciones.validarSoloLetras($ubicacion, validaciones.soloLetras);
                estadoLetrasAvance = funciones.validarSoloLetras($Avance, validaciones.soloLetras);
               
            }
             if(estadoSoloNumeros.estadoNumerotelefono == false || estadoSoloNumeros.estadoNumerortn == false ){
                e.preventDefault();
                estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
                estadoSoloNumeros.estadoNumerortn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
            }else{
                if(estadoCorreo == false || estadoSelect == false ){
                    e.preventDefault();   
                    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);        
                    estadoSelect = funciones.validarCampoVacio($name);
                    estadoSelect = funciones.validarCampoVacio($direccion);
                    estadoSelect = funciones.validarCampoVacio($rtn);
                    estadoSelect = funciones.validarCampoVacio($correo);
                    estadoSelect = funciones.validarCampoVacio($telefono);
                } else {
                    estadoValidado = true; // 
                }  
            }
        
        } 
    }
});
$name.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_nombre", 100);
});
$direccion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasDireccion= funciones.validarSoloLetras($direccion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_direccion", 50);
});
$correo.addEventListener('keyup', ()=>{
    estadoMasdeUnEspacio.estadoMasEspacioDireccion= funciones.validarMasdeUnEspacio($correo, validaciones.correo);
   funciones.limitarCantidadCaracteres("E_email", 50);
});
$name.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioName){
        funciones.validarMasdeUnEspacio($name);
    }  
});
$telefono.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspaciotelefono){
        funciones.validarMasdeUnEspacio($telefono);
    }  
});
$correo.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioCorreo){
        funciones.validarMasdeUnEspacio($correo);
    }  
});
$direccion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioDireccion){
        funciones.validarMasdeUnEspacio($direccion);
    }  
});
$rtn.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioRtn){
        funciones.validarMasdeUnEspacio($rtn);
    }  
});


$name.addEventListener('change', ()=>{
    estadoSelect.estadoSelectName = funciones.validarCampoVacio($name);
});
$telefono.addEventListener('change', ()=>{
    estadoSelect.estadoSelecttelefono = funciones.validarCampoVacio($telefono);
});
$direccion.addEventListener('change', ()=>{
    estadoSelect.estadoSelectDireccion = funciones.validarCampoVacio($direccion);
});
$correo.addEventListener('change', ()=>{
    estadoSelect.estadoSelectCorreo = funciones.validarCampoVacio($correo);
});
$rtn.addEventListener('change', ()=>{
    estadoSelect.estadoSelectRtn= funciones.validarCampoVacio($rtn);
});
$telefono.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
   funciones.limitarCantidadCaracteres("E_telefono", 20);
});

$rtn.addEventListener('input', (event)=>{
    if (!funciones.RTN_guion(event)) {
        event.preventDefault();
    }
   funciones.limitarCantidadCaracteres("E_rtn", 20);
});

