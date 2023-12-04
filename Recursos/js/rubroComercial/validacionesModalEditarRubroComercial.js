import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus

let estadoRubroComercialExiste = false;
let estadoMasDeUnEspacioRubroComercial = true;
let estadoMasdeUnEspacioDescripcion = true;

const $form = document.getElementById('form-Edit_rubroComercial');
const $rubroComercial = document.getElementById('E_rubroComercial');
const $descripcion = document.getElementById('E_descripcion');

//Validar inputs
$form.addEventListener('submit', (e) => {
    let estadoInputRubroComercial = funciones.validarCampoVacio($rubroComercial);
    let estadoInputDescripcion = funciones.validarCampoVacio($descripcion);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputRubroComercial == false || estadoInputDescripcion == false) {
        e.preventDefault();
    } else {
    if (estadoMasDeUnEspacioRubroComercial == false || estadoMasdeUnEspacioDescripcion == false) {
                e.preventDefault();
                estadoMasDeUnEspacioRubroComercial = funciones.validarMasdeUnEspacio($rubroComercial);
                estadoMasdeUnEspacioDescripcion = funciones.validarMasdeUnEspacio($descripcion);
            } else {
                   estadoValidado = true; // 
        }
    }
});

$rubroComercial.addEventListener('keyup', ()=>{
    funciones.validarCampoVacio($rubroComercial);
    funciones.limitarCantidadCaracteres('E_rubroComercial', 50);
    
});
$rubroComercial.addEventListener('focusout', ()=>{
   estadoMasDeUnEspacioRubroComercial = funciones.validarMasdeUnEspacio($rubroComercial);
   let rubroComercialMayus = $rubroComercial.value.toUpperCase();
    $rubroComercial.value = rubroComercialMayus;
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

// let obtenerRubroComercialExiste = ($rubroComercial) => {
//     $.ajax({
//         url: "../../../Vista/crud/rubroComercial/rubroComercialExistente.php",
//         type: "POST",
//         datatype: "JSON",
//         data: {
//             rubroComercial: $rubroComercial
//         },
//         success: function (rubroComercial) {
//             let $ObjRubroComercial = JSON.parse(rubroComercial);
//             if ($ObjRubroComercial.estado == 'true') {
//                 document.getElementById('rubroComercial').classList.add('mensaje_error');
//                 document.getElementById('rubroComercial').parentElement.querySelector('p').innerText = '*El Rubro Comercial ya existe';
//                 estadoRubroComercialExiste = false; // rubroComercial es existente, es false
//             } else {
//                 document.getElementById('rubroComercial').classList.remove('mensaje_error');
//                 document.getElementById('rubroComercial').parentElement.querySelector('p').innerText = '';
//                 estadoRubroComercialExiste = true; // Preunta no existe, es true
//             }
//         }
        
//     });
// }