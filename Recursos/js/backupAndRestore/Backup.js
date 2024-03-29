const $btnBackup = document.getElementById('btn-backup');
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
    console.log('se llamo')
    generarBackup();
});

let generarBackup = function (){
    $.ajax({
        url: '../../../Vista/crud/backupAndRestore/generarBackup.php',
        type: 'POST',
        success: function (res) {
            console.log(res)
            Toast.fire({
                icon: "success",
                title: "Se hizo el backup correctamente",
            });

        }
    })
}