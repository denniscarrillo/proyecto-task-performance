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
const $form = document.getElementById('form-Edit-Metrica');
const $meta = document.getElementById('E_meta');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
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
            estadoValidado = true;
        }     
    }
});
$meta.addEventListener('keyup', ()=>{
     estadoSoloNumeros.estadoNumerosMeta = funciones.validarSoloNumeros($meta, validaciones.soloNumeros);
    funciones.limitarCantidadCaracteres("E_meta", 14);
});