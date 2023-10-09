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
let limiteContrasenia = true;

let estadoPasswordSegura ={
    estadoPassword : true
}
const expresiones = {
    password : /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,16}$/
}

const $form = document.getElementById('formContrasenia');
const $password = document.getElementById('password');
const $password2= document.getElementById('confirmPassword');

$form.addEventListener('submit', async e => {  
    let estadoInputPassword = funciones.validarCampoVacio($password);
    let estadoInputPassword2 = funciones.validarCampoVacio($password2);

    if (estadoInputPassword == false || estadoInputPassword2 == false){
        e.preventDefault();
    }else{
        if (estadoPasswordSegura.estadoPassword == false ) {
            estadoPasswordSegura.estadoPassword = funciones.validarPassword($password, expresiones.password);
         } else {
            try{
                limiteContrasenia = await funciones.cantidadParametrosContrasenia($password);
                if(limiteContrasenia == false){
                    e.preventDefault();
                }
            }catch(error){
                console.log(e);
             }
         }

        }
    });
    $password2.addEventListener('keyup',() =>{
        funciones.validarCoincidirPassword($password, $password2);
        funciones.limitarCantidadCaracteres("confirmPassword", 15);
    });
    $password.addEventListener('keyup', () => {
        funciones.validarPassword($password, expresiones.password);
        funciones.limitarCantidadCaracteres("password", 20);
    });
    $password.addEventListener('focusout', () => {
        limiteContrasenia = funciones.cantidadParametrosContrasenia($password);
    });
        
    $form.addEventListener('submit', e =>{
        let estado;
        let mensaje = $password2.parentElement.querySelector('p');
        if($password.value != $password2.value){
            mensaje.innerText = '*Las Contraseña no coincide';
            $password2.classList.add('mensaje_error');
            estado = false;
            } 
        else {
            $password2.classList.remove('mensaje_error');
            mensaje.innerText = '';
            estado = true;
        }
        if ($password.value != $password2.value) {
            e.preventDefault();
        }
        return estado;
    });
//Validacion en la cual no deje hacer submit hasta que la contraseña sea robusta
$form.addEventListener('submit', e => {
    let estado;
    let mensaje = $password.parentElement.querySelector('p');
    if ($password.value.trim() === ''){
        mensaje.innerText = '*Campo vacio';
        $password.classList.add('mensaje_error');
        estado = false;
    } else {
        $password.classList.remove('mensaje_error');
        mensaje.innerText = '';
        estado = true;
    }
    if ($password.value.trim() === '') {
        e.preventDefault();
    }
    return estado;
});
//Validacion en la cual no deje hacer submit hasta que la contraseña sea robusta

$form.addEventListener('submit', e =>{
    let mensaje = '';
    let input = $password.value;
    if(!expresiones.password.test(input)){
        mensaje = $password.parentElement.querySelector('p');
        mensaje.innerText = '*Mínimo una mayúscula, minúscula, número y caracter especial.';
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




