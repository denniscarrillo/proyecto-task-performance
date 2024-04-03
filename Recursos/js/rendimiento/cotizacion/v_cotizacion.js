import * as funciones from "../../funcionesValidaciones.js";
import { estadoValidado as validoProd } from "./validacionesCotizacion.js";
import { estado } from "./validacionesCotizacion.js";

let $idTarea = document.querySelector(".encabezado").id;
const $tbody = document.getElementById("t-body");
const $btnAgregar = document.getElementById("btn-agregar-producto");
let $optionDescuento = document.getElementById("estado-desc");
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
$(document).ready(async () => {
  let cotTarea = document.getElementById("id-cot-tarea").textContent;
  if (parseInt(cotTarea) > 0) {
    vencimientoCotizacion(cotTarea);
  }
  let idCotizacion = await validarDatosCotizacion();
  alternarHiddenBotones();
  if (estadoCot == "Existente") {
    let nCotizacion = `<label>Cotización N°</label><label id="id-cotizacion">${idCotizacion}</label>`;
    document.querySelector(".title-dashboard-task").innerHTML = nCotizacion;
  }
});
let contItem = 0;
let itemProdDB = [];
let estadoCot = "Nueva";
let tableProductos = "";
let estadoCant = false;
let $addNewProduct = {
  descripcion: document.getElementById("descripcion"),
  marca: document.getElementById("marca"),
  cantidad: document.getElementById("cantidad"),
  precio: document.getElementById("precio"),
};
let $resumenCotizacion = {
  subtotal: document.getElementById("sub-total"),
  descuento: document.getElementById("descuento"),
  subdescuento: document.getElementById("sub-descuento"),
  impuesto: document.getElementById("impuesto"),
  total: document.getElementById("total"),
};
$(document).on("click", ".btn_article", function () {
  selectArticulos(this.children[0]);
});
let selectArticulos = function ($elementoHtml) {
  $elementoHtml.classList.toggle("select-articulo");
};
document.getElementById("btn_agregar").addEventListener("click", () => {
  let totalSuma = 0;
  document.querySelectorAll(".select-articulo").forEach((articulo) => {
    contItem += 1;
    let trProducto = articulo.parentElement.parentElement.parentElement;
    let productosCotizados = {
      codArticulo: trProducto.children[0].textContent,
      descripcion: trProducto.children[1].textContent,
      marca: trProducto.children[2].textContent,
      precio: trProducto.children[3].textContent,
      idPrecio: trProducto.id,
    };
    insertarNewProduct(contItem, productosCotizados, $tbody, 0, false);
  });
  let arrayTotales = [];
  document.querySelectorAll(".total-producto").forEach((element) => {
    arrayTotales.push(element.textContent.split(" ")[1]);
  });
  calcularResumenCotizacion(arrayTotales, totalSuma);
  document.querySelectorAll(".fa-circle-xmark-new").forEach((xmark) => {
    agregarEventoBorrar(xmark);
  });
  $("#modalProductosCotizados").modal("hide");
  document.getElementById("estado-desc").removeAttribute("disabled");
});

$(document).on("input", ".input-cant", function () {
  let totalSuma = 0;
  let $inputs = document.querySelectorAll(".input-cant");
  validarCantidad($inputs);
  let cant = parseInt(this.value);
  let precio = parseFloat(
    this.parentElement.nextSibling.textContent.split(" ")[1]
  );
  this.parentElement.nextSibling.nextSibling.textContent = `Lps. ${parseFloat((cant * precio).toFixed(2))}`;
  let arrayTotales = [];
  document.querySelectorAll(".total-producto").forEach((element) => {
    arrayTotales.push(element.textContent.split(" ")[1]);
  });
  calcularResumenCotizacion(arrayTotales, totalSuma);
});

$(document).on('input', '#valor-descuento', function(){
  let totalSuma = 0;
  const desc = $(this).val();
  if(parseInt(desc) < 1 || desc == "") {
    $(this).val(1);

  } else {
    let arrayTotales = [];
    document.querySelectorAll(".total-producto").forEach((element) => {
      arrayTotales.push(element.textContent.split(" ")[1]);
    });
    calcularResumenCotizacion(arrayTotales, totalSuma);
  }
})


let validarCantidad = function ($inputs) {
  let totalSuma = 0;
  estadoCant = true;
  $inputs.forEach($input => {
    if (parseInt($input.value) < 1 || $input.value == "") {
      $input.value = 1;
      let arrayTotales = [];
      document.querySelectorAll(".total-producto").forEach((element) => {
        arrayTotales.push(element.textContent.split(" ")[1]);
      });
      calcularResumenCotizacion(arrayTotales, totalSuma);
    } 
  });
};

