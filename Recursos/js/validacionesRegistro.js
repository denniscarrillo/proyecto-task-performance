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
//(?=.*[^a-zA-Z])
//^(?=.*[A-Z])(?=.*[^A-Z(.)\1]))
/* VALIDACIONES FORMULARIO REGISTRO */
//objeto con expresiones regulares para los inptus
const expresiones = {
	usuario: /^(?=.*(.)\1)/, // no permite escribir que se repida mas de dos veces un caracter
	nombre: /^(?=.*[^a-zA-Z\s])/, 
    password : /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/,
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
}
// CAMPOS VACIOS
const $form = document.getElementById('formRegis');
const $usuario = document.getElementById('usuario');
const $nombre = document.getElementById('nombre');
const $password = document.getElementById('password');
const $password2 = document.getElementById('password2');
const $correo = document.getElementById('correo');
/* const Registro = document.querySelectorAll('.form-grupo'); */
/*  const inputs = document.querySelectorAll('.input'); */
/* const Btnregistrar = document.querySelector('.btn '); */ 

//Cuando se quiera enviar el formulario de registro, primero se validaran si los inputs no estan vacios
$form.addEventListener('submit', e => {   
    if ($usuario.value.trim() === ''){
        let div = $usuario.parentElement 
        let mensaje = div.querySelector('p');
        mensaje.innerText = '*Campo vacio';
        $usuario.classList.add('mensaje_error');
    } 
    else {
        let div = $usuario.parentElement 
        let mensaje = div.querySelector('p');
        $usuario.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
	if ($nombre.value.trim() === ''){
        let div = $nombre.parentElement 
        let mensaje = div.querySelector('p');
        mensaje.innerText = '*Campo vacio';
        $nombre.classList.add('mensaje_error');
    } 
    else {
        let div = $nombre.parentElement 
        let mensaje = div.querySelector('p');
        $nombre.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
    if ($password.value.trim() === '') {
        let div = $password.parentElement 
        let mensaje = div.querySelector('p');
        mensaje.innerText = '*Campo vacio';
        $password.classList.add('mensaje_error');
    } 
    else {
        let div = $password.parentElement 
        let mensaje = div.querySelector('p');
        $password.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
	if ($password2.value.trim() === '') {
        let div = $password2.parentElement 
        let mensaje = div.querySelector('p');
        mensaje.innerText = '*Campo vacio';
        $password2.classList.add('mensaje_error');
    } 
    else {
        let div = $password2.parentElement 
        let mensaje = div.querySelector('p');
        $password2.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
	if ($correo.value.trim() === ''){
        let div = $correo.parentElement 
        let mensaje = div.querySelector('p');
        mensaje.innerText = '*Campo vacio';
        $correo.classList.add('mensaje_error');
    } 
    else {
        let div = $correo.parentElement 
        let mensaje = div.querySelector('p');
        $correo.classList.remove('mensaje_error');
        mensaje.innerText = '';
    }
    if ($usuario.value.trim() === '' || $nombre.value.trim() === '' || $password.value.trim() === '' || $correo.value.trim() === '' ) {
        e.preventDefault();
    }
});
// INPUTS TEXTOS EN MAYUSCULAS
$usuario.addEventListener('focusout', () => {
    let usuarioMayus = $usuario.value.toUpperCase();
    $usuario.value = usuarioMayus;
});

$nombre.addEventListener('focusout', () =>{
    let nombreMayus = $nombre.value.toUpperCase();
    $nombre.value = nombreMayus;
});

// NO PERMITIR ESPACIOS
$usuario.addEventListener('keyup', e => {
    validarEspacios(e, $usuario);
});
$correo.addEventListener('keyup', e => {
    validarEspacios(e, $correo);
});
$password.addEventListener('keyup', e => {
    validarEspacios(e, $password);
});
$password2.addEventListener('keyup', e => {
    validarEspacios(e, $password2);
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

const campos = {
	usuario: false,
	nombre: false,
    estado: false,
    contrasenia: false,
    correo: false,
	
	
}

//Validacion para que contraseña y confirmacion de contraseña coincidan
$password2.addEventListener('keyup',() =>{
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
});

//Validacion en la cual no deje hacer submit hasta que las dos contraseñas coincidan

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
    $password.addEventListener('keyup', () => {
        validarPassword($password);
    });
    //Para validar que la contraseña sea segura
    const validarPassword = elemento => {
        let mensaje = '';
        let input = elemento.value;
        if (!expresiones.password.test(input)){
            mensaje = elemento.parentElement.querySelector('p');
            mensaje.innerText = '*Mínimo 8 caracteres, una mayúscula, minúscula, número y caracter especial.';
            elemento.classList.add('mensaje_error');
        } else {
            mensaje.innerText = '';
            elemento.classList.remove('mensaje_error');
        }
    }
    $usuario.addEventListener('keyup', () => {
        limitedeCaracteres($usuario);
    });
    const limitedeCaracteres = elemento => {
        let mensaje = elemento.parentElement.querySelector('p');
        let input = elemento.value;
        if (expresiones.usuario.test(input)){
            mensaje.innerText = '*No debe colocar tres caracteres seguidos.';
            elemento.classList.add('mensaje_error');
        } else {
            mensaje.innerText = '';
            elemento.classList.remove('mensaje_error');
        }
    }

    $nombre.addEventListener('keyup', () => {
        soloLetras($nombre);
    });
    const soloLetras= elemento => {
        let mensaje = elemento.parentElement.querySelector('p');
        let input = elemento.value;
        if (expresiones.nombre.test(input)){
            mensaje.innerText = '*Solo se permiten letras.';
            elemento.classList.add('mensaje_error');
        } else {
            mensaje.innerText = '';
                elemento.classList.remove('mensaje_error');
        }
    }

    $usuario.addEventListener('focusout', () => {
    let usuario = $usuario.value;
    let mensaje='';
    // let mensaje = $usuario.parentElement.querySelector('p').innerText='EVENTO '+usuario;
        $.ajax({
            url: "../../../Vista/login/validarRegistro.php",
            type: "POST",
            datatype: "JSON",
            data: {
             nuevoUsuario: usuario
            },
            success:function(data) {
                if(data[0].usuario > 0){
                  mensaje = $usuario.parentElement.querySelector('p')
                  mensaje.innerText = '*Este usuario ya existe';
                  $usuario.classList.add('mensaje_error');
                }
                else{
                    mensaje.innerText = '';
                    $usuario.classList.remove('mensaje_error');
                }
            }
          });
    })
