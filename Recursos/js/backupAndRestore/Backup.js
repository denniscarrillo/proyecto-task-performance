const $btnBackup = document.getElementById('btn-backup');
const $btnRestore = document.getElementById('btn-restore');
const Toast = Swal.mixin({
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

$btnBackup.addEventListener('click', () => {
    generarBackup();
    obtenerHistorialBackup();
});

$(document).ready(function(){
    obtenerHistorialBackup();
})

$btnRestore.addEventListener('click', () => { 
    const url = $('#historial-backups').val();
    Swal.fire({
        title: `¿Estás seguro de restaurar el backup "${(url).substring(9)}"?`,
        text: "Se cerrará la sesión y se iniciará la restauración",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Si, Continuar!",
      }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("form-historial-backups").submit();
        }
    });
});

let generarBackup = function (){
    $.ajax({
        url: '../../../Vista/crud/backupAndRestore/generarBackup.php',
        type: 'POST',
        success: function (res) {
            const estado = Boolean(res);
            if(estado) {
                Toast.fire({
                    icon: "success",
                    title: "Se hizo el backup correctamente",
                });
            } else {
                Toast.fire({
                    icon: "error",
                    title: "No se logró realizar el backup",
                });
            }
        }
    })
}

let obtenerHistorialBackups = function (){
    $.ajax({
        url: '../../../Vista/crud/backupAndRestore/generarBackup.php',
        type: 'POST',
        success: function (res) {
            const estado = Boolean(res);
            if(estado) {
                Toast.fire({
                    icon: "success",
                    title: "Se hizo el backup correctamente",
                });
            } else {
                Toast.fire({
                    icon: "error",
                    title: "No se logró realizar el backup",
                });
            }
        }
    })
}

let obtenerHistorialBackup = function () {
    //Petición para obtener estado de usuario
    $.ajax({
      url: "../../../Vista/crud/backupAndRestore/obtenerUrlBackups.php",
      type: "GET",
      dataType: "JSON",
      success: function (urls) {
        if(urls.length > 0){
            let valores = '';
            urls.forEach(url => {
                const urlVista = (url.url).substring(9);
                valores += `<option value="${url.url}">${urlVista}</option>`;
            });
            $('#historial-backups').html(valores);
        }
      },
    });
  };

  let restaurarBackup = function (url){
    $.ajax({
        url: '../../../Vista/crud/backupAndRestore/generarRestore.php',
        type: 'POST',
        dataType: 'JSON',
        data: {
            urlBackup: url
        }
    })
}