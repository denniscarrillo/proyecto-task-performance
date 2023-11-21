import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\/ .ÑñáéíóúÁÉÍÓÚs])/, //Solo letras
    soloNumeros: /^[0-9,-]*$/
 
}

let estadoEspacioInput = {
    estadoEspaciodescripcion: true,
    estadoEspaciotelefono: true,
    estadoEspacioubicacion: true,
    estadoEspacioAvance: true
}
  


let estadoSelect = {
    estadoSelectdescripcion: true,
    estadoSelecttelefono: true,
    estadoSelectubicacion: true,
    estadoSelectAvance: true
}
let estadoMasdeUnEspacio = {
    estadoMasEspaciodescripcion: true,
    estadoMasEspaciotelefono: true,
    estadoMasEspacioubicacion: true,
    estadoMasEspacioAvance: true
}

let estadoSoloLetras = {
    estadoLetrasdescripcion: true,
    estadoLetrasubicacion: true,
    estadoLetrasAvance: true,
    
  

}
let estadoSoloNumeros = {
   
    estadoNumerotelefono :true,
}
//VARIABLES GLOBALES




const $form = document.getElementById('form-Edit-Solicitud');
const $descripcion = document.getElementById('E_descripcion');
const $telefono = document.getElementById('E_telefono_cliente');
const $ubicacion = document.getElementById('E_ubicacion');
const $Avance = document.getElementById('E_AvanceSolicitud');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    //Validamos que algún campo no esté vacío.
    let estadoInputdescripcion = funciones.validarCampoVacio($descripcion);
    let estadoInputtelefono = funciones.validarCampoVacio($telefono);
    let estadoInputubicacion = funciones.validarCampoVacio($ubicacion);
    let estadoInputAvance = funciones.validarCampoVacio($Avance);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputdescripcion == false || estadoInputtelefono  == false || estadoInputubicacion == false || estadoInputAvance == false) {
        e.preventDefault();
    }else{
        if(estadoEspacioInput.estadoEspaciodescripcion == false || estadoEspacioInput.estadoEspaciotelefono  == false || estadoEspacioInput.estadoEspacioubicacion == false || estadoEspacioInput.estadoEspacioAvance == false){ 
            e.preventDefault();
            estadoEspacioInput.estadoEspaciodescripcion = funciones.validarEspacios($descripcion);  
            estadoEspacioInput.estadoEspaciotelefono= funciones.validarEspacios($telefono);  
            estadoEspacioInput.estadoEspacioubicacion = funciones.validarEspacios($ubicacion);  
            estadoEspacioInput.estadoEspacioAvance = funciones.validarEspacios($Avance);  
        }
        estadoMasdeUnEspacio.estadoMasEspaciodescripcion= funciones.validarMasdeUnEspacio($descripcion);
        estadoMasdeUnEspacio.estadoMasEspaciotelefono= funciones.validarMasdeUnEspacio($telefono);
        estadoMasdeUnEspacio.estadoMasEspacioubicacion= funciones.validarMasdeUnEspacio($ubicacion);
        estadoMasdeUnEspacio.estadoMasEspacioAvance = funciones.validarMasdeUnEspacio($Avance);
       
        if(estadoMasdeUnEspacio.estadoMasEspaciodescripcion == false || estadoMasdeUnEspacio.estadoMasEspaciotelefono == false || estadoMasdeUnEspacio.estadoMasEspacioubicacion == false || estadoMasdeUnEspacio.estadoMasEspacioAvance == false){
            e.preventDefault();
            console.log(estadoMasdeUnEspacio.estadoMasEspaciodescripcion);
            console.log(estadoMasdeUnEspacio.estadoMasEspacioubicacion);
        }else{
            if(estadoSoloLetras.estadoLetrasdescripcion == false ||  estadoSoloLetras.estadoLetrasubicacion == false || estadoSoloLetras.estadoLetrasAvance == false){
                e.preventDefault();
                estadoLetrasdescripcion = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
                estadoLetrasubicacion = funciones.validarSoloLetras($ubicacion, validaciones.soloLetras);
                estadoLetrasAvance = funciones.validarSoloLetras($Avance, validaciones.soloLetras);
               
            }
             if(estadoSoloNumeros.estadoNumerotelefono == false ){
                e.preventDefault();
                estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
            }else{
                if(estadoSelect == false ){
                    e.preventDefault();           
                    estadoSelect = funciones.validarCampoVacio($MotivoCancelacion);
                    estadoSelect = funciones.validarCampoVacio($telefono);
                    estadoSelect = funciones.validarCampoVacio($ubicacion);
                    estadoSelect = funciones.validarCampoVacio($Avance);
                } else {
                    estadoValidado = true; // 
                }  
            }
        
        } 
    }
});
$descripcion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasdescripcion = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_descripcion", 30);
});
$ubicacion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasubicacion= funciones.validarSoloLetras($ubicacion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_ubicacion", 30);
});
$Avance.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasAvance= funciones.validarSoloLetras($Avance, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_AvanceSolicitud", 30);
});
$descripcion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspaciodescripcion){
        funciones.validarMasdeUnEspacio($descripcion);
    }  
});
$telefono.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspaciotelefono){
        funciones.validarMasdeUnEspacio($telefono);
    }  
});
$ubicacion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioubicacion){
        funciones.validarMasdeUnEspacio($ubicacion);
    }  
});
$Avance.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioAvance){
        funciones.validarMasdeUnEspacio($Avance);
    }  
});

$descripcion.addEventListener('change', ()=>{
    estadoSelect.estadoSelectdescripcion = funciones.validarCampoVacio($descripcion);
});
$telefono.addEventListener('change', ()=>{
    estadoSelect.estadoSelecttelefono = funciones.validarCampoVacio($telefono);
});
$ubicacion.addEventListener('change', ()=>{
    estadoSelect.estadoSelectubicacion = funciones.validarCampoVacio($ubicacion);
});
$Avance.addEventListener('change', ()=>{
    estadoSelect.estadoSelectAvance = funciones.validarCampoVacio($Avance);
});
$telefono.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
   funciones.limitarCantidadCaracteres("E_telefono_cliente", 14);
});

// || estadoMasdeUnEspacio.estadoMasEspacioNombre == true