import { validarCampoVacio, convertirAMayusculas, validarSiExisteUsuario } from "./funcionesValidaciones.js";
const $form = document.getElementById('formcorreo');
const $usuario = document.getElementById('usuario');

// Validar el formulario antes de enviar los datos
$form.addEventListener('submit', e => {
  (!validarCampoVacio($usuario)) ? e.preventDefault() : '';
});

$usuario.addEventListener('focusout', async () => validarSiExisteUsuario($usuario, await existeUsuario($usuario)));
$usuario.addEventListener('input', () => convertirAMayusculas($usuario));

/**
 * 
 * @param {HTMLElement} $usuario espera un elemento input
 * @returns estado
 */
let existeUsuario = async ($usuario) => {
  if($usuario.value.trim() != ''){
   const data = await $.ajax({
      url: "../../Vista/crud/usuario/usuarioExistente.php",
      type: "POST",
      datatype: "JSON",
      data: { usuario: $usuario.value }
    })
    return JSON.parse(data).estado
  }
} 