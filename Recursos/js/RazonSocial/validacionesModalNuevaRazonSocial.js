import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus

let estadoExisteRazonSocial= false;


const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z.\s])/, // Letras y espacios
    caracterMas3Veces: /^(?=.*(..)\1)/,
}

let inputsNuevaRazonSocial = {
    razonSocial: document.getElementById('razonSocial'),
    descripcion: document.getElementById('descripcion')
}

// let btnGuardar = document.getElementById('btn-submit');
$(document).ready(function(){
    document.getElementById("btn-submit").addEventListener("click", () => {
        validarInputRazonSocial();
        validarInputDescripcion();
        if (
          document.querySelectorAll(".mensaje_error").length == 0
        ) {
          estadoValidado = true;
        }
      });
})
// const $form = document.getElementById('form-razonSocial');
// const $razonSocial = document.getElementById('razonSocial');
// const $descripcion = document.getElementById('descripcion');

inputsNuevaRazonSocial.razonSocial.addEventListener('keyup', ()=>{
    validarInputRazonSocial();
    funciones.limitarCantidadCaracteres('razonSocial', 50);
});
// inputsNuevaRazonSocial.razonSocial.addEventListener('focusout', ()=>{
//     let razonSocialMayus = inputsNuevaRazonSocial.razonSocial.value.toUpperCase();
//     inputsNuevaRazonSocial.razonSocial.value = razonSocialMayus
// });
inputsNuevaRazonSocial.descripcion.addEventListener('keyup', ()=>{
    validarInputDescripcion();
    funciones.limitarCantidadCaracteres('descripcion', 300);
});
// inputsNuevaRazonSocial.descripcion.addEventListener('focusout', ()=>{
//     let descripcionMayus = inputsNuevaRazonSocial.descripcion.value.toUpperCase();
//     inputsNuevaRazonSocial.descripcion.value = descripcionMayus;
// });
let validarInputRazonSocial = () => {
   let razonMayus = inputsNuevaRazonSocial.razonSocial.value.toUpperCase();
   inputsNuevaRazonSocial.razonSocial.value = razonMayus;
   let razonSocialValidaciones = {
    estadoVacio: false,
    estadoMasEspacio: false,
    estadoSoloLetras: false,
    estadoLimiteCaracter: false,
    estadoExisteRazonSocial: false, 
    
 };
    razonSocialValidaciones.estadoVacio = funciones.validarCampoVacio(inputsNuevaRazonSocial.razonSocial);
    razonSocialValidaciones.estadoVacio ? (razonSocialValidaciones.estadoMasEspacio = 
    funciones.validarMasdeUnEspacio(inputsNuevaRazonSocial.razonSocial))
    : '';
    razonSocialValidaciones.estadoMasEspacio ? (razonSocialValidaciones.estadoSoloLetras = 
    funciones.validarSoloLetras(inputsNuevaRazonSocial.razonSocial, validaciones.soloLetras))
    : '';
    razonSocialValidaciones.estadoSoloLetras ? (razonSocialValidaciones.estadoLimiteCaracter =
        funciones.limiteMismoCaracter(inputsNuevaRazonSocial.razonSocial, validaciones.caracterMas3Veces))
        : '';
        razonSocialValidaciones.estadoSoloLetras ? (estadoExisteRazonSocial =
        obtenerRazonSocialExiste($('#razonSocial').val()))
        :'';
};


