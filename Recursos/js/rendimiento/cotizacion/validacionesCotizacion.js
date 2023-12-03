import * as funciones from '../../funcionesValidaciones.js';
export let estadoValidado = false;
export let estado = false;
//Objeto con expresiones regulares para los inptus

const $btnGuarCoti = document.getElementById('btn-submit-cotizacion');
const $btnProduct = document.getElementById('btn-agregar-producto');
const $descProducto = document.getElementById('descripcion');
const $marProducto = document.getElementById('marca');
const $preProducto = document.getElementById('precio');
// let $cantsProducto = document.querySelectorAll('.input-cant');
// const $descuento = document.getElementById('valor-descuento');

$(document).ready(() => {
    $btnProduct.addEventListener('click', e =>{
        let $descripProducto = funciones.validarCampoVacio($descProducto);
        let $marcaProducto = funciones.validarCampoVacio($marProducto);
        let $precioProducto = funciones.validarCampoVacio($preProducto);
        if($descripProducto == false || $marcaProducto == false || $precioProducto == false){
            e.preventDefault();
        }else{
            estadoValidado = true;
        }
    });
    $(document).on('click', '#btn-submit-cotizacion', function (e) {
        let $cantsProducto = document.querySelectorAll('.input-cant');
        console.log($cantsProducto);
        $cantsProducto.forEach(cant => {
            let cantidad = funciones.validarCampoVacioCant(cant);
            if(cantidad == false){
                e.preventDefault();
                console.log('falso');
            }else{
                estado = true;
            }
        });
    });
});