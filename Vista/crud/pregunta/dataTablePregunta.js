let tablaPregunta = '';

$(document).ready(function () {
  tablaPregunta = $('#table-Pregunta').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/Pregunta/obtenerPregunta.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "id_Pregunta" },
      { "data": 'pregunta' },
      {
        "defaultContent":
          '<div>' +
          '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' +
          '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>' +
          '</div>'
      }
    ]
  });
});
