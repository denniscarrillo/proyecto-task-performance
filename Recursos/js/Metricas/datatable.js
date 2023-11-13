
import {estadoValidado as valido } from './validacionesModalEditarMetrica.js';

let tablaMetricas = '';
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
     
});


//Recibe la respuesta de la peticion AJAX y la procesa
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
  
  tablaMetricas = $('#table-Metricas').DataTable({

    "ajax": {
      "url": "../../../Vista/crud/Metricas/obtenerMetricas.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    
    "columns": [
      { "data": "idMetrica"},
      { "data": "descripcion"},
      { "data": "meta"},
      {
        "defaultContent":
        `<button class="btn-editar btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>`+
        `<button class="btn_eliminar btns btn ${(permisos.Eliminar == 'N')? 'hidden': ''}" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button>`
      }
    ],    
    "dom": "Bfrtilp",
    "initComplete": function () {
      // Configurar el botón de exportación después de que la tabla se haya inicializado
      this.api().buttons().container().appendTo($('#table-Metricas_wrapper .col-md-6:eq(0)'));
    },
    "buttons": [
      {
        "extend": "pdfHtml5",
        "text": '<i class="fas fa-file-pdf"></i>',
        "titleAttr": "Exportar a PDF",
        "className": "btn btn-danger",
        "download": "open",
        messageTop: 'Reporte de Métrica',
        "customize": function (doc) {
          var nombreEmpresa = empresaData.nombreP;
          var correoEmpresa = empresaData.correoP;
          var direccionEmpresa = empresaData.direccionP;
          var telefonoEmpresa = empresaData.telefonoP;
          var telefono2Empresa = empresaData.telefono2P;
          var fechaActual = empresaData.fechaActual;
          // const image = new Image();
          // image.src = '../../../Recursos/imagenes/LOGO-HD-transparente.jpg';
          // Asegúrate de que esta imagen se cargue correctamente en tu aplicación
          // const image = new Image();
          // image.src = '<?php echo $logoUrl; ?>';
          //var logoUrl = "../../../Recursos/imagenes/LOGO-HD-transparente.jpg";
          
          // Proporciona la ruta relativa de la imagen local
          var logoUrl = "http://localhost:3000/Recursos/imagenes/LOGO-HD-transparente.jpg";


              // Convertir la imagen en dataURL
          //toDataURL(logoUrl, function(dataURL) {
            // Agregar información dinámica al encabezado
            doc.header = function () {
              return {
                columns: [
                  {
                    //image: dataURL,
                    text: 'LOGO',
                    width: 50, // Ancho de la imagen
                    alignment: 'center'
                  },
                  
                  {
                    width: '*',
                    stack: [
                      { text: nombreEmpresa, style: 'header-bold', alignment: 'left'},
                      { text: 'Correo: '+ correoEmpresa, style: 'header', alignment: 'left' },      
                      { text: direccionEmpresa, style: 'header',  alignment: 'left' },
                      { text: 'Teléfono: ' + telefonoEmpresa +', '+telefono2Empresa, style: 'header', alignment: 'left' },
                    ]
                  },
                  {
                    width: '*',
                    stack: [
                      { text: fechaActual, style: 'header',alignment: 'right' }
                    ]
                  }
                ],
                margin: [40, 10],
                alignment: 'center'
              };
            };  

            // Pie de página con numeración
            doc.footer = function (currentPage, pageCount) {
              return {
                columns: [
                  { text: 'Página ' + currentPage.toString() + ' de ' + pageCount, style: 'footer', alignment: 'right' }
                ],
                margin: [40, 0],
                alignment: 'center'
              };
            };
            
            // Resto del código para personalizar el PDF...
            doc.pageMargins = [40, 60, 40, 60];
            doc.styles.header = {
              fontSize: 10,
              alignment: 'center',
            };
            doc.styles['header-bold'] = {
              bold: true
            };

            doc.styles.footer = {
              fontSize: 10,
              alignment: 'center'
            };
            doc.encoding = 'utf-8';  // Agrega esta línea
          //});
        },
        
      },
    ],  
  });
}

// Función para convertir la imagen en dataURL
function toDataURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result);
        };
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
    console.log('pdf hola Tania')
}


//Peticion  AJAX que trae los permisos
let obtenerPermisos = function ($idObjeto, callback) { 
  $.ajax({
      url: "../../../Vista/crud/permiso/obtenerPermisos.php",
      type: "POST",
      datatype: "JSON",
      data: {idObjeto: $idObjeto},
      success: callback
    });
}

$(document).on("click", "#btn_editar", function(){		        
  let fila = $(this).closest("tr"),	        
  idMetrica = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		
  metrica = fila.find('td:eq(1)').text(),
  meta = fila.find('td:eq(2)').text();
  $("#E_idMetrica").val(idMetrica);
  $("#E_descripcion").val(metrica);
  $("#E_meta").val(meta);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalEditarMetrica').modal('show');		   
});

$('#form-Edit-Metrica').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Cliente
   let idMetrica = $('#E_idMetrica').val(),
   meta =  $('#E_meta').val();
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/Metricas/editarMetrica.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idMetrica: idMetrica,
       meta: meta
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          'Actualizado!',
          'La metrica ha sido modificada!',
          'success',
        )
        tablaMetricas.ajax.reload(null, false);
      }
    });
    $('#modalEditarMetrica').modal('hide');
   }
});

//Limpiar modal de editar
document.getElementById('button-cerrar').addEventListener('click', ()=>{
  limpiarFormEdit();
})
document.getElementById('button-x').addEventListener('click', ()=>{
  limpiarFormEdit();
})
let limpiarFormEdit = () => {
  let $inputs = document.querySelectorAll('.mensaje_error');
  let $mensajes = document.querySelectorAll('.mensaje');
  $inputs.forEach($input => {
    $input.classList.remove('mensaje_error');
  });
  $mensajes.forEach($mensaje =>{
    $mensaje.innerText = '';
  });
}