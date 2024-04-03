let tablaBitacora = "";
let $fechaDesde = document.getElementById('fecha-desde');
let $fechaHasta = document.getElementById('fecha-hasta');
const Toast = Swal.mixin({
  toast: true,
  position: "top",
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

$(document).ready(function () {
  setearRangoDeFechas();
  tablaBitacora = $("#table-Bitacora").DataTable({
    ajax: {
      url: "../../../Vista/crud/bitacora/obtenerBitacora.php",
      type: "post",
      data: function (data){
          data.fechaDesde = $fechaDesde.value.replace('T', ' '),
          data.fechaHasta = obtenerfechaHasta()
      },
      dataSrc: ""
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json",
      emptyTable: "No se encontron registros en el rango de fecha seleccionado"
    },
    scrollX: true,
    fnCreatedRow: function(rowEl, data) {
      $(rowEl).attr('id', data['id_Bitacora']);
    },
    columns: [
      { data: "item" },
      { data: "fecha.date",
        render: function (data) {
          return data.slice(0, 16);
        }
      },
      { data: "Usuario" },
      { data: "Objeto" },
      { data: "accion" },
      { data: "descripcion" },
    ],
  });

  $("#btn_ver").click(function () {
    let id_Bitacora = $(this).closest("tr").find("td:eq(0)").text();
    GenerarReporte(id_Bitacora);
  });

  let GenerarReporte = (id_Bitacora) => {
    $.ajax({
      url: "../../../Vista/fpdf/Reporte_rol.php",
      type: "POST",
      datatype: "JSON",
      data: {
        id_Bitacora: id_Bitacora,
      },
    }); //Fin AJAX
  };
  let filtro = document.querySelector('input[type=search]');
});

$(document).on("focusout", "input[type=search]", function (e) {
  let filtro = $(this).val();
  capturarFiltroDataTable(filtro);
});
const capturarFiltroDataTable = function(filtro){
  if(filtro.trim()){
    $.ajax({
      url: "../../../Vista/crud/bitacora/registrarBitacoraFiltroBitacora.php",
      type: "POST",
      data: {
        filtro: filtro
      }
    })
  }
}

$(document).on("click", "#btn_depurar", function () {
  Swal.fire({
    title: `¿Está seguro de eliminar los ${tablaBitacora.rows().count()} registros?`,
    text: "No podrá revertir esto",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "¡Si, eliminalo!",
    focusCancel: true,
    confirmButtonColor: "#f5971d",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../../Vista/crud/bitacora/depurarBitacora.php",
        type: "POST",
        datatype: "json",
        data: {
          fechaDesde: $fechaDesde.value.replace('T', ' '),
          fechaHasta: obtenerfechaHasta()
        },
        success: function (res) {
          if(res == 'true') {
            setearRangoDeFechas();
            tablaBitacora.ajax.reload();
            Toast.fire({
              icon: "success",
              title: "La bitácora fue depurada",
            });
          } else {
            Toast.fire({
              icon: "error",
              title: "No se pudo depurar la bitácora",
            });
          }
        },
      }); //Fin del AJAX
    }
  });
});

$(document).on("click", "#btn_Pdf", function () {
  let buscar = $("#table-Bitacora_filter > label > input[type=search]").val();
  let fechaDesde= $fechaDesde.value.replace('T', ' ');
  // let fechaHasta = $fechaHasta.value.replace('T', ' ');
  console.log(fechaDesde);
  window.open(
    "../../../TCPDF/examples/reporteriaBitacora.php?buscar=" + buscar + 
    "&fechaDesde=" + fechaDesde +
    "&fechaHasta=" + obtenerfechaHasta(), 
    "_blank"
  );
});

const obtenerfechaHasta = function(){
  let fechaActual = new Date($fechaHasta.value);
  return formatearFecha(fechaActual,1);
}

$fechaHasta.addEventListener('input', () => {
  if(!compararFechas()){
    tablaBitacora.ajax.reload();
  }else{
    Toast.fire({
      icon: "error",
      title: "Rango de fecha inválido",
    });
  }
});
$fechaDesde.addEventListener('input', () => {
  if(!compararFechas()){
    tablaBitacora.ajax.reload();
  }else{
    Toast.fire({
      icon: "error",
      title: "Rango de fecha inválido",
    });
  }
});

const setearRangoDeFechas = () => {
  const ahora = new Date(); //Obtenemos la fecha del dia actual(hoy)
  let diasDesde = 1000 * 60 * 60 * 24 * 7; // Convertimos a milisegundos los dias que deseamos restar a una fecha
  /**
   * getTime() nos devuelve la fecha del dia actual(hoy) en milisegundos 
   * y a esta le restamos los dias deseados(también convertidos en milisegundos)
   */
  let desde = (ahora.getTime()) - diasDesde; //Realizamos la resta y obtenemos la nueva fecha en milisegundos
  //Convertimos a un objeto de tipo fecha(Date), la fecha(en milisegundos) obtenida anteriormente 
  const fechaDesde = formatearFecha(new Date(desde),0)  //Esta funcion nos formatea la fecha Desde y nos la retorna como tipo String
  const fechaHasta = formatearFecha(ahora,0)  //Esta funcion nos formatea la fecha Hasta y nos la retorna como tipo String
  //Ahora seteamos ambas fechas en los inputs segun correspondan
  $fechaDesde.value = fechaDesde;
  $fechaHasta.value = fechaHasta;
  // console.log($fechaDesde.value);
  // console.log($fechaHasta.value);
}

const compararFechas = () => {
  const fechaDesde = new Date($fechaDesde.value);
  const fechaHasta = new Date($fechaHasta.value);
  return (fechaDesde.getTime() > fechaHasta.getTime())? true : false;
}

const formatearFecha = (date, origen) => {
  const year = (date.getFullYear() < 10) ? `0${date.getFullYear()}`: date.getFullYear();
  const month = ((date.getMonth()+1) < 10) ? `0${date.getMonth()+1}`: date.getMonth()+1;
  const day = (date.getDate() < 10) ? `0${date.getDate()}` : date.getDate();
  const hour = (date.getHours() < 10) ? `0${date.getHours()}` : date.getHours();
  let min = null;
  if(origen == 1){
    min = (date.getMinutes() < 10) ? `0${date.getMinutes()+1}`: (date.getMinutes() == 59)?date.getMinutes():date.getMinutes()+1;
  }else{
    min = (date.getMinutes() < 10) ? `0${date.getMinutes()}`: date.getMinutes();
  }
  
  return `${year}-${month}-${day} ${hour}:${min}`
}
