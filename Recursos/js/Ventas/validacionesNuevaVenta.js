import * as funciones from "../funcionesValidaciones.js";
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
  soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
  correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
  soloNumeros: /^[0-9 -]*$/,
  numerosDecimales: /^[0-9]+([.])?([0-9]+)?$/,
  caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
  caracterMas5veces: /^(?=.*(...)\1)/,
  letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
  direccion: /^[a-zA-Z0-9 #.,-]+$/,
};
$(document).ready(function (){
  document.getElementById("btn-submit").addEventListener("click", () => {
    validarInputRTN();
    validarInputTotalVenta();
    if (
      document.querySelectorAll(".mensaje_error").length == 0 &&
      document.querySelectorAll(".mensaje-existe-cliente").length == 0
    ) {
      estadoValidado = true;
    }else{
      estadoValidado = false;
    }
  });
});

let inputsNuevaVentas = {
    rtn: document.getElementById('rtn'),
    totalVenta: document.getElementById('totalVenta')
} 

inputsNuevaVentas.rtn.addEventListener('input', (event) => {
  if (!funciones.RTN_guion(event)) {
      event.preventDefault();
  }
  validarInputRTN();
  funciones.limitarCantidadCaracteres("rtn", 20);
});
inputsNuevaVentas.totalVenta.addEventListener("keyup", ()=>{
  validarInputTotalVenta();
  funciones.limitarCantidadCaracteres("totalVenta", 10)
});
let validarInputRTN = () => {
  let estadoValidaciones = {
    estadoSN: false,
    estadoCV: false,
    estadoME: false,
    estadoMO: false,
    estadoMC: false,
  };
  estadoValidaciones.estadoCV = funciones.validarCampoVacio(
    inputsNuevaVentas.rtn
  );
  estadoValidaciones.estadoCV
    ? (estadoValidaciones.estadoSN = funciones.validarSoloNumeros(
        inputsNuevaVentas.rtn,
        validaciones.soloNumeros
      ))
    : "";
  estadoValidaciones.estadoSN
    ? (estadoValidaciones.estadoME = funciones.validarEspacios(
        inputsNuevaVentas.rtn
      ))
    : "";
  estadoValidaciones.estadoME
    ? (estadoValidaciones.estadoMC = funciones.validarMismoNumeroConsecutivo(
        inputsNuevaVentas.rtn,
        validaciones.caracterMas5veces
      ))
    : "";
    estadoValidaciones.estadoMC
    ? funciones.caracteresMinimo(inputsNuevaVentas.rtn, 13)
    : "";
};
let validarInputTotalVenta = () => {
  let estadoValidaciones = {
    estadoSN: false,
    estadoME: false,
    estadoCV: false,
  };
  estadoValidaciones.estadoCV = funciones.validarCampoVacio(
    inputsNuevaVentas.totalVenta
  );
  estadoValidaciones.estadoCV
    ? (estadoValidaciones.estadoME = funciones.validarEspacios(
      inputsNuevaVentas.totalVenta
    )) 
    : "";
    estadoValidaciones.estadoME
    ? (estadoValidaciones.estadoSN = funciones.validarSoloNumeros(
        inputsNuevaVentas.totalVenta,
        validaciones.numerosDecimales
      ))
    : "";
    estadoValidaciones.estadoSN
    ? (estadoValidaciones.estadoMO = funciones.MayorACero(
      inputsNuevaVentas.totalVenta
    ))
    :"";
};
