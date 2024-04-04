import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
let minMAxCaracteresPassword = null;
//Objeto con expresiones regulares para los inptus
const expresiones = {
    usuario: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    user: /^(?=.*[^a-zA-Z\s])/, //Solo permite Letras
    nombre: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ.\s.,])/, // Letras, acentos y Ñ, también permite punto // Solo letras
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])/,
    pass: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])./,
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
}
//VARIABLES GLOBALES

let limiteContrasenia = true;

let estadoEspacioInput = {
    estadoEspacioUser: true,
    estadoEspacioPassword: true, 
} 
let estadoSoloLetras = {
    estadoLetrasUser: true,
    estadoLetrasName: true,
}
let estadoPassword = {
    estadoPassword1: true,
    estadoPassword2: true
}
let estadoMasdeUnEspacio = {
    estadoMasEspacioNombre: true
}

const $form = document.getElementById('formPerfilContrasenia');

const $password = document.getElementById('confirmPassword');
const  $password2 = document.getElementById('confirmPassword');


$password.addEventListener("input", () => {
    validarInputPassword();
  });
  $password2.addEventListener("focusout", () => {
    validarInputConfirmarPassword();
  });

  const aplicarValidacionesInputs = () => {
    //Llamamos a todas las funciones que aplican sus respectivas validaciones a cada input
    
    validarInputPassword();
    validarInputConfirmarPassword();
   
  };
//Funcion para mostrar contraseña
$(document).ready(function () {
    $('#checkbox').click(function () {
        if ($(this).is(':checked')) {
            $('#confirmPassword').attr('type', 'text');
         
        } else {
            $('#confirmPassword').attr('type', 'password');
          
        }
    });
});

$form.addEventListener("submit", async (e) => {
    // Aplicar todas las validaciones a todos los campos
    aplicarValidacionesInputs();
    
   
    
    const estadoValidaciones = document.querySelectorAll(".mensaje_error").length;
    
    // Actualizar el estado de validación
    estadoValidado = estadoValidaciones === 0;
    
    // Si hay errores, prevenir el envío del formulario
    if (!estadoValidado) {
        e.preventDefault();
    }
  });

    const validarInputPassword = () => {
        let estadoValidaciones = {
          campoVacio: false,
          password: false,
          espacios: false,
        };
      
        const cantMinMax = {
          min: minMAxCaracteresPassword[0],
          max: minMAxCaracteresPassword[1],
        };
      
        estadoValidaciones.campoVacio = funciones.validarCampoVacio($password);
      
        estadoValidaciones.campoVacio
          ? (estadoValidaciones.espacios = funciones.validarEspacios($password))
          : "";
        estadoValidaciones.espacios
          ? (estadoValidaciones.password = funciones.validarPassword(
              $password,
              expresiones.password
            ))
          : "";
        estadoValidaciones.password
          ? funciones.validarMinMaxCaracteresPasswordU($password, cantMinMax)
          : "";
      };
      
      const validarInputConfirmarPassword = () => {
        let estadoValidaciones = {
          campoVacio: false,
          password: false,
          coincidir: false,
          espacios: false,
        };
      
        estadoValidaciones.campoVacio = funciones.validarCampoVacio($password2);
        estadoValidaciones.campoVacio
          ? (estadoValidaciones.espacios = funciones.validarEspacios($password2))
          : "";
        estadoValidaciones.espacios
          ? (estadoValidaciones.coincidir = funciones.validarCoincidirPassword(
              $password,
              $password2
            ))
          : "";
        estadoValidaciones.coincidir
          ? (estadoValidaciones.password = funciones.validarPassword(
              $password2,
              expresiones.password
            ))
          : "";
      };