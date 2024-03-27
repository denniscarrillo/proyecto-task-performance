import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus



const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s,])/,//Lentras, acentos y Ñ //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};


let inputsNuvoRubroC = {
    rubroC: document.getElementById('rubroComercial'),
    descripcion: document.getElementById('descripcion')
}


$(document).ready(function (){
    //Evento clic para hacer todas las validaciones
  document.getElementById("btnsubmit").addEventListener("click", () => {
    ValidarInputRubroC();
    ValidarInputDescrip();
   
    console.log(document.querySelectorAll(".mensaje_error").length)
    console.log(document.querySelectorAll(".mensaje-existe-razonsocial").length)
    if (
        document.querySelectorAll(".mensaje_error").length == 0 &&
      document.querySelectorAll(".mensaje-existe-razonsocial").length == 0
    ){
        estadoValidado = true;
    }else{
        estadoValidado = false;   
    }
  });
})

inputsNuvoRubroC.rubroC.addEventListener('keyup', async()=>{
  
    funciones.limitarCantidadCaracteres('rubroComercial', 50);
});
inputsNuvoRubroC.descripcion.addEventListener('keyup', ()=>{
 
    funciones.limitarCantidadCaracteres('descripcion', 300);
});
//Validar inputs
let ValidarInputRubroC =  function ()  {
    let rubroMayus = inputsNuvoRubroC.rubroC.value.toUpperCase();
    inputsNuvoRubroC.rubroC.value = rubroMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false,
        //estadoRubroComercialExiste: false

    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuvoRubroC.rubroC);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputsNuvoRubroC.rubroC, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuvoRubroC.rubroC);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuvoRubroC.rubroC, validaciones.caracterMas3veces);
    }
   /*  if(estadoValidaciones.estadoNoCaracteresSeguidos){
       // await obtenerRubroComercialExiste($('#rubroComercial').val());
    } */

    0
    
}

let ValidarInputDescrip = function () {
    let descripcionMayus = inputsNuvoRubroC.descripcion.value.toUpperCase();
    inputsNuvoRubroC.descripcion.value = descripcionMayus;
    
    let descripcionValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
      
    }

    descripcionValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputsNuvoRubroC.descripcion);
    if(descripcionValidaciones.estadoCampoVacio) {
        descripcionValidaciones.estadoSoloLetras = funciones.validarSoloLetras(inputsNuvoRubroC.descripcion, validaciones.soloLetras);
    } 
    if(descripcionValidaciones.estadoSoloLetras) {
       descripcionValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputsNuvoRubroC.descripcion);
    }
    if(descripcionValidaciones.estadoNoMasdeUnEspacios) {
        descripcionValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputsNuvoRubroC.descripcion, 
            validaciones.caracterMas3veces);
    }
    
 
}


let obtenerRubroComercialExiste = async ($rubroComercial) => {
    const existeRubro = await $.ajax({
        url: "../../../Vista/crud/rubroComercial/rubroComercialExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            rubroComercial: $rubroComercial
        },
    });
    let $ObjRubroComercial = JSON.parse(existeRubro);
    if ($ObjRubroComercial.estado == 'true') {
        document.getElementById('rubroComercial').classList.add('mensaje_error');
        document.getElementById('rubroComercial').parentElement.querySelector('p').innerText = '*El Rubro Comercial ya existe';  
    } else {
        document.getElementById('rubroComercial').classList.remove('mensaje_error');
        document.getElementById('rubroComercial').parentElement.querySelector('p').innerText = '';
    }
    
}