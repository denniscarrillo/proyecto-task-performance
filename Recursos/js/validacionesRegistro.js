import * as funciones from './funcionesValidaciones.js';
//VARIABLES GLOBALES
let estadoExisteUsuario = false;

let estadoExisteCorreo = false;

let limiteContrasenia = true;

let estadoValidacionesEspacio = {
    estadoEspacioUsuario: true,
    estadoEspacioCorreo: true,
    estadoEspacioPassword: true,
    estadoEspacioPassword2: true
}
let estadoLetrasRepetidas = {
    estadoLetrasRepetidasUsuario: true,
    estadoLetrasRepetidasNombre: true,
    estadoPassword: true
}
let estadoSoloLetras = {
    estadoLetrasUsuario: true,
    estadoLetrasNombre: true,
}
let estadoMasdeUnEspacio = {
    estadoMasEspacioNombre: true
}

//Nuevo comentario

// INPUTS
const $form = document.getElementById('formRegis');
const $nombre = document.getElementById('nombre');
const $usuario = document.getElementById('usuario');
const $password = document.getElementById('password');
const $password2 = document.getElementById('password2');
const $correo = document.getElementById('correo');

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

//objeto con expresiones regulares para los inptus
const expresiones = {
	usuario: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    user: /^(?=.*[^a-zA-Z\s])/, //Solo permite Letras
	nombre: /^(?=.*[^a-zA-Z\s])/, 
    password : /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,16}$/,
    pass: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])./,
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
}

//Cuando se quiera enviar el formulario de registro, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {  
    let estadoInputNombre = funciones.validarCampoVacio($nombre);
    let estadoInputUsuario = funciones.validarCampoVacio($usuario);
    let estadoInputPassword = funciones.validarCampoVacio($password);
    let estadoInputPassword2 = funciones.validarCampoVacio($password2);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);

    if (estadoInputNombre == false || estadoInputUsuario  == false || estadoInputPassword == false || 
        estadoInputPassword2 == false || estadoInputCorreo == false){
        e.preventDefault();
     } else {
            if(estadoValidacionesEspacio.estadoEspacioUsuario == false || estadoValidacionesEspacio.estadoEspacioPassword == false || 
                estadoValidacionesEspacio.estadoEspacioPassword2 == false || estadoValidacionesEspacio.estadoEspacioCorreo == false){ 
                e.preventDefault();
                estadoValidacionesEspacio.estadoEspacioUsuario = funciones.validarEspacios($usuario);
                estadoValidacionesEspacio.estadoEspacioCorreo = funciones.validarEspacios($correo);
                estadoValidacionesEspacio.estadoEspacioPassword = funciones.validarEspacios($password); 
                estadoValidacionesEspacio.estadoEspacioPassword2 = funciones.validarEspacios($password2);
                    } else {
                           estadoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($nombre);
                            console.log(estadoMasdeUnEspacio.estadoMasEspacioNombre);
                        if (estadoMasdeUnEspacio.estadoMasEspacioNombre == false) {
                            e.preventDefault();
                            console.log(estadoMasdeUnEspacio.estadoMasEspacioNombre);
                            // return estadoMasdeUnEspacio.estadoMasEspacioNombre;
                        } else {
                               if (estadoExisteUsuario == false) { // Check for 'true' instead of 'false'
                                    console.log(estadoExisteUsuario);
                                    e.preventDefault(); // Prevent form submission if username exists
                                    estadoExisteUsuario =  obtenerUsuarioExiste($('#usuario').val());
                                    console.log(estadoExisteUsuario);
                                } else {
                                    if(estadoExisteCorreo == false){
                                        e.preventDefault();
                                        estadoExisteCorreo = obtenerCorreoExiste($('#correo').val());
                                    } else {
                                    if(estadoLetrasRepetidas.estadoLetrasRepetidasNombre == false ||estadoLetrasRepetidas.estadoLetrasRepetidasUsuario == false ||
                                        estadoLetrasRepetidas.estadoPassword == false){
                                        e.preventDefault();
                                        estadoLetrasRepetidas.estadoLetrasRepetidasNombre = funciones.limiteMismoCaracter($nombre, expresiones.usuario);
                                        estadoLetrasRepetidas.estadoLetrasRepetidasUsuario = funciones.limiteMismoCaracter($usuario, expresiones.usuario);
                                        estadoLetrasRepetidas.estadoPassword = funciones.validarPassword($password, expresiones.password);
                                    } else {
                                         if (estadoSoloLetras.estadoLetrasUsuario == false || estadoSoloLetras.estadoLetrasNombre == false) {
                                              e.preventDefault();
                                              estadoSoloLetras.estadoLetrasUsuario = funciones.validarSoloLetras($usuario, expresiones.user);
                                              estadoSoloLetras.estadoLetrasNombre = funciones.validarSoloLetras($nombre, expresiones.user);
                                } 
                            }
                          }
                         }
                    }
                }
            }
    });
