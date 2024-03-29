import { sidePanel_Interaction } from "../../components/js/sidePanel.js"; //importamos la funcion del sidePanel
import { estadoValidado } from "./validacionesEditarTarea.js";

// let estado = false;
let tipoCliente = "";
let existEvidencia = 0;
let numEvidencia = "";
let $idTarea = document.getElementById("id-Tarea").value;
let $idEstadoTarea = document.querySelector(".id-estado-tarea").id;
const $btnCotizacion = document.getElementById("btn-container-cotizacion");
let radioOption = document.getElementsByName("radioOption");
let estadoRTN = "";
let $codCliente = "";
let $rtn_Cliente = document.getElementById("rnt-cliente");
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
let inputsEditarTarea = {
  rtn: document.getElementById("rnt-cliente"),
  nombre: document.getElementById("nombre-cliente"),
  telefono: document.getElementById("telefono-cliente"),
  correo: document.getElementById("correo-cliente"),
  direccion: document.getElementById("direccion-cliente"),
  rubroComercial: document.getElementById("rubrocomercial"),
  razonSocial: document.getElementById("razonsocial"),
  clasificacionLead: document.getElementById("clasificacion-lead"),
  origenLead: document.getElementById("origen-lead"),
};
$(document).ready(async function () {
  $idEstadoTarea == "3" ? $btnCotizacion.removeAttribute("hidden") : "";
  $idEstadoTarea == "4"
    ? document.getElementById("container-num-factura").removeAttribute("hidden")
    : "";
  setEstadoTarea();
  obtenerComentarios($idTarea);
  obtenerDatosTarea($idTarea, $idEstadoTarea);
  document.getElementById("list-articulos").childElementCount > 0
    ? (document.getElementById("sin-productos-interes").hidden = true)
    : "";

  estadoRTN = await $.ajax({
    url: "../../../Vista/rendimiento/cotizacion/obtenerRTN_Tarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idTarea: $idTarea,
    },
  });
  tipoCliente = radioOption[1].checked
    ? radioOption[1].value
    : radioOption[0].value;
  document
    .getElementById("link-nueva-cotizacion")
    .setAttribute(
      "href",
      `./cotizacion/v_cotizacion.php?idTarea=${$idTarea}&estadoCliente=${tipoCliente}`
    );
  //Evento para el boton de Finalizar una tarea
  document
    .getElementById("btn-finalizar-tarea")
    .addEventListener("click", () => {
      let estadoFinalizar = document
        .getElementById("estado-finalizacion")
        .textContent.trim();
      if (estadoFinalizar != "PENDIENTE" && estadoFinalizar != "REABIERTA") {
        Toast.fire({
          icon: "error",
          title: "La tarea ya fue finalizada",
        });
        return;
      }
      if ($idTarea != null) {
        Swal.fire({
          title: "Estas seguro de finalizar la tarea # " + $idTarea + "?",
          text: "No podras revertir esto!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Si, finalizalo!",
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "../../../Vista/rendimiento/finalizarTarea.php",
              type: "POST",
              datatype: "JSON",
              data: {
                idTarea: $idTarea,
              },
              success: function (data) {
                if (!JSON.parse(data) == true) {
                  Swal.fire(
                    "Lo sentimos!",
                    "La tarea no ha sido finalizada.",
                    "error"
                  );
                  return;
                }
                Swal.fire(
                  "Tarea Finalizada!",
                  "Ya no se te permite editarla, a menos que sea reabierta por tu Administrador",
                  "success"
                );
                document.getElementById("estado-finalizacion").textContent =
                  "FINALIZADA";
                document.getElementById("btn-finalizar-tarea").textContent =
                  "Tarea finalizada";
                document.getElementById("btn-guardar").disabled = true;
              },
            }); //Fin del AJAX
          }
        });
      }
    });
}); //Fin del document.Ready()

document.getElementById("btn-comment").addEventListener("click", () => {
  obtenerComentarios($idTarea);
  obtenerHistorialTarea($idTarea);
});
//Validar datos del cliente antes de redirigir al usuario a la vista cotización
document
  .getElementById("link-nueva-cotizacion")
  .addEventListener("click", (e) => {
    if (JSON.parse(estadoRTN) == false) {
      e.preventDefault();
      Toast.fire({
        icon: "warning",
        title: "Debe tener los datos del cliente",
      });
    }
  });

