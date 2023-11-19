let $inputEvidencia = document.getElementById('evidencia');
let $formEvidencia = document.getElementById('form-evidencia');

$formEvidencia.addEventListener('submit', (event) => {
    event.preventDefault();
    subirEvidencia($formEvidencia);
    $inputEvidencia.value = null;
    Swal.fire(
        'Exito!',
        'Su evidencia ha sido guardada',
        'success',
      )
 });

let subirEvidencia = function($form){
    let ajax = new XMLHttpRequest();
    let urlPHP = '../../../Vista/crud/DataTableSolicitud/guardarEvidencia.php';
    ajax.open('post', urlPHP)
    ajax.send(new FormData($form));
}