import * as funciones from "./funcionesValidaciones.js";
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
//VARIABLES GLOBALES
let minMAxCaracteresPassword = null;

const $form = document.getElementById("form-usuario");
const $nombre = document.getElementById("nombre");
const $usuario = document.getElementById("usuario");
const $password = document.getElementById("password");
const $password2 = document.getElementById("password2");
const $correo = document.getElementById("correo");
const $rol = document.getElementById("rol");


//Funcion para mostrar contraseña
$(document).ready(async function () {
  minMAxCaracteresPassword = await funciones.obtenerMinMaxCaracteresPasswordU();
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
const expresiones = {
    usuario: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    user: /^(?=.*[^a-zA-Z\s])/, //Solo permite Letras
    nombre: /^(?=.*[^a-zA-Z\s])/,
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])/,
    pass: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])./,
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
}
/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener("submit", async (e) => {
  // Aplicar todas las validaciones a todos los campos
  aplicarValidacionesInputs();
  
  // Transformar datos a mayúsculas
  funciones.transformarAMayusculas($nombre);
  funciones.transformarAMayusculas($usuario);
  
  // Esperar la finalización de las validaciones asincrónicas
  await Promise.all([
      validarInputUsuario(),
      validarInputCorreo()
  ]);
  
  // Verificar si hay errores de validación
  const estadoValidaciones = document.querySelectorAll(".mensaje_error").length;
  
  // Actualizar el estado de validación
  estadoValidado = estadoValidaciones === 0;
  
  // Si hay errores, prevenir el envío del formulario
  if (!estadoValidado) {
      e.preventDefault();
  }
});

// Llamada a las validaciones en distintos eventos
$nombre.addEventListener("input", () => {
    funciones.convertirAMayusculasVisualmente($nombre);
    funciones.limitarCantidadCaracteres("nombre", 60);
    validacionInputNombre();
  });
  $nombre.addEventListener("keydown", () => {
    funciones.soloLetrasConEspacios($nombre)
  });
  $usuario.addEventListener("input", () => {
    funciones.limitarCantidadCaracteres("usuario", 25);
    funciones.convertirAMayusculasVisualmente($usuario);
    validarInputUsuario();
  });
  //Para activar el evento de aceptar solo letras
  $usuario.addEventListener("keydown", () => {
    funciones.soloLetrasSinEspacios($usuario)
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
  $rol.addEventListener("change", ()=>{
    validarSelectRol();
  });
  //FUNCIONES VALIDACIONES PARA CADA INPUT DEL FORMULARIO
const aplicarValidacionesInputs = () => {
    //Llamamos a todas las funciones que aplican sus respectivas validaciones a cada input
    validacionInputNombre();
    validarInputUsuario();
    validarInputCorreo();
    validarInputPassword();
    validarInputConfirmarPassword();
    validarSelectRol();
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
      caracteresMinimo: false,
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
      ? (estadoValidaciones.caracteresMasTresVeces =
          funciones.limiteMismoCaracter($usuario, expresiones.usuario))
      : "";
    estadoValidaciones.caracteresMasTresVeces
      ? (estadoValidaciones.caracteresMinimo = funciones.caracteresMinimo(
          $usuario,
          5
        ))
      : "";
    estadoValidaciones.caracteresMinimo
      ? funciones.validarUsuarioExistente(
          await obtenerUsuarioExiste($usuario.value)
        )
      : "";
  };

const validarInputCorreo = async () =>{
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
     ? (estadoValidaciones.correo = funciones.validarCorreo($correo,expresiones.correo))
     : "";
    estadoValidaciones.espacios
     ? (estadoValidaciones.caracteresMasTresVeces =
        funciones.limiteMismoCaracter($correo,expresiones.usuario))
     : "";
    estadoValidaciones.caracteresMasTresVeces
     ? (estadoValidaciones.caracteresMinimo =
        funciones.caracteresMinimo($correo, 15))
     : "";
    estadoValidaciones.caracteresMinimo
     ? funciones.validarCorreoExistente(await obtenerCorreoExiste($correo.value))
     : "";
}

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

  const validarSelectRol = () => {
    let estadoValidaciones = {
        estadoSelect: false,
    };

estadoValidaciones.estadoSelect = funciones.validarCampoVacio($rol);
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