/* ----------- Función de que le da interacción del sidepanel -------------------------*/
let $tabComments = document.getElementById("tab-comment");
let $tabHistory = document.getElementById("tab-history");
let $commentsContainer = document.getElementById("comments-container-list");
let $historyContainer = document.getElementById("history-container");
sidePanel_Interaction(
  document.getElementById("btn-comment"),
  document.getElementById("btn-close-comment")
);
/* ------------------ Intercambio de tabs para el sidepanel  -------------------- */
$tabHistory.addEventListener("click", () => {
  $commentsContainer.setAttribute("style", "z-index: -30; opacity: 0;");
  $historyContainer.setAttribute("style", "z-index: 20; opacity: 1;");
  $tabComments.classList.remove("tab-selected");
  $tabHistory.classList.add("tab-selected");
});
$tabComments.addEventListener("click", () => {
  $tabHistory.classList.remove("tab-selected");
  $tabComments.classList.add("tab-selected");
  $commentsContainer.removeAttribute("style");
  $historyContainer.removeAttribute("style");
});

/* ------------------------------------------------------------------------------------ */
//En el evento submit llamamos a la función que enviara el comentario a la base de datos
document.getElementById("form-comentario").addEventListener("submit", (e) => {
  e.preventDefault();
  let $comentario = document.getElementById("input-comentario").value;
  nuevoComentario($idTarea, $comentario);
  obtenerComentarios($idTarea);
  obtenerHistorialTarea($idTarea);
});
document
  .getElementById("form-Edit-Tarea")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    let $idTask = $("#id-Tarea").val();
    let radioOption = document.getElementsByName("radioOption");
    let tipoCliente = radioOption[1].checked
      ? radioOption[1].value
      : radioOption[0].value;
    if (estadoValidado) {
      //Si se cumplen todas las validacinones se guardara la data
      let $datosTarea = validarCamposEnviar(tipoCliente);
      actualizarDatosTarea($datosTarea);
      enviarProductosInteres($idTask); //Enviamos los productos de interes a almacenar
      obtenerDatosTarea($idTarea, $idEstadoTarea);
      setTimeout(() => {
        location.href = "../../../Vista/rendimiento/v_tarea.php";
      }, 1800);
    }
  });
// CARGAR LOS ARTICULOS A AGREGAR A LA TAREA
$("#btn-articulos").click(() => {
  if (document.getElementById("table-Articulos_wrapper") == null) {
    let articulosTarea = $("#table-Articulos").DataTable({
      ajax: {
        url: "../../../Vista/rendimiento/obtenerArticulos.php",
        dataSrc: "",
      },
      language: {
        url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
      },
      fnCreatedRow: function(rowEl) {
        $(rowEl).attr('class', 'addProduct')
      },
      lengthMenu: [
        [2, 5, 10, 20], //Define la cantidad de rows a mostrar en el DataTable
        [2, 5, 10, 20], //Es lo que se muestra en el menu desplegable del DataTable
      ],
      columns: [
        { data: "codArticulo" }, 
        { data: "articulo" },
        { data: "detalleArticulo" },
        { data: "marcaArticulo" },
        {
          defaultContent:
            '<div class="btn-select-container"><button class="btns btn" id="btn_select-article"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>',
        },
      ],
    });
  }
});
$(document).on("click", ".addProduct", function (e) {
  $(this).find("button")[0].classList.toggle("select_articulo");
  e.currentTarget.classList.toggle("ArtSelec");
});

