import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
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
                        estadoValidado = true;
                        console.log(estadoValidado); // 
                    }
                
            
            }       
            
        }
});


// $valor.addEventListener('keyup', ()=>{
//     estadoSoloNumeros.estadoNumerosValorPorcentaje = funciones.validarSoloNumeros($valor, validaciones.soloNumeros);
//     $("#valorPorcentaje").inputlimiter({
//         limit: 14
//     });
// });

// $descripcion.addEventListener('keyup', ()=>{
//     estadoSoloLetras.estadoLetrasDescripcionPorcentaje = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
//     $("#descripcionPorcentaje").inputlimiter({
//         limit: 50
//     });
// });

// $estado.addEventListener('change', ()=>{
//     estadoSelect = funciones.validarCampoVacio($estado);
// });