let validarInputDescripcion = () => {
    let descripcionMayus = inputsNuevaRazonSocial.descripcion.value.toUpperCase();
    inputsNuevaRazonSocial.descripcion.value = descripcionMayus;
    let descripcionValidaciones = {
        descripcionVacio: false,
        descripcionMasEspacio: false,
        descripcionLimiteCaracter: false,
    }
    descripcionValidaciones.descripcionVacio = funciones.validarCampoVacio(inputsNuevaRazonSocial.descripcion);
    descripcionValidaciones.descripcionVacio ? (descripcionValidaciones.descripcionMasEspacio =
        funciones.validarMasdeUnEspacio(inputsNuevaRazonSocial.descripcion))
        :'';
        descripcionValidaciones.descripcionMasEspacio ? (descripcionValidaciones.descripcionLimiteCaracter =
            funciones.limiteMismoCaracter(inputsNuevaRazonSocial.descripcion, validaciones.caracterMas3Veces))
        :'';
}
// //Validar inputs
// $form.addEventListener('submit', (e) => {
//     let estadoInputRazonSocial = funciones.validarCampoVacio($razonSocial);
//     let estadoInputDescripcion = funciones.validarCampoVacio($descripcion);
//     // Comprobamos que todas las validaciones se hayan cumplido 
//     if (estadoInputRazonSocial == false || estadoInputDescripcion == false) {
//         e.preventDefault();
//     } else {
//     if (estadoMasdeUnEspacioRazonSocial == false || estadoMasdeUnEspacioDescripcion == false) {
//                 e.preventDefault();
//                 estadoMasdeUnEspacioRazonSocial = funciones.validarMasdeUnEspacio($razonSocial);
//                 estadoMasdeUnEspacioDescripcion = funciones.validarMasdeUnEspacio($descripcion);
//             } else {
//                 if(estadoExisteRazonSocial == false){
//                     e.preventDefault();
//                     estadoExisteRazonSocial = obtenerRazonSocialExiste($('#razonSocial').val());
//             } else {
//                    estadoValidado = true; // 
//             }
//         }
//     }
// });

// $razonSocial.addEventListener('keyup', ()=>{
//     funciones.validarCampoVacio($razonSocial);
//     funciones.limitarCantidadCaracteres('razonSocial', 50);
    
// });
// $razonSocial.addEventListener('focusout', ()=>{
//    let razonesSociales = estadoMasdeUnEspacioRazonSocial = funciones.validarMasdeUnEspacio($razonSocial);
//    if(razonesSociales){
//          let razonSocial = $('#razonSocial').val();
//          estadoExisteRazonSocial = obtenerRazonSocialExiste(razonSocial);
//    }
//    let razonSocialMayus = $razonSocial.value.toUpperCase();
//     $razonSocial.value = razonSocialMayus;
// });
// $descripcion.addEventListener('keyup', ()=>{
//     funciones.validarCampoVacio($descripcion);
//     funciones.limitarCantidadCaracteres('descripcion', 300);
// });
// $descripcion.addEventListener('focusout', ()=>{
//     estadoMasdeUnEspacioDescripcion = funciones.validarMasdeUnEspacio($descripcion);
//     let descripcionMayus = $descripcion.value.toUpperCase();
//     $descripcion.value = descripcionMayus;
// });
// /* $pregunta.addEventListener('keyup', ()=>{
//     estadoSoloLetras.estadoLetrasPregunta = funciones.validarSoloLetras($pregunta, validaciones.soloLetras);
// }); */

let obtenerRazonSocialExiste = ($razonSocial) => {
    $.ajax({
        url: "../../../Vista/crud/razonSocial/razonSocialExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            razonSocial: $razonSocial
        },
        success: function (razonSocial) {
            let $objRazonSocial = JSON.parse(razonSocial);
            if ($objRazonSocial.estado == 'true') {
                document.getElementById('razonSocial').classList.add('mensaje_error');
                document.getElementById('razonSocial').parentElement.querySelector('p').innerText = '*La Razon Social ya existe';
                estadoExisteRazonSocial = false; // razonSocial es existente, es false
            } else {
                document.getElementById('razonSocial').classList.remove('mensaje_error');
                document.getElementById('razonSocial').parentElement.querySelector('p').innerText = '';
                estadoExisteRazonSocial = true; // Preunta no existe, es true
            }
        }
        
    });
}