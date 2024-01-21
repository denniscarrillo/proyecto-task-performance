import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus


const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\/ .ÑñáéíóúÁÉÍÓÚs])+$/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9,-]*$/,
    MismoCaracter: /^(?=.*(..)\1)/, 
}
//VARIABLES GLOBALES

let estadoEspacioInput = {
   
    estadoEspacioArticulo: true,
    estadoEspacioDetalle: true,
    estadoEspacioMarca: true,

}
  


let estadoSelect = {
   
    estadoSelectArticulo: true,
    estadoSelectDetalle: true,
    estadoSelectMarca: true,
  
}

let estadoMasdeUnEspacio = {
       
        estadoMasEspacioArticulo:true,
        estadoMasEspacioDetalle:true,
        estadoMasEspacioMarca:true,

}

let estadoSoloLetras = {
    estadoLetrasArticulo:true,
    estadoLetrasMarca:true,
  

}


const $form = document.getElementById('form_Articulo');

const $articulo = document.getElementById('Articulo');
const $detalle= document.getElementById('Detalle');
const $marca = document.getElementById('Marca');


/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    //Validamos que algún campo no esté vacío.

    let estadoInputarticulo = funciones.validarCampoVacio($articulo);
    let estadoInputdetalle= funciones.validarCampoVacio($detalle);
    let estadoInputmarca = funciones.validarCampoVacio($marca);
  
    // Comprobamos que todas las validaciones se hayan cumplido 
    if ( estadoInputarticulo  == false || estadoInputdetalle == false || estadoInputmarca == false  ) {
        e.preventDefault();
    }else{
        if(estadoEspacioInput.estadoEspacioArticulo  == false || estadoEspacioInput.estadoEspacioMarca== false || estadoEspacioInput.estadoEspacioDetalle == false ){ 
            e.preventDefault();
       
            estadoEspacioInput.estadoEspacioArticulo= funciones.validarEspacios($articulo);  
            estadoEspacioInput.estadoEspacioDetalle = funciones.validarEspacios($detalle); 
            estadoEspacioInput.estadoEspacioMarca = funciones.validarEspacios($marca);   
        }
      
        estadoMasdeUnEspacio.estadoMasEspacioArticulo= funciones.validarMasdeUnEspacio($articulo);
        estadoMasdeUnEspacio.estadoMasEspacioDetalle = funciones.validarMasdeUnEspacio($detalle);
        estadoMasdeUnEspacio.estadoMasEspacioMarca = funciones.validarMasdeUnEspacio($marca);
       
        if(estadoMasdeUnEspacio.estadoMasEspacioArticulo == false || estadoMasdeUnEspacio.estadoMasEspacioDetalle == false || estadoMasdeUnEspacio.estadoMasEspacioMarca == false ){
            e.preventDefault();
            console.log(estadoMasdeUnEspacio.estadoMasEspacioDireccion);
           
               
        }else{
            if(estadoSoloLetras.estadoLetrasArticulo == false ||  estadoSoloLetras.estadoLetrasMarca == false ){
                e.preventDefault();
                estadoLetrasArticulo = funciones.validarSoloLetras($articulo, validaciones.soloLetras);
                estadoLetrasMarca = funciones.validarSoloLetras($marca, validaciones.soloLetras);
               
            }else{
                if( estadoSelect == false ){
                    e.preventDefault();         
                   // estadoSelect = funciones.validarCampoVacio($name);
                    estadoSelect = funciones.validarCampoVacio($articulo);
                    estadoSelect = funciones.validarCampoVacio($detalle);
                    estadoSelect = funciones.validarCampoVacio($marca);
                } else {
                    estadoValidado = true; // 
                }  
            }
        
        } 
    }
});
$articulo.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasArticulo = funciones.validarSoloLetras($articulo, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("A_Articulo", 50);
});
$marca.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasMarca= funciones.validarSoloLetras($marca, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("A_Marca", 50);
});

$articulo.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioArticulo){
        funciones.validarMasdeUnEspacio($articulo);
    } 
    let articuloMayus = $articulo.value.toUpperCase();
    $articulo.value = articuloMayus; 
});

$detalle.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioDetalle){
        funciones.validarMasdeUnEspacio($detalle);
    } 
    let detalleMayus = $detalle.value.toUpperCase();
    $detalle.value = detalleMayus; 
});

$marca.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioMarca){
        funciones.validarMasdeUnEspacio($marca);
    } 
    let marcaMayus = $marca.value.toUpperCase();
    $marca.value = marcaMayus;  

});

$articulo.addEventListener('change', ()=>{
    estadoSelect.estadoSelectArticulo = funciones.validarCampoVacio($articulo);
});
$detalle.addEventListener('change', ()=>{
    estadoSelect.estadoSelectDetalle = funciones.validarCampoVacio($detalle);
});
$marca.addEventListener('change', ()=>{
    estadoSelect.estadoSelectMarca = funciones.validarCampoVacio($marca);
});