$(document).on("click", "#btn_select-cliente", function () {
  let fila = $(this).closest("tr");
  let codCliente = fila.find("td:eq(0)").text();
  $codCliente = codCliente;
  let nombreCliente = fila.find("td:eq(1)").text();
  let rtnCliente = fila.find("td:eq(2)").text();
  let telefonoCliente = fila.find("td:eq(3)").text();
  let correoCliente = fila.find("td:eq(4)").text();
  let direccionCliente = fila.find("td:eq(5)").text();

  let nombre = document.getElementById("nombre-cliente");
  let rtn = document.getElementById("rnt-cliente");
  let telefono = document.getElementById("telefono-cliente");
  let correo = document.getElementById("correo-cliente");
  let direccion = document.getElementById("direccion-cliente");

  //Setear datos del cliente
  nombre.value = nombreCliente;
  rtn.value = rtnCliente;
  correo.value = correoCliente;
  telefono.value = telefonoCliente;
  direccion.value = direccionCliente;

  //Deshabilitar elementos
  nombre.setAttribute("disabled", "true");
  correo.setAttribute("disabled", "true");
  telefono.setAttribute("disabled", "true");
  direccion.setAttribute("disabled", "true");

  $("#modalClientes").modal("hide");
  $("#modalEditarTarea").modal("show");
});
//Evento al boton "Agregar"
$("#btn_agregar").click(function () {
  agregarArticulos();
  $("#modalArticulos").modal("hide");
  $("#modalEditarTarea").modal("show");
});
let agregarArticulos = function () {
  let $Articulos = [];
  let productosSeleccionados = $("#table-Articulos")
    .DataTable()
    .rows(".ArtSelec")
    .data();
  for (let i = 0; i < productosSeleccionados.length; i++) {
    $Articulos.push({
      id: productosSeleccionados[i].codArticulo,
      nombre: productosSeleccionados[i].articulo,
      marca: productosSeleccionados[i].marcaArticulo,
    });
  }
  carritoArticulos($Articulos);
};

let carritoArticulos = ($productos) => {
  let productos = "";
  let $tableArticulos = document.getElementById("list-articulos");
  $productos.forEach((producto) => {
    productos += `
      <tr>
      <td><input type="text" value="${producto.id}" class="id-producto" name="id-producto"></td>
        <td>${producto.nombre}</td>
        <td>${producto.marca}</td>
        <td><input type="number" id="${producto.id}" class="cant-producto" value="1" min="1" pattern="^[1-9]+"></td>
      </tr>
    `;
  });
  $tableArticulos.innerHTML = productos;
  let idsProducto = document.querySelectorAll(".id-producto");
  idsProducto.forEach(function (idProducto) {
    idProducto.setAttribute("disabled", "true");
  });
  if ($productos.length > 0) {
    document.getElementById("sin-productos-interes").hidden = true;
  } else {
    document.getElementById("sin-productos-interes").hidden = false;
  }
};
let setEstadoTarea = function () {
  let $select = document.getElementById("estados-tarea");
  let idTareaEstado = document.querySelector(".id-estado-tarea");
  let estado = idTareaEstado.getAttribute("id");
  //Setear tipo de tarea
  for (var i = 0; i < $select.length; i++) {
    let option = $select[i];
    if (estado == option.value) {
      option.setAttribute("selected", "true");
      //Si el estado es Lead se mostraran los campos origenLead y clasificacionLead
      if (option.value == 2) {
        document
          .getElementById("container-clasificacion-lead")
          .removeAttribute("hidden");
        document
          .getElementById("container-origen-lead")
          .removeAttribute("hidden");
      } else {
        document
          .getElementById("container-clasificacion-lead")
          .setAttribute("hidden", "true");
        document
          .getElementById("container-origen-lead")
          .setAttribute("hidden", "true");
      }
    }
  }
};
/* ============= EVENTOS DE TIPO DE CLIENTE Y BOTON PARA BUSCAR EL CLIENTE, EN CASO SEA EXISTENTE ================== */
// Si el tipo de cliente es existen se crea y muestra un boton para buscar el cliente
let rtnCliente = document.getElementById("cliente-existente");
rtnCliente.addEventListener("change", function () {
  if (document.querySelectorAll(".mensaje-existe-cliente").length > 0) {
    document.querySelector(".mensaje-existe-cliente").textContent = "";
    document
      .querySelector(".mensaje-existe-cliente")
      .classList.remove("mensaje-existe-cliente");
  }

  inputsEditarTarea.rtn.disabled = true;
  limpiarForm();
  let $containerRTN = document.getElementById("container-rtn-cliente");
  if (document.getElementById("btn-clientes") == null) {
    let $btnBuscar = document.createElement("div");
    $btnBuscar.classList.add("btn-buscar-cliente");
    $btnBuscar.innerHTML = `
    <button type="button" class="btn btn-primary" id="btn-clientes" data-bs-toggle="modal" data-bs-target="#modalClientes">
      Buscar <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
    </button>
    `;
    $containerRTN.appendChild($btnBuscar);
  }
});

