import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus

let estadoRubroComercialExiste = false;


// const $form = document.getElementById('form-Edit_rubroComercial');
// const $rubroComercial = document.getElementById('E_rubroComercial');
// const $descripcion = document.getElementById('E_descripcion');

const validaciones = {
    caracterMas3Veces: /^(?=.*(..)\1)/,
}
let inputsEditarRubroC = {
    descripcion: document.getElementById('E_descripcion')
}
$(document).ready(function(){
    document.getElementById("btn-submit").addEventListener("click", () => {
        // ValidarInputRubroC();
        ValidarInputDescrip();
        if (
          document.querySelectorAll(".mensaje_error").length == 0
        ) {
          estadoValidado = true;
        }
      });
});
inputsEditarRubroC.descripcion.addEventListener('keyup', ()=>{
    ValidarInputDescrip();
    funciones.limitarCantidadCaracteres('E_descripcion', 300);
})

//Validar Descripcion
let ValidarInputDescrip = () =>{
    let descripcionMayus = inputsEditarRubroC.descripcion.value.toUpperCase();
    inputsEditarRubroC.descripcion.value = descripcionMayus;
    let descripcionValidaciones = {
        descripcionVacio: false,
        descripcionMasEspacio: false,
        descripcionLimiteCaracter: false,
    }
    descripcionValidaciones.descripcionVacio = funciones.validarCampoVacio(inputsEditarRubroC.descripcion);
    descripcionValidaciones.descripcionVacio ? (descripcionValidaciones.descripcionMasEspacio =
        funciones.validarMasdeUnEspacio(inputsEditarRubroC.descripcion))
        :'';
        descripcionValidaciones.descripcionMasEspacio ? (descripcionValidaciones.descripcionLimiteCaracter =
            funciones.limiteMismoCaracter(inputsEditarRubroC.descripcion, validaciones.caracterMas3Veces))
        :'';
};
