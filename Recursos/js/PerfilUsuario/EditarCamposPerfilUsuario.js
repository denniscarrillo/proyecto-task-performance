let $formRespuestas = document.getElementById('form-Edit-Preguntas');


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
    console.log(enviarRespuestasActualizar);
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
        console.log(data);
       }
      
    })
 
}

// $CamposPerfil.addEventListener('submit', function(e){
//     e.preventDefault();
//     const $inputsRespuestas = document.querySelectorAll('.input-actualizacion')/*agregar una clase con el . usa selectores css*/ 
//     console.log($inputsRespuestas);
//     $inputsRespuestas(function(inputRespuesta){/*me muestra de uno a uno*/

//     let respuestaActualizar = {
//        idpregunta: inputRespuesta.getAttribute('id'),/*en js se habla de clave y valor despues de los dos puntos*/ 
//        respuesta: inputRespuesta.value,
//     }

//    })
//    enviarRespuestasActualizar(respuestasActualizar);
//    console.log($formRespuestas);

    
//   });
 
//   // Evento Submit que edita el Rubro Comercial
//   $btnAgregar.addEventListener("click", () => {
//     let $newProduct = {
//       descripcion: $addNewProduct.descripcion.value,
//       marca: $addNewProduct.marca.value,
//       precio: $addNewProduct.precio.value,
//     };
//     if (validoProd) {
//       $.ajax({
//         url: "../../../Vista/crud/PerfilUsuario/actualizarPerfilUsuario.php",
//         type: "POST",
//         datatype: "JSON",
//         data: {
//           nuevoProducto: $newProduct,
//         },
//         success: () => {
         
//         },
//       });
//     }
//   });