// const tableUser = document.getElementById('table');
  // let table = new DataTable('#table');

  $(document).ready(function(){
    $('#table-Usuarios').DataTable({
      "ajax":{
        "url":"../../Vista/crud/obtenerUsuarios.php",
        "dataSrc":""
      },
      "columns":[
        {"data":"usuario"},
        {"data":"nombreUsuario"},
        {"data":"contrasenia"},
        {"data":"correo"},
        {"data":"Estado"},
        {"data":"Rol"}
      ]
    });
  });