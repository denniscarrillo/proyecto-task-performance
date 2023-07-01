  $(document).ready(function(){
    var tablaUsuarios = $('#table-Usuarios').DataTable({
      "ajax":{
        "url":"../../../Vista/crud/usuario/obtenerUsuarios.php",
        "dataSrc":""
      },
      "columns":[
        {"data":"usuario"},
        {"data":"nombreUsuario"},
        {"data":"contrasenia"},
        {"data":"correo"},
        {"data":"Estado"},
        {"data":"Rol"},
        {"defaultContent":
        '<div><button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>'+
        '<button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>'+
        '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'}
      ]
    });

    $('#form-usuario').submit(function(e){                         
      e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
      //Obtener datos del nuevo Usuario
      nombre = $.trim($('#nombre').val());    
      usuario = $.trim($('#usuario').val());
      password = $.trim($('#password').val());
      correo = $.trim($('#correo').val());  
      rol = $.trim($('#rol').option().val());    
      estado = $.trim($('#estado').option().val());    
     
      $.ajax({
        url: "../../../Vista/crud/usuario/nuevoUsuario.php",
        type: "POST",
        datatype:"JSON",    
        data: {
          nombre: nombre,
          usuario: usuario,
          contrasenia:password,
          correo:correo,
          idRol:rol,
          idEstado:estado
        },
        success: function(data) {
          tablaUsuarios.ajax.reload(null, false);
        }
      });			        
      $('#modalNuevoUsuario').modal('hide');											     			
    });

  });



  $('#btn_nuevoRegistro').click(function(){
    //Petición para obtener roles
    $.ajax({
      url: '../../../Vista/crud/usuario/obtenerRoles.php',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        let valores = '<option value="">Seleccionar...</option>';
        //Recorremos el arreglo de roles que nos devuelve la peticion
        for(i = 0; i < data.length; i++){
          valores += '<option value="'+data[i].id_Rol+'">'+data[i].rol+'</option>';
            $('#rol').html(valores);
        }
      }
    });
    //Petición para obtener estado de usuario
    $.ajax({
      url: '../../../Vista/crud/usuario/obtenerEstadosUsuario.php',
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        let valores = '<option value="">Seleccionar...</option>';
        //Recorremos el arreglo de roles que nos devuelve la peticion
        for(i = 0; i < data.length; i++){
          valores += '<option value="'+data[i].id_Estado_Usuario+'">'+data[i].descripcion+'</option>';
            $('#estado').html(valores);
        }
      }
    });
  });