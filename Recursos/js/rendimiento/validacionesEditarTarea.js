import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
const $form = document.getElementById('form-Edit-Tarea'); 
const $estadoTarea = document.getElementById('estados-tarea');
const $radioButton = document.getElementsByName('radioOption');
let $tipoCliente = '';
let inputsEditarTarea = {
    titulo: document.getElementById('input-titulo-tarea'),
    rtn: document.getElementById('rnt-cliente'),
    nombre: document.getElementById('nombre-cliente'),
    telefono: document.getElementById('telefono-cliente'),
    correo: document.getElementById('correo-cliente'),
    direccion: document.getElementById('direccion-cliente'),
    rubroComercial: document.getElementById('rubrocomercial'),
    razonSocial: document.getElementById('razonsocial'), 
    clasificacionLead: document.getElementById('clasificacion-lead'),
    origenLead: document.getElementById('origen-lead')
  }
$(document).ready(function(){
    $tipoCliente = ($radioButton[1].checked) ? $radioButton[1].value : $radioButton[0].value;
    console.log($tipoCliente);
    //Evento SUBMIT
    $form.addEventListener('submit', () => { 
        validarInputs(funciones, $tipoCliente);
        // if (document.querySelectorAll('.mensaje_error').length == 0) {
        //     console.log('ENTRO')
        //     estadoValidado = true;
        // }
    });
    //Volver a validar cuando se han introducido datos de un cliente existente
    $(document).on("click", "#btn_select-cliente", function () {
        validarInputs(funciones, $tipoCliente);    
    });
});
inputsEditarTarea.clasificacionLead.addEventListener('change', () => {
    validarInputs(funciones, $tipoCliente);
});
inputsEditarTarea.origenLead.addEventListener('change', () => {
    validarInputs(funciones, $tipoCliente);
});
inputsEditarTarea.rubroComercial.addEventListener('focusout', () => {
    validarInputs(funciones, $tipoCliente);
});
inputsEditarTarea.rubroComercial.addEventListener('mouseout', () => {
    validarInputs(funciones, $tipoCliente);
});
inputsEditarTarea.razonSocial.addEventListener('focusout', () => {
    validarInputs(funciones, $tipoCliente);
});
inputsEditarTarea.razonSocial.addEventListener('mouseout', () => {
    validarInputs(funciones, $tipoCliente);
});





let optionExistente = document.getElementById('cliente-existente');
optionExistente.addEventListener('change', function () {
    $tipoCliente =  $tipoCliente = ($radioButton[1].checked) ? $radioButton[1].value : $radioButton[0].value;
    //Limpiamos los errores al cambiar a existes ya que estos campos no se validan aqui
    document.querySelectorAll('.mensaje_error').forEach(input => {
        input.classList.remove('mensaje_error');
        input.parentElement.querySelector('p').innerHTML = '';
    });
});
let optionNuevo = document.getElementById('cliente-nuevo');
optionNuevo.addEventListener('change', function () {
    $tipoCliente =  $tipoCliente = ($radioButton[1].checked) ? $radioButton[1].value : $radioButton[0].value;
    //Limpiamos los errores al cambiar a existes ya que estos campos no se validan aqui
    document.querySelectorAll('.mensaje_error').forEach(input => {
        input.classList.remove('mensaje_error');
        input.parentElement.querySelector('p').innerHTML = '';
    });
});
//Funcion principal que aplica validaciones a los inptus de forma dinamica segun tipo cliente y tipo tarea
let validarInputs = (funciones, tipoCliente) => {
    switch ($estadoTarea.value){
        case "2":{
            funciones.validarCampoVacio(inputsEditarTarea.titulo);
            funciones.validarCampoVacio(inputsEditarTarea.rtn);
            funciones.validarCampoVacio(inputsEditarTarea.nombre);
            if(tipoCliente != 'Existente'){
                funciones.validarCampoVacio(inputsEditarTarea.telefono);
                funciones.validarCampoVacio(inputsEditarTarea.correo);
                funciones.validarCampoVacio(inputsEditarTarea.direccion);   
            }
            funciones.validarCampoVacio(inputsEditarTarea.rubroComercial);
            funciones.validarCampoVacio(inputsEditarTarea.razonSocial);
            funciones.validarCampoVacio(inputsEditarTarea.clasificacionLead);
            funciones.validarCampoVacio(inputsEditarTarea.origenLead);
        }  
        default:{
            funciones.validarCampoVacio(inputsEditarTarea.titulo);
            funciones.validarCampoVacio(inputsEditarTarea.rtn);
            funciones.validarCampoVacio(inputsEditarTarea.nombre);
            if(tipoCliente != 'Existente'){
                funciones.validarCampoVacio(inputsEditarTarea.telefono);
                funciones.validarCampoVacio(inputsEditarTarea.correo);
                funciones.validarCampoVacio(inputsEditarTarea.direccion);     
            }
            funciones.validarCampoVacio(inputsEditarTarea.rubroComercial);
            funciones.validarCampoVacio(inputsEditarTarea.razonSocial);
        }   
    }
}