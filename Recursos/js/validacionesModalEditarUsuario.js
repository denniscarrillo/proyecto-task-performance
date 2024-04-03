import * as funciones from "./funcionesValidaciones.js";
export let estadoValidado = false;

const $form = document.getElementById("form-Edit-Usuario");
const $nombre = document.getElementById("E_nombre");
const $correo = document.getElementById("E_correo");
const $rol = document.getElementById("E_rol");
const $estado = document.getElementById("E_estado");

//Objeto con expresiones regulares para los inptus
const expresiones = {
    usuario: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    nombre: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ.\s.,])/, // Letras, acentos y Ñ, también permite punto // Solo letras
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
}
/* ---------------- VALIDACIONES FORMULARIO GESTION EDITAR USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener("submit", async (e) => {
  // Aplicar todas las validaciones a todos los campos
  aplicarValidacionesInputsEditar();
  
  // Transformar datos a mayúsculas
  funciones.transformarAMayusculas($nombre);
  
  // Esperar la finalización de las validaciones asincrónicas
  // await Promise.all([
  //     validarInputCorreo()
  // ]);
  
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
    funciones.limitarCantidadCaracteres("E_nombre", 60);
    validacionInputNombre();
  });
  $nombre.addEventListener("keydown", () => {
    funciones.soloLetrasYPuntos($nombre)
  });
  $correo.addEventListener("input", () => {
    funciones.limitarCantidadCaracteres("E_correo", 50);
    validarInputCorreo();
  });
  $correo.addEventListener("focusout", () => {
    validarInputCorreo();
  });
  $rol.addEventListener("change", () => {
    validarSelectRol();
  });
  $estado.addEventListener("change", () => {
    validarSelectEstado();
  });
    //FUNCIONES VALIDACIONES PARA CADA INPUT DEL FORMULARIO
const aplicarValidacionesInputsEditar = () => {
    //Llamamos a todas las funciones que aplican sus respectivas validaciones a cada input
    validacionInputNombre();
    validarInputCorreo();
    validarSelectRol();
    validarSelectEstado();
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
        ? (estadoValidaciones.correo = funciones.validarCorreo($correo, expresiones.correo))
        : "";
    estadoValidaciones.espacios
        ? (estadoValidaciones.caracteresMasTresVeces = funciones.limiteMismoCaracter($correo, expresiones.usuario))
        : "";
    estadoValidaciones.caracteresMasTresVeces
        ? (estadoValidaciones.caracteresMinimo = funciones.caracteresMinimo($correo, 15))
        : "";
    // estadoValidaciones.caracteresMinimo
    //     ? funciones.validarCorreoExistenteE(await obtenerCorreoExiste($correo.value))
    //     : "";
};


const validarSelectRol = () => {
    let estadoValidaciones = {
        estadoSelect: false,
    };

estadoValidaciones.estadoSelect = funciones.validarCampoVacio($rol);
  };

  const validarSelectEstado = () => {
    let estadoValidaciones = {
        estadoSelect: false,
    };

estadoValidaciones.estadoSelect = funciones.validarCampoVacio($estado);
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
