const $inputGarantia = document.getElementById('evidencia_garantia');
const $formEditSolicitud = document.getElementById('form-Edit-Solicitud');
// const $idSolicitud = document.getElementById('E_IdSolicitud');

$formEditSolicitud.addEventListener('submit', e => {
    e.preventDefault();
    subirGarantia($formEditSolicitud);
});

let subirGarantia = function($form){
    console.log($form);
    let ajax = new XMLHttpRequest();
    let urlPHP = '../../../Vista/crud/DataTableSolicitud/guardarEvidencia.php';
    ajax.open('post', urlPHP);
    ajax.send(new FormData($form));
}

// $(document).on("click", "#btn_Pdf",  function (){
//     let idTarea = document.querySelector('.encabezado').id;
//     let estadoCliente = document.querySelector('.datos-cotizacion').id;
// });