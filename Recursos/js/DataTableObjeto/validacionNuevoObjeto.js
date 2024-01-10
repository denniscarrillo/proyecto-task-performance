import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus

let estadoMasdeUnEspacioObjeto = true;
let estadoMasdeUnEspacioDescripcion = true;
const $form = document.getElementById('form-Nuevo-Objeto');
const $objeto = document.getElementById('objeto');
const $descripcion = document.getElementById('descripcion');

//Validar inputs
$form.addEventListener('submit', (e) => {
    estadoValidado = false;
    let estadoInputobjeto = funciones.validarCampoVacio($objeto);
    let estadoInputdescripcion = funciones.validarCampoVacio($descripcion);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputobjeto == false || estadoInputdescripcion == false) {
        e.preventDefault();
    } else {
    if (estadoMasdeUnEspacioObjeto == false || estadoMasdeUnEspacioDescripcion) {
                e.preventDefault();
                estadoMasdeUnEspacioObjeto = funciones.validarMasdeUnEspacio($objeto);
                estadoMasdeUnEspacioDescripcion = funciones.validarMasdeUnEspacio($descripcion);
            } else {
                   estadoValidado = true; // 
            }
    }
});

$objeto.addEventListener('keyup', ()=>{
    funciones.validarCampoVacio($objeto);
    funciones.limitarCantidadCaracteres('objeto', 45);
});

$objeto.addEventListener('focusout', ()=>{
    funciones.validarCampoVacio($objeto);
    funciones.limitarCantidadCaracteres('objeto', 45);
});

$objeto.addEventListener('focusout', ()=>{
  estadoMasdeUnEspacioObjeto= funciones.validarMasdeUnEspacio($objeto);
});



$descripcion.addEventListener('keyup', ()=>{
    funciones.validarCampoVacio($descripcion);
    funciones.limitarCantidadCaracteres('objeto', 45);
});

$descripcion.addEventListener('focusout', ()=>{
    funciones.validarCampoVacio($descripcion);
    funciones.limitarCantidadCaracteres('descripcion', 45);
});

$descripcion.addEventListener('focusout', ()=>{
  estadoMasdeUnEspacioDescripcion= funciones.validarMasdeUnEspacio($descripcion);
});

