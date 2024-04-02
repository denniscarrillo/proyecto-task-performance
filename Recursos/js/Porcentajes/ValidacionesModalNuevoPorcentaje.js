import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

let estadoExistePorcentaje = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    soloNumeros: /^\d+(\.\d+)?$/
}
//VARIABLES GLOBALES

let estadoSoloNumeros = {
    estadoNumerosValorPorcentaje: true,
}
let estadoSoloLetras = {
    estadoLetrasDescripcionPorcentaje: true,
}
let estadoMayorCero = {
    estadoMayorCeroMeta: true
} 
let estadoSelect = true;


const $form = document.getElementById('form-Porcentajes');
const $valor = document.getElementById('valorPorcentaje');
const $descripcion = document.getElementById('descripcionPorcentaje');
const $estado = document.getElementById('estadoPorcentaje');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputValor = funciones.validarCampoVacio($valor);
    let estadoInputDescripcion = funciones.validarCampoVacio($descripcion);
    let estadoInputEstado = funciones.validarCampoVacio($estado);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputValor == false || estadoInputDescripcion == false || estadoInputEstado == false) {
        e.preventDefault();
    } else {
        if(estadoSoloNumeros.estadoNumerosValorPorcentaje == false){
            e.preventDefault();
            estadoSoloNumeros.estadoNumerosValorPorcentaje = funciones.validarSoloNumeros($valor, validaciones.soloNumeros);           
            } else{
                if(estadoSoloLetras.estadoLetrasDescripcionPorcentaje== false){
                    e.preventDefault();
                    estadoSoloLetras.estadoLetrasDescripcionPorcentaje = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
                }
                 else {
                    if (estadoExistePorcentaje == false) {
                        e.preventDefault();
                        let valorEntero = parseInt($('#valorPorcentaje').val());
                        let valorDecimal = valorEntero / 100;
                        $valor.value = valorDecimal;
                        estadoExistePorcentaje = 
                        estadoExistePorcentaje = obtenerPorcentajeExiste(valorPorcentaje);
                    } else {
                        if(estadoMayorCero.estadoMayorCeroMeta == false){
                            e.preventDefault();
                            estadoMayorCero.estadoMayorCeroMeta = funciones.MayorACero($valor);    
                        } else {
                            estadoValidado = true;
                            console.log(estadoValidado); // 
                        }
                
                }
            }       
            
        }
    } 
});
$('#valorPorcentaje').on('focusout', function () {
    // Obtiene el valor ingresado por el usuario como número entero
    let valorEntero = parseInt($(this).val());

    // Verifica si el valor es un número válido
    if (!isNaN(valorEntero)) {
        // Convierte el número entero a decimal dividiéndolo por 100
        let valorDecimal = valorEntero / 100;

        // Llama a la función para verificar si el porcentaje existe en la base de datos
        estadoExistePorcentaje = obtenerPorcentajeExiste(valorDecimal);
    } 
});


let obtenerPorcentajeExiste = ($valorPorcentaje) => {
  
    $.ajax({
        url: "../../../Vista/crud/Porcentajes/porcentajeExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            valorPorcentaje: $valorPorcentaje
        },
        success: function (valorPorcentaje) {
            let $objPorcentaje = JSON.parse(valorPorcentaje);
            if ($objPorcentaje.estado == 'true') {
                document.getElementById('valorPorcentaje').classList.add('mensaje_error');
                document.getElementById('valorPorcentaje').parentElement.querySelector('p').innerText = '*El porcentaje ya existe';
                estadoExistePorcentaje = false; // porcentaje es existente, es false
            } else {
                document.getElementById('valorPorcentaje').classList.remove('mensaje_error');
                document.getElementById('valorPorcentaje').parentElement.querySelector('p').innerText = '';
                estadoExistePorcentaje = true; // porcentaje no existe, es true
            }
        }
        
    });
}

$valor.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerosValorPorcentaje = funciones.validarSoloNumeros($valor, validaciones.soloNumeros);
    $("#valorPorcentaje").inputlimiter({
        limit: 14
    });
});

$valor.addEventListener('keyup', ()=>{
    estadoMayorCero.estadoMayorCeroMeta = funciones.MayorACero($valor);
    $("#valorPorcentaje").inputlimiter({
        limit: 14
    });
});

$valor.addEventListener('focusout', ()=>{
    estadoMayorCero.estadoMayorCeroMeta = funciones.MayorACero($valor);
    $("#valorPorcentaje").inputlimiter({
        limit: 14
    });
});

$(document).on("keydown", "#valorPorcentaje", function (e) {
    let key = e.keyCode || e.which;
    // Permitir solo números positivos (código ASCII del 48 al 57 es 0-9)
    if ((key < 48 || key > 57) && key != 46 && key != 8) {
        e.preventDefault();
    } else {
        let currentValue = parseFloat(this.value + String.fromCharCode(key));
        // Evitar números negativos o cero
        if (currentValue <= 0 || isNaN(currentValue)) {
            e.preventDefault();
        }
    }
});

$descripcion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasDescripcionPorcentaje = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
    $("#descripcionPorcentaje").inputlimiter({
        limit: 50
    });
    let descripcionMayus = $descripcion.value.toUpperCase();
     $descripcion.value = descripcionMayus; 
});

$estado.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($estado);
});