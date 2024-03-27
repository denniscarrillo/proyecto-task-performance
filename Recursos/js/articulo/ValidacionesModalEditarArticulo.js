import * as funciones from '../funcionesValidaciones.js';
export let estadoValido = false;

const Toast = Swal.mixin({
    toast: true,
    position: "top",
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-ZáéíóúñÁÉÍÓÚüÜÑ\s,])/,//Lentras, acentos y Ñ
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9 ]*$/,
    caracterMas3veces: /^(?=.*(..)\1)/, // no permite escribir que se repida mas de tres veces un caracter
    caracterMas5veces: /^(?=.*(...)\1)/,
    letrasNumeros: /^[a-zA-Z0-9 #-]+$/,
    direccion: /^[a-zA-Z0-9 #.,-]+$/,
};

let inputseditarArticulo = {
    Articulo: document.getElementById('A_Articulo'),
    Detalle: document.getElementById('A_Detalle'),
    Marca: document.getElementById('A_Marca'),
}
let btnGuardar = document.getElementById('btn-editarsubmit');

btnGuardar.addEventListener('click', () => {
    validarInputArticulo();
    validarInputDetalle();
    validarInputMarca();
    if (document.querySelectorAll(".mensaje_error").length == 0) {
        estadoValido = true;
    }else{
        estadoValido = false;
    }
});

$(document).on('click', '.btn-editar', async function(){
    const codArticulo = $(this).closest("tr").attr('id');
    await setearPreciosProducto(codArticulo);
});
$('#btn-nuevo-precio').click(function(){
    document.getElementById('container-input-nuevo-precio').removeAttribute('hidden')
    document.getElementById('btn-nuevo-precio').disabled = true;
    document.getElementById('btn-editar-estado-precios').disabled = true;
    document.querySelector('.container-precios').classList.add('edit');
});
$('#btn-cerrar-nuevo-precio').click(function(){
    document.getElementById('container-input-nuevo-precio').setAttribute('hidden', 'true')
    document.getElementById('btn-nuevo-precio').disabled = false;
    document.getElementById('btn-editar-estado-precios').disabled = false;
    document.getElementById('input-nuevo-precio').value = 1;
    document.querySelector('.container-precios').classList.remove('edit');
});
$('#btn-cerrar-table').click(function(){
    document.querySelector('.container-editar-precios').setAttribute('hidden', 'true')
    document.getElementById('btn-cerrar-table').setAttribute('hidden', 'true')
    document.getElementById('btn-editar-estado-precios').disabled = false;
    document.getElementById('btn-nuevo-precio').disabled = false;
});
$(document).on('click', '#btn-editar-estado-precios', async function(){
    document.getElementById('btn-cerrar-table').removeAttribute('hidden')
    const codArticulo = $('#A_CodArticulo').val();
    let preciosProducto = await obtenerPreciosProducto(codArticulo);
    renderTablaPrecios(preciosProducto);
    document.querySelector('.container-editar-precios').removeAttribute('hidden');
    document.getElementById('btn-editar-estado-precios').disabled = true;
});
document.getElementById("btn-cerrar-modal-editar").addEventListener("click", async () => {
    const codArticulo = $('#A_CodArticulo').val();
    let preciosProducto = await obtenerPreciosProducto(codArticulo);
    renderTablaPrecios(preciosProducto);
    ocultarTablaPrecios();
});
document.getElementById("btn-x-modal-editar").addEventListener("click", async () => {
    const codArticulo = $('#A_CodArticulo').val();
    let preciosProducto = await obtenerPreciosProducto(codArticulo);
    renderTablaPrecios(preciosProducto);
    ocultarTablaPrecios();
});

$(document).on('click', '.btn-update-estado-precio', async function(){
    await enviarNuevoEstadoPrecio(this, 'ACTIVAR');
});

$(document).on('click', '.btn-update-estado-precio-inactivar', async function(){
    await enviarNuevoEstadoPrecio(this, 'INACTIVAR');
});

$('#btn-agregar-nuevo-precio').click(function(){
    document.getElementById('btn-nuevo-precio').disabled = false;
    const codArticulo = $('#A_CodArticulo').val();
    const nuevoPrecio = $('#input-nuevo-precio').val();
    Swal.fire({
        title: `¿Está seguro de continuar?`,
        text: "Todos los precios anteriores se inactivarán",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, continuar",
        focusCancel: true,
        confirmButtonColor: "#f5971d",
        cancelButtonText: "Cancelar"
      }).then(async (result) => {
        if (result.isConfirmed) {
            const estado = await enviarNuevoPrecio(codArticulo, nuevoPrecio)
            if(estado) {
                await setearPreciosProducto(codArticulo);
                Toast.fire({
                    icon: "success",
                    title: "¡Nuevo precio agregado!",
                });
                document.getElementById('container-input-nuevo-precio').setAttribute('hidden', 'true')
                document.getElementById('btn-nuevo-precio').disabled = false;
                document.getElementById('btn-editar-estado-precios').disabled = false;
                document.getElementById('input-nuevo-precio').value = 1;
                document.querySelector('.container-precios').classList.remove('edit');
            }
        }
      });
});

const renderTablaPrecios = (preciosProducto) => {
    //Pintamos los precios en la tabla para editarlos
    let precios = document.getElementById("tbody-precios");
    let listaPrecios = '';
    preciosProducto.forEach(precio => {
        listaPrecios+=
        `<tr> 
            <td>${precio.item}</td>
            <td>${precio.precio}</td>
            <td>${precio.estado}</td>
            <td>
                <button id="${precio.idPrecio}" class="${precio.estado == 'INACTIVO'
                    ? 'btn-update-estado-precio' 
                    : 'btn-update-estado-precio-inactivar'}">
                    <i class="fa-solid fa-rotate-right"></i>
                    ${precio.estado == 'ACTIVO' ? 'INACTIVAR' : 'ACTIVAR'}
                </button>
            </td>
        </tr>`;
    });
    precios.innerHTML = listaPrecios;
}

let ocultarTablaPrecios = () => {
    document.querySelector('.container-editar-precios').setAttribute('hidden', 'true')
    document.getElementById('btn-cerrar-table').setAttribute('hidden', 'true')
    document.getElementById('btn-editar-estado-precios').disabled = false;
    document.getElementById('btn-nuevo-precio').disabled = false;
}

const enviarNuevoEstadoPrecio = async (elemento, accion) => {
    const idPrecio = $(elemento).attr('id');
    const codArticulo = $('#A_CodArticulo').val();
    const estadoActual = $(elemento).closest("tr").find("td:eq(2)").text();
    const estadoUpdate = await actualizarEstadoPrecio(idPrecio, codArticulo, estadoActual);
    if(estadoUpdate) {
        const mensaje = (accion === 'ACTIVAR') ? 'activado': 'inactivado';
        Toast.fire({
            icon: "success",
            title: `¡Precio ${mensaje}!`,
        });
        let preciosProducto = await obtenerPreciosProducto(codArticulo);
        renderTablaPrecios(preciosProducto);
        await setearPreciosProducto(codArticulo);
    } else {
        Toast.fire({
            icon: "error",
            title: "¡Ha ocurrido un error!",
        });
    }
}
const setearPreciosProducto = async (codArticulo) => {
    let preciosProducto = await obtenerPreciosProducto(codArticulo);
    let precios = document.getElementById("precios");
    let listaPrecios = '';
    let precioActual = document.getElementById('idPrecio').getAttribute('class');
    let preciosActivos = 0;
    preciosProducto.forEach((precio, index) => {
        if(precio.estado === 'ACTIVO') {
            preciosActivos++;
            listaPrecios+=
            `<option value="${precio.idPrecio}" ${(precio.precio == precioActual) ? 'selected': ''}> ${precio.precio}</option>`;
        } else if(preciosActivos == 0 && index == (preciosProducto.length - 1)) { 
            listaPrecios+=
            `<option value="0">No tiene precios activos</option>`;
        }
    });
    precios.innerHTML = listaPrecios;
}

const enviarNuevoPrecio = async (codArticulo, nuevoPrecio) => {
    const estadoNuevoPrecio = await $.ajax({
        url: "../../../Vista/crud/articulo/nuevoPrecio.php",
        type: "POST",
        datatype: "JSON",
        data: {
          codArticulo: codArticulo,
          nuevoPrecio: nuevoPrecio
        }
    });
    return JSON.parse(estadoNuevoPrecio);
}

const obtenerPreciosProducto = async (codArticulo) => {
    const precios = await $.ajax({
      url: "../../../Vista/crud/articulo/obtenerPrecios.php",
      type: "POST",
      datatype: "JSON",
      data: {
        codArticulo: codArticulo,
      }
    });
    return JSON.parse(precios);
}

const actualizarEstadoPrecio = async (idPrecio, codArticulo, estadoActual) => {
    const nuevoEstadoPrecio = await $.ajax({
        url: "../../../Vista/crud/articulo/cambiarEstadoPrecio.php",
        type: "POST",
        datatype: "JSON",
        data: {
            idPrecio: idPrecio,
            codArticulo: codArticulo,
            estadoActual: estadoActual
        }
    });
    return JSON.parse(nuevoEstadoPrecio);
}

document.getElementById('A_Existencias').addEventListener('input', (event) => {
    const cant = event.target.value;
    if(parseFloat(cant) < 1 || cant === '') {
        event.target.value = 1;
    }
})

document.getElementById('input-nuevo-precio').addEventListener('input', (event) => {
    const cant = event.target.value;
    if(parseFloat(cant) < 1 || cant === '') {
        event.target.value = 1;
    }
})

let validarInputArticulo = function () {
    let ArticuloMayus = inputseditarArticulo.Articulo.value.toUpperCase();
    inputseditarArticulo.Articulo.value = ArticuloMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarArticulo.Articulo);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarArticulo.Articulo);
    } 
    if(  estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarArticulo.Articulo, validaciones.caracterMas3veces);
    }
}

