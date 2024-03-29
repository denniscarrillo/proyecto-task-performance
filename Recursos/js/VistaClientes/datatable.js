let tablaClientes = "";
$(document).ready(function () {
  tablaClientes = $("#table-VistaClientes").DataTable({
    ajax: {
      url: "../../../Vista/crud/cliente/obtenerClientes.php",
      dataSrc: "",
    },
    scrollX: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    columns: [
      { data: "codCliente" },
      { data: "nombreCliente" },
      { data: "rtnCliente" },
      { data: "telefono" },
      { data: "direccion" },
    ],
  });
});

$(document).on("click", "#btn_Pdf", function () {
  let buscar = $(
    "#table-VistaClientes_filter > label > input[type=search]"
  ).val();
  window.open(
    "../../../TCPDF/examples/reporteriaClientes.php?buscar=" + buscar,
    "_blank"
  );
});
