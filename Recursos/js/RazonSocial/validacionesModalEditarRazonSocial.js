import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus

let estadoMasdeUnEspacioRazonSocial = true;
let estadoMasdeUnEspacioDescripcion = true;

const $form = document.getElementById('form-Edit_razonSocial');
const $razonSocial = document.getElementById('E_razonSocial');
const $descripcion = document.getElementById('E_descripcion');

//Validar inputs
$form.addEventListener('submit', (e) => {
    let estadoInputRazonSocial = funciones.validarCampoVacio($razonSocial);
    let estadoInputDescripcion = funciones.validarCampoVacio($descripcion);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputRazonSocial == false || estadoInputDescripcion == false) {
        e.preventDefault();
    } else {
    if (estadoMasdeUnEspacioRazonSocial == false || estadoMasdeUnEspacioDescripcion == false) {
                e.preventDefault();
                estadoMasdeUnEspacioRazonSocial = funciones.validarMasdeUnEspacio($razonSocial);
                estadoMasdeUnEspacioDescripcion = funciones.validarMasdeUnEspacio($descripcion);
            } else {
                   estadoValidado = true; // 
        }
    }
});

$razonSocial.addEventListener('keyup', ()=>{
    funciones.validarCampoVacio($razonSocial);
    funciones.limitarCantidadCaracteres('E_razonSocial', 50);
    
});
$razonSocial.addEventListener('focusout', ()=>{
   estadoMasdeUnEspacioRazonSocial = funciones.validarMasdeUnEspacio($razonSocial);
//    if(razonesSociales){
//          let razonSocial = $('#E_razonSocial').val();
//          estadoExisteRazonSocial = obtenerRazonSocialExiste(razonSocial);
//    }
   let razonSocialMayus = $razonSocial.value.toUpperCase();
    $razonSocial.value = razonSocialMayus;
});
$descripcion.addEventListener('keyup', ()=>{
    funciones.validarCampoVacio($descripcion);
    funciones.limitarCantidadCaracteres('E_descripcion', 300);
});
$descripcion.addEventListener('focusout', ()=>{
    estadoMasdeUnEspacioDescripcion = funciones.validarMasdeUnEspacio($descripcion);
    let descripcionMayus = $descripcion.value.toUpperCase();
    $descripcion.value = descripcionMayus;
});
/* $pregunta.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasPregunta = funciones.validarSoloLetras($pregunta, validaciones.soloLetras);
}); */

// let obtenerRazonSocialExiste = ($razonSocial) => {
//     $.ajax({
//         url: "../../../Vista/crud/razonSocial/razonSocialExistente.php",
//         type: "POST",
//         datatype: "JSON",
//         data: {
//             razonSocial: $razonSocial
//         },
//         success: function (razonSocial) {
//             let $objRazonSocial = JSON.parse(razonSocial);
//             if ($objRazonSocial.estado == 'true') {
//                 document.getElementById('E_razonSocial').classList.add('mensaje_error');
//                 document.getElementById('E_razonSocial').parentElement.querySelector('p').innerText = '*La Razon Social ya existe';
//                 estadoExisteRazonSocial = false; // razonSocial es existente, es false
//             } else {
//                 document.getElementById('E_razonSocial').classList.remove('mensaje_error');
//                 document.getElementById('E_razonSocial').parentElement.querySelector('p').innerText = '';
//                 estadoExisteRazonSocial = true; // Preunta no existe, es true
//             }
//         }
        
//     });
// }