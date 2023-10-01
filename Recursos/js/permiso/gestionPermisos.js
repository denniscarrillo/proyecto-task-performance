$(document).ready(function () {
    let btnsEditar = null;
    if(document.querySelectorAll('.btn-editar')) {
        btnsEditar = document.querySelectorAll('.btn-editar');
        console.log(btnsEditar);
    }
    console.log(btnsEditar);
    let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
    obtenerPermisos($idObjetoSistema, btnsEditar);
});
let obtenerPermisos = function($idObjeto, btnsEditar){
    $.ajax({
        url: "../../../Vista/crud/permiso/obtenerPermisos.php",
        type: "POST",
        datatype: "JSON",
        data: {idObjeto: $idObjeto},
        success: function (data) {
            let objPermisos = JSON.parse(data);
            console.log(objPermisos);
            mostrarElementos(objPermisos, btnsEditar);
        }
    });
}
let mostrarElementos = function($objPermisos, btnsEditar){
    let $idObjetoSistema = document.querySelector('.title-dashboard-task').id
    if($objPermisos.Insertar == 'Y'){
        if($idObjetoSistema == "5"){
            let $btnsNuevaTarea = document.querySelectorAll('.btn_nuevoRegistro');
            $btnsNuevaTarea.forEach($btnNuevaTarea => {
                $btnNuevaTarea.classList.remove('hidden');
            });
        }else{
            document.getElementById('btn_nuevoRegistro').classList.remove('hidden');
        }
    }
    if($objPermisos.Actualizar == 'Y') {
        btnsEditar.forEach(btnEditar => {
            if($objPermisos.Actualizar == 'Y'){
                btnEditar.classList.remove('hidden');
            }
        });
    }
}

