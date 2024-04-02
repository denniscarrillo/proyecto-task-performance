import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚÑ\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 áéíóúñÁÉÍÓÚÑ#-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};

let inputsNuevoEstadoU = {
    descripcionEstadoU: document.getElementById('estado')
}
let btnGuardar = document.getElementById('btn-submit');

btnGuardar.addEventListener('click', () => {
    validarInputDescripcionEstadoUsuario();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValidado = true;
    }else{
        estadoValidado = false;
    }
});

inputsNuevoEstadoU.descripcionEstadoU.addEventListener("keyup", ()=>{
    validarInputDescripcionEstadoUsuario();
    funciones.limitarCantidadCaracteres("estado", 20);
})

let validarInputDescripcionEstadoUsuario = function () {
    let descripcionEstadoUMayus = inputsNuevoEstadoU.descripcionEstadoU.value.toUpperCase();
    inputsNuevoEstadoU.descripcionEstadoU.value = descripcionEstadoUMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuevoEstadoU.descripcionEstadoU);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputsNuevoEstadoU.descripcionEstadoU, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuevoEstadoU.descripcionEstadoU);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuevoEstadoU.descripcionEstadoU, validaciones.caracterMas3veces);
    }
}
