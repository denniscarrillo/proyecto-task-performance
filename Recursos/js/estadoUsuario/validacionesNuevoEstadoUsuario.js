import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;


const $form = document.getElementById("form-estado");
const $estado = document.getElementById("estado");

const expresiones = {
    soloLetras: /^(?=.*[^a-zA-Z\/ .ÑñáéíóúÁÉÍÓÚs])+$/, //Solo letras
    estado: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    
};
$estado.addEventListener("input", () => {
    funciones.convertirAMayusculasVisualmente($estado);
    funciones.limitarCantidadCaracteres("estado", 20);
    validacionInputEstado();
  });
  $estado.addEventListener("keydown", () => {
    funciones.soloLetrasYPuntos($estado)
  });
  const aplicarValidacionesInputs = () => {
    //Llamamos a todas las funciones que aplican sus respectivas validaciones a cada input
    validacionInputEstado();
  };
  $form.addEventListener("submit", (e) => {
    // Aplicar todas las validaciones a todos los campos
    aplicarValidacionesInputs();
    
    // Transformar datos a mayúsculas
    funciones.transformarAMayusculas($estado);

    // Verificar si hay errores de validación
    const estadoValidaciones = document.querySelectorAll(".mensaje_error").length;
    
    // Actualizar el estado de validación
    estadoValidado = estadoValidaciones === 0;
    
    // Si hay errores, prevenir el envío del formulario
    if (!estadoValidado) {
        e.preventDefault();
    }
  });


  const validacionInputEstado = () => {
    let estadoValidaciones = {
      campoVacio: false,
      soloLetras: false,
      masDeUnEspacio: false,
      caracteresMasTresVeces: false,
    };
    estadoValidaciones.campoVacio = funciones.validarCampoVacio($estado);
    estadoValidaciones.campoVacio
      ? (estadoValidaciones.soloLetras = funciones.validarSoloLetras(
          $estado,
          expresiones.soloLetras
        ))
      : "";
    estadoValidaciones.soloLetras
      ? (estadoValidaciones.masDeUnEspacio =
          funciones.validarMasdeUnEspacio($estado))
      : "";
    estadoValidaciones.masDeUnEspacio
      ? (estadoValidaciones.caracteresMasTresVeces =
          funciones.limiteMismoCaracter($estado, expresiones.estado))
      : "";
    estadoValidaciones.caracteresMasTresVeces
      ? funciones.caracteresMinimo($estado, 4)
      : "";
  };
