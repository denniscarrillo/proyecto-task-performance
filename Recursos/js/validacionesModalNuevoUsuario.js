//objeto con expresiones regulares para los inptus
const validaciones = {
    // (?=.*[A-Z])(?!.*\s)
    usuario: /^(?=.*[A-Z])/,
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/
}

const $nombreUsuario = document.getElementById('nombre');
const $usuario = document.getElementById('usuario');
const $contrasenia = document.getElementById('password');
const $confirmarContrasenia = document.getElementById('password2');

// USUARIO EN MAYUSCULAS
$nombreUsuario.addEventListener('focusout', () => {
    let nombreMayus = $nombreUsuario.value.toUpperCase();
    $nombreUsuario.value = nombreMayus;
});
$usuario.addEventListener('focusout', () => {
    let usuarioMayus = $usuario.value.toUpperCase();
    $usuario.value = usuarioMayus;
});

// NO PERMITIR ESPACIOS
$usuario.addEventListener('keyup', e => {
    validarEspacios(e, $usuario);
    //Validación con jQuery inputlimiter
    $("#usuario").inputlimiter({
        limit: 15
    });
});
$contrasenia.addEventListener('keyup', e => {
    validarEspacios(e, $contrasenia);
    $("#password").inputlimiter({
        limit: 20
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
};

//VALIDAR QUE LA CONTRASEÑA Y CONFIRMAR CONTRASEÑA COINCIDAN
$confirmarContrasenia.addEventListener('focusout',() =>{
    let mensaje = '';
    let div = '';
    if($contrasenia.value != $confirmarContrasenia.value){
        div = $confirmarContrasenia.parentElement
        mensaje = div.querySelector('p');
        mensaje.innerText = '*Las contraseñas no coinciden';
        $confirmarContrasenia.classList.add('mensaje_error');
    }else{
        $confirmarContrasenia.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
})

// VALIDAR QUE SE CUMPLAN LAS REGLAS MÍNIMAS PARA LA CONTRASEÑA
$contrasenia.addEventListener('focusout',() => {
    validarPassword($contrasenia);
});

const validarPassword = elemento => {
    let mensaje = '';
    let input = elemento.value;
    if (!validaciones.contrasenia.test(input)){
        mensaje = elemento.parentElement.querySelector('p');
        mensaje.innerText = '*Mínimo 8 caracteres, una mayúscula, minúscula, número y caracter especial.';
        elemento.classList.add('mensaje_error');
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
    }
}
