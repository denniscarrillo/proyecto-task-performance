import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus



const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\/ .Ñós])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9,-]*$/
}
//VARIABLES GLOBALES

//let estadoExisteRtn = false;

let estadoEspacioInput = {
    estadoEspacioName: true,
    estadoEspaciotelefono: true,
    estadoEspaciodescripcion: true,
    estadoEspacioRtn: true,
    estadoEspacioCorreo: true,
    estadoEspacioCorreoCliente: true,
    estadoEspaciofechaSolicitud: true,
    estadoEspaciotipoServicio: true,
}
  


let estadoSelect = {
    estadoSelectCorreoCliente: true,
    estadoSelecttelefono: true,
    estadoSelectDireccion: true,
    estadoSelectDescripcion: true,
    estadoSelectName: true,
    estadoSelectRtn:true,
    estadoSelectCantProducto:true,
    estadoSelecttipoServicio:true,
}

let estadoMasdeUnEspacio = {
        estadoMasEspacioCorreoCliente:true,
        estadoMasEspacioDireccion:true,
        estadoMasEspacioDescripcion:true,
        estadoMasEspaciotelefono:true,
        estadoMasEspacioRtn:true,
        estadoMasEspacioName:true,
        estadoMasEspaciofechaSolicitud:true,
        estadoMasEspaciotipoServicio:true,

}

let estadoSoloLetras = {
   
    estadoLetrasName:true,
}
let estadoSoloNumeros = {

    estadoNumerotelefono :true,
}


let estadoCorreo = true;

const $form = document.getElementById('form-solicitud');
const $name = document.getElementById('nombre');
const $rtn = document.getElementById('rtnCliente');
const $correo = document.getElementById('correo');
const $correoCliente = document.getElementById('correoCliente');
const $telefono = document.getElementById('telefono');
const $direccion= document.getElementById('direccion');
const $descripcion = document.getElementById('descripcion');
const $fechaSolicitud = document.getElementById('fechaSolicitud');
const $tipoServicio = document.getElementById('tiposervicio');
const $cantProducto = document.getElementById('CantidadProducto');



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
    let estadoInputdescripcion = funciones.validarCampoVacio($descripcion);
   // let estadoInputCantProducto= funciones.validarCampoVacio($cantProducto);
    let estadoInputTipoServicio= funciones.validarCampoVacio($tipoServicio);
    
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputName == false || estadoInputTipoServicio == false ||estadoInputdescripcion == false || estadoInputtelefono  == false ||   estadoInputDireccion == false) {
        e.preventDefault();
    }else{
        if(estadoEspacioInput.estadoEspacioName == false || estadoEspacioInput.estadoEspaciodescripcion  == false || estadoEspacioInput.estadoEspaciotelefono  == false ||  estadoEspacioInput.estadoEspacioCorreoCliente == false || estadoEspacioInput.estadoEspacioDireccion == false){ 
            e.preventDefault();
            estadoEspacioInput.estadoEspacioName = funciones.validarEspacios($name);  
            estadoEspacioInput.estadoEspaciotelefono= funciones.validarEspacios($telefono);  
            estadoEspacioInput.estadoEspacioDireccion = funciones.validarEspacios($direccion);  
            estadoEspacioInput.estadoEspacioCorreoCliente = funciones.validarEspacios($correoCliente); 
            estadoEspacioInput.estadoEspaciodescripcion = funciones.validarEspacios($descripcion); 
         
              
        }
        estadoMasdeUnEspacio.estadoMasEspacioName= funciones.validarMasdeUnEspacio($name);
        estadoMasdeUnEspacio.estadoMasEspacioDescripcion= funciones.validarMasdeUnEspacio($descripcion);
        estadoMasdeUnEspacio.estadoMasEspaciotelefono= funciones.validarMasdeUnEspacio($telefono);
        estadoMasdeUnEspacio.estadoMasEspacioDireccion= funciones.validarMasdeUnEspacio($direccion);
        estadoMasdeUnEspacio.estadoMasEspacioCorreoCliente = funciones.validarMasdeUnEspacio($correoCliente);
       
        if(estadoMasdeUnEspacio.estadoMasEspacioName == false ||  estadoMasdeUnEspacio.estadoMasEspacioDescripcion == false ||  estadoMasdeUnEspacio.estadoMasEspaciotelefono == false || estadoMasdeUnEspacio.estadoMasEspacioDireccion== false || estadoMasdeUnEspacio.estadoMasEspacioCorreoCliente == false){
            e.preventDefault();
            console.log(estadoMasdeUnEspacio.estadoMasEspacioDireccion);
            console.log(estadoMasdeUnEspacio.estadoMasEspacioName);
        }else{
            if(estadoSoloLetras.estadoLetrasName == false ){
                e.preventDefault();
                estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
                
            }
            
             if(estadoSoloNumeros.estadoNumerotelefono == false ){
                e.preventDefault();
                estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
            if(estadoExisteRtn == false){
                    e.preventDefault();
                    estadoExisteRtn = obtenerRtnExiste($('#rntcliente').val());
            }  
            }else{
                if(estadoCorreo == false || estadoSelect == false ){
                    e.preventDefault();   
                    estadoSelect = funciones.validarCampoVacio($name);
                    estadoSelect = funciones.validarCampoVacio($direccion);
                    estadoSelect = funciones.validarCampoVacio($tipoServicio);
                    estadoSelect = funciones.validarCampoVacio($telefono);
                    estadoSelect = funciones.validarCampoVacio($descripcion);
                 //   estadoSelect = funciones.validarCampoVacio($cantProducto);
                  //  estadoSelect = funciones.validarCampoVacio($correoCliente);
                    estadoCorreo = funciones.validarCorreo($correoCliente, validaciones.correo);      

                } else {
                    estadoValidado = true; // 
                }  
            }
        
        } 
    }
});


 $name.addEventListener('keyup', ()=>{
     estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("nombre", 50);
});

 $direccion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasDireccion = funciones.validarSoloLetras($direccion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("direccion", 30);
 });
 $descripcion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasDescripcion = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("descripcion", 30);
 });

 $correoCliente.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correoCliente, validaciones.correo);
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
     if(estadoMasdeUnEspacio.estadoMasEspacioCorreoCliente){
         funciones.validarMasdeUnEspacio($correoCliente);
    }  
 });
 $direccion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioDireccion){
        funciones.validarMasdeUnEspacio($direccion);
     }  
 });
$descripcion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioDescripcion){
        funciones.validarMasdeUnEspacio($descripcion);
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

 $descripcion.addEventListener('change', ()=>{
    estadoSelect.estadoSelectDescripcion= funciones.validarCampoVacio($descripcion);
 });

//  $cantProducto.addEventListener('change', ()=>{
//     estadoSelect.estadoSelectCantProducto= funciones.validarCampoVacio($cantProducto);
//  });


//  if (document.querySelector('#clientenuevo')) {
//     // Verifica si el formulario es nuevo
//     $correoCliente.addEventListener('change', () => {
//       estadoSelect.estadoSelectCorreoCliente = funciones.validarCampoVacio($correoCliente);
//     });
//   }

 $telefono.addEventListener('keyup', ()=>{
     estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
    funciones.limitarCantidadCaracteres("telefono", 14);
  });

//    $rtn.addEventListener('focusout', () => {
//      let rtn = $('#rntcliente').val();
//      estadoExisteRtn = obtenerRtnExiste(rtn);
//  });