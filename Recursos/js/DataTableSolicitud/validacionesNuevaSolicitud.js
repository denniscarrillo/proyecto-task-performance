import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus

const validaciones = {
   // Mismo Caracter: Valida la repetición de cualquier par de caracteres
   MismoCaracter: /^(?=.*(..)\1)/,
    // Correo electrónico: Valida un formato básico de dirección de correo electrónico
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    // Solo números: Permite solo dígitos numéricos, comas y guiones
    soloNumeros: /^[0-9,-]*$/,
     // Solo letras: Permite solo letras (mayúsculas y minúsculas) y algunos caracteres especiales
     soloLetras: /^[a-zA-Z\/ .ÑñáéíóúÁÉÍÓÚs]+$/,
};

//VARIABLES GLOBALES


let estadoEspacioInput = {
    estadoEspacioName: true,
    estadoEspaciotelefono: true,
    estadoEspaciodescripcion: true,
    estadoEspacioDireccion: true,
    estadoEspacioRtn: true,
    estadoEspacioCorreo: true,
    estadoEspacioCorreoCliente: true,
    estadoEspaciofechaSolicitud: true,
    estadoEspaciotipoServicio: true,
}
let estadoLetrasRepetidas = {
    estadoLetrasRepetidasDescripcion: true,
    estadoLetrasRepetidasname: true,
    estadoLetrasRepetidasDireccion: true
}
 
let estadoSelect = {
    estadoSelectCorreoCliente: true,
    estadoSelecttelefono: true,
    estadoSelectDireccion: true,
    estadoSelectDescripcion: true,
    estadoSelectName: true,
    estadoSelectRtn:true,
    estadoSelectCantProducto:true,
    estadoSelecttipoServicio:true,
}

let estadoMasdeUnEspacio = {
        estadoMasEspacioCorreoCliente:true,
        estadoMasEspacioDireccion:true,
        estadoMasEspacioDescripcion:true,
        estadoMasEspaciotelefono:true,
        estadoMasEspacioRtn:true,
        estadoMasEspacioName:true,
        estadoMasEspaciofechaSolicitud:true,
        estadoMasEspaciotipoServicio:true,

}

let estadoSoloLetras = {
   
    estadoLetrasName:true,
}
let estadoSoloNumeros = {

    estadoNumerotelefono :true,
    estadoNumeroRTN :true,
}

let estadoExisteRtn = false;
let estadoCorreo = true;

const $form = document.getElementById('form-solicitud');
const $name = document.getElementById('nombre');
const $rtn = document.getElementById('rtnCliente');
const $correo = document.getElementById('correo');
const $correoCliente = document.getElementById('correoCliente');
const $telefono = document.getElementById('telefono');
const $direccion= document.getElementById('direccion');
const $descripcion = document.getElementById('descripcion');
const $fechaSolicitud = document.getElementById('fechaSolicitud');
const $tipoServicio = document.getElementById('tiposervicio');