//Cuando el cliente es nuevo se oculta el buscador de existir.
document
  .getElementById("cliente-nuevo")
  .addEventListener("change", function () {
    if (document.querySelectorAll(".mensaje-existe-cliente").length > 0) {
      document.querySelector(".mensaje-existe-cliente").textContent = "";
      document
        .querySelector(".mensaje-existe-cliente")
        .classList.remove("mensaje-existe-cliente");
    }
    let $containerRTN = document.getElementById("container-rtn-cliente");
    let $btnBuscarCliente = document.querySelector(".btn-buscar-cliente");
    //Volvemos a habilitar los inputs
    if (inputsEditarTarea.rtn.disabled == true) {
      inputsEditarTarea.rtn.disabled = false;
      inputsEditarTarea.nombre.disabled = false;
      inputsEditarTarea.telefono.disabled = false;
      inputsEditarTarea.direccion.disabled = false;
    }
    if ($btnBuscarCliente) {
      $containerRTN.removeChild($btnBuscarCliente);
      limpiarForm();
    }
    let correo = document.getElementById("container-correo");
    correo.removeAttribute("hidden");
  });
$(document).on("click", "#btn-clientes", function () {
  obtenerClientes();
});
let obtenerClientes = function () {
  if (document.getElementById("table-Cliente_wrapper") == null) {
    $("#table-Cliente").DataTable({
      ajax: {
        url: "../../../Vista/rendimiento/obtenerClientes.php",
        dataSrc: "",
      },
      language: {
        url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
      },
      columns: [
        { data: "codCliente" },
        { data: "nombre" },
        { data: "rtn" },
        { data: "telefono" },
        { data: "correo" },
        { data: "direccion" },
        {
          defaultContent:
            '<div><button class="btns btn" id="btn_select-cliente"><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>',
        },
      ],
    });
  }
};
document
  .getElementById("estados-tarea")
  .addEventListener("change", async () => {
    let $newEstado = document.getElementById("estados-tarea").value;
    if ($newEstado < parseInt($idEstadoTarea)) {
      document.getElementById("estados-tarea").value = $idEstadoTarea;
      Toast.fire({
        icon: "error",
        title: "No puedes volver a un estado anterior",
      });
    } else {
      cambiarEstado($newEstado, $idTarea);
      setTimeout(() => {
        location.href = "./v_editarTarea.php?idTarea=" + $idTarea;
      }, 100);
    }
  });

$rtn_Cliente.addEventListener("focusout", function () {
  let $mensaje = document.querySelector(".mensaje-rtn");
  $mensaje.innerText = "";
  $mensaje.classList.remove("mensaje-existe-cliente");
  if ($rtn_Cliente.value.trim() != "") {
    $.ajax({
      url: "../../../Vista/rendimiento/validarTipoCliente.php",
      type: "POST",
      datatype: "JSON",
      data: {
        rtnCliente: $rtn_Cliente.value,
      },
      success: function (cliente) {
        let $objCliente = JSON.parse(cliente);
        if ($objCliente.estado == "true") {
          $mensaje.innerText = "Cliente existente";
          $mensaje.classList.add("mensaje-existe-cliente");
        } else {
          $mensaje.innerText = "";
          $mensaje.classList.remove("mensaje-existe-cliente");
          if (
            $objCliente.nombre != undefined &&
            $objCliente.estado != "false"
          ) {
            setearDatosClienteCartera($objCliente);
          }
        }
      },
    }); //Fin AJAX
  }
});

let setearDatosClienteCartera = (cliente) => {
  let nombre = document.getElementById("nombre-cliente"),
    // rtn = document.getElementById("rnt-cliente"),
    telefono = document.getElementById("telefono-cliente"),
    correo = document.getElementById("correo-cliente"),
    direccion = document.getElementById("direccion-cliente");
  //Setear los datos
  nombre.value = cliente.nombre;
  telefono.value = cliente.telefono;
  correo.value = cliente.correo;
  direccion.value = cliente.direccion;
  //Desahabilitar los inputs
  nombre.disabled = true;
  // rtn.disabled = true;
  telefono.disabled = true;
  correo.disabled = true;
  direccion.disabled = true;
};

