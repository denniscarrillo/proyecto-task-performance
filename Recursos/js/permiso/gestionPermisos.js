$(document).on('load', function(){
    console.log(document.getElementById('btn_ver'));
})
$(document).ready(function () {
    let btnsEditar = null;
    if(document.querySelectorAll('.btn-editar')) {
        btnsEditar = document.querySelectorAll('.btn-editar');
        console.log(btnsEditar);
    }
    let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
    obtenerPermisos($idObjetoSistema, btnsEditar);
    //Seleccionamos los span del menu
    let $links = document.querySelectorAll('.check__conteiner');
    //Ahora recorremos y vamos buscamos donded hay coincidencia entre la vista actual y alguna opcion del sidebar
    $links.forEach($link => {
        if($idObjetoSistema == $link.id){
            //Donde coincidan, entonces le añadimos la clase 'item-menu-active' que aplica estilos para marcar en que parte del sidebar estamos situados
            $link.classList.add('item-menu-active');
        }
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

