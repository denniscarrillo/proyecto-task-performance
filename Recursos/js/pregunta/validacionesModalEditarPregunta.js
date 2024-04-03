import * as funciones from '../funcionesValidaciones.js';
export let validarEditar = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
  soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s,.\¿?])/,//Solo letras
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
  };
const $pregunta = document.getElementById("pregunta_E");
let inputEditarPregunta = document.getElementById("pregunta_E");
$(document).ready(function (){
    //Evento clic para hacer todas las validaciones
  document.getElementById("btn-guardar").addEventListener("click", () => {
    validarEditarPregunta();
    if (
      document.querySelectorAll(".mensaje_error").length == 0 &&
      document.querySelectorAll(".mensaje-existe-pregunta").length == 0
    ) {
      validarEditar = true;
    }else{
      validarEditar = false;
    }
  });
})
inputEditarPregunta.addEventListener("keyup", ()=>{
    validarEditarPregunta();
    funciones.limitarCantidadCaracteres("pregunta_E", 100);
})
$pregunta.addEventListener("input", () => {
  funciones.convertirAMayusculasVisualmente($pregunta);
  validarEditarPregunta();
});
$pregunta.addEventListener("keydown", () => {
  funciones.soloLetrasYPuntosYSignos($pregunta)
});
let validarEditarPregunta = () =>{
  inputEditarPregunta.value = inputEditarPregunta.value.toUpperCase();
  let estadoValidacion = {
      estCampoVacio: false,
      estSoloLetras: false,
      estaMasDeUnEspacio: false,
      estMismoCaracter: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
      inputEditarPregunta
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estSoloLetras = funciones.validarSoloLetras(
      inputEditarPregunta, 
      validaciones.soloLetras
  )):"";
  estadoValidacion.estSoloLetras
  ?(estadoValidacion.estaMasDeUnEspacio = funciones.validarMasdeUnEspacio(
      inputEditarPregunta
  )):"";
  estadoValidacion.estaMasDeUnEspacio
  ?(estadoValidacion.estMismoCaracter = funciones.limiteMismoCaracter(
      inputEditarPregunta,
      validaciones.caracterMas3veces
  )):"";
  estadoValidacion.estMismoCaracter 
  ? funciones.caracteresMinimo(inputEditarPregunta, 7):"";
}




