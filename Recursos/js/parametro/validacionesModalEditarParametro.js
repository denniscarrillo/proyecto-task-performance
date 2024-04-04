import * as funciones from '../funcionesValidaciones.js';
export let estadoValido = false;


const validaciones = {
    //soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    soloLetras: /^(?=.*[^()a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s])/,
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};

let inputseditarParametro = {
   
    valorParametro: document.getElementById('E_valor'),
    descripcionParametro: document.getElementById('E_descripcion')
}
let btnGuardar = document.getElementById('btn-editarsubmit');

btnGuardar.addEventListener('click', () => {
  
    validarInputValorParametro();
    validarInputDescripcionParametro();
    if (document.querySelectorAll(".mensaje_error").length == 0) 
    {
        estadoValido = true;
    }else {
        estadoValido = false;
    }
});

inputseditarParametro.valorParametro.addEventListener("keyup", ()=>{
    validarInputValorParametro();
    funciones.limitarCantidadCaracteres("E_valor", 100);
})

inputseditarParametro.descripcionParametro.addEventListener("keyup", ()=>{
    validarInputDescripcionParametro();
    funciones.limitarCantidadCaracteres("E_descripcion", 100);
})

let validarInputDescripcionParametro = function () {
    let descripcionParametroMayus = inputseditarParametro.descripcionParametro.value.toUpperCase();
    inputseditarParametro.descripcionParametro.value = descripcionParametroMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarParametro.descripcionParametro);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputseditarParametro.descripcionParametro, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarParametro.descripcionParametro);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarParametro.descripcionParametro, validaciones.caracterMas3veces);
    }
}

let validarInputValorParametro = function () {
   
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarParametro.valorParametro);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarParametro.valorParametro);
    } 
    if( estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarParametro.valorParametro, validaciones.caracterMas3veces);
    }
    
}

