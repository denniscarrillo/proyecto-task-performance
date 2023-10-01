$(document).ready(function () {
    let btnsEditar = null;
    if(document.querySelectorAll('.btn-editar')) {
        btnsEditar = document.querySelectorAll('.btn-editar');
        console.log(btnsEditar);
    }
    let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
    obtenerPermisos($idObjetoSistema, btnsEditar);

    let $links = document.querySelectorAll('.check__conteiner');
    console.log($links);
    $links.forEach($link => {
        if($idObjetoSistema == $link.id){
            $link.classList.add('item-menu-active');
            // console.log($link.setAttribute('checked'));
            console.log($idObjetoSistema+" -- "+$link.id);
        }
        // console.log($idObjetoSistema+" -- "+$link.id);
    });

    //Probar para acceder a los botones de editar
    // console.log($("#sidebar-id").find('span').length);
    // for(let i = 0; i < $("#sidebar-id").find('span').length; i++){
    //     if($("#sidebar-id").find('span')[i].className == 'check__conteiner dropdown__link__span'){
    //         console.log($("#sidebar-id").find('span')[i]);
    //     }
    // }
   

   
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