let limpiarForm = () => {
  let $mensaje = document.querySelector(".mensaje");
  $mensaje.innerText = "";
  $mensaje.classList.remove("mensaje-existe-cliente");
  let rtn = document.getElementById("rnt-cliente"),
    nombre = document.getElementById("nombre-cliente"),
    telefono = document.getElementById("telefono-cliente"),
    correo = document.getElementById("correo-cliente"),
    direccion = document.getElementById("direccion-cliente"),
    rubro = document.getElementById("rubrocomercial"),
    razon = document.getElementById("razonsocial"),
    clasificacion = document.getElementById("clasificacion-lead"),
    origen = document.getElementById("origen-lead");
  //Vaciar campos cliente
  rtn.value = "";
  nombre.value = "";
  telefono.value = "";
  correo.value = "";
  direccion.value = "";
  rubro.value = "";
  razon.value = "";
  clasificacion.value = "";
  origen.value = "";
  if (rtn.getAttribute("disabled")) {
    // rtn.removeAttribute('disabled');
    nombre.removeAttribute("disabled");
    telefono.removeAttribute("disabled");
    direccion.removeAttribute("disabled");
  }
};
let enviarProductosInteres = ($idTarea) => {
  let $idProductos = document.querySelectorAll(".id-producto");
  let $cantProducto = document.querySelectorAll(".cant-producto");
  let productos = [];
  $idProductos.forEach((id) => {
    $cantProducto.forEach((cant) => {
      if (id.value == cant.getAttribute("id")) {
        let objProducto = {
          id: id.value,
          cant: cant.value,
        };
        productos.push(objProducto);
      }
    });
  });
  //AJAX para almacenar los productos y su cantidad
  $.ajax({
    url: "../../../Vista/rendimiento/almacenarProductosTarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idTarea: $idTarea,
      productos: JSON.stringify(productos),
    },
    success: function (resp) {
      Swal.fire({
        position: "center",
        icon: "success",
        title: "La tarea " + $idTarea + " ha sido actualizada",
        showConfirmButton: false,
        allowOutsideClick: false,
        allowEscapeKey: false,
        timer: 2000,
        customClass: {
          title: "text-label-sweetAlert",
        },
      });
    },
  }); //Fin AJAX
};

let nuevoComentario = ($idTarea, $comentario) => {
  document.getElementById("input-comentario").value = "";
  //Enviamos el nuevo comentario a la base de datos
  $.ajax({
    url: "../../../Vista/rendimiento/nuevoComentario.php",
    type: "POST",
    datatype: "JSON",
    data: {
      id_Tarea: $idTarea,
      comentario: $comentario,
    },
  }); //Fin AJAX
};

let obtenerComentarios = ($idTarea) => {
  //Enviamos el nuevo comentario a la base de datos
  $.ajax({
    url: "../../../Vista/rendimiento/obtenerComentarios.php",
    type: "POST",
    datatype: "JSON",
    data: {
      id_Tarea: $idTarea,
    },
    success: function (comentarios) {
      let comments = "";
      let ObjComentarios = JSON.parse(comentarios);
      let conteinerComments = document.getElementById(
        "comments-container-list"
      );
      let $tabContainer = document
        .getElementById("tab-comment")
        .getAttribute("name");
      ObjComentarios.forEach((comentario) => {
        comments += `<div class="card-comment ${
          $tabContainer == comentario.creadoPor ? "align-right" : ""
        }">
        <section class="info-comment">
          <section class="creadoPor-comment">${comentario.creadoPor}</section>
          <section class="data-comment">${
            comentario.FechaCreacion.date.split(".")[0]
          }</section>
        </section>
          <section class="title-comment">${comentario.comentarioTarea}</section>
        </div>`;
        conteinerComments.innerHTML = comments;
      });
    },
  }); //Fin AJAX
};
let obtenerHistorialTarea = ($idTarea) => {
  $.ajax({
    url: "../../../Vista/rendimiento/obtenerBitacoraTarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      id_Tarea: $idTarea,
    },
    success: function (historial) {
      let historialTarea = "";
      let ObjHistorial = JSON.parse(historial);
      let conteinerHistory = document.getElementById("history-container");
      ObjHistorial.forEach((historial) => {
        historialTarea += `<div class="card-history">
          <section class="info-history">
            <section class="creadoPor-history">${
              historial.usuarioTarea
            }</section>
            <section class="data-history">${
              historial.fecha.date.split(".")[0]
            }</section>
          </section>
          <section class="text-history">${historial.descripcion}</section>
          ${
            historial.comentario != null
              ? `<section class="text-history comentario">${historial.comentario}</section>`
              : ""
          }
        </div>`;
        conteinerHistory.innerHTML = historialTarea;
      });
    },
  }); //Fin AJAX
};
let actualizarDatosTarea = ($datosTarea) => {
  $.ajax({
    url: "../../../Vista/rendimiento/validacionesEditarTarea.php",
    type: "POST",
    datatype: "JSON",
    data: $datosTarea,
  });
};

