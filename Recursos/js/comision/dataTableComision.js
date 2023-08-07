/* import {estadoValidado as validado } from './validacionesModalNuevoUsuario.js';
import {estadoValidado as valido } from './validacionesModalEditarUsuario.js';
 */
let tablaComision = '';
$(document).ready(function () {
  tablaComision = $('#table-Comision').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/comision/obtenerComision.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "idComision"},
      { "data": "factura" },
      { "data": "totalVenta" },
      { "data": "porcentaje" },
      { "data": "comisionTotal" },
      { "data": "fechaComision" },
      {
        "defaultContent":
          '<div><button class="btns btn" id="btn_ver"><i class="fas fa-file-pdf"></i></button>' /* +
          '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>' */
      }
    ]
  });
});