/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO name ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    //Validamos que algún campo no esté vacío.
    let estadoInputName = funciones.validarCampoVacio($name);
    let estadoInputtelefono = funciones.validarCampoVacio($telefono);
    let estadoInputDireccion = funciones.validarCampoVacio($direccion);
    let estadoInputdescripcion = funciones.validarCampoVacio($descripcion);
    let estadoInputRtn = funciones.validarCampoVacio($rtn);
    let estadoInputTipoServicio= funciones.validarCampoVacio($tipoServicio);
    
    if (estadoInputName == false ||  estadoInputRtn == false || estadoInputTipoServicio == false ||estadoInputdescripcion == false || estadoInputtelefono  == false ||   estadoInputDireccion == false) {
        e.preventDefault();
    }else{
        if(estadoEspacioInput.estadoEspacioName == false || estadoEspacioInput.estadoEspaciodescripcion  == false || estadoEspacioInput.estadoEspaciotelefono  == false ||  estadoEspacioInput.estadoEspacioCorreoCliente == false || estadoEspacioInput.estadoEspacioDireccion == false){ 
            e.preventDefault();
            estadoEspacioInput.estadoEspacioName = funciones.validarEspacios($name);  
            estadoEspacioInput.estadoEspaciotelefono= funciones.validarEspacios($telefono);  
            estadoEspacioInput.estadoEspacioDireccion = funciones.validarEspacios($direccion);  
            estadoEspacioInput.estadoEspacioCorreoCliente = funciones.validarEspacios($correoCliente); 
            estadoEspacioInput.estadoEspaciodescripcion = funciones.validarEspacios($descripcion); 
         
              
        }
        estadoMasdeUnEspacio.estadoMasEspacioName= funciones.validarMasdeUnEspacio($name);
        estadoMasdeUnEspacio.estadoMasEspacioDescripcion= funciones.validarMasdeUnEspacio($descripcion);
        estadoMasdeUnEspacio.estadoMasEspaciotelefono= funciones.validarMasdeUnEspacio($telefono);
        estadoMasdeUnEspacio.estadoMasEspacioDireccion= funciones.validarMasdeUnEspacio($direccion);
        estadoMasdeUnEspacio.estadoMasEspacioCorreoCliente = funciones.validarMasdeUnEspacio($correoCliente);
       
        if(estadoMasdeUnEspacio.estadoMasEspacioName == false ||  estadoMasdeUnEspacio.estadoMasEspacioDescripcion == false ||  estadoMasdeUnEspacio.estadoMasEspaciotelefono == false || estadoMasdeUnEspacio.estadoMasEspacioDireccion== false || estadoMasdeUnEspacio.estadoMasEspacioCorreoCliente == false){
            e.preventDefault();
            console.log(estadoMasdeUnEspacio.estadoMasEspacioDireccion);
            console.log(estadoMasdeUnEspacio.estadoMasEspacioName);
        }else{
          if(estadoLetrasRepetidas.estadoLetrasRepetidasname == false ||estadoLetrasRepetidas.estadoLetrasRepetidasDescripcion == false ||
                        estadoLetrasRepetidas.estadoLetrasRepetidasDireccion == false){
                        e.preventDefault();
                        estadoLetrasRepetidas.estadoLetrasRepetidasname= funciones.limiteMismoCaracter($name, validaciones.MismoCaracter);
                        estadoLetrasRepetidas.estadoLetrasRepetidasDescripcion = funciones.limiteMismoCaracter($descripcion, validaciones.MismoCaracter);
                        estadoLetrasRepetidas.estadoLetrasRepetidasDireccion = funciones.limiteMismoCaracter($direccion, validaciones.MismoCaracter);
            }else{
                if(estadoSoloLetras.estadoLetrasName == false){
                    e.preventDefault();
                    estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
                    console.log(estadoSoloLetras.estadoLetrasName); 
     
                }
    
        if(estadoSoloNumeros.estadoNumerotelefono == false|| estadoSoloNumeros.estadoNumeroRTN== false ){
            e.preventDefault();
            estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
            estadoSoloNumeros.estadoNumeroRTN = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
        }else{
            if(estadoCorreo == false || estadoSelect == false ){
                e.preventDefault();   
                estadoSelect = funciones.validarCampoVacio($name);
                estadoSelect = funciones.validarCampoVacio($direccion);
                estadoSelect = funciones.validarCampoVacio($tipoServicio);
                estadoSelect = funciones.validarCampoVacio($telefono);
                estadoSelect = funciones.validarCampoVacio($descripcion);
                estadoSelect = funciones.validarCampoVacio($rtn);
              //  estadoSelect = funciones.validarCampoVacio($correoCliente);
                estadoCorreo = funciones.validarCorreo($correoCliente, validaciones.correo);
        
                                      
                }else{
                        estadoValidado = true;
                           
               
                    
                      
                }    
           
         } }
                  
            
        }
    }
});


$name.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    if(estadoSoloLetras.estadoLetrasName){
    estadoLetrasRepetidas.estadoLetrasRepetidasname = funciones.limiteMismoCaracter($name, validaciones.MismoCaracter);
    }
    funciones.limitarCantidadCaracteres("nombre", 50 );
});


 $direccion.addEventListener('keyup', ()=>{
    estadoLetrasRepetidas.estadoLetrasRepetidasDireccion = funciones.limiteMismoCaracter($direccion, validaciones.MismoCaracter);
    estadoSoloLetras.estadoLetrasdireccion = funciones.validarSoloLetras($direccion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("direccion", 100);

 });
 $descripcion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasdescripcion = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("descripcion", 500);
 });

 $correoCliente.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correoCliente, validaciones.correo);
});

 $name.addEventListener('focusout', ()=>{
    
    if(estadoMasdeUnEspacio.estadoMasEspacioName){
         funciones.validarMasdeUnEspacio($name);
    }
    let nameMayus = $name.value.toUpperCase();
    $name.value = nameMayus;

 });
 $telefono.addEventListener('focusout', ()=>{
     if(estadoMasdeUnEspacio.estadoMasEspaciotelefono){
         funciones.validarMasdeUnEspacio($telefono);
     }  
 });
 $correoCliente.addEventListener('focusout', ()=>{
     if(estadoMasdeUnEspacio.estadoMasEspacioCorreoCliente){
         funciones.validarMasdeUnEspacio($correoCliente);
    }  
 });
 $direccion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioDireccion){
        funciones.validarMasdeUnEspacio($direccion);
     }
     let direccionMayus = $direccion.value.toUpperCase();
     $direccion.value = direccionMayus; 
 });