let obtenerDatosTarea = ($idTarea, $idEstadoTarea) => {
  $.ajax({
    url: "../../../Vista/rendimiento/validacionesEditarTarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idTarea: $idTarea,
      idEstado: $idEstadoTarea,
    },
    success: function ($datosTarea) {
      let datos = JSON.parse($datosTarea);
      Object.keys(datos).length > 1
        ? setearDatosTarea(datos)
        : (document.getElementsByName("estadoEdicion")[0].id = datos.data);
      !(Object.keys(datos).length > 1)
        ? document.getElementById("container-correo").removeAttribute("hidden")
        : "";
      document.getElementsByClassName("estadoEdicion").textContent == "false"
        ? document.getElementById("num-factura").removeAttribute("disabled")
        : "";
      !(Object.keys(datos).length > 0)
        ? document.getElementById("num-factura").removeAttribute("disabled")
        : "";
    },
  });
};
let setearDatosTarea = ($datosTarea) => {
  if ($datosTarea.productos != undefined) {
    setArticulosInteres($datosTarea.productos);
    document.getElementById("sin-productos-interes").hidden = true;
  }
  document.getElementById("num-factura").removeAttribute("disabled");
  let nuevo = document.getElementById("cliente-nuevo");
  let existe = document.getElementById("cliente-existente");
  let nombre = document.getElementById("nombre-cliente");
  let rtn = document.getElementById("rnt-cliente");
  let correo = document.getElementById("correo-cliente");
  let nFactura = document.getElementById("num-factura");
  let telefono = document.getElementById("telefono-cliente");
  let direccion = document.getElementById("direccion-cliente");
  document.getElementById("input-titulo-tarea").value = $datosTarea.titulo;
  rtn.value = $datosTarea.RTN_Cliente;
  rtn.disabled = true;
  nombre.value = $datosTarea.NOMBRECLIENTE;
  nFactura.value =
    $datosTarea.evidencia != null && $datosTarea.evidencia != ""
      ? $datosTarea.evidencia
      : "";
  numEvidencia =
    $datosTarea.evidencia != null && $datosTarea.evidencia != ""
      ? $datosTarea.evidencia
      : "";
  $datosTarea.evidencia != null && $datosTarea.evidencia != ""
    ? (existEvidencia = 1)
    : "";
  nombre.disabled = true;
  (document.getElementById("telefono-cliente").value = $datosTarea.TELEFONO),
    (correo.value = $datosTarea.correo);
  document.getElementById("direccion-cliente").value = $datosTarea.DIRECCION;
  if ($datosTarea.id_ClasificacionLead != null) {
    document.getElementById("clasificacion-lead").value =
      $datosTarea.id_ClasificacionLead;
    document.getElementById("origen-lead").value = $datosTarea.id_OrigenLead;
  }
  (document.getElementById("rubrocomercial").value =
    $datosTarea.id_rubro_Comercial),
    (document.getElementById("razonsocial").value =
      $datosTarea.id_razon_Social);
  if ($datosTarea.estado_Cliente_Tarea == "Existente") {
    nuevo.removeAttribute("checked");
    nuevo.disabled = true;
    existe.setAttribute("checked", "true");
    existe.disabled = true;
    telefono.disabled = true;
    correo.disabled = true;
    direccion.disabled = true;
    tipoCliente = $datosTarea.estado_Cliente_Tarea;
  } else {
    document.getElementById("container-correo").removeAttribute("hidden");
    existe.removeAttribute("checked");
    existe.disabled = true;
    nuevo.setAttribute("checked", "true");
    nuevo.disabled = true;
  }
};
let setArticulosInteres = (productos) => {
  //Recorremos todos los productos y los insertamos en la tabla
  productos.forEach((producto) => {
    let $tBody = document.getElementById("list-articulos");
    let $fila = document.createElement("tr");
    let id = $fila.appendChild(document.createElement("td"));
    let articulo = $fila.appendChild(document.createElement("td"));
    let marca = $fila.appendChild(document.createElement("td"));
    let cantidad = $fila.appendChild(document.createElement("td"));
    id.innerText = producto.id;
    articulo.innerText = producto.descripcion;
    marca.innerText = producto.marca;
    cantidad.innerText = producto.cantidad;
    $tBody.appendChild($fila);
  });
};

