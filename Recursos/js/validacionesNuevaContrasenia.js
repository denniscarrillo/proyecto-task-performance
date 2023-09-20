import * as funciones from './funcionesValidaciones.js';

//  Cambiar tipo del candado para mostrar/ocultar contraseña
$(document).ready(function () {
    $('#checkbox').click(function () {
        if ($(this).is(':checked')) {
            $('#password').attr('type', 'text');
            $('#confirmPassword').attr('type', 'text');
        } else {
            $('#password').attr('type', 'password');
            $('#confirmPassword').attr('type', 'password');
        }
    });
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
        funciones.limitarCantidadCaracteres("confirmPassword", 15);
    });
    $password.addEventListener('keyup', () => {
        funciones.validarPassword($password, expresiones.password);
        funciones.limitarCantidadCaracteres("password", 15);
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
    $form.addEventListener('submit', e =>{
            let mensaje = $password.parentElement.querySelector('p');
            let estado;
            let input = $password.value;
            if (!expresiones.test(input)){
                mensaje.innerText = '*Mínimo 8 caracteres, una mayúscula, minúscula, número y caracter especial.';
                $password.classList.add('mensaje_error');
                estado =  false;
            } else {
                mensaje.innerText = '';
                $password.classList.remove('mensaje_error');
                estado = true;
            }
            return estado;
        }
    );

}); 


