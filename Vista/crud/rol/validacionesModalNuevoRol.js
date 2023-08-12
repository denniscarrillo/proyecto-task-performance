import * as funciones from './funcionesValidaciones.js';

export let estadoValidado = false;

const validaciones = {
    soloLetras: /^[a-zA-Z\s]+$/, // Expresión regular para solo letras y espacios
};

let estadoEspacioInput = {
    estadoEspacioRol: true,
    estadoEspacioDescripcion: true,
};

let estadoSoloLetras = {
    estadoLetrasRol: true,
    estadoLetrasDescripcion: true,
};

let estadoSelect = true;
let estadoCorreo = true;

const $form = document.getElementById('form-rol');
const $Rol = document.getElementById('rol');
const $Descripcion = document.getElementById('descripcion');
const iconClass = document.querySelector('.type-lock');
const icon_candado = document.querySelector('.lock');

$form.addEventListener('submit', e => {
    const estadoInputRol = funciones.validarCampoVacio($Rol);
    const estadoInputDescripcion = funciones.validarCampoVacio($Descripcion);

    if (estadoInputRol === false || estadoInputDescripcion === false) {
        e.preventDefault();
    } else {
        if (estadoEspacioInput.estadoEspacioRol === false || estadoEspacioInput.estadoEspacioDescripcion === false) {
            e.preventDefault();
            estadoEspacioInput.estadoEspacioRol = funciones.validarEspacios($Rol);
            estadoEspacioInput.estadoEspacioDescripcion = funciones.validarEspacios($Descripcion);
        }
    }
});

$Rol.addEventListener('keyup', () => {
    estadoSoloLetras.estadoLetrasRol = funciones.validarSoloLetras($Rol, validaciones.soloLetras);
    $("#rol").inputlimiter({
        limit: 10,
    });
});

$Rol.addEventListener('focusout', () => {
    const usuarioMayus = $Rol.value.toUpperCase();
    $Rol.value = usuarioMayus;
});

$Rol.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioRol = funciones.validarEspacios($Rol);
    $("#descripcion").inputlimiter({
        limit: 20,
    });
});

$Rol.addEventListener('focusout', () => {
    if (estadoEspacioInput.estadoEspacioRol) {
        estadoSoloLetras.estadoLetrasDescripcion = funciones.validarSoloLetras($Rol, validaciones.soloLetras);
    }
    const RolMayus = $Rol.value.toUpperCase();
    $Rol.value = RolMayus;
});
