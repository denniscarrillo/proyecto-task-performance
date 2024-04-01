import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s,])/,//Lentras, acentos y Ñ //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};

let inputsNuevoArticulo = {
   
    Articulo: document.getElementById('Articulo'),
    Detalle: document.getElementById('Detalle'),
    Marca: document.getElementById('Marca')
    
}
let btnGuardar = document.getElementById('btn-submit');

btnGuardar.addEventListener('click', () => {
  
    validarInputArticulo();
    validarInputDetalle();
    validarInputMarca();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValidado = true;
    }else{
        estadoValidado = false;
    }
});

document.getElementById('precio').addEventListener('input', (event) => {
    funciones.permitirSoloNumeros(event)
    const cant = event.target.value;
    if(parseFloat(cant) < 1 || cant === '') {
        event.target.value = 1;
    }
})

document.getElementById('existencias').addEventListener('input', (event) => {
    funciones.permitirSoloNumeros(event)
    const cant = event.target.value;
    if(parseFloat(cant) < 1 || cant === '') {
        event.target.value = 1;
    }
})

let validarInputArticulo = function () {
    let ArticuloMayus = inputsNuevoArticulo.Articulo.value.toUpperCase();
    inputsNuevoArticulo.Articulo.value = ArticuloMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuevoArticulo.Articulo);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuevoArticulo.Articulo);
    } 
    if(  estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuevoArticulo.Articulo, validaciones.caracterMas3veces);
    }
    
}

let validarInputDetalle = function () {
    let DetalleMayus =  inputsNuevoArticulo.Detalle.value.toUpperCase();
     inputsNuevoArticulo.Detalle.value = DetalleMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuevoArticulo.Detalle);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuevoArticulo.Detalle);
    } 
    if(  estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuevoArticulo.Detalle, validaciones.caracterMas3veces);
    }
}

let validarInputMarca = function () {
    let MarcaMayus =  inputsNuevoArticulo.Marca.value.toUpperCase();
     inputsNuevoArticulo.Marca.value = MarcaMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio( inputsNuevoArticulo.Marca);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras( inputsNuevoArticulo.Marca, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio( inputsNuevoArticulo.Marca);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter( inputsNuevoArticulo.Marca, validaciones.caracterMas3veces);
    }
}