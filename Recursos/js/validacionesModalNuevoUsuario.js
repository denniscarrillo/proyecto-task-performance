import * as funciones from './funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/,
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES
let estadoEspacioInput = {
    estadoEspacioUser: true,
    estadoEspacioPassword: true, 
} 
let estadoSoloLetras = {
    estadoLetrasUser: true,
    estadoLetrasName: true,
}
let estadoPassword = {
    estadoPassword1: true,
    estadoPassword2: true
}
let estadoSelect = true;
let estadoCorreo = true;

const $form = document.getElementById('form-usuario');
const $user = document.getElementById('usuario');
const $name = document.getElementById('nombre');
const $password = document.getElementById('password');
const $confirmarContrasenia = document.getElementById('password2');
const $correo = document.getElementById('correo');
const $rol = document.getElementById('rol');
let iconClass = document.querySelector('.type-lock');
let icon_candado = document.querySelector('.lock');

//Ocultar o mostrar contrasenia
icon_candado.addEventListener('click', function() { 
    if(this.nextElementSibling.type === "password"){
        this.nextElementSibling.type = "text";
        iconClass.classList.remove('fa-lock');
        iconClass.classList.add('fa-lock-open');
    } else {
        this.nextElementSibling.type = "password";
        iconClass.classList.remove('fa-lock-open');
        iconClass.classList.add('fa-lock');
    }
});
/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputNombre = funciones.validarCampoVacio($name);
    let estadoInputUser =  funciones.validarCampoVacio($user);
    let estadoInputPassword = funciones.validarCampoVacio($password);
    let estadoInputConfirmarContrasenia = funciones.validarCampoVacio($confirmarContrasenia);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    let estadoInputRol = funciones.validarCampoVacio($rol);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputNombre == false || estadoInputUser  == false || estadoInputPassword == false || 
        estadoInputConfirmarContrasenia == false || estadoInputCorreo == false || estadoInputRol == false) {
        e.preventDefault();
    } else {
        if(estadoEspacioInput.estadoEspacioUser == false || estadoEspacioInput.estadoEspacioPassword == false){ 
            e.preventDefault();
            estadoEspacioInput.estadoEspacioPassword = funciones.validarEspacios($password); 
            estadoEspacioInput.estadoEspacioUser = funciones.validarEspacios($user);
        } else {
            if(estadoSoloLetras.estadoLetrasUser == false || estadoSoloLetras.estadoLetrasName == false ||
                estadoPassword.estadoPassword1 == false || estadoPassword.estadoPassword2 == false){
                e.preventDefault();
                estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
                estadoSoloLetras.estadoLetrasUser = funciones.validarSoloLetras($user, validaciones.soloLetras);
                estadoPassword.estadoPassword1= funciones.validarPassword($password, validaciones.password);
                estadoPassword.estadoPassword2= funciones.validarCoincidirPassword($password, $confirmarContrasenia);
            } else {
                if(estadoCorreo == false || estadoSelect == false){
                    e.preventDefault();
                    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
                    estadoSelect = funciones.validarCampoVacio($rol);
                } else {
                    estadoValidado = true; // 
                }
            }
        }
    }
});
$name.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    $("#nombre").inputlimiter({
        limit: 50
    });
});
$name.addEventListener('focusout', ()=>{
    let usuarioMayus = $name.value.toUpperCase();
    $name.value = usuarioMayus;
});
//Evento que llama a la función que valida espacios entre caracteres.
$user.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioUser = funciones.validarEspacios($user);
    //Validación con jQuery inputlimiter
    $("#usuario").inputlimiter({
        limit: 15
    });
});
// Convierte usuario en mayúsuculas antes de enviar.
$user.addEventListener('focusout', () => {
    if(estadoEspacioInput.estadoEspacioUser){
        estadoSoloLetras.estadoLetrasUser = funciones.validarSoloLetras($user, validaciones.soloLetras);
    }
    let usuarioMayus = $user.value.toUpperCase();
    $user.value = usuarioMayus;
});
//Evento que llama a la función que valida espacios entre caracteres.
$password.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioPassword= funciones.validarEspacios($password);
    $("#password").inputlimiter({
        limit: 20
    });
});
//Evento que llama a la función para validar que la contraseña sea robusta.
$password.addEventListener('focusout',() => {
    //Mientras no se haya cumplido la validación de espacios no se ejecutara la de validar Password
    if(estadoEspacioInput.estadoEspacioPassword){
        estadoPassword.estadoPassword1 = funciones.validarPassword($password, validaciones.password);
    }
});
$confirmarContrasenia.addEventListener('focusout', ()=>{
    estadoPassword.estadoPassword2 = funciones.validarCoincidirPassword($password, $confirmarContrasenia);
});
$correo.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
});
$rol.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($rol);
});






