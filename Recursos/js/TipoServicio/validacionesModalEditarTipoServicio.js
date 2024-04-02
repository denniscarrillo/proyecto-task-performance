import * as funciones from '../funcionesValidaciones.js';
export let estadoValido = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};

let inputseditarServicioTecnico = {
   
    EServicioTecnico: document.getElementById('E_servicio_Tecnico')
}
let btnGuardar = document.getElementById('btn-editarsubmit');

btnGuardar.addEventListener('click', () => {
    validarInputServicioTecnico();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValido = true;
    }else{
        estadoValido = false;
    }
});

inputseditarServicioTecnico.EServicioTecnico.addEventListener("keyup", ()=>{
    validarInputServicioTecnico();
    funciones.limitarCantidadCaracteres("E_servicio_Tecnico", 50);
})

let validarInputServicioTecnico = function () {
    let EServicioTecnicoMayus = inputseditarServicioTecnico.EServicioTecnico.value.toUpperCase();
    inputseditarServicioTecnico.EServicioTecnico.value = EServicioTecnicoMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarServicioTecnico.EServicioTecnico);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputseditarServicioTecnico.EServicioTecnico, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarServicioTecnico.EServicioTecnico);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarServicioTecnico.EServicioTecnico, validaciones.caracterMas3veces);
    }
}
