let tablaPermisos = '';
$(document).ready(function () {
    tablaPermisos = $('#table-Permisos').DataTable({
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    }
  });                                  
});
// let checkboxs = document.querySelectorAll();
let btn_confirms =  document.querySelectorAll('.btn_confirm');

btn_confirms.forEach((btn_confirm) => {
  btn_confirm.addEventListener('click', function(){
    actualizarPermisos($(this));
  });
});

let actualizarPermisos = function (elementoFila) {
  let $fila = elementoFila.closest("tr");
  let rol = $fila.find("td:eq(0)").text();
  let objeto = $fila.find("td:eq(1)").text();
  let consultar = ($fila.find("td:eq(2)").find('input')[0].checked == true) ? 'Y' : 'N';
  let insertar = ($fila.find("td:eq(3)").find('input')[0].checked == true) ? 'Y' : 'N'; 
  let actualizar = ($fila.find("td:eq(4)").find('input')[0].checked == true) ? 'Y' : 'N'; 
  let eliminar =  ($fila.find("td:eq(5)").find('input')[0].checked == true) ? 'Y' : 'N'; 

  Swal.fire({
    title: 'Esta seguro?',
    text: "Se actualizaran los permisos",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#ee9827',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, actualizar',
    cancelButtonText: 'Cancelar',
    focusConfirm: true
  }).then((result) => {
    if (result.isConfirmed) {
      //Si el usuario confirma la actualizacion de permisos esta se ejecutara
      $.ajax({
        url: "../../../Vista/crud/permiso/editarPermisos.php",
        type: "POST",
        datatype: "JSON",
        data: {
          rol: rol,
          objeto: objeto,
          consultar: consultar,
          insertar: insertar,
          actualizar: actualizar,
          eliminar: eliminar
        },
        success: function () {
          //Creamos el toast que nos confirma la actualización de los permisos
          const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
          //Mostramos el toast
          Toast.fire({
            icon: 'success',
            title: 'Actualizado correctamente!'
          })
        }
      });
    }
  });
}
