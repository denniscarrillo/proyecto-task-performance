import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

let estadoExisteservicioTecnico = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
};

//VARIABLES GLOBALES
let estadoValidaciones = {
    estadoLetrasServicioTecnico: false,
    estadoInputServicio_Tecnico: false
};

const $form = document.getElementById('form-TipoServicio');
const $servicio_Tecnico = document.getElementById('servicio_Tecnico');

$form.addEventListener('submit', e => {
    estadoValidaciones.estadoInputServicio_Tecnico = funciones.validarCampoVacio($servicio_Tecnico);
    
    if (estadoValidaciones.estadoInputServicio_Tecnico === false) {
        e.preventDefault();
    } else {
        estadoValidaciones.estadoLetrasServicioTecnico = funciones.validarSoloLetras($servicio_Tecnico, validaciones.soloLetras);          
        if(estadoValidaciones.estadoLetrasServicioTecnico == false){
            e.preventDefault();           
        } else {
            if(estadoExisteservicioTecnico == false){
                e.preventDefault();
                estadoExisteservicioTecnico = obtenerServicioTecnico($('#servicio_Tecnico').val());
            } else {
            estadoValidado = true;
        } 
      }
    }
});

$servicio_Tecnico.addEventListener('keyup', () => {
    estadoValidaciones.estadoLetrasServicioTecnico = funciones.validarSoloLetras($servicio_Tecnico, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("servicio_Tecnico", 50);
});
$servicio_Tecnico.addEventListener('focusout', () => {
    let servicioTecnico = $('#servicio_Tecnico').val();
    estadoExisteservicioTecnico = obtenerServicioTecnico(servicioTecnico);
});

let obtenerServicioTecnico = ($servicioTecnico) => {
    $.ajax({
        url: "../../../Vista/crud/TipoServicio/obtenerServicioExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            servicioTecnico: $servicioTecnico
        },
        success: function (servicioTecnico) {
            let $objservicioTecnico = JSON.parse(servicioTecnico);
            if ($objservicioTecnico.estado == 'true') {
                document.getElementById('servicio_Tecnico').classList.add('mensaje_error');
                document.getElementById('servicio_Tecnico').parentElement.querySelector('p').innerText = '*Este servicio tecnico ya existe';
                estadoExisteservicioTecnico = false; // servicioTecnico es existente, es false
            } else {
                document.getElementById('servicio_Tecnico').classList.remove('mensaje_error');
                document.getElementById('servicio_Tecnico').parentElement.querySelector('p').innerText = '';
                estadoExisteservicioTecnico = true; // servicioTecnico no existe, es true
            }
        }
        
    });
}