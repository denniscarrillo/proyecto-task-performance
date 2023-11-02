import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus



const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\Ñós])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9,-]*$/
}
//VARIABLES GLOBALES



let estadoEspacioInput = {
    estadoEspacioName: true,
    estadoEspaciotelefono: true,
    estadoEspacioDireccion: true,
    estadoEspaciodescripcion: true,
    estadoEspacioRtn: true,
    estadoEspacioCorreo: true,
    estadoEspacioCorreoCliente: true,
    estadoEspaciofechaSolicitud: true,
    estadoEspaciotipoServicio: true,
}
  


let estadoSelect = {
    estadoSelectCorreo: true,
    estadoSelecttelefono: true,
    estadoSelectDireccion: true,
    estadoSelectDescripcion: true,
    estadoSelectName: true,
    estadoSelectRtn:true,
}
let estadoMasdeUnEspacio = {
        estadoMasEspacioCorreo:true,
        estadoMasEspacioDireccion:true,
        estadoMasEspacioDescripcion:true,
        estadoMasEspaciotelefono:true,
        estadoMasEspacioRtn:true,
        estadoMasEspacioName:true,
        estadoMasEspaciofechaSolicitud:true,
        estadoMasEspaciotipoServicio:true,

}

let estadoSoloLetras = {
    estadoLetrasDireccion:true,
    estadoLetrasName:true,
    estadoLetrasDescripcion:true,
  
  

}
let estadoSoloNumeros = {
    estadoNumerortn :true,
    estadoNumerotelefono :true,
}




