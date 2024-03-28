import * as funciones from '../funcionesValidaciones.js';
export let estadoValido = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s,])/,//Lentras, acentos y Ñ //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};

let inputseditarObjeto = {
   
    descripcionObjeto: document.getElementById('A_descripcion')
}
let btnGuardar = document.getElementById('btn-editarsubmit');

btnGuardar.addEventListener('click', () => {
  
    validarInputDescripcionObjeto();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValido = true;
    }
});

inputseditarObjeto.descripcionObjeto.addEventListener("keyup", ()=>{
    validarInputDescripcionObjeto();
    funciones.limitarCantidadCaracteres("A_descripcion", 100);
})

let validarInputDescripcionObjeto = function () {
    let descripcionObjetoMayus = inputseditarObjeto.descripcionObjeto.value.toUpperCase();
    inputseditarObjeto.descripcionObjeto.value = descripcionObjetoMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarObjeto.descripcionObjeto);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputseditarObjeto.descripcionObjeto, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarObjeto.descripcionObjeto);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarObjeto.descripcionObjeto, validaciones.caracterMas3veces);
    }
}
