let user = document.getElementById('username').textContent;
$(document).ready(function () {
    let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
    //Invocamos a la funcion que trae y valida el permiso Insertar
    if(user != 'SUPERADMIN'){
        obtenerPermisos($idObjetoSistema, manejarPermisoInsertar);
        return;
    }
    if((user == 'SUPERADMIN')){
        document.getElementById('btn_Pdf').classList.remove('hidden');
    }
    let $btnsNuevaTarea = document.querySelectorAll('.btn_nuevoRegistro');
    $btnsNuevaTarea.forEach($btnNuevaTarea => {
        $btnNuevaTarea.classList.remove('hidden');
    });
});
let manejarPermisoInsertar = (permisos) => {
    let objPermisos = JSON.parse(permisos);
    //Valida los permisos de Insertar
    if((objPermisos.Insertar == 'Y')){
        let $objTarea = document.querySelector('.title-dashboard-task').getAttribute('name');
        if($objTarea == 'v_tarea.php'){ //Para cuando sea la vista de kanban tareas
            let $btnsNuevaTarea = document.querySelectorAll('.btn_nuevoRegistro');
            $btnsNuevaTarea.forEach($btnNuevaTarea => {
                $btnNuevaTarea.classList.remove('hidden');
            });
        }else{
            (document.getElementById('btn_nuevoRegistro') != null) ?  document.getElementById('btn_nuevoRegistro').classList.remove('hidden') : '';
        }
    }
    if((objPermisos.Reporte == 'Y')){
        document.getElementById('btn_Pdf').classList.remove('hidden');
    }
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