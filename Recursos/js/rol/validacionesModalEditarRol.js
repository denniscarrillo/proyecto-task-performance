import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
}
//VARIABLES GLOBALES
let estadoSoloLetras = {
    estadoLetrasRol: true,
    estadoLetrasDescripcion: true,
};

const $form = document.getElementById('form-Edit-Rol');
const $Rol = document.getElementById('E_rol');
const $Descripcion = document.getElementById('E_descripcion');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    const estadoInputRol = funciones.validarCampoVacio($Rol);
    const estadoInputDescripcion = funciones.validarCampoVacio($Descripcion);
    if (estadoInputRol === false || estadoInputDescripcion === false) {
        e.preventDefault();
    } else {
        if(estadoSoloLetras.estadoLetrasRol == false || estadoSoloLetras.estadoLetrasDescripcion == false){
            e.preventDefault();
            estadoSoloLetras.estadoLetrasRol = funciones.validarSoloLetras($Rol, validaciones.soloLetras);
            estadoSoloLetras.estadoLetrasDescripcion = funciones.validarSoloLetras($Descripcion, validaciones.soloLetras);
        } else {
            estadoValidado = true;
        } 
    }
});

$Rol.addEventListener('keyup', () => {
    estadoSoloLetras.estadoLetrasRol = funciones.validarSoloLetras($Rol, validaciones.soloLetras);
    $("#rol").inputlimiter({
        limit: 45,
    });
});
$Descripcion.addEventListener('keyup', () => {
    estadoSoloLetras.estadoLetrasRol = funciones.validarSoloLetras($Descripcion, validaciones.soloLetras);
    $("#descripcion").inputlimiter({
        limit: 45,
    });
});