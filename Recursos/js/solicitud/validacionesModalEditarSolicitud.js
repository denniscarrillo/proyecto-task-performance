import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES
let estadoLetrasName = true;

let estadoSelect = {
    estadoSelectTipo: true,
    estadoSelectEstado: true,
}

let estadoCorreo = true;

const $form = document.getElementById('form-Edit-Solicitud');
const $ubicacion = document.getElementById('E_ubicacion');
const $correo = document.getElementById('E_correo');
const $fechaEnvio = document.getElementById('E_fechaEnvio');
const $estadoSolicitud = document.getElementById('E_idEstadoSolicitud');
const $tipoServicio = document.getElementById('E_idTipoServicio');
const $cliente = document.getElementById('E_cliente');
const $usuario = document.getElementById('E_idUsuario');

/* ---------------- VALIDACIONES FORMULARIO GESTION SOLICITUDES ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    //Validamos que algún campo no esté vacío.
    let estadoInputUbicacion = funciones.validarCampoVacio($ubicacion);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    let estadoImputFecha = funciones.validarCampoVacio($fechaEnvio);
    let estadoInputSolicitud = funciones.validarCampoVacio($estadoSolicitud);
    let tipoInputServicio = funciones.validarCampoVacio($tipoServicio);
    let $clienteInput = funciones.validarCampoVacio($cliente);
    let $usuarioInput = funciones.validarCampoVacio($usuario);

    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputUbicacion == false || estadoInputCorreo == false || estadoImputFecha == false || estadoInputSolicitud == false || tipoInputServicio == false || $clienteInput == false || $usuarioInput == false) {
        e.preventDefault();
    } else {
        if (estadoLetrasName == false) {
            e.preventDefault();
            estadoLetrasName = funciones.validarSoloLetras($ubicacion, validaciones.soloLetras);
        } else {
            if (estadoCorreo == false || estadoSelect.estadoSelectEstado == false || estadoSelect.estadoSelectTipo == false) {
                e.preventDefault();
                estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
                estadoSelect.estadoSelectEstado = funciones.validarCampoVacio($estadoSolicitud);
                estadoSelect.estadoSelectTipo = funciones.validarCampoVacio($tipoServicio);
            } else {
                estadoValidado = true; // 
            }
        }
    }
});
$ubicacion.addEventListener('keyup', () => {
    estadoLetrasName = funciones.validarSoloLetras($ubicacion, validaciones.soloLetras);
    $("E_ubicacion").inputlimiter({
        limit: 50
    });
});
$ubicacion.addEventListener('focusout', () => {
    let usuarioMayus = $ubicacion.value.toUpperCase();
    $ubicacion.value = usuarioMayus;
});
$correo.addEventListener('keyup', () => {
    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
});
$tipoServicio.addEventListener('change', () => {
    estadoSelect.estadoSelectTipo = funciones.validarCampoVacio($tipoServicio);
});
$estadoSolicitud.addEventListener('change', () => {
    estadoSelect.estadoSelectEstado = funciones.validarCampoVacio($estadoSolicitud);
});