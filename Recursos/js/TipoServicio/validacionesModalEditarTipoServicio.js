import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.'*[^a-zA-Z\s])/, //Solo letras
}
//VARIABLES GLOBALES
let estadoValidaciones = {
    estadoLetrasServicio_Tecnico: false,
    estadoInputServicio_Tecnico: false
};

const $form = document.getElementById('form-Edit-TipoServicio');
const $servicio_Tecnico = document.getElementById('E_servicio_Tecnico');

$form.addEventListener('submit', e => {
    estadoValidaciones.estadoInputServicio_Tecnico = funciones.validarCampoVacio($servicio_Tecnico);
    
    if (estadoValidaciones.estadoInputServicio_Tecnico === false ) {
        e.preventDefault();
    } else {
        estadoValidaciones.estadoLetrasServicio_Tecnico = funciones.validarSoloLetras($servicio_Tecnico, validaciones.soloLetras);
        if(estadoValidaciones.estadoLetrasServicio_Tecnico == false){
            e.preventDefault();
                       
        } else {
            estadoValidado = true;
        } 
    }
});

$servicio_Tecnico.addEventListener('keyup', () => {
    estadoValidaciones.estadoLetrasServicio_Tecnico = funciones.validarSoloLetras($servicio_Tecnico, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("E_servicio_Tecnico", 50);

});
$servicio_Tecnico.addEventListener('focusout', ()=>{
    
     let servicio_TecnicoMayus = $servicio_Tecnico.value.toUpperCase();
     $servicio_Tecnico.value = servicio_TecnicoMayus;  
 });