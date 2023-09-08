import * as funciones from './funcionesValidaciones.js';
export let estadoValidado = false;
//VARIABLES GLOBALES
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

// CAMPOS VACIOS
const $form = document.getElementById('formRegis');
const $nombre = document.getElementById('nombre');
const $usuario = document.getElementById('usuario');
const $password = document.getElementById('password');
const $password2 = document.getElementById('password2');
const $correo = document.getElementById('correo');

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
//objeto con expresiones regulares para los inptus
const expresiones = {
	usuario: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    user: /^(?=.*[^a-zA-Z\s])/, //Solo permite Letras
	nombre: /^(?=.*[^a-zA-Z\s])/, 
    password : /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/,
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
            if(estadoMasdeUnEspacio.estadoMasEspacioNombre == false || estadoValidacionesEspacio.estadoEspacioUsuario == false || estadoValidacionesEspacio.estadoEspacioPassword == false || 
                estadoValidacionesEspacio.estadoEspacioPassword2 == false || estadoValidacionesEspacio.estadoEspacioCorreo == false){ 
                e.preventDefault();
                estadoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($nombre);
                estadoValidacionesEspacio.estadoEspacioUsuario = funciones.validarEspacios($usuario);
                estadoValidacionesEspacio.estadoEspacioCorreo = funciones.validarEspacios($correo);
                estadoValidacionesEspacio.estadoEspacioPassword = funciones.validarEspacios($password); 
                estadoValidacionesEspacio.estadoEspacioPassword2 = funciones.validarEspacios($password2);
                    } else {
                        if(estadoLetrasRepetidas.estadoLetrasRepetidasNombre == false || estadoLetrasRepetidas.estadoPassword == false ||
                            estadoLetrasRepetidas.estadoLetrasRepetidasUsuario == false){
                            e.preventDefault();
                            estadoLetrasRepetidas.estadoLetrasRepetidasNombre = funciones.limiteMismoCaracter($nombre, expresiones.usuario);
                            estadoLetrasRepetidas.estadoLetrasRepetidasUsuario = funciones.limiteMismoCaracter($usuario, expresiones.usuario);
                            estadoLetrasRepetidas.estadoPassword = funciones.validarPassword($password, expresiones.password);
                        }
                         else{
                            if (estadoSoloLetras.estadoLetrasUsuario == false || estadoSoloLetras.estadoLetrasNombre == false) {
                                e.preventDefault();
                                estadoSoloLetras.estadoLetrasUsuario = funciones.validarSoloLetras($usuario, expresiones.user);
                                estadoSoloLetras.estadoLetrasNombre = funciones.validarSoloLetras($nombre, expresiones.user);
                            } else {
                                if(estadoMasdeUnEspacio.estadoMasEspacioNombre == false){
                                    e.preventDefault();
                                    estadoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($nombre);
                                } else {
                                    estadoValidado = true;
                                    console.log(estadoValidado);
                                }
                            }
                         }
                    }
            }
    });
// INPUTS TEXTOS EN MAYUSCULAS y //Solo permite letras
$usuario.addEventListener('focusout', () => {
    //console.log(estadoLetrasRepetidas.estadoLetrasRepetidasUsuario);
    if(estadoLetrasRepetidas.estadoLetrasRepetidasUsuario){
        funciones.validarSoloLetras($usuario, expresiones.user);
    }
    let usuarioMayus = $usuario.value.toUpperCase();
    $usuario.value = usuarioMayus;
});
$nombre.addEventListener('focusout', () =>{
    if(estadoMasdeUnEspacio.estadoMasEspacioNombre){
        funciones.validarMasdeUnEspacio($nombre);
    } else{
    if(estadoLetrasRepetidas.estadoLetrasRepetidasNombre){
        funciones.validarSoloLetras($nombre, expresiones.nombre);
    }
    }
    let nombreMayus = $nombre.value.toUpperCase();
    $nombre.value = nombreMayus;
});

//solo permitir una letra keyup Nombre
$nombre.addEventListener('keyup', ()=>{
    /* estadoCampoVacio.estadoVacioNombre = funciones.validarCampoVacio($nombre); */
    estadoLetrasRepetidas.estadoLetrasRepetidasNombre = funciones.limiteMismoCaracter($nombre, expresiones.usuario);
    funciones.limitarCantidadCaracteres("nombre", 20 );
});

$nombre.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasNombre = funciones.validarSoloLetras($nombre, expresiones.user);
}
);