document
  .getElementById("form-cotizacion")
  .addEventListener("submit", async (event) => {
    event.preventDefault();
    if (!estado) {
      event.preventDefault();
    } else {
      //Capturamos los datos de la cotizacion y producto a enviar
      let $datosCotizacion = {
        idTarea: document.querySelector(".encabezado").id,
        validez: document
          .getElementById("validez-cotizacion")
          .textContent.trim()
          .split(" ")[0],
        subTotal: document
          .getElementById("sub-total")
          .textContent.trim()
          .split(" ")[1],
        descuento: document
          .getElementById("descuento")
          .textContent.trim()
          .split(" ")[1],
        subDescuento: document
          .getElementById("sub-descuento")
          .textContent.trim()
          .split(" ")[1],
        isv: document
          .getElementById("impuesto")
          .textContent.trim()
          .split(" ")[1],
        total: document
          .getElementById("total")
          .textContent.trim()
          .split(" ")[1],
      };

      let $productosCot = document.querySelectorAll(".new-product");
      let $arrayProductosCot = [];
      $productosCot.forEach((producto) => {
        let $newProduct = {
          codArticulo: producto.getAttribute("class").split(" ")[1],
          item: producto.children[0].textContent,
          cantidad: producto.children[3].children[0].value,
          idPrecio: producto.children[4].id,
          total: producto.children[5].textContent.split(" ")[1],
        };
        $arrayProductosCot.push($newProduct);
      });

      //Llamamos a la funcion que envia la cotizacion al servidor y recibe estos parametros
      if (estado) {
        enviarNuevaCotizacion($datosCotizacion, $arrayProductosCot);
        $optionDescuento[0].selected = true;
        document.getElementById("estado-desc").setAttribute("disabled", "true");
        document.querySelector(".container-input-cant-desc").innerHTML = "";
        estadoCot = "Existente";
        alternarHiddenBotones();
        document.querySelectorAll(".new").forEach((elemento) => {
          elemento.classList.add("hidden");
        });
        $tbody.innerHTML = "";
        let idCotizacion = await validarDatosCotizacion();
        if (estadoCot == "Existente") {
          let nCotizacion = `<label>Cotización N°</label><label id="id-cotizacion">${idCotizacion}</label>`;
          document.querySelector(".title-dashboard-task").innerHTML =
            nCotizacion;
        }
        let btnCancel = document.getElementById("btn-salir-cotizacion");
        btnCancel.children[1].textContent = "Refrescar...";
        setTimeout(() => {
          location.href =
            "../../../../Vista/rendimiento/v_editarTarea.php?idTarea=" +
            $idTarea;
        }, 2200);
      }
    }
  });

let alternarHiddenBotones = () => {
  if (estadoCot == "Nueva") {
    document.querySelectorAll(".new").forEach((elemento) => {
      elemento.classList.remove("hidden");
    });
  } else {
    document.querySelectorAll(".exist").forEach((elemento) => {
      elemento.classList.remove("hidden");
    });
  }
};
// let recalcularTotales = () => {
//   const producto = document.querySelectorAll('.new-product');
//   const cantidad = producto.children[3]
//   const precio = producto.children[3]
//   console.log(cantidad)
// }

let calcularResumenCotizacion = (elementosSumar, acumTotalSuma) => {
  elementosSumar.forEach((total) => {
    let totalInt = parseFloat(total);
    acumTotalSuma = acumTotalSuma + totalInt;
  });
  $resumenCotizacion.subtotal.textContent = `Lps. ${acumTotalSuma.toFixed(2)}`;
  let desc = "";
  if (document.getElementById("valor-descuento") != null) {
    let $valDesc = parseInt(document.getElementById("valor-descuento").value);
    if (
      $optionDescuento.value == "Aplica" &&
      $valDesc > 0 &&
      !isNaN($valDesc)
    ) {
      $resumenCotizacion.descuento.textContent = `Lps. ${(
        acumTotalSuma *
        ($valDesc / 100)
      ).toFixed(2)}`;
    } else {
      desc = $resumenCotizacion.descuento.textContent = "Lps. 0.00";
    }
  } else {
    desc = $resumenCotizacion.descuento.textContent = "Lps. 0.00";
  }
  $resumenCotizacion.subdescuento.textContent = `Lps. ${(
    acumTotalSuma -
    parseFloat($resumenCotizacion.descuento.textContent.split(" ")[1])
  ).toFixed(2)}`;
  $resumenCotizacion.impuesto.textContent = `Lps. ${(
    parseFloat($resumenCotizacion.subdescuento.textContent.split(" ")[1]) * 0.15
  ).toFixed(2)}`;
  $resumenCotizacion.total.textContent = `Lps. ${(
    parseFloat($resumenCotizacion.subdescuento.textContent.split(" ")[1]) +
    parseFloat($resumenCotizacion.impuesto.textContent.split(" ")[1])
  ).toFixed(2)}`;
};