let validarCamposEnviar = (tipoCliente) => {
  let $datosTarea;
  if (document.getElementsByName("estadoEdicion")[0].id == "false") {
    if ($idEstadoTarea == "2") {
      $datosTarea = {
        idTarea: $idTarea,
        idEstado: $idEstadoTarea,
        tipoCliente: tipoCliente,
        titulo: document.getElementById("input-titulo-tarea").value,
        rtnCliente: document.getElementById("rnt-cliente").value,
        codCliente: $codCliente,
        nombre: document.getElementById("nombre-cliente").value,
        telefono: document.getElementById("telefono-cliente").value,
        correo: document.getElementById("correo-cliente").value,
        direccion: document.getElementById("direccion-cliente").value,
        clasificacionLead: document.getElementById("clasificacion-lead").value,
        origenLead: document.getElementById("origen-lead").value,
        rubrocomercial: document.getElementById("rubrocomercial").value,
        razonsocial: document.getElementById("razonsocial").value,
        nFactura: document.getElementById("num-factura").value,
        accion: existEvidencia,
      };
    } else {
      $datosTarea = {
        idTarea: $idTarea,
        idEstado: $idEstadoTarea,
        tipoCliente: tipoCliente,
        titulo: document.getElementById("input-titulo-tarea").value,
        rtnCliente: document.getElementById("rnt-cliente").value,
        codCliente: $codCliente,
        nombre: document.getElementById("nombre-cliente").value,
        telefono: document.getElementById("telefono-cliente").value,
        correo: document.getElementById("correo-cliente").value,
        direccion: document.getElementById("direccion-cliente").value,
        rubrocomercial: document.getElementById("rubrocomercial").value,
        razonsocial: document.getElementById("razonsocial").value,
        nFactura: document.getElementById("num-factura").value,
        accion: existEvidencia,
      };
    }
  } else {
    if ($idEstadoTarea == "2") {
      $datosTarea = {
        idTarea: $idTarea,
        idEstado: $idEstadoTarea,
        tipoCliente: tipoCliente,
        titulo: document.getElementById("input-titulo-tarea").value,
        rtnCliente: document.getElementById("rnt-cliente").value,
        codCliente: $codCliente,
        nombre: document.getElementById("nombre-cliente").value,
        telefono: document.getElementById("telefono-cliente").value,
        correo: document.getElementById("correo-cliente").value,
        direccion: document.getElementById("direccion-cliente").value,
        clasificacionLead: document.getElementById("clasificacion-lead").value,
        origenLead: document.getElementById("origen-lead").value,
        rubrocomercial: document.getElementById("rubrocomercial").value,
        razonsocial: document.getElementById("razonsocial").value,
        nFactura: document.getElementById("num-factura").value,
        accion: existEvidencia,
      };
    } else {
      $datosTarea = {
        idTarea: $idTarea,
        idEstado: $idEstadoTarea,
        tipoCliente: tipoCliente,
        titulo: document.getElementById("input-titulo-tarea").value,
        rtnCliente: document.getElementById("rnt-cliente").value,
        codCliente: $codCliente,
        nombre: document.getElementById("nombre-cliente").value,
        telefono: document.getElementById("telefono-cliente").value,
        correo: document.getElementById("correo-cliente").value,
        direccion: document.getElementById("direccion-cliente").value,
        rubrocomercial: document.getElementById("rubrocomercial").value,
        razonsocial: document.getElementById("razonsocial").value,
        nFactura: document.getElementById("num-factura").value,
        accion: existEvidencia,
      };
    }
  }
  return $datosTarea;
};

