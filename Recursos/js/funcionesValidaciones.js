// export let estadoEspacioUser;

//Objeto con expresiones regulares para los inptus
const validaciones = {
    user: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/
}
//Validar que haya espacios entre palabras
export const validarEspacios = elemento => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    let regex = /\s/g; //Expresión literal para saber si existen espacios en la cadena
    if (regex.test(input.trim())){ //Evaluamos expresion vs la cadena
        //Si existen especios mostramos mensaje de error
        mensaje.innerText = '*No se permiten espacios';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        elemento.classList.remove('mensaje_error');
        mensaje.innerText = '';
        estado = true;
    }
    return estado;
};

// VALIDAR QUE SE CUMPLAN LAS REGLAS MÍNIMAS PARA LA CONTRASEÑA
export const validarPassword = elemento => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    if (!validaciones.password.test(input)){
        mensaje.innerText = '*Mínimo 8 caracteres, una mayúscula, minúscula, número y caracter especial.';
        elemento.classList.add('mensaje_error');
        estado =  false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}
export const validarSoloLetrasUser = elemento => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    if (validaciones.user.test(input)){
        mensaje.innerText = '*Solo se permiten letras.';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}
//Funcion para validar campos vacios
export const validarCampoVacio = elemento => {
    let estado;
    let mensaje = elemento.parentElement.querySelector('p');
    if (elemento.value.trim() === ''){
        mensaje.innerText = '*Campo vacio';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        elemento.classList.remove('mensaje_error');
        mensaje.innerText = '';
        estado = true;
    }
    return estado;
}