//nueva Cotizacion
let enviarNuevaCotizacion = ($datosCotizacion, $productosCotizacion) => {
  console.log($datosCotizacion);
  console.log($productosCotizacion);
  $.ajax({
    url: "../../../../Vista/rendimiento/cotizacion/nuevaCotizacion.php",
    type: "POST",
    datatype: "JSON",
    data: {
      datosCotizacion: $datosCotizacion,
      productos: $productosCotizacion,
    },
    success: function () {
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
      Toast.fire({
        icon: "success",
        title: "La cotización ha sido generada",
      });
    },
  });
};
let agregarEventoBorrar = ($deleteButton) => {
  let totalSuma = 0;
  if (!($deleteButton == null)) {
    $deleteButton.addEventListener("click", () => {
      $deleteButton.parentElement.parentElement.parentElement.remove();
      let arrayTotales = [];
      document.querySelectorAll(".total-producto").forEach((element) => {
        arrayTotales.push(element.textContent.split(" ")[1]);
      });
      calcularResumenCotizacion(arrayTotales, totalSuma);
      document.querySelectorAll(".item-num").forEach((item, index) => {
        contItem = index + 1;
        item.textContent = contItem;
      });
      if(document.querySelectorAll('.input-cant').length < 1) {
        let inputsCant = document.getElementById('estado-desc');
        inputsCant.disabled = true;
        $optionDescuento[0].selected = true;
        document.getElementById('t-body').innerHTML = `<tr id="row-temp">
          <td colspan="6" style="text-align: center;">Debe seleccionar artículos para su nueva cotización</td>
        </tr>`;
      }
    });
  }
};
let validarDatosCotizacion = async () => {
  const data = await obtenerDatosCotizacion(
    document.querySelector(".encabezado").id
  );
  if (!(data[0] == false)) {
    document.getElementById("estado-cot").textContent =
      data.detalle.estado_Cotizacion;
    estadoCot = "Existente";
    data.productos.forEach((product, index) => {
      contItem = index + 1;
      insertarNewProduct(contItem, product, $tbody, 1, true);
      itemProdDB.push(product.item);
    });

    $resumenCotizacion.subtotal.textContent = `Lps. ${data.detalle.subTotal}`;
    if (parseFloat(data.detalle.descuento) > 0) {
      document.getElementById("input-descuento").classList.remove("hidden");
      document.getElementById("input-sub-descuento").classList.remove("hidden");
    }
    $resumenCotizacion.descuento.textContent = `Lps. ${data.detalle.descuento}`;
    $resumenCotizacion.subdescuento.textContent = `Lps. ${data.detalle.subDescuento}`;
    $resumenCotizacion.impuesto.textContent = `Lps. ${data.detalle.isv}`;
    $resumenCotizacion.total.textContent = `Lps. ${data.detalle.total_Cotizacion}`;
    //Recaulcular el resumen de cotizacion
    let arrayTotales = [];
    let totalSuma = 0;
    document.querySelectorAll(".total-producto").forEach((element) => {
      arrayTotales.push(element.textContent.split(" ")[1]);
    });
    calcularResumenCotizacion(arrayTotales, totalSuma);
    return data.detalle.id_Cotizacion;
  }
};
$optionDescuento.addEventListener("click", () => {
  let $inputs = document.querySelectorAll(".input-cant");
  validarCantidad($inputs);
  if (estadoCant == false) {
    document.getElementById("estado-desc").setAttribute("disabled", "true");
  }
});
//Parte del descuento para que se aplique solo si se necesita
$optionDescuento.addEventListener("change", () => {
  let totalSuma = 0;
  let container = document.querySelector(".container-input-cant-desc");
  if ($optionDescuento.value == "Aplica") {
    container.innerHTML = `
        <input type="number" id="valor-descuento" min="1" value="1">
        <p class="mensaje"></p>`;
    document.getElementById("input-descuento").classList.remove("hidden");
    document.getElementById("input-sub-descuento").classList.remove("hidden");
    agregarEventoDescuento(totalSuma);
    let arrayTotales = [];
    document.querySelectorAll(".total-producto").forEach((element) => {
      arrayTotales.push(element.textContent.split(" ")[1]);
    });
    calcularResumenCotizacion(arrayTotales, totalSuma);

  } else {
    document.getElementById("input-descuento").classList.add("hidden");
    document.getElementById("input-sub-descuento").classList.add("hidden");
    container.innerHTML = "";
    let arrayTotales = [];
    document.querySelectorAll(".total-producto").forEach((element) => {
      arrayTotales.push(element.textContent.split(" ")[1]);
    });
    calcularResumenCotizacion(arrayTotales, totalSuma);
  }
});

