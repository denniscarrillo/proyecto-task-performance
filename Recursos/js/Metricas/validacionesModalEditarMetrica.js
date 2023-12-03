import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloNumeros: /^[0-9]*$/
    // soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    // correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    
}
let estadoSoloNumeros = {
    estadoNumerosMeta: true,
}
let estadoMasdeUnEspacio = {
    estadoMasEspacioMeta: true
}
let estadoMayorCero = {
    estadoMayorCeroMeta: true
}
const $form = document.getElementById('form-Edit-Metrica');
const $meta = document.getElementById('E_meta');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {  
    estadoValidado = false; 
    //Validamos que algún campo no esté vacío.
    let estadoInputMeta = funciones.validarCampoVacio($meta);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputMeta == false) {
        e.preventDefault();
    } else {    
        if(estadoSoloNumeros.estadoNumerosMeta == false){
            e.preventDefault();
            estadoSoloNumeros.estadoNumerosMeta = funciones.validarSoloNumeros($meta, validaciones.soloNumeros);
            
        }else {
            if(estadoMasdeUnEspacio.estadoMasEspacioMeta == false){
            e.preventDefault();
            estadoMasdeUnEspacio.estadoMasEspacioMeta = funciones.validarMasdeUnEspacio($meta);
        } else {
            if(estadoMayorCero.estadoMayorCeroMeta == false){
                e.preventDefault();
                estadoMayorCero.estadoMayorCeroMeta = funciones.MayorACero($meta);
            } else {
                estadoValidado = true; 
                }                  
            }    
        }
    }

});
$meta.addEventListener('keyup', ()=>{
     estadoSoloNumeros.estadoNumerosMeta = funciones.validarSoloNumeros($meta, validaciones.soloNumeros);
    funciones.limitarCantidadCaracteres("E_meta", 14);
});
$meta.addEventListener('focusout', ()=>{
    estadoMasdeUnEspacio.estadoMasEspacioMeta = funciones.validarMasdeUnEspacio($meta);
});

$meta.addEventListener('focusout', () => {
    estadoMayorCero.estadoMayorCeroMeta = funciones.MayorACero($meta);
});

$meta.addEventListener('keyup', ()=>{
    estadoMayorCero.estadoMayorCeroMeta = funciones.MayorACero($meta);
});