const $form = document.getElementById('form-solicitud');
const $name = document.getElementById('nombre');
const $rtn = document.getElementById('rtnCliente');
const $correo = document.getElementById('correo');
const $correoCliente = document.getElementById('correoElectronicoCliente');
const $telefono = document.getElementById('telefono');
const $direccion= document.getElementById('direccion');
const $descripcion = document.getElementById('descripcion');
const $fechaSolicitud = document.getElementById('fechaSolicitud');
const $tipoServicio = document.getElementById('tiposervicio');


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
    let estadoInputfechaSolicitud = funciones.validarCampoVacio($fechaSolicitud);
    let estadoInputtipoServicio = funciones.validarCampoVacio($tipoServicio);
    let estadoInputdescripcion = funciones.validarCampoVacio($descripcion);
    
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputName == false || estadoInputdescripcion == false ||estadoInputfechaSolicitud == false || estadoInputtipoServicio == false ||estadoInputtelefono  == false || estadoInputRtn == false || estadoInputCorreo == false  || estadoInputDireccion == false) {
        e.preventDefault();
    }else{
        if(estadoEspacioInput.estadoEspacioName == false || estadoEspacioInput.estadoEspaciodescripcion  == false || estadoEspacioInput.estadoEspaciotelefono  == false || estadoEspacioInput.estadoEspacioRtn== false || estadoEspacioInput.estadoEspacioCorreo == false || estadoEspacioInput.estadoEspacioDireccion == false){ 
            e.preventDefault();
            estadoEspacioInput.estadoEspacioName = funciones.validarEspacios($name);  
            estadoEspacioInput.estadoEspaciotelefono= funciones.validarEspacios($telefono);  
            estadoEspacioInput.estadoEspacioDireccion = funciones.validarEspacios($direccion);  
            estadoEspacioInput.estadoEspacioCorreo = funciones.validarEspacios($correo); 
            estadoEspacioInput.estadoEspacioRtn = funciones.validarEspacios($rtn); 
            estadoEspacioInput.estadoEspaciodescripcion = funciones.validarEspacios($descripcion);  
            estadoEspacioInput.estadoEspaciofechaSolicitud = funciones.validarEspacios($fechaSolicitud); 
            estadoEspacioInput.estadoEspaciotipoServicio = funciones.validarEspacios($tipoServicio);       
        }
        estadoMasdeUnEspacio.estadoMasEspacioName= funciones.validarMasdeUnEspacio($name);
        estadoMasdeUnEspacio.estadoMasEspacioDescripcion= funciones.validarMasdeUnEspacio($descripcion);
        estadoMasdeUnEspacio.estadoMasEspaciotelefono= funciones.validarMasdeUnEspacio($telefono);
        estadoMasdeUnEspacio.estadoMasEspacioDireccion= funciones.validarMasdeUnEspacio($direccion);
        estadoMasdeUnEspacio.estadoMasEspacioCorreo = funciones.validarMasdeUnEspacio($correo);
        estadoMasdeUnEspacio.estadoMasEspacioRtn = funciones.validarMasdeUnEspacio($rtn);
        estadoMasdeUnEspacio.estadoMasEspaciofechaSolicitud = funciones.validarMasdeUnEspacio($fechaSolicitud);
        estadoMasdeUnEspacio.estadoMasEspaciotipoServicio = funciones.validarMasdeUnEspacio($tipoServicio);
       
       
        if(estadoMasdeUnEspacio.estadoMasEspacioName == false ||  estadoMasdeUnEspacio.estadoMasEspaciotipoServicio == false || estadoMasdeUnEspacio.estadoMasEspaciofechaSolicitud == false || estadoMasdeUnEspacio.estadoMasEspacioDescripcion == false ||  estadoMasdeUnEspacio.estadoMasEspaciotelefono == false || estadoMasdeUnEspacio.estadoMasEspacioDireccion== false || estadoMasdeUnEspacio.estadoMasEspacioRtn == false|| estadoMasdeUnEspacio.estadoMasEspacioCorreo == false){
            e.preventDefault();
            console.log(estadoMasdeUnEspacio.estadoMasEspacioDireccion);
            console.log(estadoMasdeUnEspacio.estadoMasEspacioubicacion);
        }else{
            if(estadoSoloLetras.estadoLetrasName == false || estadoSoloLetras.estadoLetrasDescripcion == false ||  estadoSoloLetras.estadoLetrasDireccion == false ){
                e.preventDefault();
                estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
               estadoLetrasDescripcion = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
                estadoLetrasDireccion = funciones.validarSoloLetras($direccion, validaciones.soloLetras);
            }
             if(estadoSoloNumeros.estadoNumerotelefono == false || estadoSoloNumeros.estadoNumerortn == false ){
                e.preventDefault();
                estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
                estadoSoloNumeros.estadoNumerortn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
            }else{
                if(estadoCorreo == false || estadoSelect == false ){
                    e.preventDefault();   
                    estadoCorreoCliente = funciones.validarCorreo($correoCliente, validaciones.correo);        
                    estadoSelect = funciones.validarCampoVacio($name);
                    estadoSelect = funciones.validarCampoVacio($direccion);
                    estadoSelect = funciones.validarCampoVacio($rtn);
                   // estadoSelect = funciones.validarCampoVacio($correo);
                    estadoSelect = funciones.validarCampoVacio($telefono);
                    estadoSelect = funciones.validarCampoVacio($descripcion);
                } else {
                    estadoValidado = true; // 
                }  
            }
        
        } 
    }
});


 $name.addEventListener('keyup', ()=>{
     estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("nombre", 30);
});

 $direccion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasDireccion = funciones.validarSoloLetras($direccion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("direccion", 30);
 });
 $descripcion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasDescripcion = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("descripcion", 30);
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
 $correoCliente.addEventListener('focusout', ()=>{
     if(estadoMasdeUnEspacio.estadoMasEspacioCorreo){
         funciones.validarMasdeUnEspacio($correoCliente);
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

 $rtn.addEventListener('change', ()=>{
     estadoSelect.estadoSelectRtn= funciones.validarCampoVacio($rtn);
 });

 $descripcion.addEventListener('change', ()=>{
    estadoSelect.estadoSelectDescripcion= funciones.validarCampoVacio($rtn);
 });
 $telefono.addEventListener('keyup', ()=>{
     estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
    funciones.limitarCantidadCaracteres("telefono", 14);
 });

 $rtn.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerortn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
    funciones.limitarCantidadCaracteres("rntcliente", 14);
 });