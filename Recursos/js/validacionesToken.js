//Creamos el toast que nos confirma la actualización de los permisos
if(document.querySelector('.tokenSend').id == 1){
    document.querySelector('.tokenSend').id = 0;
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
    Toast.fire({
        icon: 'success',
        title: 'Se ha enviado un token a su correo'
    });
}
