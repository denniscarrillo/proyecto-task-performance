import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus



const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s,])/,//Lentras, acentos y Ñ //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};


let inputsNuevaRazonSocial = {
    RazonSocial: document.getElementById('razonSocial'),
    descripcion: document.getElementById('descripcion')
}

/* let btnGuardar = document.getElementById('btn-submit');


btnGuardar.addEventListener('click', async () => {
  
    ValidarInputRazonSocial();
    ValidarInputDescrip();
   
    console.log(document.querySelectorAll(".mensaje_error").length)
    if (
        document.querySelectorAll(".mensaje_error").length == 0 &&
      document.querySelectorAll(".mensaje-existe-cliente").length == 0
    ){
        estadoValidado = true;
    }else{
        estadoValidado = false;   
    }
    
}); */
$(document).ready(function (){
    //Evento clic para hacer todas las validaciones
  document.getElementById("btn-submit").addEventListener("click", () => {
    ValidarInputRazonSocial();
    ValidarInputDescrip();
   
    console.log(document.querySelectorAll(".mensaje_error").length)
    console.log(document.querySelectorAll(".mensaje-existe-razonsocial").length)
    if (
        document.querySelectorAll(".mensaje_error").length == 0 &&
      document.querySelectorAll(".mensaje-existe-razonsocial").length == 0
    ){
        estadoValidado = true;
    }else{
        estadoValidado = false;   
    }
  });
})

inputsNuevaRazonSocial.RazonSocial.addEventListener('keyup', async()=>{
  
    funciones.limitarCantidadCaracteres('RazonSocial', 50);
});
inputsNuevaRazonSocial.descripcion.addEventListener('keyup', ()=>{
 
    funciones.limitarCantidadCaracteres('descripcion', 300);
});
//Validar inputs
let ValidarInputRazonSocial =  function ()  {
    let rubroMayus = inputsNuevaRazonSocial.RazonSocial.value.toUpperCase();
    inputsNuevaRazonSocial.RazonSocial.value = rubroMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false,
        //estadoRazonSocialExiste: false

    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuevaRazonSocial.RazonSocial);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputsNuevaRazonSocial.RazonSocial, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuevaRazonSocial.RazonSocial);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuevaRazonSocial.RazonSocial, validaciones.caracterMas3veces);
    }
   /*  if(estadoValidaciones.estadoNoCaracteresSeguidos){
       // await obtenerRazonSocialExiste($('#RazonSocial').val());
    } */

    
    
}

let ValidarInputDescrip = function () {
    let descripcionMayus = inputsNuevaRazonSocial.descripcion.value.toUpperCase();
    inputsNuevaRazonSocial.descripcion.value = descripcionMayus;
    
    let descripcionValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
      
    }

    descripcionValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuevaRazonSocial.descripcion);
    if(descripcionValidaciones.estadoCampoVacio) {
        descripcionValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputsNuevaRazonSocial.descripcion, validaciones.soloLetras);
    } 
    if(descripcionValidaciones.estadoSoloLetras) {
       descripcionValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuevaRazonSocial.descripcion);
    }
    if(descripcionValidaciones.estadoNoMasdeUnEspacios) {
        descripcionValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuevaRazonSocial.descripcion, 
            validaciones.caracterMas3veces);
    }
    
 
}


