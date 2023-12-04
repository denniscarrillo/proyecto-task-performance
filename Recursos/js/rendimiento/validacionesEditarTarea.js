import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/
}
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
    origenLead: document.getElementById('origen-lead'),
    nFactura: document.getElementById('num-factura')
}
$(document).ready(function(){
    if(document.getElementById('tipoCliente').textContent != "" && document.getElementById('tipoCliente').textContent != null){
        $tipoCliente = document.getElementById('tipoCliente').textContent;
    } else {
        $tipoCliente = ($radioButton[1].checked) ? $radioButton[1].value : $radioButton[0].value;
    }
    //Evento clic para hacer todas las validaciones
    document.getElementById('btn-guardar').addEventListener('click', () =>{
        validarInputs(funciones, $tipoCliente);
        if (document.querySelectorAll('.mensaje_error').length == 0 && document.querySelectorAll('.mensaje-existe-cliente').length == 0) {
            estadoValidado = true;
        } else {
            estadoValidado = false;
        }
    });
    //Volver a validar cuando se han introducido datos de un cliente existente
    $(document).on("click", "#btn_select-cliente", function () {
        validarInputs(funciones, $tipoCliente);    
    });
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
//VALIDACIONES EN LOS DISTINTOS EVENTOS MIENTRAS EDITA =====================================================
inputsEditarTarea.titulo.addEventListener('keyup', () => {
    validarInputTitulo();
    funciones.limitarCantidadCaracteres('input-titulo-tarea', 45);
});
inputsEditarTarea.rtn.addEventListener('keyup', () => {
    validarInputRTN($tipoCliente);
    funciones.limitarCantidadCaracteres('rnt-cliente', 20);
});
inputsEditarTarea.nombre.addEventListener('keyup', () => {
    validarInputNombreCliente($tipoCliente);
    funciones.limitarCantidadCaracteres('nombre-cliente', 50);
});
inputsEditarTarea.telefono.addEventListener('keyup', () => {
    validarInputTelefono();
    funciones.limitarCantidadCaracteres('telefono-cliente', 20);
});
inputsEditarTarea.correo.addEventListener('keyup', () => {
    validarInputCorreo();
    funciones.limitarCantidadCaracteres('correo-cliente', 50);
});
inputsEditarTarea.direccion.addEventListener('keyup', () => {
    validarInputDireccion();
    funciones.limitarCantidadCaracteres('direccion-cliente', 100);
});
inputsEditarTarea.clasificacionLead.addEventListener('change', () => {
    funciones.validarCampoVacio(inputsEditarTarea.clasificacionLead);
});
inputsEditarTarea.origenLead.addEventListener('change', () => {
    funciones.validarCampoVacio(inputsEditarTarea.origenLead);
});
inputsEditarTarea.rubroComercial.addEventListener('change', () => {
    funciones.validarCampoVacio(inputsEditarTarea.rubroComercial);
});
inputsEditarTarea.razonSocial.addEventListener('change', () => {
    funciones.validarCampoVacio(inputsEditarTarea.razonSocial);
});
// ============================================================================================================
//Funcion principal que aplica validaciones a los inptus de forma dinamica segun tipo cliente y tipo tarea
let validarInputs = (funciones, tipoCliente) => {
    switch ($estadoTarea.value){
        case "2":{ //Leads
            validarInputRTN(tipoCliente);
            validarInputNombreCliente(tipoCliente);
            validarInputTitulo ();
            if(tipoCliente != 'Existente'){
                validarInputTelefono();
                validarInputCorreo();
                validarInputDireccion();
            }
            funciones.validarCampoVacio(inputsEditarTarea.rubroComercial);
            funciones.validarCampoVacio(inputsEditarTarea.razonSocial);
            funciones.validarCampoVacio(inputsEditarTarea.clasificacionLead);
            funciones.validarCampoVacio(inputsEditarTarea.origenLead);
            break;
        } 
        case "4": {
            validarInputEvidenciaFactura();
            validarInputRTN(tipoCliente);
            validarInputNombreCliente(tipoCliente);
            validarInputTitulo();
            if(tipoCliente != 'Existente'){ 
                validarInputTelefono();
                validarInputCorreo();
                validarInputDireccion();
            }
            funciones.validarCampoVacio(inputsEditarTarea.rubroComercial);
            funciones.validarCampoVacio(inputsEditarTarea.razonSocial);
            break;
        }
        default:{ //Otros estados
            validarInputRTN(tipoCliente);
            validarInputNombreCliente(tipoCliente);
            validarInputTitulo();
            if(tipoCliente != 'Existente'){ 
                validarInputTelefono();
                validarInputCorreo();
                validarInputDireccion();
            }
            funciones.validarCampoVacio(inputsEditarTarea.rubroComercial);
            funciones.validarCampoVacio(inputsEditarTarea.razonSocial);
            break;
        }   
    }
    
}
let validarInputRTN = ($tipoCliente) => {
    let estadoValidaciones = {
        estadoSN: false,
        estadoCV: false,
        estadoME: false,
        estadoMC: false
    }
    estadoValidaciones.estadoCV = funciones.validarCampoVacio(inputsEditarTarea.rtn);
    (estadoValidaciones.estadoCV) ? estadoValidaciones.estadoSN = funciones.validarSoloNumeros(inputsEditarTarea.rtn, validaciones.soloNumeros) : '';
    (estadoValidaciones.estadoSN) ? estadoValidaciones.estadoME =funciones.validarEspacios(inputsEditarTarea.rtn) : '';
    (estadoValidaciones.estadoME) ? estadoValidaciones.estadoMC = funciones.validarMismoNumeroConsecutivo(inputsEditarTarea.rtn, validaciones.caracterMas5veces) : '';
    (estadoValidaciones.estadoMC && $tipoCliente != 'Existente') ? funciones.caracteresMinimo(inputsEditarTarea.rtn, 13) : '';
}
//Validaciones campo nombre cliente
let validarInputNombreCliente = ($tipoCliente) => {
    let usuarioMayus = inputsEditarTarea.nombre.value.toUpperCase();
    inputsEditarTarea.nombre.value = usuarioMayus;
    let estadoValidaciones = {
        estadoSL: false,
        estadoCV: false,
        estadoME: false,
        estadoMC: false
    }
    estadoValidaciones.estadoCV = funciones.validarCampoVacio(inputsEditarTarea.nombre);
    (estadoValidaciones.estadoCV  && $tipoCliente != 'Existente') ? estadoValidaciones.estadoSL = funciones.validarSoloLetras(inputsEditarTarea.nombre, validaciones.soloLetras) : '';
    (estadoValidaciones.estadoSL  && $tipoCliente != 'Existente') ? estadoValidaciones.estadoME = funciones.validarMasdeUnEspacio(inputsEditarTarea.nombre) : '';
    (estadoValidaciones.estadoME  && $tipoCliente != 'Existente') ? estadoValidaciones.estadoMC = funciones.limiteMismoCaracter(inputsEditarTarea.nombre, validaciones.caracterMas3veces) : '';
    (estadoValidaciones.estadoMC && $tipoCliente != 'Existente') ? funciones.caracteresMinimo(inputsEditarTarea.nombre, 13) : '';
 }
//Validaciones del campo telefono
let validarInputTelefono = () => {
    let estadoValidaciones = {
        estadoCV: false,
        estadoSN: false,
        estadoE: false,
        estadoMC: false
    }
    estadoValidaciones.estadoCV = funciones.validarCampoVacio(inputsEditarTarea.telefono);
    (estadoValidaciones.estadoCV) ? estadoValidaciones.estadoSN = funciones.validarSoloNumeros(inputsEditarTarea.telefono, validaciones.soloNumeros) : '';
    (estadoValidaciones.estadoSN) ? estadoValidaciones.estadoE = funciones.validarEspacios(inputsEditarTarea.telefono) : '';
    (estadoValidaciones.estadoE) ? estadoValidaciones.estadoMC = funciones.validarMismoNumeroConsecutivo(inputsEditarTarea.telefono, validaciones.caracterMas5veces) : '';
    (estadoValidaciones.estadoMC) ? funciones.caracteresMinimo(inputsEditarTarea.telefono, 8) : '';
}
let validarInputCorreo = () => {
    (funciones.validarCampoVacio(inputsEditarTarea.correo)) ? funciones.validarCorreo(inputsEditarTarea.correo, validaciones.correo) : '';
}
let validarInputTitulo = () => {
    let estadoValidaciones = {
        estadoCV: false,
        estadoME: false,
        estadoSLN: false
    }
    estadoValidaciones.estadoCV = funciones.validarCampoVacio(inputsEditarTarea.titulo);
    (estadoValidaciones.estadoCV) ? estadoValidaciones.estadoSLN = funciones.validarSoloLetrasNumeros(inputsEditarTarea.titulo, validaciones.letrasNumeros) : '';
    (estadoValidaciones.estadoSLN) ? estadoValidaciones.estadoME = funciones.validarMasdeUnEspacio(inputsEditarTarea.titulo) : '';
    (estadoValidaciones.estadoME) ? funciones.limiteMismoCaracter(inputsEditarTarea.titulo, validaciones.caracterMas3veces) : '';
}
let validarInputDireccion = () => {
    let estadoValidaciones = {
        estadoCV: false,
        estadoME: false,
        estadoSLN: false,
        estadoMC: false
    }
    estadoValidaciones.estadoCV = funciones.validarCampoVacio(inputsEditarTarea.direccion);
    (estadoValidaciones.estadoCV) ? estadoValidaciones.estadoSLN = funciones.validarSoloLetrasNumeros(inputsEditarTarea.direccion, validaciones.direccion) : '';
    (estadoValidaciones.estadoSLN) ? estadoValidaciones.estadoME = funciones.validarMasdeUnEspacio(inputsEditarTarea.direccion) : '';
    (estadoValidaciones.estadoME) ? estadoValidaciones.estadoMC = funciones.limiteMismoCaracter(inputsEditarTarea.direccion, validaciones.caracterMas3veces) : '';
    (estadoValidaciones.estadoMC) ? funciones.caracteresMinimo(inputsEditarTarea.direccion, 20) : '';
}
let validarInputEvidenciaFactura = () => {
    let estadoValidaciones = {
        estadoCV: false,
    }
    if(inputsEditarTarea.nFactura.disabled == false) {
        estadoValidaciones.estadoCV = funciones.validarCampoVacio(inputsEditarTarea.nFactura);
    }
}

