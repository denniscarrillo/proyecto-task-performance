import * as funciones from '../funcionesValidaciones.js';
export let estadoValido = false;

const validaciones = {
    //soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s])/,//Lentras, acentos y Ñ
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};

let inputseditarEstado = {
   
    descripcionEstado: document.getElementById('E_descripcion')
}
let btnGuardar = document.getElementById('btn-editarsubmit');

btnGuardar.addEventListener('click', () => {
  
    validarInputDescripcionEstado();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValido = true;
    }else{
        estadoValido = false;
    }

});



let validarInputDescripcionEstado = function () {
    let descripcionEstadoMayus = inputseditarEstado.descripcionEstado.value.toUpperCase();
    inputseditarEstado.descripcionEstado.value = descripcionEstadoMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarEstado.descripcionEstado);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputseditarEstado.descripcionEstado, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarEstado.descripcionEstado);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarEstado.descripcionEstado, validaciones.caracterMas3veces);
    }
}
