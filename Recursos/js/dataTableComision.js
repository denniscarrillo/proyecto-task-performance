import {estadoValidado as validado } from './validacionesModalNuevoUsuario.js';
import {estadoValidado as valido } from './validacionesModalEditarUsuario.js';

let tablaComision = '';
$(document).ready(function () {
  tablaComision = $('#table-Comision').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/usuario/obtenerComision.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "IdComision"},
      { "data": "Venta" },
      { "data": "Porcentaje" },
      { "data": "ComisionTotal" },
      {
        "defaultContent":
          '<div><button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>' +
          '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' +
          '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'
      }
    ]
  });

});
