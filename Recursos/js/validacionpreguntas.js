/* VALIDACIONES FORMULARIO PREGUNTAS */
//objeto con expresiones regulares para los inptus
const validaciones = {
    user: /^[Z0-9-a-zA\_\-]{4,16}$/,
    //password: /^(?=.*\d)(?=.*[a-z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/
}

// CAMPOS
const $form = document.getElementById('formPreguntas');
const $user = document.getElementById('user');
const $mensaje = document.querySelectorAll('.mensaje');

//Cuando se quiera enviar el formulario de login, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {   
    if ($user.value.trim() === ''){
        let div = $user.parentElement 
        let mensaje = div.querySelector('p');
        mensaje.innerText = '*Campo vacio';
        $user.classList.add('mensaje_error');
    } else {
        let div = $user.parentElement 
        let mensaje = div.querySelector('p');
        $user.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
    if ($user.value.trim() === ''){
        e.preventDefault();
   }

});

// USUARIO EN MAYUSCULAS
$user.addEventListener('focusout', () => {
    let usuarioMayus = $user.value.toUpperCase();
    $user.value = usuarioMayus;
});

// NO PERMITIR ESPACIOS
$user.addEventListener('keyup', e => {
    validarEspacios(e, $user);
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
};