import * as funciones from './funcionesValidaciones.js';

//  Cambiar tipo del candado para mostrar/ocultar contraseña
let iconClass = document.getElementsByClassName('type-lock');
let iconClass1 = document.getElementsByClassName('type-lock');
let icon_candado = document.querySelector('.lock');
let icon_candado1 = document.querySelector('.lock1');

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
icon_candado1.addEventListener('click', function() { 
    if(this.nextElementSibling.type === "password"){
        this.nextElementSibling.type = "text";
        iconClass1.classList.remove('fa-lock');
        iconClass1.classList.add('fa-lock-open');
    } else {
        this.nextElementSibling.type = "password";
        iconClass1.classList.remove('fa-lock-open');
        iconClass1.classList.add('fa-lock');
    }
});

let estadoPasswordSegura ={
    estadoPassword : true
}
const expresiones = {
    password : /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/
}

const $form = document.getElementById('formContrasenia');
const $password = document.getElementById('password');
const $password2= document.getElementById('confirmPassword');

$form.addEventListener('submit', e => {  
    let estadoInputPassword = funciones.validarCampoVacio($password);
    let estadoInputPassword2 = funciones.validarCampoVacio($password2);

    if (estadoInputPassword == false || estadoInputPassword2 == false){
        e.preventDefault();
    }else{
        if (estadoPasswordSegura.estadoPassword == false ) {
            estadoPasswordSegura.estadoPassword = funciones.validarPassword($password, expresiones.password);
        }
                           
        }
    });
    $password2.addEventListener('keyup',() =>{
        funciones.validarCoincidirPassword($password, $password2);
    });
    $password.addEventListener('focusout', () => {
        funciones.validarPassword($password, expresiones.password);
    });
        
$form.addEventListener('submit', e =>{
    let mensaje = '';
    let div = '';
    if($password.value != $password2.value){
        div = $password2.parentElement 
        mensaje = div.querySelector('p');
        mensaje.innerText = '*Las Contraseñas no coinciden';
        $password2.classList.add('mensaje_error');
    } 
    else {
        $password2.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
    if ($password.value != $password2.value) {
        e.preventDefault();
    }
});
//Validacion en la cual no deje hacer submit hasta que la contraseña sea robusta
$form.addEventListener('submit', e =>{
    let mensaje = '';
    let input = $password.value;
    if(!expresiones.password.test(input)){
        mensaje = $password.parentElement.querySelector('p');
        mensaje.innerText = '*Campo Vacio.';
        $password.classList.add('mensaje_error');
    } 
    else {
        mensaje = $password.parentElement.querySelector('p');
        $password.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
    if (!expresiones.password.test(input)) {
        e.preventDefault();
    }
}); 


