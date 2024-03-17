import * as funciones from "./funcionesValidaciones.js";

//VARIABLES GLOBALES
let minMaxCaracteresPassword = null;

// INPUTS
const $form = document.getElementById("formRegis");
const $nombre = document.getElementById("nombre");
const $usuario = document.getElementById("usuario");
const $password = document.getElementById("password");
const $password2 = document.getElementById("password2");
const $correo = document.getElementById("correo");

//Funcion para mostrar contraseña
$(document).ready(async function () {
  minMaxCaracteresPassword = await funciones.obtenerMinMaxCaracteresPassword();
  $("#checkbox").click(function () {
    if ($(this).is(":checked")) {
      $("#password").attr("type", "text");
      $("#password2").attr("type", "text");
    } else {
      $("#password").attr("type", "password");
      $("#password2").attr("type", "password");
    }
  });
});

//objeto con expresiones regulares para los inptus
const expresiones = {
  usuario: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
  user: /^(?=.*[^a-zA-Z\s])/, //Solo permite Letras
  nombre: /^(?=.*[^a-zA-Z\s])/,
  password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])/,
  pass: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])./,
  correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
};

//Cuando se quiera enviar el formulario de registro, se aplicaran todas validaciones a todos los inputs
$form.addEventListener("submit", (e) => {
  aplicarValidacionesInputs();
  const estaValidaciones = document.querySelectorAll(".mensaje_error").length;
  if (estaValidaciones > 0) {
    e.preventDefault();
  }
});

// Llamada a las validaciones en distintos eventos
$nombre.addEventListener("input", () => {
  funciones.convertirAMayusculas($nombre);
  funciones.limitarCantidadCaracteres("nombre", 60);
  validacionInputNombre();
});
$usuario.addEventListener("input", () => {
  funciones.limitarCantidadCaracteres("usuario", 25);
  funciones.convertirAMayusculas($usuario);
  validarInputUsuario();
});
$correo.addEventListener("input", () => {
  funciones.limitarCantidadCaracteres("correo", 50);
  validarInputCorreo();
});
$correo.addEventListener("focusout", () => {
  validarInputCorreo();
});
$password.addEventListener("input", () => {
  validarInputPassword();
});
$password2.addEventListener("focusout", () => {
  validarInputConfirmarPassword();
});

//FUNCIONES VALIDACIONES PARA CADA INPUT DEL FORMULARIO
const aplicarValidacionesInputs = () => {
  //Llamamos a todas las funciones que aplican sus respectivas validaciones a cada input
  validacionInputNombre();
  validarInputUsuario();
  validarInputCorreo();
  validarInputPassword();
  validarInputConfirmarPassword();
};

const validacionInputNombre = () => {
  let estadoValidaciones = {
    campoVacio: false,
    soloLetras: false,
    masDeUnEspacio: false,
    caracteresMasTresVeces: false,
  };
  estadoValidaciones.campoVacio = funciones.validarCampoVacio($nombre);
  estadoValidaciones.campoVacio
    ? (estadoValidaciones.soloLetras = funciones.validarSoloLetras(
        $nombre,
        expresiones.nombre
      ))
    : "";
  estadoValidaciones.soloLetras
    ? (estadoValidaciones.masDeUnEspacio =
        funciones.validarMasdeUnEspacio($nombre))
    : "";
  estadoValidaciones.masDeUnEspacio
    ? (estadoValidaciones.caracteresMasTresVeces =
        funciones.limiteMismoCaracter($nombre, expresiones.usuario))
    : "";
  estadoValidaciones.caracteresMasTresVeces
    ? funciones.caracteresMinimo($nombre, 10)
    : "";
};

const validarInputUsuario = async () => {
  let estadoValidaciones = {
    campoVacio: false,
    soloLetras: false,
    espacios: false,
    caracteresMasTresVeces: false,
  };
  estadoValidaciones.campoVacio = funciones.validarCampoVacio($usuario);
  estadoValidaciones.campoVacio
    ? (estadoValidaciones.soloLetras = funciones.validarSoloLetras(
        $usuario,
        expresiones.user
      ))
    : "";
  estadoValidaciones.soloLetras
    ? (estadoValidaciones.espacios = funciones.validarEspacios($usuario))
    : "";
  estadoValidaciones.espacios
    ? funciones.validarUsuarioExistente(
        await obtenerUsuarioExiste($usuario.value)
      )
    : "";
  estadoValidaciones.espacios
    ? (estadoValidaciones.caracteresMasTresVeces =
        funciones.limiteMismoCaracter($usuario, expresiones.usuario))
    : "";
  estadoValidaciones.caracteresMasTresVeces
    ? funciones.caracteresMinimo($usuario, 5)
    : "";
};

const validarInputCorreo = async () => {
  let estadoValidaciones = {
    campoVacio: false,
    espacios: false,
    correo: false,
    caracteresMasTresVeces: false,
    caracteresMinimo: false,
  };
  estadoValidaciones.campoVacio = funciones.validarCampoVacio($correo);
  estadoValidaciones.campoVacio
    ? (estadoValidaciones.espacios = funciones.validarEspacios($correo))
    : "";
  estadoValidaciones.espacios
    ? (estadoValidaciones.correo = funciones.validarCorreo(
        $correo,
        expresiones.correo
      ))
    : "";
  estadoValidaciones.espacios
    ? (estadoValidaciones.caracteresMasTresVeces =
        funciones.limiteMismoCaracter($correo, expresiones.usuario))
    : "";
  estadoValidaciones.caracteresMasTresVeces
    ? (estadoValidaciones.caracteresMinimo = funciones.caracteresMinimo(
        $correo,
        15
      ))
    : "";
  estadoValidaciones.caracteresMinimo
    ? funciones.validarCorreoExistente(await obtenerCorreoExiste($correo.value))
    : "";
};

const validarInputPassword = () => {
  let estadoValidaciones = {
    campoVacio: false,
    password: false,
    espacios: false,
  };

  const cantMinMax = {
    min: minMaxCaracteresPassword[0],
    max: minMaxCaracteresPassword[1],
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
    ? funciones.validarMinMaxCaracteresPassword($password, cantMinMax)
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

let obtenerUsuarioExiste = async ($usuario) => {
  const estadoUsuario = await $.ajax({
    url: "../../../Vista/crud/usuario/usuarioExistente.php",
    type: "POST",
    datatype: "JSON",
    data: {
      usuario: $usuario,
    },
  });
  return JSON.parse(estadoUsuario).estado;
};

let obtenerCorreoExiste = async ($correo) => {
  const existeEmail = await $.ajax({
    url: "../../../Vista/crud/usuario/correoExiste.php",
    type: "POST",
    datatype: "JSON",
    data: {
      correo: $correo,
    },
  });
  return JSON.parse(existeEmail).estado;
};
