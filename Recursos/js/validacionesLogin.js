import * as funciones from './funcionesValidaciones.js';

//Objeto con expresiones regulares para los inptus
const validaciones = {
    user: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/
}
//VARIABLES GLOBALES
let estadoValidaciones = {
    campoVacioUser: true,
    campoVacioPassword: true,
    soloLetrasUser: true,
    limiteEspaciosUser: false,
    espaciosUser: true,
    espaciosPassword: true
}
const $form = document.getElementById('formLogin');
const $user = document.getElementById('userName');
const $password = document.getElementById('userPassword');
//  Cambiar tipo del candado para mostrar/ocultar contraseña
let iconClass = document.querySelector('.type-lock');
let icon_candado = document.querySelector('.lock');
//No permitir copiar, pegar y dar click derecho.
$(document).ready(function(){
    $('body').bind('cut copy paste', function(e){
        e.preventDefault();
    });
    $('body').on('contextmenu', function(e){
        return false;
    });
    //Detectar si viene de autoregistro y mostrar un Toast de confirmacion
    let $toastRegistro =  document.querySelector('.registro-exitoso');
    if($toastRegistro.id == '1'){
        $toastRegistro.id ='0';//Esto para que el mensaje se muestre solo cuando viene de registro
        //Creamos el toast que nos confirma la actualización de los permisos
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            customClass: { //Para agregar clases propias
                popup: 'customizable-toast'
              },
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        Toast.fire({
            icon: 'success',
            title: 'Registro de cuenta exitoso!'
        });
    }
});
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
/* ---------------- VALIDACIONES FORMULARIO LOGIN ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {  
    // console.log(estadoValidaciones.campoVacioUser, estadoValidaciones.campoVacioPassword);
  //Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoValidaciones.campoVacioUser  == false || estadoValidaciones.campoVacioPassword == false) {
        e.preventDefault();
        //Validamos que algún campo no esté vacío.
        estadoValidaciones.campoVacioUser =  funciones.validarCampoVacio($user);
        estadoValidaciones.campoVacioPassword = funciones.validarCampoVacio($password);
        console.log('Entro')
    } else 
    if(estadoValidaciones.espaciosUser == false || estadoValidaciones.espaciosPassword == false){ 
        e.preventDefault();
        estadoValidaciones.espaciosUser = funciones.validarEspacios($password);
        estadoValidaciones.espaciosPassword = funciones.validarEspacios($user); 
        console.log('Entro')
    } else
    if(estadoValidaciones.soloLetrasUser == false){
        e.preventDefault();
        estadoValidaciones.soloLetrasUser= funciones.validarSoloLetras($user, validaciones.user);
        console.log('Entro')
    } 
});
//Evento que llama a la función que valida espacios entre caracteres.
$user.addEventListener('keyup', () => {
    estadoValidaciones.espaciosUser = funciones.validarEspacios($user);
    //Validación con jQuery inputlimiter
    funciones.limitarCantidadCaracteres("userName", 15);
});
// Convierte usuario en mayúsuculas antes de enviar.
$user.addEventListener('focusout', () => {
    // estadoValidaciones.campoVacioUser = funciones.validarCampoVacio($user);
    if (estadoValidaciones.espaciosUser) {
        estadoValidaciones.soloLetrasUser = funciones.validarSoloLetras($user, validaciones.user);
    }
    if(estadoValidaciones.soloLetrasUser){
        estadoValidaciones.limiteEspaciosUser = funciones.validarMasdeUnEspacio($user);
    }
    let usuarioMayus = $user.value.toUpperCase();
    $user.value = usuarioMayus;
});
//Evento que llama a la función que valida espacios entre caracteres.
$password.addEventListener('keyup', () => {
    estadoValidaciones.espaciosPassword = funciones.validarEspacios($password);
    funciones.limitarCantidadCaracteres("userPassword", 20);
});
$password.addEventListener('focusout', () => {
    if($password.value.trim() == ''){
        estadoValidaciones.campoVacioPassword = funciones.validarCampoVacio($password);
    }
});
