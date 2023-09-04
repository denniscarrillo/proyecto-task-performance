import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

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
            estadoValidado = true;
        } 
    }
});

$servicio_Tecnico.addEventListener('keyup', () => {
    estadoValidaciones.estadoLetrasServicioTecnico = funciones.validarSoloLetras($servicio_Tecnico, validaciones.soloLetras);
    $("#servicio_Tecnico").inputlimiter({
        limit: 50,
    });
});