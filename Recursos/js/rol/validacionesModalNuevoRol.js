import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

let estadoExisteRol = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
};

let estadoSoloLetras = {
    estadoLetrasRol: true,
    estadoLetrasDescripcion: true,
};
let estadoMasdeUnEspacio = {
    estadoMasEspacioRol: true,
    estadoMasEspacioDescripcion: true,
};

const $form = document.getElementById('form-Rol');
const $Rol = document.getElementById('rol');
const $Descripcion = document.getElementById('descripcion');

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
        } else{ 
            if(estadoMasdeUnEspacio.estadoMasEspacioRol == false || estadoMasdeUnEspacio.estadoMasEspacioDescripcion == false){
            e.preventDefault();
            estadoMasdeUnEspacio.estadoMasEspacioRol = funciones.validarMasdeUnEspacio($Rol);
            estadoMasdeUnEspacio.estadoMasEspacioDescripcion = funciones.validarMasdeUnEspacio($Descripcion);
           } else {
            if(estadoExisteRol == false){
                e.preventDefault();
                estadoExisteRol = obtenerRolExiste($('#rol').val());
        } else {
            estadoValidado = true;
        }
     }
    }
}
});

$Rol.addEventListener('keyup', () => {
    estadoSoloLetras.estadoLetrasRol = funciones.validarSoloLetras($Rol, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("rol", 45);
});
$Descripcion.addEventListener('keyup', () => {
    estadoSoloLetras.estadoLetrasRol = funciones.validarSoloLetras($Descripcion, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("descripcion", 45);
});
$Rol.addEventListener('focusout', () => {
    let roles = estadoMasdeUnEspacio.estadoMasEspacioRol = funciones.validarMasdeUnEspacio($Rol);
    if(roles){
          let rol = $('#rol').val();
          estadoExisteRol = obtenerRolExiste(rol);
    }
    let rolMayus = $Rol.value.toUpperCase();
     $Rol.value = rolMayus;  
});

$Descripcion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioDescripcion){
        funciones.validarMasdeUnEspacio($Descripcion);
     }
     let descripcionMayus = $Descripcion.value.toUpperCase();
     $Descripcion.value = descripcionMayus;  
 });

let obtenerRolExiste = ($rol) => {
    $.ajax({
        url: "../../../Vista/crud/rol/rolExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            rol: $rol
        },
        success: function (rol) {
            let $objrol = JSON.parse(rol);
            if ($objrol.estado == 'true') {
                document.getElementById('rol').classList.add('mensaje_error');
                document.getElementById('rol').parentElement.querySelector('p').innerText = '*El rol ya existe';
                estadoExisteRol = false; // rol es existente, es false
            } else {
                document.getElementById('rol').classList.remove('mensaje_error');
                document.getElementById('rol').parentElement.querySelector('p').innerText = '';
                estadoExisteRol = true; // rol no existe, es true
            }
        }
        
    });
}