let validarInputDetalle = function () {
    let DetalleMayus =  inputseditarArticulo.Detalle.value.toUpperCase();
     inputseditarArticulo.Detalle.value = DetalleMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio(inputseditarArticulo.Detalle);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio(inputseditarArticulo.Detalle);
    } 
    if(  estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter(inputseditarArticulo.Detalle, validaciones.caracterMas3veces);
    }
}

let validarInputMarca = function () {
    let MarcaMayus =  inputseditarArticulo.Marca.value.toUpperCase();
     inputseditarArticulo.Marca.value = MarcaMayus;
    let estadoValidaciones = {
        estadoCampoVacio: false,
        estadoSoloLetras: false,
        estadoNoMasdeUnEspacios: false,
        estadoNoCaracteresSeguidos: false
    }
    estadoValidaciones.estadoCampoVacio = funciones.validarCampoVacio( inputseditarArticulo.Marca);
    if(estadoValidaciones.estadoCampoVacio) {
        estadoValidaciones.estadoSoloLetras = funciones.validarSoloLetras( inputseditarArticulo.Marca, validaciones.soloLetras);
    } 
    if(estadoValidaciones.estadoSoloLetras) {
        estadoValidaciones.estadoNoMasdeUnEspacios = funciones.validarMasdeUnEspacio( inputseditarArticulo.Marca);
    }
    if(estadoValidaciones.estadoNoMasdeUnEspacios) {
        estadoValidaciones.estadoNoCaracteresSeguidos = funciones.limiteMismoCaracter( inputseditarArticulo.Marca, validaciones.caracterMas3veces);
    }
}