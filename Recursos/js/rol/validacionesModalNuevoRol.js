import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    descripcion: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ.\s.,])/, // Letras, acentos y Ñ, también permite punto // Solo letras
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
  };
const $rol = document.getElementById("rol");
const $descripcion = document.getElementById("descripcion");
let inputEditarRol = {
    rol: document.getElementById('rol'),
    descripcion: document.getElementById('descripcion')
}
$(document).ready(function (){
    //Evento clic para hacer todas las validaciones
  document.getElementById("btn-submit").addEventListener("click", () => {
    validarInputRol();
    validarInputDescripcion();
    if (
      document.querySelectorAll(".mensaje_error").length == 0 &&
      document.querySelectorAll(".mensaje-existe-rol").length == 0
    ) {
      estadoValidado = true;
    }else{
      estadoValidado = false;
    }
  });
})
inputEditarRol.rol.addEventListener("keyup", ()=>{
    validarInputRol();
    funciones.limitarCantidadCaracteres("rol", 45);
})
$rol.addEventListener("input", () => {
  funciones.convertirAMayusculasVisualmente($rol);
  validarInputRol();
});
$rol.addEventListener("keydown", () => {
  funciones.soloLetrasConEspacios($rol)
});
inputEditarRol.descripcion.addEventListener("keyup", ()=>{
    validarInputDescripcion();
    funciones.limitarCantidadCaracteres("descripcion", 45);
})
$descripcion.addEventListener("input", () => {
  funciones.convertirAMayusculasVisualmente($descripcion);
  validarInputDescripcion();
});
$descripcion.addEventListener("keydown", () => {
  funciones.soloLetrasYPuntosYComas($descripcion)
});
let validarInputRol = () =>{
  inputEditarRol.rol.value = inputEditarRol.rol.value.toUpperCase();
  let estadoValidacion = {
      estCampoVacio: false,
      estSoloLetras: false,
      estaMasDeUnEspacio: false,
      estMismoCaracter: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
    inputEditarRol.rol
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estSoloLetras = funciones.validarSoloLetras(
    inputEditarRol.rol, 
    validaciones.soloLetras
  )):"";
  estadoValidacion.estSoloLetras
  ?(estadoValidacion.estaMasDeUnEspacio = funciones.validarMasdeUnEspacio(
    inputEditarRol.rol
  )):"";
  estadoValidacion.estaMasDeUnEspacio
  ?(estadoValidacion.estMismoCaracter = funciones.limiteMismoCaracter(
    inputEditarRol.rol,
    validaciones.caracterMas3veces
  )):"";
  estadoValidacion.estMismoCaracter 
  ? funciones.caracteresMinimo(inputEditarRol.rol, 7):"";
}
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
