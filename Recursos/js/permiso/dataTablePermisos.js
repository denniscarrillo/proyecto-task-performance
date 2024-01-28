let permisos = "";
let tablaPermisos = "";
$(document).ready(function () {
  tablaPermisos = $("#table-Permisos").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
    },
    scrollX: true,
  });
  let btn_confirms = document.querySelectorAll(".btn_confirm");
  validarPermisos(btn_confirms);
});

let actualizarPermisos = function (elementoFila) {
  let $fila = elementoFila.closest("tr");
  let rol = $fila.find("td:eq(0)").text();
  let objeto = $fila.find("td:eq(1)").text();
  let consultar =
    $fila.find("td:eq(2)").find("input")[0].checked == true ? "Y" : "N";
  let insertar =
    $fila.find("td:eq(3)").find("input")[0].checked == true ? "Y" : "N";
  let actualizar =
    $fila.find("td:eq(4)").find("input")[0].checked == true ? "Y" : "N";
  let eliminar =
    $fila.find("td:eq(5)").find("input")[0].checked == true ? "Y" : "N";
  let reporte =
    $fila.find("td:eq(6)").find("input")[0].checked == true ? "Y" : "N";
  Swal.fire({
    title: "¿Esta seguro?",
    text: "Se actualizaran los permisos",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#ee9827",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, actualizar",
    cancelButtonText: "Cancelar",
    focusConfirm: true,
  }).then((result) => {
    if (result.isConfirmed) {
      //Si el usuario confirma la actualizacion de permisos esta se ejecutara
      $.ajax({
        url: "../../../Vista/crud/permiso/editarPermisos.php",
        type: "POST",
        datatype: "JSON",
        data: {
          rol: rol,
          objeto: objeto,
          consultar: consultar,
          insertar: insertar,
          actualizar: actualizar,
          eliminar: eliminar,
          reporte: reporte,
        },
        success: function () {
          //Creamos el toast que nos confirma la actualización de los permisos
          const Toast = Swal.mixin({
            toast: true,
            position: "top",
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener("mouseenter", Swal.stopTimer);
              toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
          });
          //Mostramos el toast
          Toast.fire({
            icon: "success",
            title: "Actualizado correctamente",
          });
        },
      });
    }
  });
};

//Obtener permisos del usuario logeado
let obtenerPermisos = async function () {
  try {
    let permisos = await $.ajax({
      url: "../../../Vista/crud/permiso/obtenerPermisos.php",
      type: "POST",
      datatype: "JSON",
      data: {
        idObjeto: document.querySelector(".title-dashboard-task").id,
      },
    });
    return JSON.stringify(permisos).split('"')[8].split('"')[0].split("\\")[0];
  } catch (error) {
    console.error(error);
  }
};
let validarPermisos = async function (btn_confirms) {
  let user = document.getElementById("username").textContent;
  let permisoActualizar = "N";
  if (user != "SUPERADMIN") {
    permisoActualizar = await obtenerPermisos();
  }
  btn_confirms.forEach((btn_confirm) => {
    if (permisoActualizar == "Y" || user == "SUPERADMIN") {
      btn_confirm.addEventListener("click", function () {
        actualizarPermisos($(this));
      });
    } else {
      btn_confirm.classList.remove("btn_confirm");
      btn_confirm.classList.add("fa-check-circle");
    }
  });
};

//Generar reporte PDF
$(document).on("click", "#btn_Pdf", function () {
  let buscar = $("#table-Permisos_filter > label > input[type=search]").val();
  window.open(
    "../../../TCPDF/examples/reportePermisos.php?buscar=" + buscar,
    "_blank"
  );
});
