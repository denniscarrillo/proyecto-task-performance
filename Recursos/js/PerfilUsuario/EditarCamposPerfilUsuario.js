
let $formRespuestas = document.getElementById('form-Edit-Preguntas');
let $CamposPerfil = document.getElementById('form-Edit-PerfilUsuario');

$formRespuestas.addEventListener('submit', function(e){
    e.preventDefault();
    let respuestasActualizar = [];
    const $inputsRespuestas = document.querySelectorAll('.input-respuesta')/*agregar una clase con el . usa selectores css*/ 
    $inputsRespuestas.forEach(function(inputRespuesta){/*me muestra de uno a uno*/

     let respuestaActualizar = {
        idpregunta: inputRespuesta.getAttribute('id'),/*en js se habla de clave y valor despues de los dos puntos*/ 
        respuesta: inputRespuesta.value,
     }
     respuestasActualizar.push(respuestaActualizar)/*push metodo de array*/

    })
    enviarRespuestasActualizar(respuestasActualizar);
    console.log($inputsRespuestas);
})

const enviarRespuestasActualizar = function(respuestasActualizar){
    $.ajax({/*cuando se agregan llaves se llaman objetos*/ 
       url: '../../../Vista/crud/PerfilUsuario/actualizarPreguntasUsuario.php',
       type: 'POST',
       datatype: 'JSON',
       data: {
        respuestas: respuestasActualizar
       },
       success: function(data){
        Swal.fire(
            "¡Actualizado!",
            "¡Se ha modificado tu respuesta!",
            "success"
          );
       }
    })
}
document.getElementById('btn-guardarActualizacion').addEventListener('click', function(e){
    e.preventDefault();
    enviarPerfil();
   
});

const enviarPerfil =function(){
    let  
    nombre = $("#E_nombre").val(),
    rtn = $("#E_rtn").val(),
    telefono = $("#E_telefono").val(),
    direccion = $("#E_direccion").val(),
    correo = $("#E_email").val();

    
    $.ajax({
        url: "../../../Vista/crud/PerfilUsuario/actualizarPerfilUsuario.php",
        type: "POST",
        datatype: "JSON",
        data: {
          nombre: nombre,
          rtn: rtn,
          telefono:telefono,
          direccion: direccion,
          email: correo
        },
        success: function (data) {
          //Mostrar mensaje de exito
          
          Swal.fire("¡Actualizado!", "¡El perfil del Usuario ha sido modificado!", "success");
          
        }
       
      });  
}
 
 

 
