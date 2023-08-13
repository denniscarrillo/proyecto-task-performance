let tablaBitacora = '';
$(document).ready(function () {
  tablaBitacora = $('#table-Bitacora').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/bitacora/obtenerBitacora.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "id_Bitacora"},
      { "data": 'fecha' },
      { "data": 'id_Usuario' },
      { "data": 'id_Objeto' },
      { "data": 'accion' },
      { "data": 'descripcion' },
      
      
      {
        "defaultContent":
          '<div></div>'
      }
    ]
  });

  $('#btn_ver').click(function () {
    let id_Bitacora = $(this).closest('tr').find('td:eq(0)').text();
    GenerarReporte(id_Bitacora);
  });

  let GenerarReporte = (id_Bitacora) => {
    $.ajax({
      url: "../../../Vista/fpdf/Reporte_rol.php",
      type: "POST",
      datatype: "JSON",
      data: {
        id_Bitacora: id_Bitacora
      }
    }); //Fin AJAX
  }

});