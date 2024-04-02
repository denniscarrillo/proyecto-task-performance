import * as funciones from '../funcionesValidaciones.js';
export let validarEditar = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    descripcion: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ.\s.,])/, // Letras, acentos y Ñ, también permite punto // Solo letras
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
  };
const $descripcion = document.getElementById("E_descripcion");
let inputEditarRol = {
    descripcion: document.getElementById('E_descripcion')
}
$(document).ready(function (){
    //Evento clic para hacer todas las validaciones
  document.getElementById("btn-guardar").addEventListener("click", () => {
    validarInputDescripcion();
    if (
      document.querySelectorAll(".mensaje_error").length == 0 &&
      document.querySelectorAll(".mensaje-existe-rol").length == 0
    ) {
        validarEditar = true;
    }else{
        validarEditar = false;
    }
  });
})

inputEditarRol.descripcion.addEventListener("keyup", ()=>{
    validarInputDescripcion();
    funciones.limitarCantidadCaracteres("E_descripcion", 45);
})
$descripcion.addEventListener("input", () => {
  funciones.convertirAMayusculasVisualmente($descripcion);
  validarInputDescripcion
});
$descripcion.addEventListener("keydown", () => {
  funciones.soloLetrasYPuntosYComas($descripcion)
});
let validarInputDescripcion = () =>{
    inputEditarRol.descripcion.value = inputEditarRol.descripcion.value.toUpperCase();
    let estadoValidacion = {
        estCampoVacio: false,
        estSoloLetras: false,
        estaMasDeUnEspacio: false,
        estMismoCaracter: false,
    }
    estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
      inputEditarRol.descripcion
    );
    estadoValidacion.estCampoVacio
    ? (estadoValidacion.estSoloLetras = funciones.validarSoloLetras(
      inputEditarRol.descripcion, 
      validaciones.descripcion
    )):"";
    estadoValidacion.estSoloLetras
    ?(estadoValidacion.estaMasDeUnEspacio = funciones.validarMasdeUnEspacio(
      inputEditarRol.descripcion
    )):"";
    estadoValidacion.estaMasDeUnEspacio
    ?(estadoValidacion.estMismoCaracter = funciones.limiteMismoCaracter(
      inputEditarRol.descripcion,
      validaciones.caracterMas3veces
    )):"";
    estadoValidacion.estMismoCaracter 
    ? funciones.caracteresMinimo(inputEditarRol.descripcion, 7):"";
  }
