
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
export const validarPassword = (elemento, objetoRegex) => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    if (!objetoRegex.test(input)){
        mensaje.innerText = '*Minimo una mayúscula, minúscula, número y caracter especial';
        elemento.classList.add('mensaje_error');
        estado =  false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}
export const validarSoloLetras = (elemento, objetoRegex) => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    if (objetoRegex.test(input)){
        mensaje.innerText = '*Solo se permiten letras';
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
//Funcion para validar campos vacios cantidad cotizacion
export const validarCampoVacioCant = elemento => {
    let estado;
    // let mensaje = elemento.parentElement.querySelector('p');
    if (elemento.value.trim() === ''){
        // mensaje.innerText = '*';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        elemento.classList.remove('mensaje_error');
        // mensaje.innerText = '';
        estado = true;
    }
    return estado;
}
export const validarCoincidirPassword = (password, password2) => {
    let estado;
    let mensaje = password2.parentElement.querySelector('p');
    if(password.value != password2.value){
        mensaje.innerText = '*Las contraseñas no coinciden';
        password2.classList.add('mensaje_error');
        estado = false;
        } 
    else {
        password2.classList.remove('mensaje_error');
        mensaje.innerText = '';
        estado = true;
    }
    return estado;
}
export const limiteMismoCaracter = (elemento, objetoRegex) => {
    let estado;
    let mensaje = elemento.parentElement.querySelector('p');
    let input = elemento.value;
    if (objetoRegex.test(input)){
        mensaje.innerText = '*No debe colocar el mismo caracter +3 veces seguidas.';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}

export const validarCorreo = (elemento, objetoRegex) => {
    let estado;
    let mensaje = elemento.parentElement.querySelector('p');
    let correo = elemento.value;
    if (!objetoRegex.test(correo)){
        mensaje.innerText = '*Correo no válido, verifiquélo';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}

export const validarSoloNumeros = (elemento, objetoRegex) => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    if (!objetoRegex.test(input)){
        mensaje.innerText = '*Solo se permiten Numeros.';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;        
    }
    return estado;
}
export const limitarCantidadCaracteres = (elemento, cantMax) => {
    $('#'+elemento).inputlimiter({
        limit: cantMax,
		remText: '',
        limitText: '',
		limitTextShow: true
    });
}

export const validarMasdeUnEspacio = elemento => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    let regex = /\s\s/g; //Expresión literal para saber si existen mas de un espacio en la cadena
    if (regex.test(input.trim())){ //Evaluamos expresion vs la cadena
        //Si existen especios mostramos mensaje de error
        mensaje.innerText = '*No se permite más de un espacio entre palabras';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        elemento.classList.remove('mensaje_error');
        mensaje.innerText = '';
        estado = true;
    }
    return estado;
};
export const cantidadParametrosContrasenia = async (elemento) => {
    let estado = false;
    let mensaje = elemento.parentElement.querySelector('p');
    try {
        const minMaxParametros = await $.ajax({
            url: "../../Vista/crud/usuario/validarParametrosContrasenia.php",
            type: "POST",
            dataType: "JSON",
        });
        let minLength = minMaxParametros [0];
        let maxLength = minMaxParametros [1];
        if (elemento.value.length < minLength || elemento.value.length > maxLength) {
            mensaje.innerText = '*Mínimo ' + minLength + ', máximo ' + maxLength + ' caracteres';
            elemento.classList.add('mensaje_error');
        } else {
            mensaje.innerText = '';
            elemento.classList.remove('mensaje_error');
            estado = true;
        }
    } catch (error) {
        console.log(error);
    }
    return estado;
};

    



