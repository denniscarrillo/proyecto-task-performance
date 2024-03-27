import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ.\s.,])/,// Letras, acentos y Ñ, también permite punto // Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};


let inputsNuevoObjeto = {
    nombreObjeto:  document.getElementById('objeto'),
    descripcionObjeto: document.getElementById('descripcion')
}
let btnGuardar = document.getElementById('btn-submit');

btnGuardar.addEventListener('click', () => {
    validarInputNombreObjeto();
    validarInputDescripcionObjeto();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValidado = true;
    }else{
        estadoValidado = false;
    }
});

let validarInputNombreObjeto = function () {
    let nombreObjetoMayus = inputsNuevoObjeto.nombreObjeto.value.toUpperCase();
    inputsNuevoObjeto.nombreObjeto.value = nombreObjetoMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuevoObjeto.nombreObjeto);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputsNuevoObjeto.nombreObjeto, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuevoObjeto.nombreObjeto);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuevoObjeto.nombreObjeto, validaciones.caracterMas3veces);
    }
}

let validarInputDescripcionObjeto = function () {
    let descripcionObjetoMayus = inputsNuevoObjeto.descripcionObjeto.value.toUpperCase();
    inputsNuevoObjeto.descripcionObjeto.value = descripcionObjetoMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuevoObjeto.descripcionObjeto);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputsNuevoObjeto.descripcionObjeto, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuevoObjeto.descripcionObjeto);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuevoObjeto.descripcionObjeto, validaciones.caracterMas3veces);
    }
}


/////////////////////////editar objetos///////////////////////////////////////

// let inputseditarObjeto = {
//     nombreObjeto:  document.getElementById('A_objeto'),
//     descripcionObjeto: document.getElementById('A_descripcion')
// }
// let btneditarGuardar = document.getElementById('btn-submit');

// btneditarGuardar.addEventListener('click', () => {
//     validarInputeditarNombreObjeto();
//     validarInputeditarDescripcionObjeto();
//     if (document.querySelectorAll(".mensaje_error").length == 0) {
//         estadoValidado = true;
//     }
// });

// let validarInputeditarNombreObjeto = function () {
//     let nombreObjetoMayus = inputseditarObjeto.nombreObjeto.value.toUpperCase();
//     inputseditarObjeto.nombreObjeto.value = nombreObjetoMayus;
//     let estadoValidaciones = {
//         estadoCampoVacio: false,
//         estadoSoloLetras: false,
//         estadoNoMasdeUnEspacios: false,
//         estadoNoCaracteresSeguidos: false
//     }
//     estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarObjeto.nombreObjeto);
//     if(estadoValidaciones.estadoCampoVacio) {
//         estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputseditarObjeto.nombreObjeto, validaciones.soloLetras);
//     } 
//     if(estadoValidaciones.estadoSoloLetras) {
//         estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarObjeto.nombreObjeto);
//     }
//     if(estadoValidaciones.estadoNoMasdeUnEspacios) {
//         estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarObjeto.nombreObjeto, validaciones.caracterMas3veces);
//     }
// }

// let validarInputeditarDescripcionObjeto = function () {
//     let descripcionObjetoMayus = inputseditarObjeto.descripcionObjeto.value.toUpperCase();
//     inputseditarObjeto.descripcionObjeto.value = descripcionObjetoMayus;
//     let estadoValidaciones = {
//         estadoCampoVacio: false,
//         estadoSoloLetras: false,
//         estadoNoMasdeUnEspacios: false,
//         estadoNoCaracteresSeguidos: false
//     }
//     estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarObjeto.descripcionObjeto);
//     if(estadoValidaciones.estadoCampoVacio) {
//         estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputseditarObjeto.descripcionObjeto, validaciones.soloLetras);
//     } 
//     if(estadoValidaciones.estadoSoloLetras) {
//         estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarObjeto.descripcionObjeto);
//     }
//     if(estadoValidaciones.estadoNoMasdeUnEspacios) {
//         estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarObjeto.descripcionObjeto, validaciones.caracterMas3veces);
//     }
// }



// // $form.addEventListener('submit', (e) => {
// //     estadoValidado = false;
// //     let estadoInputobjeto = funciones.validarCampoVacio($objeto);
// //     let estadoInputdescripcion = funciones.validarCampoVacio($descripcion);
// //     // Comprobamos que todas las validaciones se hayan cumplido 
// //     if (estadoInputobjeto == false || estadoInputdescripcion == false) {
// //         e.preventDefault();
// //     } else {
// //     if (estadoMasdeUnEspacioObjeto == false || estadoMasdeUnEspacioDescripcion) {
// //                 e.preventDefault();
// //                 estadoMasdeUnEspacioObjeto = funciones.validarMasdeUnEspacio($objeto);
// //                 estadoMasdeUnEspacioDescripcion = funciones.validarMasdeUnEspacio($descripcion);
// //             } else {
// //                    estadoValidado = true; // 
// //             }
// //     }
// // });

// // $objeto.addEventListener('keyup', ()=>{
// //     funciones.validarCampoVacio($objeto);
// //     funciones.limitarCantidadCaracteres('objeto', 45);
// // });

// // $objeto.addEventListener('focusout', ()=>{
// //     funciones.validarCampoVacio($objeto);
// //     funciones.limitarCantidadCaracteres('objeto', 45);
// // });

// // $objeto.addEventListener('focusout', ()=>{
// //   estadoMasdeUnEspacioObjeto= funciones.validarMasdeUnEspacio($objeto);
// // });



// // $descripcion.addEventListener('keyup', ()=>{
// //     funciones.validarCampoVacio($descripcion);
// //     funciones.limitarCantidadCaracteres('objeto', 45);
// // });

// // $descripcion.addEventListener('focusout', ()=>{
// //     funciones.validarCampoVacio($descripcion);
// //     funciones.limitarCantidadCaracteres('descripcion', 45);
// // });

// // $descripcion.addEventListener('focusout', ()=>{
// //   estadoMasdeUnEspacioDescripcion= funciones.validarMasdeUnEspacio($descripcion);
// // });