let cambiarEstado = ($newEstado, $idTarea) => {
  $.ajax({
    url: "../../../Vista/rendimiento/cambiarEstadoTarea.php",
    type: "POST",
    datatype: "JSON",
    data: {
      nuevoEstado: $newEstado,
      idTarea: $idTarea,
    },
  });
};
document.getElementById("num-factura").addEventListener("focusout", () => {
  let $inputNumFactura = document.getElementById("num-factura");
  if (
    $inputNumFactura.parentElement
      .querySelector("p")
      .classList.contains("mensaje-existe-cliente")
  ) {
    $inputNumFactura.parentElement.querySelector("p").innerText = "";
    $inputNumFactura.parentElement
      .querySelector("p")
      .classList.remove("mensaje-existe-cliente");
  }
  if (
    $inputNumFactura.value.trim() != "" &&
    $inputNumFactura.value != numEvidencia
  ) {
    validarEvidencia($inputNumFactura.value, $inputNumFactura);
  }
});

let validarEvidencia = ($evidencia, $elemento) => {
  $.ajax({
    url: "../../../Vista/rendimiento/validarEstadoEvidencia.php",
    type: "POST",
    datatype: "JSON",
    data: {
      idTarea: $idTarea,
      evidencia: $evidencia,
    },
    success: (res) => {
      let $estado = JSON.parse(res);
      let $mensaje = $elemento.parentElement.querySelector(".mensaje");
      if ($estado.estado == true) {
        $mensaje.innerText = `Existente en venta N° ${$estado.nTarea} => Vendedor ${$estado.vendedor}`;
        $mensaje.classList.add("mensaje-existe-cliente");
      } else {
        if ($estado.existeFacturaCliente == false) {
          $mensaje.innerText = `La factura no existe para este cliente`;
          $mensaje.classList.add("mensaje-existe-cliente");
        }
      }
    },
  });
};
document.getElementById("btn-finalizar-tarea").addEventListener("click", () => {
  if ($idTarea != null) {
    Swal.fire({
      title: "Estas seguro de finalizar la tarea # " + $idTarea + "?",
      text: "No podras revertir esto!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si, finalizalo!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../../../Vista/rendimiento/finalizarTarea.php",
          type: "POST",
          datatype: "JSON",
          data: {
            idTarea: $idTarea,
          },
          success: function (data) {
            console.log(JSON.parse(data));
            // if(JSON.parse(data) == true){
            //   Swal.fire(
            //     'Tarea Finalizada!',
            //     'La tarea ha sido finalizada.',
            //     'success'
            //   )
            //   document.getElementById('btn-finalizar-tarea').setAttribute('disabled', 'true');
            // } else{
            //   Swal.fire(
            //     'Lo sentimos!',
            //     'La tarea no ha sido finalizada.',
            //     'error'
            //   )
            // }
            if (!(JSON.parse(data) == true)) {
              Swal.fire(
                "Lo sentimos!",
                "La tarea no ha sido finalizada.",
                "error"
              );
              return;
            }
            Swal.fire(
              "Tarea Finalizada!",
              "La tarea ha sido finalizada.",
              "success"
            );
            document
              .getElementById("btn-finalizar-tarea")
              .setAttribute("disabled", "true");
          },
        }); //Fin del AJAX
      }
    });
  }
});
// let obtenerEstadoTarea = ($newEstado, $idTarea) => {
//   $.ajax({
//     url: '../../../Vista/rendimiento/cambiarEstadoTarea.php',
//     type: 'POST',
//     datatype: 'JSON',
//     data: {
//       nuevoEstado: $newEstado,
//       idTarea: $idTarea
//     }
//   });
// }
// let obtenerHistorialEstado = async ($idTarea) => {
//   let estadosTarea = null;
//   try {
//       estadosTarea = await $.ajax({
//       url: '../../../Vista/rendimiento/obtenerHistorialEstado.php',
//       type: 'POST',
//       datatype: 'JSON',
//       data: {idTarea: $idTarea}
//     });
//   } catch (error) {
//     console.error('Ha ocurrido un error: '+error);
//   }
//   return estadosTarea;
// }