// INPUTS TEXTOS EN MAYUSCULAS y //Solo permite letras
$usuario.addEventListener('focusout', () => {
    if (estadoLetrasRepetidas.estadoLetrasRepetidasUsuario) {
        let letras = funciones.validarSoloLetras($usuario, expresiones.user);
        if (letras) {
            let usuario =   $('#usuario').val();
                estadoExisteUsuario = obtenerUsuarioExiste(usuario);
        }
    }

    let usuarioMayus = $usuario.value.toUpperCase();
    $usuario.value = usuarioMayus;
});

$nombre.addEventListener('focusout', () =>{
    if(estadoMasdeUnEspacio.estadoMasEspacioNombre){
        funciones.validarMasdeUnEspacio($nombre);
    }
    let nombreMayus = $nombre.value.toUpperCase();
    $nombre.value = nombreMayus;
});

//solo permitir una letra keyup Nombre
$nombre.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasNombre = funciones.validarSoloLetras($nombre, expresiones.user);
    if(estadoSoloLetras.estadoLetrasNombre){
    estadoLetrasRepetidas.estadoLetrasRepetidasNombre = funciones.limiteMismoCaracter($nombre, expresiones.usuario);
    }
    funciones.limitarCantidadCaracteres("nombre", 20 );
});

// NO PERMITIR ESPACIOS
$usuario.addEventListener('keyup', () => {
    /* estadoCampoVacio.estadoVacioUsuario = funciones.validarCampoVacio($usuario); */
    estadoValidacionesEspacio.estadoEspacioUsuario = funciones.validarEspacios($usuario);
    if(estadoValidacionesEspacio.estadoEspacioUsuario){
    estadoLetrasRepetidas.estadoLetrasRepetidasUsuario = funciones.limiteMismoCaracter($usuario, expresiones.usuario);
    }
    funciones.limitarCantidadCaracteres("usuario", 15 );
    
});
$correo.addEventListener('keyup', () => {
    funciones.validarEspacios($correo);
});
$password.addEventListener('keyup', () => {
    estadoValidacionesEspacio.estadoEspacioPassword = funciones.validarEspacios($password);
    if(estadoValidacionesEspacio.estadoEspacioPassword){
        let validado = estadoLetrasRepetidas.estadoPassword = funciones.validarPassword($password, expresiones.pass);
        if(validado){
            estadoValidacionesEspacio.estadoEspacioPassword = funciones.validarEspacios($password);
      }
    }
    funciones.limitarCantidadCaracteres("password", 20);
});
$password.addEventListener('focusout', () => {
        if(estadoValidacionesEspacio.estadoEspacioPassword){
            let contrasenia = funciones.validarEspacios($password);
            if(contrasenia){
                limiteContrasenia = funciones.cantidadParametrosContrasenia($password);
            }
        }
});
$password2.addEventListener('keyup', () => {
    funciones.validarEspacios($password2);
    funciones.limitarCantidadCaracteres("password2", 20);
});

//Validacion para que contraseña y confirmacion de contraseña coincidan
$password2.addEventListener('keyup',() =>{
    funciones.validarCoincidirPassword($password, $password2);
});

// $correo.addEventListener('focusout', () => {
//     funciones.limitarCantidadCaracteres("correo", 50);
// });
$correo.addEventListener('focusout', () => {
    let correo = $('#correo').val();
    estadoExisteCorreo = obtenerCorreoExiste(correo);
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

$form.addEventListener('submit', async e => {
try {
    limiteContrasenia =  await funciones.cantidadParametrosContrasenia($password); 
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
                document.getElementById('correo').parentElement.querySelector('p').innerText = '*Correo ya existente, agregue otro';
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