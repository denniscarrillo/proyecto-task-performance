import * as funciones from './funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,16}$/,
    pass: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])/,
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES
let estadoExisteUsuario = false;

let estadoExisteCorreo = false;

let limiteContrasenia = true;

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
let estadoMasdeUnEspacio = {
    estadoMasEspacioNombre: true
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


//Funcion para mostrar contraseña
$(document).ready(function () {
    $('#checkbox').click(function () {
        if ($(this).is(':checked')) {
            $('#password').attr('type', 'text');
            $('#password2').attr('type', 'text');
        } else {
            $('#password').attr('type', 'password');
            $('#password2').attr('type', 'password');
        }
    });
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
            estadoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($name);
            console.log(estadoMasdeUnEspacio.estadoMasEspacioNombre);
            if(estadoMasdeUnEspacio.estadoMasEspacioNombre == false){
                e.preventDefault();
                console.log(estadoMasdeUnEspacio.estadoMasEspacioNombre);
            } else {
                if (estadoExisteUsuario == false) {
                    e.preventDefault(); // Prevent form submission if username exists
                    estadoExisteUsuario = obtenerUsuarioExiste($('#usuario').val());
                } else {
                    if (estadoExisteCorreo == false) {
                        e.preventDefault(); // Prevent form submission if username exists
                        estadoExisteCorreo = obtenerCorreoExiste($('#correo').val());
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
                            estadoValidado = true;
                    }
                }
             }
            }
          }
        }
    }
});


$name.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("nombre", 100 );
});
$name.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioNombre){
        funciones.validarMasdeUnEspacio($name);
    }
    let usuarioMayus = $name.value.toUpperCase();
    $name.value = usuarioMayus;
});
//Evento que llama a la función que valida espacios entre caracteres.
$user.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioUser = funciones.validarEspacios($user);
    //Validación con jQuery inputlimiter
    funciones.limitarCantidadCaracteres("usuario", 25 );
});
// Convierte usuario en mayúsuculas antes de enviar.
$user.addEventListener('focusout', () => {
    if(estadoEspacioInput.estadoEspacioUser){
        let letras = funciones.validarSoloLetras($user, validaciones.soloLetras);
    if(letras) {
        let usuario = $('#usuario').val();
        estadoExisteUsuario = obtenerUsuarioExiste(usuario); 
       } 
    }
    let usuarioMayus = $user.value.toUpperCase();
    $user.value = usuarioMayus;
});
//Evento que llama a la función que valida espacios entre caracteres.
$password.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioPassword= funciones.validarEspacios($password);
    if(estadoEspacioInput.estadoEspacioPassword){
        estadoPassword.estadoPassword1 = funciones.validarPassword($password, validaciones.password);
    }
    funciones.limitarCantidadCaracteres("password", 25 );
});
$confirmarContrasenia.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioPassword= funciones.validarEspacios($confirmarContrasenia);
    if(estadoEspacioInput.estadoEspacioPassword){
        estadoPassword.estadoPassword1 = funciones.validarPassword($confirmarContrasenia, validaciones.password);
    }
    funciones.limitarCantidadCaracteres("password2", 25 );
});
//Evento que llama a la función para validar que la contraseña sea robusta.
$password.addEventListener('focusout',() => {
    //Mientras no se haya cumplido la validación de espacios no se ejecutara la de validar Password
    if(estadoEspacioInput.estadoEspacioPassword){
       let contrasenia = funciones.validarEspacios($password);
         if(contrasenia){
                limiteContrasenia = cantidadParametrosContrasenia($password);
         }
    }
});
$confirmarContrasenia.addEventListener('focusout', ()=>{
    estadoPassword.estadoPassword2 = funciones.validarCoincidirPassword($password, $confirmarContrasenia);
});
$correo.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
    funciones.limitarCantidadCaracteres("correo", 50 );
});
$correo.addEventListener('focusout', ()=>{
    if(estadoCorreo){
        let validarCorreo = funciones.validarCorreo($correo, validaciones.correo);
        if(validarCorreo){
            estadoExisteCorreo = obtenerCorreoExiste($('#correo').val());
        }
    }
});

$rol.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($rol);
});


let obtenerUsuarioExiste = ($usuario) => {
    $.ajax({
        url: "../../../Vista/crud/usuario/usuarioExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            usuario: $usuario
        },
        success: function (usuario) {
            let $objUsuario = JSON.parse(usuario);
            if ($objUsuario.estado == 'true') {
                document.getElementById('usuario').classList.add('mensaje_error');
                document.getElementById('usuario').parentElement.querySelector('p').innerText = '*Usuario ya existe';
                estadoExisteUsuario = false; // Username exists, set to false
            } else {
                document.getElementById('usuario').classList.remove('mensaje_error');
                document.getElementById('usuario').parentElement.querySelector('p').innerText = '';
                estadoExisteUsuario = true; // Username doesn't exist, set to true
            }
        }
        
    });
}

 const cantidadParametrosContrasenia = ($password) => {
    return new Promise(async (resolve, reject) => {
        let mensaje = $password.parentElement.querySelector('p');
        try {
            const data = await $.ajax({
                url: "../../../Vista/crud/usuario/validarParametrosContrasenia.php",
                type: "POST",
                dataType: "JSON",
            });

            let minLength = data[0];
            let maxLength = data[1];

            if ($password.value.length < minLength || $password.value.length > maxLength) {
                mensaje.innerText = '*Mínimo ' + minLength + ', máximo ' + maxLength + ' caracteres.';
                $password.classList.add('mensaje_error');
                resolve(false); // Resolve the promise with false
            } else {
                mensaje.innerText = '';
                $password.classList.remove('mensaje_error');
                resolve(true); // Resolve the promise with true
            }
        } catch (error) {
            console.log(error);
            reject(error); // Reject the promise if there's an error
        }
    });
};

$form.addEventListener('submit', async e => {
    try {
        limiteContrasenia =  await cantidadParametrosContrasenia($password); 
        console.log(limiteContrasenia);
        if (limiteContrasenia == false) {
           console.log(limiteContrasenia);
        e.preventDefault();
        }
        } catch (error) {
            console.log(error);
        }
    });

    let obtenerCorreoExiste = ($correo) => {
        $.ajax({
            url: "../../../Vista/crud/usuario/correoExiste.php",
            type: "POST",
            datatype: "JSON",
            data: {
                correo: $correo
            },
            success: function (correo) {
                let $objCorreo = JSON.parse(correo);
                if ($objCorreo.estado == 'true') {
                    document.getElementById('correo').classList.add('mensaje_error');
                    document.getElementById('correo').parentElement.querySelector('p').innerText = '*El correo proporcionado ya está en uso. Por favor, ingrese otro.';
                    estadoExisteCorreo = false; // El correo existe, set to false
                } else {
                    document.getElementById('correo').classList.remove('mensaje_error');
                    document.getElementById('correo').parentElement.querySelector('p').innerText = '';
                    estadoExisteCorreo = true; // El correo no existe, set to true
                }
            }
        });
    }


// || estadoMasdeUnEspacio.estadoMasEspacioNombre == true



