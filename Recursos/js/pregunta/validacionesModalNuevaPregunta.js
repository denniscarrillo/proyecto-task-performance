import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
  };
let inputNuevaPregunta = document.getElementById("pregunta");
$(document).ready(function (){
    //Evento clic para hacer todas las validaciones
  document.getElementById("btn-submit").addEventListener("click", () => {
    validarInputPregunta();
    if (
      document.querySelectorAll(".mensaje_error").length == 0 &&
      document.querySelectorAll(".mensaje-existe-pregunta").length == 0
    ) {
      estadoValidado = true;
    }else{
      estadoValidado = false;
    }
  });
})
inputNuevaPregunta.addEventListener("keyup", ()=>{
    validarInputPregunta();
    funciones.limitarCantidadCaracteres("pregunta", 30);
})
let validarInputPregunta = () =>{
  inputNuevaPregunta.value = inputNuevaPregunta.value.toUpperCase();
  let estadoValidacion = {
      estCampoVacio: false,
      estSoloLetras: false,
      estaMasDeUnEspacio: false,
      estMismoCaracter: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
      inputNuevaPregunta
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estSoloLetras = funciones.validarSoloLetras(
      inputNuevaPregunta, 
      validaciones.soloLetras
  )):"";
  estadoValidacion.estSoloLetras
  ?(estadoValidacion.estaMasDeUnEspacio = funciones.validarMasdeUnEspacio(
      inputNuevaPregunta
  )):"";
  estadoValidacion.estaMasDeUnEspacio
  ?(estadoValidacion.estMismoCaracter = funciones.limiteMismoCaracter(
      inputNuevaPregunta,
      validaciones.caracterMas3veces
  )):"";
  estadoValidacion.estMismoCaracter 
  ? funciones.caracteresMinimo(inputNuevaPregunta, 7):"";
}
