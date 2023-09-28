import * as funciones from './funcionesValidaciones.js';
// VALIDACIONES FORMULARIO CORREO
// Objeto con expresiones regulares para los inputs
let estadoExisteUsuario = true;

const validaciones = {
  user: /^[A-Za-z0-9_\-]{4,16}$/
};

// CAMPOS
const $form = document.getElementById('formcorreo');
const $usuario = document.getElementById('usuario');
const $mensaje = document.getElementById('mensaje_P');

// Función para validar el formulario
$form.addEventListener('submit', e =>{


  if ($usuario.value.trim() === '') {
    let div = $usuario.parentElement;
    let mensaje = div.querySelector('p');
    mensaje.innerText = '*Campo vacío';
    $usuario.classList.add('mensaje_error');
    
  } else {
    let div = $usuario.parentElement;
    let mensaje = div.querySelector('p');
    $usuario.classList.remove('mensaje_error');
    mensaje.innerText = '';
  }
     if ($usuario.value.trim() === ''){
        e.preventDefault();
    }
  
});



//Esta validacion convierte el usuario en letras mayusculas
$usuario.addEventListener('focusout', () => {
  let usuarioMayus = $usuario.value.toUpperCase();
  $usuario.value = usuarioMayus;
});
$usuario.addEventListener('keyup', () => {
  let usuario = $('#usuario').val();
      estadoExisteUsuario = obtenerUsuarioExiste(usuario);
});
// Cuando se quiera enviar el formulario de correo, se validarán si los inputs no están vacíos
/* $form.addEventListener('submit', e => {
  e.preventDefault(); // Prevenir el envío del formulario por defecto

  if (validarFormulario()) {
    // Validación exitosa, enviar el formulario
    $form.submit();
  }
}); */
let obtenerUsuarioExiste = ($usuario) => {
  let estadoUsuario = false;
  $.ajax({
      url: "../../Vista/crud/usuario/usuarioExistente.php",
      type: "POST",
      datatype: "JSON",
      data: {
          usuario: $usuario
      },
      success: function (usuario) {
          let $objUsuario = JSON.parse(usuario);
          if ($objUsuario.estado == 'false') {
              document.getElementById('usuario').classList.add('mensaje_error');
              document.getElementById('usuario').parentElement.querySelector('p').innerText = '*Usuario no existe';
              estadoUsuario = true; // el usuario no existe, es true
          } else {
              document.getElementById('usuario').classList.remove('mensaje_error');
              document.getElementById('usuario').parentElement.querySelector('p').innerText = '';
              estadoUsuario = false; // el usuario existe, es false
          }
      }
  });
  return estadoUsuario;
} 

// $user.addEventListener('keyup', e => {
//   validarEspacios(e, $usuario);
//   //Validación con jQuery inputlimiter
//   funciones.limitarCantidadCaracteres("user", 15);
// });

//NO PERMITIR ESPACIOS
const validarEspacios = (input, elemento) => {
  let mensaje;
  let cadena = input.target.value;
  let regex = /\s/g; //Expresión literal para saber si existen espacios en la cadena
  if (regex.test(cadena.trim())){ //Evaluamos expresion vs la cadena
      //Si existen especios mostramos mensaje de error
      mensaje = elemento.parentElement.querySelector('p');
      mensaje.innerText = '*No se permiten espacios';
      elemento.classList.add('mensaje_error');
  } else {
      mensaje = elemento.parentElement.querySelector('p');
      elemento.classList.remove('mensaje_error');
      mensaje.innerText = '';
  }


};