let agregarEventoDescuento = (totalSuma) => {
  let arrayTotales = [];
  document.querySelectorAll(".total-producto").forEach((element) => {
    arrayTotales.push(element.textContent.split(" ")[1]);
  });
  //Activamos la actualizacion del calculo resumen cotizacion en el evento keyup
  document.getElementById("valor-descuento").addEventListener("keyup", () => {
    calcularResumenCotizacion(arrayTotales, totalSuma);
  });
  //Activamos la actualizacion del calculo resumen cotizacion en el evento keyup
  document.getElementById("valor-descuento").addEventListener("change", () => {
    calcularResumenCotizacion(arrayTotales, totalSuma);
  });
};

let obtenerDatosCotizacion = async ($idTarea) => {
  let dataCotizacion = "";
  try {
    dataCotizacion = await $.ajax({
      url: "../../../../Vista/rendimiento/cotizacion/obtenerDatosCotizacion.php",
      type: "POST",
      datatype: "JSON",
      data: {
        idTarea: $idTarea,
      },
    });
  } catch (error) {
    console.error(error);
  }
  return JSON.parse(dataCotizacion);
};

let insertarNewProduct = (contItem, $addProduct, $tbody, referencia, recalcularTotal) => {
  document.getElementById("row-temp") != null
    ? document.getElementById("row-temp").remove()
    : "";
  //Creamos la fila para agregar los datos del neuvo producto
  let $fila = document.createElement("tr");
  $fila.setAttribute("class", "new-product");
  $fila.classList.add($addProduct.codArticulo);
  estadoCot == "Existente" && referencia == 0
    ? $fila.classList.add("addNewProduct")
    : "";
  let item = $fila.appendChild(document.createElement("td"));
  /*------------------- Agregamos el div con los iconos y sus clases a la columna de items ------------------*/
  item.setAttribute("class", "icon-column");
  let divIcons = item.appendChild(document.createElement("div"));
  let label = item.appendChild(document.createElement("label"));
  label.setAttribute("class", "item-num");
  divIcons.setAttribute("class", "icon-container");

  /*---------------------------------------------------------------------------------------------------------*/
  let descripcion = $fila.appendChild(document.createElement("td"));
  let marca = $fila.appendChild(document.createElement("td"));
  let cantidad = $fila.appendChild(document.createElement("td"));
  let precio = $fila.appendChild(document.createElement("td"));
  precio.setAttribute("id", $addProduct.idPrecio);
  let total = $fila.appendChild(document.createElement("td"));
  total.setAttribute("class", "total-producto");
  total.appendChild(document.createTextNode("Lps. 0.00"));

  if (referencia == 0) {
    //Ahora agregamos los datos
    divIcons.innerHTML = `<i class="fa-regular fa-circle-xmark fa-circle-xmark-new icon"></i>`;
    label.append(document.createTextNode(contItem));
    cantidad.innerHTML = `<input type="number" class="input-cant" placeholder="Ingresar..." min="1" value="1">`;
    descripcion.textContent = $addProduct.descripcion;
    marca.textContent = $addProduct.marca;
    precio.appendChild(
      document.createTextNode(
        `Lps. ${parseFloat($addProduct.precio).toFixed(2)}`
      )
    );
    total.textContent = `Lps. ${1 * parseFloat($addProduct.precio)}`;
    $tbody.appendChild($fila);
  } else {
    divIcons.innerHTML = `<i class="fa-regular fa-circle-xmark fa-circle-xmark-DB icon" hidden></i>`;
    label.append(document.createTextNode($addProduct.item));
    descripcion.textContent = $addProduct.descripcion;
    marca.textContent = $addProduct.marca;
    cantidad.innerHTML = `<input type="number" class="input-cant new hidden" placeholder="Ingresar..." min="1" value=${$addProduct.cantidad}> 
        <label class="temp-label">${$addProduct.cantidad}</label>`;
    precio.textContent = `Lps. ${$addProduct.precio}`;
    total.textContent = `Lps. ${recalcularTotal == true ? parseInt($addProduct.cantidad) * parseFloat($addProduct.precio) : $addProduct.total}`;
    $tbody.appendChild($fila);
  }
  let $inputs = document.querySelectorAll(".input-cant");
  validarCantidad($inputs);
};

