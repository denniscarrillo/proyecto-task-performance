import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\/ .ÑñáéíóúÁÉÍÓÚs])+$/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 -]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,áéíóúÁÉÍÓÚñÑ]+$/,
  };
const $nombre = document.getElementById("E_nombre");
const $direccion = document.getElementById("E_direccion");

let inputNuevoCliente = {
    nombre: document.getElementById('E_nombre'),
    rtn: document.getElementById('E_rtn'),
    telefono: document.getElementById('E_telefono'),
    correo: document.getElementById('E_email'),
    direccion: document.getElementById('E_direccion')
}
$(document).ready(function (){
    //Evento clic para hacer todas las validaciones
  document.getElementById("btn-guardarActualizacion").addEventListener("click", () => {
    validarInputNombre();
    validarInputRTN();
    validarInputTelefono();
    validarInputCorreo();
    validarInputDireccion();
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
    funciones.limitarCantidadCaracteres("E_nombre", 50);
})
$nombre.addEventListener("input", () => {
  funciones.convertirAMayusculasVisualmente($nombre);
  validarInputNombre();
});
$nombre.addEventListener("keydown", () => {
  funciones.soloLetrasYPuntos($nombre)
});
inputNuevoCliente.rtn.addEventListener('input', (event) => {
  if (!funciones.RTN_guion(event)) {
      event.preventDefault();
  }
  validarInputRTN();
  funciones.limitarCantidadCaracteres("E_rtn", 20);
});
inputNuevoCliente.telefono.addEventListener('input', (event)=>{
  if (!funciones.telefono_guion(event)) {
    event.preventDefault();
}
    validarInputTelefono();
    funciones.limitarCantidadCaracteres("E_telefono", 20);
})
inputNuevoCliente.correo.addEventListener("input", ()=>{
    validarInputCorreo();
    funciones.limitarCantidadCaracteres("E_email", 50);
})
inputNuevoCliente.direccion.addEventListener("keyup", ()=>{
    validarInputDireccion();
    funciones.limitarCantidadCaracteres("E_direccion", 100);
})
$direccion.addEventListener("input", () => {
  funciones.convertirAMayusculasVisualmente($direccion);
  validarInputDireccion();
});
$direccion.addEventListener("keydown", () => {
  funciones.permitirLetrasNumerosPuntosComas($direccion)
});
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
  ? funciones.caracteresMinimo(inputNuevoCliente.nombre, 8):"";
}
let validarInputRTN = () =>{
  let estadoValidacion = {
      estCampoVacio: false,
      estSoloNumeros: false,
      estaSinEspacio: false,
      estMismoNumero: false,
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
  ?(estadoValidacion.estaSinEspacio = funciones.validarEspacios(
    inputNuevoCliente.rtn
  )):"";
  estadoValidacion.estaSinEspacio
  ?(estadoValidacion.estMismoNumero = funciones.validarMismoNumeroConsecutivo(
    inputNuevoCliente.rtn,
    validaciones.caracterMas5veces
  )):"";
  estadoValidacion.estMismoNumero 
  ? funciones.caracteresMinimo(inputNuevoCliente.rtn, 13):"";
}
let validarInputTelefono = () =>{
    inputNuevoCliente.telefono.value = inputNuevoCliente.telefono.value.toUpperCase();
  let estadoValidacion = {
      estCampoVacio: false,
      estSoloNumeros: false,
      estaSinEspacio: false,
      estMismoNumero: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
    inputNuevoCliente.telefono
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estSoloNumeros = funciones.validarSoloNumeros(
    inputNuevoCliente.telefono, 
    validaciones.soloNumeros
  )):"";
  estadoValidacion.estSoloNumeros
  ?(estadoValidacion.estaSinEspacio = funciones.validarEspacios(
    inputNuevoCliente.telefono
  )):"";
  estadoValidacion.estaSinEspacio
  ?(estadoValidacion.estMismoNumero = funciones.validarMismoNumeroConsecutivo(
    inputNuevoCliente.telefono,
    validaciones.caracterMas5veces
  )):"";
  estadoValidacion.estMismoNumero 
  ? funciones.caracteresMinimo(inputNuevoCliente.telefono, 8):"";
}
let validarInputCorreo = () =>{
  let estadoValidacion = {
      estCampoVacio: false,
      estCorreo: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
    inputNuevoCliente.correo
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estCorreo = funciones.validarCorreo(
    inputNuevoCliente.correo, 
    validaciones.correo
  )):"";
  estadoValidacion.estCorreo
  ? funciones.caracteresMinimo(inputNuevoCliente.correo, 8):"";
}
let validarInputDireccion = () =>{
    inputNuevoCliente.direccion.value = inputNuevoCliente.direccion.value.toUpperCase();
  let estadoValidacion = {
      estCampoVacio: false,
      estDireccion: false,
      estaMasDeUnEspacio: false,
      estMismoCaracter: false,
      estMismoNumero: false,
  }
  estadoValidacion.estCampoVacio = funciones.validarCampoVacio(
    inputNuevoCliente.direccion
  );
  estadoValidacion.estCampoVacio
  ? (estadoValidacion.estDireccion = funciones.validarSoloLetrasNumeros(
    inputNuevoCliente.direccion, 
    validaciones.direccion
  )):"";
  estadoValidacion.estDireccion
  ?(estadoValidacion.estaMasDeUnEspacio = funciones.validarMasdeUnEspacio(
    inputNuevoCliente.direccion
  )):"";
  estadoValidacion.estaMasDeUnEspacio
  ?(estadoValidacion.estMismoCaracter = funciones.limiteMismoCaracter(
    inputNuevoCliente.direccion,
    validaciones.caracterMas3veces
  )):"";
  estadoValidacion.estMismoCaracter
    ? funciones.caracteresMinimo(inputNuevoCliente.direccion, 10):"";
}