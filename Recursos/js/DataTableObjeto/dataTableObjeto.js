
let tablaDataTableObjeto = '';


$(document).ready(function () {
  tablaDataTableObjeto = $('#table-Objeto').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/DataTableObjeto/obtenerDataTableObjeto.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": 'id_Objeto' },
      { "data": 'objeto' },
      { "data": 'descripcion' },
      {"data":  'tipo_Objeto' },
      {
        "defaultContent":
        `<button class="btn-editar btns btn " id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>`+
        `<button class="btn_eliminar btns btn " id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>`
      }
    ]
  });
});

$(document).on("click", "#btn_Pdf", function() {
  let buscar = $('#table-Objeto_filter > label > input[type=search]').val();
  window.open('../../../TCPDF/examples/reporteriaObjetos.php?buscar='+buscar, '_blank');
});

//Crear nuevo Objeto
// $('#form-Nuevo-Objeto').submit(function (e) {
//   e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
//      //Obtener datos del nuevo Usuario
//      let objeto = $('#objeto').val();
//      let descrip = $('#descripcion').val();
//     if(true){
//       $.ajax({
//         url: "../../../Vista/crud/DataTableObjeto/nuevoObjeto.php",
//         type: "POST",
//         datatype: "JSON",
//         data: {
//           objeto: objeto,
//           descripcion: descrip
//         },
//         success: function (data) {
//           console.log(data);
//           //Mostrar mensaje de exito
//           Swal.fire(
//            'Registrado!',
//            'Se le ha ingresado un nuevo objeto!',
//            'success',
//          )
//          tablaDataTableObjeto.ajax.reload(null, false);
//         }
//       });
//      $('#modalNuevoObjeto').modal('hide');
//     } 
//});