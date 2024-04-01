import * as funciones from "./funcionesValidaciones.js";

const $form = document.getElementById("formLogin");
const $inputUser = document.getElementById("userName");
const $inputPassword = document.getElementById("userPassword");
let icon_eye_class = document.querySelector(".fa-eye-slash");
let icon_eye = document.querySelector(".eye_position");

const Toast = Swal.mixin({
  toast: true,
  position: "top",
  customClass: {
    //Para agregar clases propias
    popup: "customizable-toast",
  },
  showConfirmButton: false,
  timer: 3500,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

//No permitir copiar, pegar y dar click derecho.
$(document).ready(function () {
  $("body").bind("cut copy paste", function (event) {
    event.preventDefault();
  });

  $("body").on("contextmenu", function () {
    return false;
  });

  //Detectar si viene de autoregistro y mostrar un Toast de confirmacion
  let $toastRegistro = document.querySelector(".registro-exitoso");
  if ($toastRegistro.id == "1") {
    Toast.fire({
      icon: "success",
      title: "Registro de cuenta exitoso",
    });
    $toastRegistro.id = "0"; //Esto para que el mensaje se muestre solo cuando viene de registro
  }

  //Detectar si viene de restore y mostrar un Toast de confirmacion
  let $toastRestore = document.querySelector('.restore-exitoso');
  if ($toastRestore.id == "1") {
      Toast.fire({
          icon: "success",
          title: "Restauración exitosa",
      });
      $toastRestore.id = "0"; //Esto para que el mensaje se muestre solo cuando viene de restore
  }
});

//Ocultar o mostrar contrasenia
icon_eye.addEventListener("click", function () {
  if (this.nextElementSibling.type === "password") {
    this.nextElementSibling.type = "text";
    icon_eye_class.classList.remove("fa-eye-slash");
    icon_eye_class.classList.add("fa-eye");
  } else {
    this.nextElementSibling.type = "password";
    icon_eye_class.classList.remove("fa-eye");
    icon_eye_class.classList.add("fa-eye-slash");
  }
});

/* ---------------- VALIDACIONES FORMULARIO LOGIN ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener("submit", (event) => {
  validacionesInputUser();
  validacionesInputPassword();
  const error = document.querySelectorAll(".mensaje_error").length;
  if (error > 0) {
    event.preventDefault();
  }
});

// Convierte usuario en mayúsuculas de inmediato mientras escribe
$inputUser.addEventListener("input", () => {
  funciones.transformarAMayusculas($inputUser);
  funciones.limitarCantidadCaracteres("userName", 25);
  validacionesInputUser();
});

$inputUser.addEventListener("focusout", () => {
  validacionesInputUser();
});

$inputUser.addEventListener("keydown", () => {
  funciones.soloLetrasSinEspacios($inputUser)
});

$inputPassword.addEventListener("input", () => {
  funciones.limitarCantidadCaracteres("userPassword", 25);
  validacionesInputPassword();
});

$inputPassword.addEventListener("focus", () => {
  icon_eye.classList.remove("hidden");
});

$inputPassword.addEventListener("focusout", () => {
  validacionesInputPassword();
});

/*
 *Sección de funciones para cada input donde se
 *aplican las validaciones correspondientes para cada uno.
 */
let validacionesInputUser = () => {
  let estadoValidaciones = {
    campoVacio: false,
    soloLetras: false,
    espacios: false,
  };
  estadoValidaciones.campoVacio = funciones.validarCampoVacio($inputUser);
  estadoValidaciones.campoVacio
    ? (estadoValidaciones.espacios = funciones.validarEspacios($inputUser))
    : "";
  estadoValidaciones.espacios
    ? (estadoValidaciones.soloLetras = funciones.validarSoloLetras(
        $inputUser,
        /^(?=.*[^a-zA-Z\s])/
      ))
    : "";
};

let validacionesInputPassword = () => {
  let estadoValidaciones = {
    campoVacio: false,
    soloLetras: false,
    espacios: false,
  };
  estadoValidaciones.campoVacio =
    funciones.validarCampoVacio($inputPassword);
  estadoValidaciones.campoVacio
    ? (estadoValidaciones.espacios =
        funciones.validarEspacios($inputPassword))
    : "";
};
