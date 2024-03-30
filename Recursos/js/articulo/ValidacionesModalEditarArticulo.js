import * as funciones from '../funcionesValidaciones.js';
export let estadoValido = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s,])/,//Lentras, acentos y Ñ
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};

let inputseditarArticulo = {
   
    Articulo: document.getElementById('A_Articulo'),
    Detalle: document.getElementById('A_Detalle'),
    Marca: document.getElementById('A_Marca')
    
}
let btnGuardar = document.getElementById('btn-editarsubmit');

btnGuardar.addEventListener('click', () => {
  
    validarInputArticulo();
    validarInputDetalle();
    validarInputMarca();
    
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValido = true;
    }else{
        estadoValido = false;
    }
});

inputseditarArticulo.Articulo.addEventListener("keyup", ()=>{
    validarInputArticulo();
    funciones.limitarCantidadCaracteres("A_Articulo", 50);
})

inputseditarArticulo.Detalle.addEventListener("keyup", ()=>{
    validarInputDetalle();
    funciones.limitarCantidadCaracteres("A_Detalle", 100);
})

inputseditarArticulo.Marca.addEventListener("keyup", ()=>{
    validarInputMarca();
    funciones.limitarCantidadCaracteres("A_Marca", 50);
})


let validarInputArticulo = function () {
    let ArticuloMayus = inputseditarArticulo.Articulo.value.toUpperCase();
    inputseditarArticulo.Articulo.value = ArticuloMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarArticulo.Articulo);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarArticulo.Articulo);
    } 
    if(  estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarArticulo.Articulo, validaciones.caracterMas3veces);
    }
}

let validarInputDetalle = function () {
    let DetalleMayus =  inputseditarArticulo.Detalle.value.toUpperCase();
     inputseditarArticulo.Detalle.value = DetalleMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarArticulo.Detalle);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarArticulo.Detalle);
    } 
    if(  estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarArticulo.Detalle, validaciones.caracterMas3veces);
    }
}

let validarInputMarca = function () {
    let MarcaMayus =  inputseditarArticulo.Marca.value.toUpperCase();
     inputseditarArticulo.Marca.value = MarcaMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio( inputseditarArticulo.Marca);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras( inputseditarArticulo.Marca, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio( inputseditarArticulo.Marca);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter( inputseditarArticulo.Marca, validaciones.caracterMas3veces);
    }
}