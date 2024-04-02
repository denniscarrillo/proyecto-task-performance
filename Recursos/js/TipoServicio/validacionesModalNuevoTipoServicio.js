import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};

let inputsNuevoServico = {
    ServicioTecnico:  document.getElementById('servicio_Tecnico'),
}
let btnGuardar = document.getElementById('btn-submit');

btnGuardar.addEventListener('click', () => {
    validarInputServicioTecnico();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValidado = true;
    }else {
        estadoValidado = false;
    }
});

inputsNuevoServico.ServicioTecnico.addEventListener("keyup", ()=>{
    validarInputServicioTecnico();
    funciones.limitarCantidadCaracteres("servicio_Tecnico", 50);
})

let validarInputServicioTecnico = function () {
    let ServicioMayus = inputsNuevoServico.ServicioTecnico.value.toUpperCase();
    inputsNuevoServico.ServicioTecnico.value = ServicioMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuevoServico.ServicioTecnico);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputsNuevoServico.ServicioTecnico, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuevoServico.ServicioTecnico);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuevoServico.ServicioTecnico, validaciones.caracterMas3veces);
    }
}

