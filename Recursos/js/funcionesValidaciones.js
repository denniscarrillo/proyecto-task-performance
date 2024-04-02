/**
 * Valida que no se incluyan espacios entre palabras
 * @param {HTMLElement} elemento 
 * @returns {true|false}
 */
export const validarEspacios = (elemento) => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    let regex = /\s/g; //Expresión literal para saber si existen espacios en la cadena
    if (regex.test(input)){ //Evaluamos expresion vs la cadena
        //Si existen espacios mostramos mensaje de error
        mensaje.innerText = 'No se permiten espacios';
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
        mensaje.innerText = 'Minimo una mayúscula, minúscula, número y caracter especial';
        elemento.classList.add('mensaje_error');
        estado =  false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}

/**
 * 
 * @param {HTMLElement} elemento 
 * @param {RegExp} objetoRegex 
 * @returns 
 */
export const validarSoloLetras = (elemento, objetoRegex) => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    if (objetoRegex.test(input)){
        mensaje.innerText = 'Solo se permiten letras';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}

export const validarSoloLetrasNumeros = (elemento, objetoRegex) => {
  let mensaje = elemento.parentElement.querySelector('p');
  let estado;
  let input = elemento.value;
  if (!objetoRegex.test(input)){
    mensaje.innerText = 'Solo #- letras y números';
    elemento.classList.add('mensaje_error');
    estado = false;
  } else {
    mensaje.innerText = '';
    elemento.classList.remove('mensaje_error');
    estado = true;
  }
  return estado;
}

//Funcion para validar mayor a cero
export const MayorACero = (elemento) => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = parseFloat(elemento.value.trim()); // Convertir a número y eliminar espacios en blanco

    if (isNaN(input) || input <= 0) {
        mensaje.innerText = 'Debe ser un número mayor a cero';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}

/**
 * 
 * @param {HTMLElement} elemento 
 * @returns  {true|false}
 */
