import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,16}$/,
    pass: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])/,
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES

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

const $form = document.getElementById('formPerfilContrasenia');

const $password = document.getElementById('confirmPassword');
const $confirmarContrasenia = document.getElementById('confirmPassword');




//Funcion para mostrar contraseña
$(document).ready(function () {
    $('#checkbox').click(function () {
        if ($(this).is(':checked')) {
            $('#confirmPassword').attr('type', 'text');
         
        } else {
            $('#confirmPassword').attr('type', 'password');
          
        }
    });
});

$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.

    let estadoInputPassword = funciones.validarCampoVacio($password);
    let estadoInputConfirmarContrasenia = funciones.validarCampoVacio($confirmarContrasenia);
    
    // Comprobamos que todas las validaciones se hayan cumplido 
    if ( estadoInputPassword == false || estadoInputConfirmarContrasenia == false ) {
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
                if( estadoPassword.estadoPassword1 == false || estadoPassword.estadoPassword2 == false){
                    e.preventDefault();
                    estadoPassword.estadoPassword1= funciones.validarPassword($password, validaciones.password);
                    estadoPassword.estadoPassword2= funciones.validarCoincidirPassword($password, $confirmarContrasenia);
                    } else {
                            estadoValidado = true;
                    }
                
             }
            
          
        }
    }
});


//Evento que llama a la función que valida espacios entre caracteres.
$password.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioPassword= funciones.validarEspacios($password);
    if(estadoEspacioInput.estadoEspacioPassword){
        estadoPassword.estadoPassword1 = funciones.validarPassword($password, validaciones.password);
    }
    funciones.limitarCantidadCaracteres("password", 20 );
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

