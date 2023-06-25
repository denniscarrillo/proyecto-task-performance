
//  Cambiar tipo del candado para mostrar/ocultar contraseña
let iconClass = document.querySelector('.type-lock');
let icon_candado = document.querySelector('.lock');
icon_candado.addEventListener('click', function() { 
    if(this.nextElementSibling.type === "password") {
        this.nextElementSibling.type = "text";
        iconClass.classList.remove('fa-lock');
        iconClass.classList.add('fa-lock-open');
    } else {
        this.nextElementSibling.type = "password";
        iconClass.classList.remove('fa-lock-open');
        iconClass.classList.add('fa-lock');
    }
});
/* VALIDACIONES FORMULARIO LOGIN */
//objeto con expresiones regulares para los inptus
const validaciones = {
    // user: /^[a-zA-Z0-9\_\-]{4,16}$/,
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/
}
// CAMPOS VACIOS
const $form = document.getElementById('formLogin');
const $user = document.getElementById('userName');
const $password = document.getElementById('userPassword');
//Cuando se quiera enviar el formulario de login, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {   
    if ($user.value.trim() === ''){
        let div = $user.parentElement 
        let mensaje = div.querySelector('p');
        mensaje.innerText = '*Campo vacio';
        $user.classList.add('mensaje_error');
    } 
    else {
        let div = $user.parentElement 
        let mensaje = div.querySelector('p');
        $user.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
    if ($password.value.trim() === '') {
        let div = $password.parentElement 
        let mensaje = div.querySelector('p');
        mensaje.innerText = '*Campo vacio';
        $password.classList.add('mensaje_error');
    } 
    else {
        let div = $password.parentElement 
        let mensaje = div.querySelector('p');
        $password.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
    if ($user.value.trim() === '' || $password.value.trim() === '') {
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
    //Validación con jQuery inputlimiter
    $("#userName").inputlimiter({
        limit: 15,
    });
});
$password.addEventListener('keyup', e => {
    validarEspacios(e, $password);
});

// $password.addEventListener('focusout', e => {
//     validarPassword(e, $password);
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
// VALIDAR QUE SE CUMPLAN LAS REGLAS MÍNIMAS PARA LA CONTRASEÑA
// const validarPassword = (input, elemento) => {
//     if (!validaciones.password.test(input)){
//         input.preventDefault();
//         let mensaje = elemento.parentElement.querySelector('p');
//         mensaje.innerText = '*Mínimo una mayúscula, minúscula, núnmero y caracter especial';
//         elemento.classList.add('mensaje_error');
//     }
// }

