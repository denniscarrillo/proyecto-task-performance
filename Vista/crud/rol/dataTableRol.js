let tablaRol = '';

$(document).ready(function () {
  tablaRol = $('#table-Rol').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/rol/obtenerRoles.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "id_Rol" },
      { "data": 'rol' },
      { "data": 'descripcion' },
      {
        "defaultContent":
          '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' +
          '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'
      }
    ]
  });

  // Crear nuevo rol
  $(document).ready(function () {
    $('#btnGuardar').click(function (e) {
      e.preventDefault();
  
      let rol = $('#rol').val();
      let descripcion = $('#descripcion').val();
  

      let validado = true; // Define y verifica la variable de validación
  
      if (validado) {
        $.ajax({
          url: "../../../Vista/crud/rol/nuevoRol.php",
          type: "POST",
          dataType: "json", // Cambié "datatype" a "dataType"
          data: {
            rol: rol,
            descripcion: descripcion,
          },
          success: function () {
            Swal.fire(
              'Registrado!',
              'Se ha registrado el nuevo rol.',
              'success'
            );
            // Si tablaRol.ajax.reload() es necesario, agrégalo aquí
            $('#modalNuevoRol').modal('hide');
          },
          error: function () {
            Swal.fire(
              'Error!',
              'Ocurrió un error al registrar el rol.',
              'error'
            );
          }
        });
      }
    });
  });
  
  // Eliminar rol
  $(document).on("click", "#btn_eliminar", function () {
    let fila = $(this);
    let rol = fila.closest('tr').find('td:eq(1)').text();

    Swal.fire({
      title: '¿Estás seguro de eliminar a ' + rol + '?',
      text: "¡Esta acción no se puede revertir!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminarlo'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../../Vista/crud/rol/eliminarRol.php",
          type: "POST",
          datatype: "json",
          data: { rol: rol },
          success: function (data) {
            tablaRol.row(fila.parents('tr')).remove().draw();
            Swal.fire(
              'Eliminado',
              'El rol ha sido eliminado.',
              'success'
            );
          }
        });
      }
    });
  });
});
