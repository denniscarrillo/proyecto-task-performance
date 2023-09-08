import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/,
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES
let estadoSelect = {
    estadoSelectRol: true,
    estadoSelectObjeto: true, 
    estadoSelectConsultar: true,
    estadoSelectInsertar: true,
    estadoSelectActualizar: true,
    estadoSelectEliminar: true
}

const $form = document.getElementById('form-permiso');
const $rol = document.getElementById('rol');
const $objeto = document.getElementById('objeto');
const $consultar = document.getElementById('consultar');
const $insertar = document.getElementById('insertar');
const $actualizar = document.getElementById('actualizar');
const $eliminar = document.getElementById('eliminar');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    // let estadoInputNombre = funciones.validarCampoVacio($name);
    // let estadoInputUser =  funciones.validarCampoVacio($user);
    // let estadoInputPassword = funciones.validarCampoVacio($password);
    // let estadoInputConfirmarContrasenia = funciones.validarCampoVacio($confirmarContrasenia);
    // let estadoInputCorreo = funciones.validarCampoVacio($correo);
    // let estadoInputRol = funciones.validarCampoVacio($rol);

    // Comprobamos que todas las validaciones se hayan cumplido 
    if(estadoSelect.estadoSelectRol == false || estadoSelect.estadoSelectObjeto == false || estadoSelect.estadoSelectInsertar ||
        estadoSelect.estadoSelectConsultar == false || estadoSelect.estadoSelectActualizar == false || estadoSelect.estadoSelectEliminar == false){
        e.preventDefault();
        estadoSelect.estadoSelectRol = funciones.validarCampoVacio($rol);
        estadoSelect.estadoSelectObjeto = funciones.validarCampoVacio($objeto);
        estadoSelect.estadoSelectInsertar = funciones.validarCampoVacio($consultar);
        estadoSelect.estadoSelectConsultar = funciones.validarCampoVacio($insertar);
        estadoSelect.estadoSelectActualizar = funciones.validarCampoVacio($actualizar);
        estadoSelect.estadoSelectEliminar = funciones.validarCampoVacio($eliminar);
    } else {
        estadoValidado = true; // 
    }
});

$rol.addEventListener('change', ()=>{
    estadoSelect.estadoSelectRol = funciones.validarCampoVacio($rol);
});
$objeto.addEventListener('change', ()=>{
    estadoSelect.estadoSelectObjeto = funciones.validarCampoVacio($objeto);
});
$consultar.addEventListener('change', ()=>{
    estadoSelect.estadoSelectInsertar = funciones.validarCampoVacio($consultar);
    funciones.limitarCantidadCaracteres("consultar", 1);
});
$insertar.addEventListener('change', ()=>{
    estadoSelect.estadoSelectConsultar = funciones.validarCampoVacio($insertar);
    funciones.limitarCantidadCaracteres("insertar", 1);
});
$actualizar.addEventListener('change', ()=>{
    estadoSelect.estadoSelectActualizar = funciones.validarCampoVacio($actualizar);
    funciones.limitarCantidadCaracteres("actualizar", 1);
});
$eliminar.addEventListener('change', ()=>{
    estadoSelect.estadoSelectEliminar = funciones.validarCampoVacio($eliminar);
    funciones.limitarCantidadCaracteres("eliminar", 1);
});


