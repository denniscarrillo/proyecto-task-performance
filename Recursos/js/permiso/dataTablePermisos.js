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
      //Mostrar mensaje de exito
      Swal.fire(
        'Actualizado',
        'Permisos actualizados!',
        'success',
      );
    }
  });
}


// checkboxs.forEach((checkbox) => {
//   checkbox.addEventListener('change', function (e){
//     e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
//       //Obtener datos del nuevo Usuari
      
//        $('#modalNuevoPermiso').modal('hide');
//   }); //Fin del evento change
// }); //Fin del forEach
