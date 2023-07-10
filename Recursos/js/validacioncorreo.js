// VALIDACIONES FORMULARIO CORREO
// Objeto con expresiones regulares para los inputs
const validaciones = {
  user: /^[A-Za-z0-9_\-]{4,16}$/
};

// CAMPOS
const $form = document.getElementById('formcorreo');
const $user = document.getElementById('user');
const $mensaje = document.querySelector('.mensaje');

// Función para validar el formulario
$form.addEventListener('submit', e =>{


  if ($user.value.trim() === '') {
    let div = $user.parentElement;
    let mensaje = div.querySelector('p');
    mensaje.innerText = '*Campo vacío';
    $user.classList.add('mensaje_error');
    
  } else {
    let div = $user.parentElement;
    let mensaje = div.querySelector('p');
    $user.classList.remove('mensaje_error');
    mensaje.innerText = '';
  }
     if ($user.value.trim() === ''){
        e.preventDefault();
    }
  
});

//Esta validacion convierte el usuario en letras mayusculas
$user.addEventListener('focusout', () => {
  let usuarioMayus = $user.value.toUpperCase();
  $user.value = usuarioMayus;
});
// Cuando se quiera enviar el formulario de correo, se validarán si los inputs no están vacíos
/* $form.addEventListener('submit', e => {
  e.preventDefault(); // Prevenir el envío del formulario por defecto

  if (validarFormulario()) {
    // Validación exitosa, enviar el formulario
    $form.submit();
  }
}); */

$user.addEventListener('keyup', e => {
  validarEspacios(e, $user);
  //Validación con jQuery inputlimiter
  $("#userName").inputlimiter({
      limit: 15
  });
});

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
/* //Validar que sean mayusculas */
  function mayus(e) {
    e.value = e.value.toUpperCase();
}

};

