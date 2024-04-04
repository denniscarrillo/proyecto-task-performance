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

