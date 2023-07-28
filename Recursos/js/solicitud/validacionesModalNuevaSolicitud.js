import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES
let estadoEspacioInput = {
    estadoEspacioUser: true,
} 
let estadoSoloLetras = {
    estadoLetrasUser: true,
    estadoLetrasName: true,
}

let estadoSelect = true;
let estadoCorreo = true;

const $form = document.getElementById('form-solicitud');
const $user = document.getElementById('usuario');
const $statusSolicitud = document.getElementById('idEstadoSolicitud');
const $typeSolicitud = document.getElementById('idTipoServicio');
const $client = document.getElementById('cliente');
const $title = document.getElementById('tituloMensaje');
const $sendDate = document.getElementById('fechaEnvio');
const $description = document.getElementById('descripcion');
const $mail = document.getElementById('correo');
const $address = document.getElementById('ubicacion');


/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVA SOLICITUD ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputUser =  funciones.validarCampoVacio($user);
    let estadoInputStatus = funciones.validarCampoVacio($statusSolicitud);
    let estadoInputType = funciones.validarCampoVacio($typeSolicitud);
    let estadoInputClient = funciones.validarCampoVacio($client);
    let estadoInputTitle = funciones.validarCampoVacio($title);
    let estadoInputSendDate = funciones.validarCampoVacio($sendDate);
    let estadoInputDescription = funciones.validarCampoVacio($description);
    let estadoInputCorreo = funciones.validarCampoVacio($mail);
    let estadoInputUbicacion = funciones.validarCampoVacio($address);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputUser  == false || estadoInputStatus == false || 
        estadoInputType == false || estadoInputClient == false || estadoInputTitle == false || estadoInputSendDate == false || estadoInputDescription == false || estadoInputCorreo == false || estadoInputUbicacion == false) {
        e.preventDefault();
    } else {
        if(estadoEspacioInput.estadoEspacioUser == false){ 
            e.preventDefault();
            estadoEspacioInput.estadoEspacioUser = funciones.validarEspacios($title);
        } else {
            if(estadoSoloLetras.estadoLetrasUser == false || estadoSoloLetras.estadoLetrasName == false){
                e.preventDefault();
                estadoSoloLetras.estadoLetrasUser = funciones.validarSoloLetras($title, validaciones.soloLetras);
            } else {
                if(estadoCorreo == false || estadoSelect == false){
                    e.preventDefault();
                    estadoCorreo = funciones.validarCorreo($mail, validaciones.correo);
                    estadoSelect = funciones.validarCampoVacio($statusSolicitud);
                    estadoSelect = funciones.validarCampoVacio($typeSolicitud);
                } else {
                    estadoValidado = true; // 
                    console.log(estadoValidado); //
                }
            }
        }
    }
});

$title.addEventListener('focusout', () => {
    if(estadoEspacioInput.estadoEspacioUser){
        estadoSoloLetras.estadoLetrasUser = funciones.validarSoloLetras($title, validaciones.soloLetras);
    }
    
});
//Evento que llama a la función que valida espacios entre caracteres.
$user.addEventListener('keyup', () => {
    estadoEspacioInput.$user= funciones.validarEspacios($user);
    $("#usuario").inputlimiter({
        limit: 20
    });
});



$mail.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($mail, validaciones.correo);
});
$statusSolicitud.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($statusSolicitud);
    
});

$typeSolicitud.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($typeSolicitud);
});
