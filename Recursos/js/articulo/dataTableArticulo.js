// import {estadoValidado as validado } from './ValidacionesModalNuevoPorcentaje.js';
// import {estadoValidado as valido } from './ValidacionesModalEditarPorcentaje.js';

let tablaArticulo = '';
$(document).ready(function () {
    tablaArticulo = $('#table-Articulos').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/articulo/obtenerArticulo.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "codigo"},
      { "data": "articulo" },
      { "data": "detalle" },
      { "data": "marcaArticulo" }
    ]
  });
});