$descripcion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioDescripcion){
        funciones.validarMasdeUnEspacio($descripcion);
     }
     let descripcionMayus = $descripcion.value.toUpperCase();
     $descripcion.value = descripcionMayus;  
 });
 $name.addEventListener('change', ()=>{
     estadoSelect.estadoSelectName = funciones.validarCampoVacio($name);
 });
 $telefono.addEventListener('change', ()=>{
     estadoSelect.estadoSelecttelefono = funciones.validarCampoVacio($telefono);
 });
 $direccion.addEventListener('change', ()=>{
     estadoSelect.estadoSelectDireccion = funciones.validarCampoVacio($direccion);
 });

 $descripcion.addEventListener('change', ()=>{
    estadoSelect.estadoSelectDescripcion= funciones.validarCampoVacio($descripcion);
 });

 $rtn.addEventListener('change', ()=>{
    estadoSelect.estadoSelectRtn= funciones.validarCampoVacio($rtn);
 });

 $telefono.addEventListener('keyup', ()=>{
     estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
    funciones.limitarCantidadCaracteres("telefono", 14);
  });



  $('input[id="clientenuevo"]').on('change', function() {
    if ($(this).is(':checked')) {
        $('#rtnCliente').on('focusout', () => {
            let $rtn = $('#rtnCliente').val();
            obtenerValidarRtnExiste($rtn);
            
        });
    } else {
        $('#rtnCliente').off('focusout'); // Remover el evento focusout si el radio no está seleccionado
        $('#mensaje').text('');
    }
});

$('input[id="clienteExistente"]').on('change', function() {
    if ($(this).is(':checked')) {
        document.getElementById('rtnCliente').classList.remove('mensaje_error');
        document.getElementById('rtnCliente').parentElement.querySelector('p').innerText = '';
    } 
});

  
let obtenerValidarRtnExiste = (rtn) => {
    $.ajax({
        url: "../../../Vista/crud/DataTableSolicitud/ExisteRTN.php",
        type: "POST",
        datatype: "JSON",
        data: {
            rtnCliente: rtn
        },
        success: function (data) {
            let $data = JSON.parse(data);
            if ($data.estado === 'true') {
                document.getElementById('rtnCliente').classList.add('mensaje_error');
                document.getElementById('rtnCliente').parentElement.querySelector('p').innerText = $data.mensaje;
            } else {
                document.getElementById('rtnCliente').classList.remove('mensaje_error');
                document.getElementById('rtnCliente').parentElement.querySelector('p').innerText = '';
            }
        }
    });
};



// let obtenerValidarRtnExiste = (rtn) => {
//   // Puedes dejar que la función maneje el caso de rtn null sin necesidad de verificarlo aquí.
//   $.ajax({
//       url: "../../../Vista/crud/DataTableSolicitud/ExisteRTN.php",
//       type: "POST",
//       datatype: "JSON",
//       data: {
//           rtnCliente:rtn
//       },
//       success: function (rtn) {
//           let $objRtn = JSON.parse(rtn);

//           if ($objRtn.estado == 'true') {
//               document.getElementById('rtnCliente').classList.add('mensaje_error');
//               document.getElementById('rtnCliente').parentElement.querySelector('p').innerText = '*Este rtn ya existe, en Cartera Clientes';
//               estadoExisteRtn = false; // Rtn es existente, es false
//           } else {
//               document.getElementById('rtnCliente').classList.remove('mensaje_error');
//               document.getElementById('rtnCliente').parentElement.querySelector('p').innerText = '';
//               estadoExisteRtn = true; // Rtn no existe, es true
//           }
//       }
//   });
// };



// $rtn.addEventListener('focusout', () => {
//   let rtnValue = $('#rtnCliente').val();
//   estadoExisteRtn = obtenerValidarRtnExiste(rtnValue);
//   console.log(rtnValue);
// });






