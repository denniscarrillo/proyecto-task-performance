import * as funciones from '../funcionesValidaciones.js';
export let validarEditar = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\/ .ÑñáéíóúÁÉÍÓÚs])+$/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #ñÑ-]+$/,
    direccion: /^[a-zA-Z0-9 #áéíóúñÁÉÍÓÚüÜÑ.,-]+$/,
  };
let inputEditarCliente = {
    telefono: document.getElementById('E_Telefono'),
    correo: document.getElementById('E_Correo'),
    direccion: document.getElementById('E_Direccion')
}
$(document).ready(function (){
    //Evento clic para hacer todas las validaciones
  document.getElementById("btn-guardar").addEventListener("click", () => {
    validarInputEditarTelefono();
    validarInputEditarCorreo();
    validarInputEditarDireccion();
    if (
      document.querySelectorAll(".mensaje_error").length == 0) {
        validarEditar = true;
    }else{
        validarEditar = false;
    }
  });
})
inputEditarCliente.telefono.addEventListener("keyup", ()=>{
    validarInputEditarTelefono();
    funciones.limitarCantidadCaracteres("E_Telefono", 20);
})
inputEditarCliente.correo.addEventListener("keyup", ()=>{
    validarInputEditarCorreo();
    funciones.limitarCantidadCaracteres("E_Correo", 30);
})
inputEditarCliente.direccion.addEventListener("keyup", ()=>{
    validarInputEditarDireccion();
    funciones.limitarCantidadCaracteres("E_Direccion", 45);
})
let validarInputEditarTelefono = () =>{
  let estadoValidacion = {
      estCampoVacio: false,
      estSoloNumeros: false,
      estaSinEspacio: false,
      estMismoNumero: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
    inputEditarCliente.telefono
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estSoloNumeros = funciones.validarSoloNumeros(
    inputEditarCliente.telefono, 
    validaciones.soloNumeros
  )):"";
  estadoValidacion.estSoloNumeros
  ?(estadoValidacion.estaSinEspacio = funciones.validarEspacios(
    inputEditarCliente.telefono
  )):"";
  estadoValidacion.estaSinEspacio
  ?(estadoValidacion.estMismoNumero = funciones.validarMismoNumeroConsecutivo(
    inputEditarCliente.telefono,
    validaciones.caracterMas5veces
  )):"";
  estadoValidacion.estMismoNumero 
  ? funciones.caracteresMinimo(inputEditarCliente.telefono, 8):"";
}
let validarInputEditarCorreo = () =>{
  let estadoValidacion = {
      estCampoVacio: false,
      estCorreo: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
    inputEditarCliente.correo
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estCorreo = funciones.validarCorreo(
    inputEditarCliente.correo, 
    validaciones.correo
  )):"";
  estadoValidacion.estCorreo
  ? funciones.caracteresMinimo(inputEditarCliente.correo, 8):"";
}
let validarInputEditarDireccion = () =>{
    inputEditarCliente.direccion.value = inputEditarCliente.direccion.value.toUpperCase();
  let estadoValidacion = {
      estCampoVacio: false,
      estDireccion: false,
      estaMasDeUnEspacio: false,
      estMismoCaracter: false,
      estMismoNumero: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
    inputEditarCliente.direccion
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estDireccion = funciones.validarSoloLetrasNumeros(
    inputEditarCliente.direccion, 
    validaciones.direccion
  )):"";
  estadoValidacion.estDireccion
  ?(estadoValidacion.estaMasDeUnEspacio = funciones.validarMasdeUnEspacio(
    inputEditarCliente.direccion
  )):"";
  estadoValidacion.estaMasDeUnEspacio
  ?(estadoValidacion.estMismoCaracter = funciones.limiteMismoCaracter(
    inputEditarCliente.direccion,
    validaciones.caracterMas3veces
  )):"";
  estadoValidacion.estMismoCaracter
    ? funciones.caracteresMinimo(inputEditarCliente.direccion, 10):"";
}

