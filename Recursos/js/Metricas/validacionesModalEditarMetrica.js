import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloNumeros: /^[0-9]*$/
    // soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    // correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    
}
//VARIABLES GLOBALES
// let estadoSoloLetras = {
//     estadoLetrasName: true,
// }
let estadoSelect = true;

let estadoSoloNumeros = {
    estadoNumerosMeta: true,
}
const $form = document.getElementById('form-Edit-Metrica');
const $descripcion = document.getElementById('E_descripcion');
const $meta = document.getElementById('E_meta');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputDescripcion = funciones.validarCampoVacio($descripcion);
    let estadoInputMeta = funciones.validarCampoVacio($meta);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputDescripcion == false || estadoInputMeta == false) {
        e.preventDefault();
    } else {
            if(estadoSelect == false){
                e.preventDefault();
                estadoSelect = funciones.validarCampoVacio($descripcion);           
            }
              else{
                   if(estadoSoloNumeros.estadoNumerosMeta == false){
                    e.preventDefault();
                    estadoSoloNumeros.estadoNumerosMeta = funciones.validarSoloNumeros($meta, validaciones.soloNumeros);
                  } 
                    else {
                    estadoValidado = true;
                    console.log(estadoValidado); // 
                }
            
            }       
            
        }
});
// // $name.addEventListener('keyup', ()=>{
// //     estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
// //     $("#nombre").inputlimiter({
// //         limit: 50
// //     });
// // });
// // $name.addEventListener('focusout', ()=>{
// //     let usuarioMayus = $name.value.toUpperCase();
// //     $name.value = usuarioMayus;
// // });

// $meta.addEventListener('keyup', ()=>{
//      estadoSoloNumeros.estadoNumerosMeta = funciones.validarSoloNumeros($meta, validaciones.soloNumeros);
//     $("#E_meta").inputlimiter({
//        limit: 14
//     });
// });

// $descripcion.addEventListener('change', ()=>{
//     estadoSelect = funciones.validarCampoVacio($descripcion);
// });