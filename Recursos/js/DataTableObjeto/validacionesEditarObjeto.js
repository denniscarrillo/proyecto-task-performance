import * as funciones from '../funcionesValidaciones.js';
export let estadoValido = false;

const $form = document.getElementById("formEditarObjeto");

const $descripcion = document.getElementById("A_descripcion");


const expresiones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ.\s.,])/, // Letras, acentos y Ñ, también permite punto // Solo letras
    objeto: /^(?=.*(..)\1)/, // no permite escribir que se repita más de tres veces un carácter
    descripcion: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ.\s.,])/, // Letras, acentos y Ñ, también permite punto // Solo letras
};
  $descripcion.addEventListener("input", () => {
    funciones.convertirAMayusculasVisualmente($descripcion);
    funciones.limitarCantidadCaracteres("A_descripcion", 100);
    validacionInputDescripcion();
  });
  $descripcion.addEventListener("keydown", () => {
    funciones.soloLetrasYPuntosYComas($descripcion)
  });
  const aplicarValidacionesInputs = () => {
    //Llamamos a todas las funciones que aplican sus respectivas validaciones a cada input
    validacionInputDescripcion();
  };
  $form.addEventListener("submit", (e) => {
    // Aplicar todas las validaciones a todos los campos
    aplicarValidacionesInputs();
    
    // Transformar datos a mayúsculas
    funciones.transformarAMayusculas($descripcion);

    // Verificar si hay errores de validación
    const estadoValidaciones = document.querySelectorAll(".mensaje_error").length;
    
    // Actualizar el estado de validación
    estadoValido = estadoValidaciones === 0;
    
    // Si hay errores, prevenir el envío del formulario
    if (!estadoValido) {
        e.preventDefault();
    }
  });

  const validacionInputDescripcion = () => {
    let estadoValidaciones = {
      campoVacio: false,
      soloLetras: false,
      masDeUnEspacio: false,
      caracteresMasTresVeces: false,
    };
    estadoValidaciones.campoVacio = funciones.validarCampoVacio($descripcion);
    estadoValidaciones.campoVacio
      ? (estadoValidaciones.soloLetras = funciones.validarSoloLetras(
          $descripcion,
          expresiones.descripcion
        ))
      : "";
    estadoValidaciones.soloLetras
      ? (estadoValidaciones.masDeUnEspacio =
          funciones.validarMasdeUnEspacio($descripcion))
      : "";
    estadoValidaciones.masDeUnEspacio
      ? (estadoValidaciones.caracteresMasTresVeces =
          funciones.limiteMismoCaracter($descripcion, expresiones.objeto))
      : "";
    // estadoValidaciones.caracteresMasTresVeces
    //   ? funciones.caracteresMinimo($descripcion, 10)
    //   : "";
  };