// NO PERMITIR ESPACIOS
$usuario.addEventListener('keyup', () => {
    /* estadoCampoVacio.estadoVacioUsuario = funciones.validarCampoVacio($usuario); */
    let usuario = $('#usuario').val();
    obtenerUsuarioExiste(usuario);
    estadoValidacionesEspacio.estadoEspacioUsuario = funciones.validarEspacios($usuario);
    funciones.limitarCantidadCaracteres("usuario", 15 );
});
$correo.addEventListener('keyup', () => {
    funciones.validarEspacios($correo);
});
$password.addEventListener('keyup', () => {
    estadoValidacionesEspacio.estadoEspacioPassword = funciones.validarEspacios($password);
    funciones.limitarCantidadCaracteres("password", 15 );
});
$password2.addEventListener('keyup', () => {
    funciones.validarEspacios($password2);
});

//Validacion para que contraseña y confirmacion de contraseña coincidan
$password2.addEventListener('keyup',() =>{
    funciones.validarCoincidirPassword($password, $password2);
});

//Validacion en la cual no deje hacer submit hasta que las dos contraseñas coincidan

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
        mensaje.innerText = '*Mínimo 8 caracteres, una mayúscula, minúscula, número y caracter especial.';
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

    //llama a la funcion para validar la contraseña segura
    $password.addEventListener('focusout', () => {
        if(estadoValidacionesEspacio.estadoEspacioPassword){
            funciones.validarPassword($password, expresiones.password);
        }
        
    });
    //Para validar que el Usuario no coloque mas de tres veces un mismo caracter y para que no permita espacios
    $usuario.addEventListener('keyup', () => {
        estadoLetrasRepetidas.estadoLetrasRepetidasUsuario = funciones.limiteMismoCaracter($usuario, expresiones.usuario);
    });
$form.addEventListener('submit', e => {
        let mensaje = $usuario.parentElement.querySelector('p');
        let input = $usuario.value;
        if (expresiones.user.test(input)){
            mensaje.innerText = '*Solo se permiten letras.';
            $usuario.classList.add('mensaje_error');
        } else {
            mensaje.innerText = '';
            $usuario.classList.remove('mensaje_error');
        }
        if (expresiones.user.test(input)) {
            e.preventDefault();
        }
        
});
$form.addEventListener('submit', e => {
    let mensaje = $nombre.parentElement.querySelector('p');
    let input = $nombre.value;
    if (expresiones.nombre.test(input)){
        mensaje.innerText = '*Solo se permiten letras.';
        $nombre.classList.add('mensaje_error');
    } else {
        mensaje.innerText = '';
        $nombre.classList.remove('mensaje_error');
    }
    if (expresiones.nombre.test(input)) {
        e.preventDefault();
    }
});
$form.addEventListener('submit', e => {
    let estado;
    let mensaje = $nombre.parentElement.querySelector('p');
    if ($nombre.value.trim() === ''){
        mensaje.innerText = '*Campo vacio';
        $nombre.classList.add('mensaje_error');
        estado = false;
    } else {
        $nombre.classList.remove('mensaje_error');
        mensaje.innerText = '';
        estado = true;
    }
    if ($nombre.value.trim() === '') {
        e.preventDefault();
    }
    return estado;
});

$form.addEventListener('submit', e => {
    let estado;
    let mensaje = $usuario.parentElement.querySelector('p');
    if ($usuario.value.trim() === ''){
        mensaje.innerText = '*Campo vacio';
        $usuario.classList.add('mensaje_error');
        estado = false;
    } else {
        $usuario.classList.remove('mensaje_error');
        mensaje.innerText = '';
        estado = true;
    }
    if ($usuario.value.trim() === '') {
        e.preventDefault();
    }
    return estado;
});

$form.addEventListener('submit', e => {
    let mensaje = $nombre.parentElement.querySelector('p');
    let estado;
    let input = $nombre.value;
    let regex = /\s\s/g; //Expresión literal para saber si existen mas de un espacio en la cadena
    if (regex.test(input.trim())){ //Evaluamos expresion vs la cadena
        //Si existen especios mostramos mensaje de error
        mensaje.innerText = '*No se permite más un espacio entre palabras';
        $nombre.classList.add('mensaje_error');
        estado = false;
    } else {
        $nombre.classList.remove('mensaje_error');
        mensaje.innerText = '';
        estado = true;
    }
    if (regex.test(input.trim())) {
        e.preventDefault();
    }
    return estado;
});


let obtenerUsuarioExiste = ($usuario) => {
    $.ajax({
        url: "../../Vista/crud/usuario/usuarioExistente.php",
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
                estadoValidado = false;
            } else {
                document.getElementById('usuario').classList.remove('mensaje_error');
                document.getElementById('usuario').parentElement.querySelector('p').innerText = '';
                estadoValidado = true;
            }
        }
    });
} 
