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

/* VALIDACIONES FORMULARIO REGISTRO */
//objeto con expresiones regulares para los inptus
const expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	password: /^(?=.*\d)(?=.*[a-z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/, // 8 a 15 digitos.
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
// USUARIO EN MAYUSCULAS
$usuario.addEventListener('focusout', () => {
    let usuarioMayus = $usuario.value.toUpperCase();
    $usuario.value = usuarioMayus;
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


/* const validarRegistro = (e) => {
	switch (e.target.name) {
		case "nombre":
			validarCampo(expresiones.nombre, e.target, 'nombre');
		break;
		case "usuario":
			validarCampo(expresiones.usuario, e.target, 'usuario');
		break;
        case "CorreoElectronico":
			validarCampo(expresiones.correo, e.target, 'CorreoElectronico');
		break;
		case "contraseña":
			validarCampo(expresiones.contrasenia, e.target, 'contraseña');
			validarPassword2();
		break;
		case "confirtmarContraseña":
			validarPassword2();
		break;
	}
}
 */
/* const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value)){
		document.getElementById(`grupo__${campo}`).classList.remove('form-control-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('form-control-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-check-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-times-circle');
		campos[campo] = true;
	} else {
		document.getElementById(`grupo__${campo}`).classList.add('form-control-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('form-control-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('fa-times-circle');
		document.querySelector(`#grupo__${campo} i`).classList.remove('fa-check-circle');
		campos[campo] = false;
	}
} */

   /*  inputs.forEach((input) = () => {
	input.addEventListener('keyup', validarRegistro);
	input.addEventListener('blur', validarRegistro);
	}); */
	/* 
	
		if(campos.usuario && campos.nombre && campos.password && campos.correo && campos.telefono && terminos.checked ){
			formulario.reset();
	
			document.getElementById('formulario__mensaje-exito').classList.add('formulario__mensaje-exito-activo');
			setTimeout(() => {
				document.getElementById('formulario__mensaje-exito').classList.remove('formulario__mensaje-exito-activo');
			}, 5000);
	
			document.querySelectorAll('.formulario__grupo-correcto').forEach((icono) => {
				icono.classList.remove('formulario__grupo-correcto');
			});
		} else {
			document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
		}
	}); */
	/* const validarPassword2 = () => {
		const inputPassword1 = document.getElementById('password');
		const inputPassword2 = document.getElementById('password2');
	
		if(inputPassword1.value !== inputPassword2.value){
			document.getElementById(`grupo__password2`).classList.add('form-control-incorrecto');
			document.getElementById(`grupo__password2`).classList.remove('form-control-correcto');
			document.querySelector(`#grupo__password2 i`).classList.add('fa-times-circle');
			document.querySelector(`#grupo__password2 i`).classList.remove('fa-check-circle');
			expresiones['password'] = false;
		} else {
			document.getElementById(`grupo__password2`).classList.remove('form-control-incorrecto');
			document.getElementById(`grupo__password2`).classList.add('form-control-correcto');
			document.querySelector(`#grupo__password2 i`).classList.remove('fa-times-circle');
			document.querySelector(`#grupo__password2 i`).classList.add('fa-check-circle');
			expresiones['password'] = true;
		}
	} 

	if(campos.usuario && campos.nombre && campos.password && campos.correo){
		formRegis.reset();


		document.querySelectorAll('.form-control-correcto').forEach((icono) => {
			icono.classList.remove('form-control-correcto');
		});
	} */