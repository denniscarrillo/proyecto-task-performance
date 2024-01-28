import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus

let estadoRubroComercialExiste = false;
// let estadoMasDeUnEspacioRubroComercial = true;
// let estadoMasdeUnEspacioDescripcion = true;

// const $form = document.getElementById('form-rubroComercial');
// const $rubroComercial = document.getElementById('rubroComercial');
// const $descripcion = document.getElementById('descripcion');
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, // Letras y espacios
    caracterMas3Veces: /^(?=.*(..)\1)/,
}

let inputsNuvoRubroC = {
    rubroC: document.getElementById('rubroComercial'),
    descripcion: document.getElementById('descripcion')
}
$(document).ready(function(){
    document.getElementById("btn-submit").addEventListener("click", () => {
        ValidarInputRubroC();
        ValidarInputDescrip();
        if (
          document.querySelectorAll(".mensaje_error").length == 0
        ) {
          estadoValidado = true;
        }
      });
});

inputsNuvoRubroC.rubroC.addEventListener('keyup', ()=>{
    ValidarInputRubroC();
    funciones.limitarCantidadCaracteres('rubroComercial', 50);
});
inputsNuvoRubroC.descripcion.addEventListener('keyup', ()=>{
    ValidarInputDescrip();
    funciones.limitarCantidadCaracteres('descripcion', 300);
});
//Validar inputs
let ValidarInputRubroC = () =>{
    let rubroMayus = inputsNuvoRubroC.rubroC.value.toUpperCase();
    inputsNuvoRubroC.rubroC.value = rubroMayus;
    let rubroValidaciones = {
        rubroVacio: false,
        rubroMasEspacio: false,
        rubroSoloLetras: false,
        rubroLimitecaracter: false,
        rubroexiste: false,
    }
    rubroValidaciones.rubroVacio =  funciones.validarCampoVacio(inputsNuvoRubroC.rubroC);
    rubroValidaciones.rubroVacio ? (rubroValidaciones.rubroMasEspacio =
    funciones.validarMasdeUnEspacio(inputsNuvoRubroC.rubroC))
        :'';
    rubroValidaciones.rubroMasEspacio ? (rubroValidaciones.rubroSoloLetras =
        funciones.validarSoloLetras(inputsNuvoRubroC.rubroC, validaciones.soloLetras))
        :'';
    rubroValidaciones.rubroSoloLetras ? (rubroValidaciones.rubroLimitecaracter =
        funciones.limiteMismoCaracter(inputsNuvoRubroC.rubroC, validaciones.caracterMas3Veces))
        :'';
};
let ValidarInputDescrip = () =>{
    let descripcionMayus = inputsNuvoRubroC.descripcion.value.toUpperCase();
    inputsNuvoRubroC.descripcion.value = descripcionMayus;
    let descripcionValidaciones = {
        descripcionVacio: false,
        descripcionMasEspacio: false,
        descripcionLimiteCaracter: false,
    }
    descripcionValidaciones.descripcionVacio = funciones.validarCampoVacio(inputsNuvoRubroC.descripcion);
    descripcionValidaciones.descripcionVacio ? (descripcionValidaciones.descripcionMasEspacio =
        funciones.validarMasdeUnEspacio(inputsNuvoRubroC.descripcion))
        :'';
        descripcionValidaciones.descripcionMasEspacio ? (descripcionValidaciones.descripcionLimiteCaracter =
            funciones.limiteMismoCaracter(inputsNuvoRubroC.descripcion, validaciones.caracterMas3Veces))
        :'';
};



let obtenerRubroComercialExiste = ($rubroComercial) => {
    $.ajax({
        url: "../../../Vista/crud/rubroComercial/rubroComercialExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            rubroComercial: $rubroComercial
        },
        success: function (rubroComercial) {
            let $ObjRubroComercial = JSON.parse(rubroComercial);
            if ($ObjRubroComercial.estado == 'true') {
                document.getElementById('rubroComercial').classList.add('mensaje_error');
                document.getElementById('rubroComercial').parentElement.querySelector('p').innerText = '*El Rubro Comercial ya existe';
                estadoRubroComercialExiste = false; // rubroComercial es existente, es false
            } else {
                document.getElementById('rubroComercial').classList.remove('mensaje_error');
                document.getElementById('rubroComercial').parentElement.querySelector('p').innerText = '';
                estadoRubroComercialExiste = true; // Preunta no existe, es true
            }
        }
        
    });
};