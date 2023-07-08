import * as funciones from './funcionesValidaciones.js';

//Objeto con expresiones regulares para los inptus
const validaciones = {
    user: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/
}

//VARIABLES GLOBALES
let estadoEspacioUser, estadoEspacioPassword, estadoLetras, estadoContrasenia;

const $form = document.getElementById('formLogin');
const $user = document.getElementById('userName');
const $password = document.getElementById('userPassword');
const $btnSubmit = document.getElementById('btn-submit');
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
/* ---------------- VALIDACIONES FORMULARIO LOGIN ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputUser =  funciones.validarCampoVacio($user);
    let estadoInputPassword = funciones.validarCampoVacio($password);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputUser == false || estadoInputPassword == false){
        e.preventDefault();
        if(estadoEspacioUser == false || estadoEspacioPassword == false){ 
            funciones.validarEspacios($password);
            funciones.validarEspacios($user); 
            funciones.validarSoloLetrasUser($user);
            funciones.validarPassword($password);
        }    
    }
});
// Convierte usuario en mayúsuculas antes de enviar.
$user.addEventListener('focusout', () => {
    if(estadoEspacioUser){
        funciones.validarSoloLetrasUser($user);
    }
    let usuarioMayus = $user.value.toUpperCase();
    $user.value = usuarioMayus;
});
//Evento que llama a la función que valida espacios entre caracteres.
$user.addEventListener('keyup', () => {
    estadoEspacioUser = funciones.validarEspacios($user);
    //Validación con jQuery inputlimiter
    $("#userName").inputlimiter({
        limit: 15
    });
});
//Evento que llama a la función que valida espacios entre caracteres.
$password.addEventListener('keyup', () => {
    estadoEspacioPassword = funciones.validarEspacios($password);
    $("#userPassword").inputlimiter({
        limit: 20
    });
});
////Evento que llama a la función para validar que la contraseña sea robusta.
$password.addEventListener('focusout',() => {
    //Mientras no se haya cumplido la validación de espacios no se ejecutara la de validar Password
    if(estadoEspacioPassword){
        estadoEspacioPassword = funciones.validarPassword($password, validaciones.password);
    }
});