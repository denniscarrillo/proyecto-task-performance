let obtenerVendedores = function () {
  if (document.getElementById('table-Vendedores_wrapper') == null) {
    $('#table-Vendedores').DataTable({
      "ajax": {
        "url": "../../../Vista/grafica/obtenerFiltroVendedores.php",
        "dataSrc": ""
      },
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
      },
      "columns": [
        { "data": 'idVendedor' },
        { "data": 'nombreVendedor' },
        {
          "defaultContent":
            '<div><button class="btns btn btn_select-Vendedores"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>'
        }
      ]
    });
  }
}