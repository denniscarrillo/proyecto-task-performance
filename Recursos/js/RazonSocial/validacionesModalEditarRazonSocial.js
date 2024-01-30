import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus



// const $form = document.getElementById('form-Edit_razonSocial');
// const $razonSocial = document.getElementById('E_razonSocial');
// const $descripcion = document.getElementById('E_descripcion');
const validaciones = {
    caracterMas3Veces: /^(?=.*(..)\1)/,
}
let inputsNuevaRazonSocial = {
    // razonSocial: document.getElementById('E_razonSocial'),
    descripcion: document.getElementById('E_descripcion')
}

// let btnGuardar = document.getElementById('btn-submit');
$(document).ready(function(){
    document.getElementById("btn-submit").addEventListener("click", () => {
        // validarInputRazonSocial();
        validarInputDescripcion();
        if (
          document.querySelectorAll(".mensaje_error").length == 0
        ) {
          estadoValidado = true;
        }
      });
})
inputsNuevaRazonSocial.descripcion.addEventListener('keyup', ()=>{
    validarInputDescripcion();
    funciones.limitarCantidadCaracteres('E_descripcion', 300);
});

//Validar inputs
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