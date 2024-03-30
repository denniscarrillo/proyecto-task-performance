let tablaDataTableTarea = "";
const Toast = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 5000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

$(document).ready(function () {
  let $idObjetoSistema = document.querySelector(".title-dashboard-task").id;
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = (data) => {
  let permisos = JSON.parse(data);
  let user = document.getElementById("username").textContent;
  tablaDataTableTarea = $("#table-Tareas").DataTable({
    ajax: {
      url: "../../../Vista/crud/DataTableTarea/obtenerDataTableTarea.php",
      dataSrc: "",
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['id']);
    },
    columns: [
      { data: "item" },
      { data: "estadoAvance" },
      { data: "rtnCliente" },
      { data: "nombreCliente" },
      { data: "titulo" },
      { data: "creadoPor" },
      { data: "estadoFinalizacion" },
      {
        data: "fechaFinalizacion.date",
        render: function (data) {
          return data ? data.split(" ")[0] : "Pendiente";
        },
      },
      { data: "diasTranscurridos" },
      {
        defaultContent: `<button class="btn-editar btns btn ${
          permisos.Reporte == "N" ? "hidden" : ""
        }" id="btn_PDFid"><i class="fas fa-file-pdf"> </i></button>
        <button class="btn-abrir ${
          permisos.Actualizar == "N" ? "hidden" : ""
        }" id="btn-abrir-tarea"><i class="fa-solid fa-envelope-open"></i> Reabrir</button>
        <button class="btn-finalizar ${
          permisos.Actualizar == "N" ? "hidden" : ""
        }" id="btn-finalizar-tarea"><i class="fa-solid fa-envelope"></i> Finalizar</button>`,
      },
    ],
  });
};

//Peticion  AJAX que trae los permisos
let obtenerPermisos = function ($idObjeto, callback) {
  $.ajax({
    url: "../../../Vista/crud/permiso/obtenerPermisos.php",
    type: "POST",
    datatype: "JSON",
    data: { idObjeto: $idObjeto },
    success: callback,
  });
};

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function () {
  let buscar = $("#table-Tareas_filter > label > input[type=search]").val();
  window.open(
    "../../../TCPDF/examples/reporteConsulTarea.php?buscar=" + buscar,
    "_blank"
  );
});

$(document).on("click", "#btn_PDFid", function () {
  let idTarea = $(this).closest("tr").find("td:eq(0)").text();
  console.log(idTarea);

  window.open(
    "../../../TCPDF/examples/reporteTareaID.php?idTarea=" + idTarea,
    "_blank"
  );
});
//Reabrir una tarea finalizada
$(document).on("click", "#btn-abrir-tarea", function () {
  let fila = $(this);
  let tarea = $(this).closest("tr").find("td:eq(0)").text();
  let estadoFinalizacion = $(this).closest("tr").find("td:eq(6)").text();
  if (estadoFinalizacion == "Finalizada") {
    Swal.fire({
      title: "Estas seguro de reabrir la tarea # " + tarea + "?",
      text: "No podras revertir esto!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, ábrela!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../../Vista/rendimiento/reabrirTarea.php",
          type: "POST",
          datatype: "json",
          data: {
            idTarea: tarea,
          },
          success: function (data) {
            if (JSON.parse(data) == true) {
              tablaDataTableTarea.row(fila.parents("tr")).remove().draw();
              Swal.fire(
                "Tarea Abierta",
                "Ha sido reabierta la tarea #" + tarea,
                "success"
              );
              tablaDataTableTarea.ajax.reload(null, false);
            } else {
              Swal.fire(
                "Lo sentimos!",
                "La tarea no se puede reabrir.",
                "error"
              );
              tablaDataTableTarea.ajax.reload(null, false);
            }
          },
        }); //Fin del AJAX
      }
    });
  } else if (estadoFinalizacion == "Reabierta") {
    Toast.fire({
      icon: "error",
      title: "La tarea ya fue reabierta",
    });
  } else {
    Toast.fire({
      icon: "error",
      title: "La tarea está pendiente de finalizar",
    });
  }
});
//Finalizar una tarea pendiente o reabierta, la acción solo la podrá realizar el SUPERADMIN
$(document).on("click", "#btn-finalizar-tarea", function () {
  let fila = $(this);
  let tarea = $(this).closest("tr").find("td:eq(0)").text();
  let estadoFinalizacion = $(this).closest("tr").find("td:eq(6)").text();
  if (estadoFinalizacion == "Pendiente" || estadoFinalizacion == "Reabierta") {
    Swal.fire({
      title: "¿Estás seguro de finalizar la tarea # " + tarea + "?",
      text: "¡No podrás revertir esto!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33", 
      confirmButtonText: "¡Si, finalízala!",
      cancelButtonText: "Cancelar" 
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../../Vista/rendimiento/finalizarTarea.php",
          type: "POST",
          datatype: "json",
          data: {
            idTarea: tarea,
          },
          success: function (data) {
            if (JSON.parse(data) == true) {
              tablaDataTableTarea.row(fila.parents("tr")).remove().draw();
              Swal.fire(
                "¡Tarea Finalizada!",
                "Ha sido finalizada la tarea #" + tarea,
                "success"
              );
              tablaDataTableTarea.ajax.reload(null, false);
            } else {
              Swal.fire(
                "¡Lo sentimos!",
                "La tarea no se puede finalizar.",
                "error"
              );
              tablaDataTableTarea.ajax.reload(null, false);
            }
          },
        }); //Fin del AJAX
      }
    });
  } else if (estadoFinalizacion == "Finalizada") {
    Toast.fire({
      icon: "error",
      title: "La tarea ya fue finalizada",
    });
  }
});