$("#btn-productos").click(() => {
  if (document.getElementById("table-productos_wrapper") == null) {
    tableProductos = $("#table-productos").DataTable({
      ajax: {
        url: "../../../../Vista/rendimiento/cotizacion/obtenerArticulos.php",
        dataSrc: "",
      },
      language: {
        url: "../../../Recursos/js/librerias/dataTableLanguage_es_ES.json",
      },
      fnCreatedRow: function(rowEl, data) {
        $(rowEl).attr('id', data['idPrecio']);
      },
      columns: [
        { data: "codigo" },
        { data: "articulo" },
        { data: "marcaArticulo" },
        { data: "precio" },
        { data: "existencias" },
        {
          defaultContent: `<button class="btns btn btn_article" ><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>`,
        },
      ],
    });
  } else {
    tableProductos.ajax.reload(null, false);
  }
});

document.getElementById("btn-nueva-cot").addEventListener("click", () => {
  let estado = document.getElementById("estado-cot").textContent;
  let mensaje = "Se anulará la cotización actual, no podrás revertir esto";
  let btnCancel = document.getElementById("btn-salir-cotizacion");
  if (estado == "ANULADA" || estado == "VENCIDA") {
    mensaje = "Ahora, podrás generar una nueva cotización";
  }
  Swal.fire({
    title: "¿Está seguro de continuar?",
    text: mensaje,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, continuar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      let totalSuma = 0;
      btnCancel.children[1].textContent = "Cancelar";
      btnCancel.addEventListener("click", (e) => {
        e.preventDefault();
        location.reload();
      });
      if (estado == "VIGENTE") {
        estado = await anularCotizacion(
          document.getElementById("id-cotizacion").textContent
        );
        estado = JSON.parse(estado);
      } else {
        estado = true;
      }
      document.querySelector(".title-dashboard-task").innerHTML =
        "Nueva Cotización";
      mostrarElementosNuevaCotizacion(estado);
      document.getElementById("input-descuento").classList.add("hidden");
      document.getElementById("input-sub-descuento").classList.add("hidden");
      let arrayTotales = [];
      document.querySelectorAll(".total-producto").forEach((element) => {
        arrayTotales.push(element.textContent.split(" ")[1]);
      });
      calcularResumenCotizacion(arrayTotales, totalSuma);
    }
  });
});

let anularCotizacion = async ($idCotizacion) => {
  let estado = "";
  try {
    estado = await $.ajax({
      url: "../../../../Vista/rendimiento/cotizacion/anularCotizacion.php",
      datatype: "JSON",
      type: "POST",
      data: {
        idCotizacion: $idCotizacion,
        idTarea: document.querySelector(".encabezado").id,
      },
    });
  } catch (error) {
    console.error(error);
  }
  return estado;
};
let vencimientoCotizacion = ($idCotizacion) => {
  $.ajax({
    url: "../../../../Vista/rendimiento/cotizacion/vencimientoCotizacion.php",
    datatype: "JSON",
    type: "POST",
    data: {
      idCotizacion: $idCotizacion,
    },
  });
};

let mostrarElementosNuevaCotizacion = (estado) => {
  estadoCot = "Nueva";
  if (estado) {
    document.querySelectorAll(".new").forEach((elemento) => {
      elemento.classList.remove("hidden");
    });
    document.querySelectorAll(".exist").forEach((elemento) => {
      elemento.classList.add("hidden");
    });
    document.getElementById("estado-desc").removeAttribute("disabled");
    document.querySelectorAll(".temp-label").forEach((label) => {
      label.remove();
    });
    document.querySelectorAll(".fa-circle-xmark").forEach((xmark) => {
      xmark.removeAttribute("hidden");
      agregarEventoBorrar(xmark);
    });
    //Para que el Toast de anulacion solo se muestre cuando la cotizacion sea Vigente
    if (document.getElementById("estado-cot").textContent == "VIGENTE") {
      //Mostramos el toast
      Toast.fire({
        icon: "success",
        title: "¡Cotización anulada!",
      });
    }
  } else {
    //Mostramos el toast
    Toast.fire({
      icon: "error",
      title: "No se ha podido anular la cotización",
    });
  }
};

$(document).on("click", "#btn_Pdf", function () {
  let idTarea = document.querySelector(".encabezado").id;
  let estadoCliente = document.querySelector(".datos-cotizacion").id;
  window.open(
    "../../../TCPDF/examples/reporteCotizacion.php?idTarea=" +
      idTarea +
      "&estadoCliente=" +
      estadoCliente,
    "_blank"
  );
});
