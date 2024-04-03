import * as funciones from '../funcionesValidaciones.js';
export let estadoValido= false;



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
let inputseditarRubroComercial = {
   
    descripcionRubroComercial: document.getElementById('E_descripcion')
    
    

}

inputseditarRubroComercial.descripcionRubroComercial.addEventListener('keyup', ()=>{
    funciones.limitarCantidadCaracteres('E_descripcion', 300);
});
$descripcion.addEventListener("input", () => {
    funciones.convertirAMayusculasVisualmente($descripcion);
    validarInputDescripcion();
  });
  $descripcion.addEventListener("keydown", () => {
    funciones.soloLetrasYPuntosYComas($descripcion)
  });
let btnGuardar = document.getElementById('btnsubmiteditar');

btnGuardar.addEventListener('click', () => {
  
    validarInputDescripcionRubroComercial();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValido = true;
    }else{
        estadoValido = false;   
    }
    
});



let validarInputDescripcionRubroComercial = function () {
    let descripcionRubroComercialMayus = inputseditarRubroComercial.descripcionRubroComercial.value.toUpperCase();
    inputseditarRubroComercial.descripcionRubroComercial.value = descripcionRubroComercialMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarRubroComercial.descripcionRubroComercial);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputseditarRubroComercial.descripcionRubroComercial,
             validaciones.descripcion);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarRubroComercial.descripcionRubroComercial);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarRubroComercial.descripcionRubroComercial,
             validaciones.caracterMas3veces);
    }
}
