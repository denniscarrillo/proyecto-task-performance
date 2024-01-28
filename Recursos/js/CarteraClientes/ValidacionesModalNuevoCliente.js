import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
  };
let inputNuevoCliente = {
    nombre: document.getElementById('nombre'),
    rtn: document.getElementById('rtn'),
    telefono: document.getElementById('telefono'),
    correo: document.getElementById('correo'),
    direccion: document.getElementById('direccion')
}
$(document).ready(function (){
    //Evento clic para hacer todas las validaciones
  document.getElementById("btn-submit").addEventListener("click", () => {
    validarInputNombre();
    validarInputRTN();
    if (
      document.querySelectorAll(".mensaje_error").length == 0 &&
      document.querySelectorAll(".mensaje-existe-cliente").length == 0
    ) {
      estadoValidado = true;
    }else{
      estadoValidado = false;
    }
  });
})
inputNuevoCliente.nombre.addEventListener("keyup", ()=>{
    validarInputNombre();
    funciones.limitarCantidadCaracteres("nombre", 40);
})
inputNuevoCliente.rtn.addEventListener("keyup", ()=>{
    validarInputRTN();
    funciones.limitarCantidadCaracteres("rtn", 20);
})
let validarInputNombre = () =>{
    inputNuevoCliente.nombre.value = inputNuevoCliente.nombre.value.toUpperCase();
  let estadoValidacion = {
      estCampoVacio: false,
      estSoloLetras: false,
      estaMasDeUnEspacio: false,
      estMismoCaracter: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
    inputNuevoCliente.nombre
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estSoloLetras = funciones.validarSoloLetras(
    inputNuevoCliente.nombre, 
    validaciones.soloLetras
  )):"";
  estadoValidacion.estSoloLetras
  ?(estadoValidacion.estaMasDeUnEspacio = funciones.validarMasdeUnEspacio(
    inputNuevoCliente.nombre
  )):"";
  estadoValidacion.estaMasDeUnEspacio
  ?(estadoValidacion.estMismoCaracter = funciones.limiteMismoCaracter(
    inputNuevoCliente.nombre,
    validaciones.caracterMas3veces
  )):"";
  estadoValidacion.estMismoCaracter 
  ? funciones.caracteresMinimo(inputNuevoCliente.nombre, 3):"";
}
let validarInputRTN = () =>{
    inputNuevoCliente.rtn.value = inputNuevoCliente.rtn.value.toUpperCase();
  let estadoValidacion = {
      estCampoVacio: false,
      estSoloNumeros: false,
      estaMasDeUnEspacio: false,
      estMismoCaracter: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
    inputNuevoCliente.rtn
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estSoloNumeros = funciones.validarSoloNumeros(
    inputNuevoCliente.rtn, 
    validaciones.soloNumeros
  )):"";
  estadoValidacion.estSoloNumeros
  ?(estadoValidacion.estaMasDeUnEspacio = funciones.validarMasdeUnEspacio(
    inputNuevoCliente.rtn
  )):"";
  estadoValidacion.estaMasDeUnEspacio
  ?(estadoValidacion.estMismoCaracter = funciones.limiteMismoCaracter(
    inputNuevoCliente.rtn,
    validaciones.caracterMas3veces
  )):"";
  estadoValidacion.estMismoCaracter 
  ? funciones.caracteresMinimo(inputNuevoCliente.rtn, 13):"";
}

