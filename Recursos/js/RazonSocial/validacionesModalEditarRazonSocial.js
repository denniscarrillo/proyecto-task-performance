import * as funciones from '../funcionesValidaciones.js';
export let estadoValido = false;
//Objeto con expresiones regulares para los inptus

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s,])/,//Lentras, acentos y Ñ //Solo letras
    descripcion: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ.\s.,])/, // Letras, acentos y Ñ, también permite punto // Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};
const $descripcion = document.getElementById("E_descripcion");
let inputsEditarRazonSocial = {
    // razonSocial: document.getElementById('E_razonSocial'),
    descripcion: document.getElementById('E_descripcion')
}

inputsEditarRazonSocial.descripcion.addEventListener('keyup', ()=>{
    funciones.limitarCantidadCaracteres('E_descripcion', 300);
});
$descripcion.addEventListener("input", () => {
    funciones.convertirAMayusculasVisualmente($descripcion);
    validarInputDescripcion();
  });
  $descripcion.addEventListener("keydown", () => {
    funciones.soloLetrasYPuntosYComas($descripcion)
  });

let btnGuardar = document.getElementById('btnEditarsubmit');

btnGuardar.addEventListener('click', () => {
    console.log(document.querySelectorAll(".mensaje_error").length);
    validarInputDescripcion();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValido = true;
    }else{
          estadoValido = false;
    }
    
});


inputsEditarRazonSocial.descripcion.addEventListener('keyup', ()=>{
    validarInputDescripcion();
    funciones.limitarCantidadCaracteres('E_descripcion', 300);
});

let validarInputDescripcion = function () {
    let descripcionMayus = inputsEditarRazonSocial.descripcion.value.toUpperCase();
    inputsEditarRazonSocial.descripcion.value = descripcionMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsEditarRazonSocial.descripcion);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputsEditarRazonSocial.descripcion,
             validaciones.descripcion);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsEditarRazonSocial.descripcion);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsEditarRazonSocial.descripcion,
             validaciones.caracterMas3veces);
    }
}
