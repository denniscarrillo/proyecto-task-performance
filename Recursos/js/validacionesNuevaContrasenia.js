import * as funciones from "./funcionesValidaciones.js";

const expresiones = {
  password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,16}$/,
};

//  Cambiar tipo del candado para mostrar/ocultar contraseña
$(document).ready(function () {
  $("#checkbox").click(function () {
    if ($(this).is(":checked")) {
      $("#password").attr("type", "text");
      $("#confirmPassword").attr("type", "text");
      $("#current-password").attr("type", "text");
    } else {
      $("#password").attr("type", "password");
      $("#confirmPassword").attr("type", "password");
      $("#current-password").attr("type", "password");
    }
  });
});
let estado = "false";
let $currentPassword = null;
let existeCurrentPassword = 0;
if (document.getElementById("current-password") != null) {
  $currentPassword = document.getElementById("current-password");
  existeCurrentPassword = 1;
}
const $form = document.getElementById("formContrasenia");
const $password = document.getElementById("password");
const $password2 = document.getElementById("confirmPassword");

//Objeto estado de Validaciones
let estadoValidaciones = {
  campoVacioPassword: false,
  campoVaciocurrentPassword: false,
  existeCurrentPassword: false,
  coincidirPassword: false,
  robustezPassword: false,
  minMaxPassword: false
};
//Cuando se hace SUBMIT verificamos que todas las validaciones se hayan cumplido, de lo contrario no evitará el envío del formulario
$form.addEventListener("submit", async (e) => {
  if (estadoValidaciones.campoVacioPassword == false || (estadoValidaciones.existeCurrentPassword == false && existeCurrentPassword == 1) 
  || estadoValidaciones.robustezPassword == false || estadoValidaciones.minMaxPassword == false) {
    e.preventDefault();
    estadoValidaciones.campoVacioPassword = funciones.validarCampoVacio($password);
    // estadoValidaciones.campoVacioPassword = true;
    if(estadoValidaciones.campoVacioPassword == true) {
      estadoValidaciones.minMaxPassword = await funciones.cantidadParametrosContrasenia($password);
      if(estadoValidaciones.minMaxPassword == true){
        estadoValidaciones.robustezPassword = funciones.validarPassword($password, expresiones.password);
      }
    }
    //Verificamos si es que existe el campo de Current Password para aplicar la validacion
    if (existeCurrentPassword == 1) {
      estadoValidaciones.campoVaciocurrentPassword = funciones.validarCampoVacio($currentPassword);
      if (estadoValidaciones.campoVaciocurrentPassword) {
          estadoValidaciones.existeCurrentPassword = validarCurrentPassword($currentPassword, estado);
      }
    }
  } else if (estadoValidaciones.coincidirPassword == false){
    e.preventDefault();
    estadoValidaciones.coincidirPassword = funciones.validarCoincidirPassword($password, $password2);
   }
});

//Verificamos si es que existe el campo de Current Password para añadir el evento y aplicar las validaciones
if (existeCurrentPassword == 1) {
  $currentPassword.addEventListener("focusout", async () => {
    let estadoCurrentPassword = await obtenerEstadoCurrentPassword(
      $currentPassword.value
    );
    // Ya que esto es un relajo, tuvimos que hacer maniobras del mas allá para poder obtener el true o el false
    estado = JSON.stringify(estadoCurrentPassword).split("n")[1].split('"')[0];
    console.log(estado);
    estadoValidaciones.existeCurrentPassword = validarCurrentPassword(
      $currentPassword,
      estado
    );
    funciones.limitarCantidadCaracteres(
      "confirmPassword",
      15
    );
  });
}
//Evento KEYUP para el campo Password
$password.addEventListener("keyup", async () => {
  estadoValidaciones.minMaxPassword = await funciones.cantidadParametrosContrasenia($password);
});
//Evento FOCUSOUT para el campo Password
$password.addEventListener("focusout", () => {
    //  estadoValidaciones.campoVacioPassword = funciones.validarCampoVacio($password);
  if (estadoValidaciones.minMaxPassword) {
    estadoValidaciones.robustezPassword = funciones.validarPassword($password, expresiones.password);
  }
});
//Evento KEYUP para el campo Confirm Password
$password2.addEventListener("keyup", () => {
  if(estadoValidaciones.minMaxPassword == true && estadoValidaciones.robustezPassword == true){
      estadoValidaciones.coincidirPassword = funciones.validarCoincidirPassword($password, $password2);
  }
  funciones.limitarCantidadCaracteres("confirmPassword", 16);
});

let validarCurrentPassword = (elemento, estadoCurrentPassword) => {
  let estado = false;
  let mensaje = elemento.parentElement.querySelector("p");
  if (estadoCurrentPassword === "false") {
    mensaje.innerText = "*Contraseña incorrecta";
    elemento.classList.add("mensaje_error");
  } else {
    elemento.classList.remove("mensaje_error");
    mensaje.innerText = "";
    estado = true;
  }
  return estado;
};
//Obtenemos el estado de la contraseña actual del usuario
let obtenerEstadoCurrentPassword = async (currentPassword) => {
  try {
    let userPassword = await $.ajax({
      url: "../../../Vista/recuperacionContrasenia/obtenerContraseniaActual.php",
      type: "POST",
      datatype: "JSON",
      data: {
        userPassword: currentPassword,
      },
    });
    return userPassword;
  } catch (err) {
    console.error(err);
  }
};