//Funcion para validar campos vacios
export const validarCampoVacio = (elemento) => {
    let estado;
    let mensaje = elemento.parentElement.querySelector('p');
    if (elemento.value.trim() === ''){
        mensaje.innerText = 'Campo requerido';
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
export const validarCampoVacioCant = (elemento) => {
    let estado;
    if (elemento.value.trim() === ''){
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}

export const validarCoincidirPassword = (password, password2) => {
    let estado;
    let mensaje = password2.parentElement.querySelector('p');
    if(password.value != password2.value){
        mensaje.innerText = 'Las contraseñas no coinciden';
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
        mensaje.innerText = 'No debe colocar el mismo caracter +3 veces seguidas';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}

export const validarMismoNumeroConsecutivo = (elemento, objetoRegex) => {
    let estado;
    let mensaje = elemento.parentElement.querySelector('p');
    let input = elemento.value;
    if (objetoRegex.test(input)){
        mensaje.innerText = 'No debe colocar el mismo número +5 veces seguidas';
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
        mensaje.innerText = 'Ingrese un correo válido: ejemplo@gmail.com';
        elemento.classList.add('mensaje_error');
        estado = false;
    } else {
        mensaje.innerText = '';
        elemento.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}

export const validarCorreoExistente = (estadoCorreo) => {
    let elemento = document.getElementById('correo');
    let $mensaje = elemento.parentElement.querySelector('p');
    let estado = false;
    if (estadoCorreo === 'true') {
        elemento.classList.add('mensaje_error');
        $mensaje.innerText = 'Correo existente';
        estado = false;
    } else {
        elemento.classList.remove('mensaje_error');
        $mensaje.parentElement.querySelector('p').innerText = '';
        estado = true;
    }
    return estado;
}
export const validarCorreoExistenteE = (estadoCorreo) => {
    let elemento = document.getElementById('E_correo');
    let $mensaje = elemento.parentElement.querySelector('p');
    let estado = false;
    if (estadoCorreo === 'true') {
        elemento.classList.add('mensaje_error');
        $mensaje.innerText = 'Correo existente';
        estado = false;
    } else {
        elemento.classList.remove('mensaje_error');
        $mensaje.parentElement.querySelector('p').innerText = '';
        estado = true;
    }
    return estado;
}
export const validarUsuarioExistente = (estadoUsuario) => {
    let elemento = document.getElementById('usuario');
    let $mensaje = elemento.parentElement.querySelector('p');
    let estado = false;
    if (estadoUsuario === 'true') {
        elemento.classList.add('mensaje_error');
        $mensaje.innerText = 'Usuario existente';
        estado = false;
    } else {
        elemento.classList.remove('mensaje_error');
        $mensaje.parentElement.querySelector('p').innerText = '';
        estado = true;
    }
    return estado;
}

/**
 * 
 * @param {HTMLElement} elemento 
 * @param {RegExp} objetoRegex 
 * @returns {true|false}
 */
export const validarSoloNumeros = (elemento, objetoRegex) => {
    let mensaje = elemento.parentElement.querySelector('p');
    let estado;
    let input = elemento.value;
    if (!objetoRegex.test(input)){
        mensaje.innerText = 'Solo se permiten números';
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

/**
 * @param {HTMLElement} elemento - input HTML al cual le queremos aplicar la validación
 * @param {number} minCaracteres - cantidad mínima de caracteres que deseamos contenga el input
 * @returns {false|true} **false** si el texto introducido en el input HTML no satisface el **minCaracteres** requerido. De lo contrario devuelve **true**
 */
export const caracteresMinimo = (elemento, minCaracteres) => {
  let mensaje = elemento.parentElement.querySelector('p');
  let estado;
  if(elemento.value.length < minCaracteres){
    mensaje.innerText = 'Debe ingresar mínimo '+minCaracteres+' caracteres';
        elemento.classList.add('mensaje_error');
        estado = false;
  } else {
    elemento.classList.remove('mensaje_error');
        mensaje.innerText = '';
        estado = true;
  }
  return estado;
}

/**
 * @param {HTMLElement} elemento - input HTML al cual le queremos aplicar la validación
 * @returns {false|true} **false** si el texto introducido en el input HTML contiene más de un espacio entre palabra. De lo contrario devuelve **true**
 */
export const validarMasdeUnEspacio = (elemento) => {
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

/**
 * @param {HTMLElement} elemento - input HTML al cual le queremos aplicar la validación
 * @returns {true|false}
 */
export const obtenerMinMaxCaracteresPassword = async () => {
    let minMaxParametros = null;
    try {
        minMaxParametros = await $.ajax({
            url: "../../Vista/crud/usuario/validarParametrosContrasenia.php",
            type: "POST",
            dataType: "JSON",
        });
    } catch (error) {
        console.log(error);
    }
    return minMaxParametros;
};

export const validarMinMaxCaracteresPassword = (input, minMaxCaracteres) => {
    let estado = false;
    let mensaje = input.parentElement.querySelector('p');
    if (input.value.length < minMaxCaracteres.min || input.value.length > minMaxCaracteres.max) {
        mensaje.innerText = '*Mínimo ' + minMaxCaracteres.min + ', máximo ' + minMaxCaracteres.max + ' caracteres';
        input.classList.add('mensaje_error');
    } else {
        mensaje.innerText = '';
        input.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}

/**
 * @param {HTMLElement} elemento - input HTML al cual le queremos aplicar la validación
 * @returns {true|false}
 */
export const obtenerMinMaxCaracteresPasswordU = async () => {
    let minMaxParametros = null;
    try {
        minMaxParametros = await $.ajax({
            url: "../../../Vista/crud/usuario/validarParametrosContrasenia.php",
            type: "POST",
            dataType: "JSON",
        });
    } catch (error) {
        console.log(error);
    }
    return minMaxParametros;
};

export const validarMinMaxCaracteresPasswordU = (input, minMaxCaracteres) => {
    let estado = false;
    let mensaje = input.parentElement.querySelector('p');
    if (input.value.length < minMaxCaracteres.min || input.value.length > minMaxCaracteres.max) {
        mensaje.innerText = '*Mínimo ' + minMaxCaracteres.min + ', máximo ' + minMaxCaracteres.max + ' caracteres';
        input.classList.add('mensaje_error');
    } else {
        mensaje.innerText = '';
        input.classList.remove('mensaje_error');
        estado = true;
    }
    return estado;
}
/**
 * @param {HTMLElement} elemento - input HTML al cual le queremos convertir el texto a mayúsculas mientras se escribe él
 */
export const convertirAMayusculasVisualmente = (elemento) => {
    elemento.style.textTransform = 'uppercase';
}

export const transformarAMayusculas = (elemento) => {
    elemento.value = elemento.value.toUpperCase();
}

export const soloLetrasSinEspacios = (elemento) => {
    elemento.setAttribute('onkeypress', 'return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122))')
}

export const soloLetrasConEspacios = (elemento) => {
    elemento.setAttribute('onkeypress', 'return ((event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode == 32))')
}

export const RTN_guion = (event) => {
        // Obtener el valor actual del input y eliminar caracteres no numéricos
        var formato = event.target.value.replace(/\D/g, '');
  
        // Aplicar formato a los dos primeros grupos de 4 números
        if (formato.length > 8) {
          formato = formato.slice(0, 4) + '-' + formato.slice(4, 8) + '-' + formato.slice(8);
        } else if (formato.length > 4) {
          formato = formato.slice(0, 4) + '-' + formato.slice(4);
        }
        // Actualizar el valor del input con el formato aplicado
        event.target.value = formato;
};

export const telefono_guion = (event) => {
    // Obtener el valor actual del input y eliminar caracteres no numéricos
    var formato = event.target.value.replace(/\D/g, '');

    // Aplicar formato a los dos primeros grupos de 4 números
    if (formato.length > 8) {
      formato = formato.slice(0, 4) + '-' + formato.slice(4, 8) + formato.slice(8);;
    } else if (formato.length > 4) {
      formato = formato.slice(0, 4) + '-' + formato.slice(4);
    }
    // Actualizar el valor del input con el formato aplicado
    event.target.value = formato;
};



/**
 * @param {HTMLElement} elemento - input HTML al cual le queremos aplicar la validación
 * @param {string} estadoUsuario espera el estado del usuario true o false como un string 
 */
export const validarSiExisteUsuario = (elemento, estadoUsuario) => {
    if (estadoUsuario == 'false') {
        elemento.classList.add('mensaje_error')
        elemento.parentElement.querySelector('p').innerText = '*El usuario ingresado no existe'
    } else {
        elemento.classList.remove('mensaje_error')
        elemento.parentElement.querySelector('p').innerText = ''
    }
}
