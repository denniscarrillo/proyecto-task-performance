import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;

let estadoSelect = {
    estadoSelectEstado: true,
}
const $form = document.getElementById("form-Edit-Comision");
const $estado = document.getElementById("estadoComision_E");

$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputEstado = funciones.validarCampoVacio($estado);

    if (estadoInputEstado == false) {
        e.preventDefault();
    }  else {
            if(estadoSelect.estadoSelectEstado == false){
                e.preventDefault();
                estadoSelect.estadoSelectEstado = funciones.validarCampoVacio($estado);
            } else {
                estadoValidado = true; // 
            }
        }
});

$estado.addEventListener('change', ()=>{
    estadoSelect.estadoSelectEstado = funciones.validarCampoVacio($estado);
});