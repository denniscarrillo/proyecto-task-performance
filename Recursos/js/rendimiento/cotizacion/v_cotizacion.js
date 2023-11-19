const $tbody = document.getElementById('t-body');
const $btnAgregar = document.getElementById('btn-agregar-producto');
$(document).ready( async () => {
    await validarDatosCotizacion();
    alternarHiddenBotones();
});
let contItem = 0;
let itemProdDB = [];
let estadoCot = 'Nueva';
let tableProductos = '';
let $addNewProduct = {
    descripcion: document.getElementById('descripcion'),
    marca: document.getElementById('marca'),
    cantidad: document.getElementById('cantidad'),
    precio: document.getElementById('precio')
}
let $resumenCotizacion = {
    subtotal: document.getElementById('sub-total'),
    descuento: document.getElementById('descuento'),
    subdescuento: document.getElementById('sub-descuento'),
    impuesto: document.getElementById('impuesto'),
    total: document.getElementById('total')
}
let row = '';
$btnAgregar.addEventListener('click', () => {
    let $newProduct = {
        descripcion: $addNewProduct.descripcion.value,
        marca: $addNewProduct.marca.value,
        precio: $addNewProduct.precio.value
    }
    $.ajax({
        url: '../../../../Vista/rendimiento/cotizacion/agregarNuevoProducto.php',
        type: 'POST',
        datatype: 'JSON',
        data: {
            nuevoProducto: $newProduct
        }
    });
});
$(document).on('click', '.btn_article', function () {
    selectArticulos(this.children[0]);
});
let selectArticulos = function ($elementoHtml) {
    $elementoHtml.classList.toggle('select-articulo');
}
document.getElementById('btn_agregar').addEventListener('click', () => {
    document.querySelectorAll('.select-articulo').forEach((articulo, i) => {
        contItem+=1;
        let trProducto = articulo.parentElement.parentElement.parentElement;
        let productosCotizados = {
            id: trProducto.children[0].textContent,
            descripcion: trProducto.children[1].textContent,
            marca: trProducto.children[2].textContent,
            precio: trProducto.children[3].textContent,
            idPrecio: trProducto.children[4].textContent
        }
        insertarNewProduct(contItem, productosCotizados, $tbody, 0);
    });
    document.querySelectorAll('.fa-circle-xmark-new').forEach(xmark => {
        agregarEventoBorrar(xmark);
    })  
    $('#modalProductosCotizados').modal('hide');
});
$(document).on('keyup', '.input-cant', function () {
    let totalSuma = 0;
    let cant = parseInt(this.value);
    let precio = parseFloat(this.parentElement.nextSibling.textContent.split(' ')[1]);
    console.log();
    this.parentElement.nextSibling.nextSibling.textContent = `Lps. ${parseFloat((cant * precio).toFixed(2))}`;
    let arrayTotales = [];
    document.querySelectorAll('.total-producto').forEach(element => {
        arrayTotales.push(element.textContent.split(' ')[1]);
    });
    calcularResumenCotizacion(arrayTotales, totalSuma);
});
document.getElementById('form-cotizacion').addEventListener('submit', async (event) => {
    event.preventDefault();
    //Capturamos los datos de la cotizacion y producto a enviar
    let $datosCotizacion = {
        idTarea: document.querySelector('.encabezado').id,
        validez: document.getElementById('validez-cotizacion').textContent.split(' ')[0],
        subTotal: document.getElementById('sub-total').textContent.split(' ')[1],
        descuento: document.getElementById('descuento').textContent.split(' ')[1],
        subDescuento: document.getElementById('sub-descuento').textContent.split(' ')[1],
        isv: document.getElementById('impuesto').textContent.split(' ')[1],
        total: document.getElementById('total').textContent.split(' ')[1]
    }
    let $productosCot = document.querySelectorAll('.new-product');
    let $arrayProductosCot = [];
    $productosCot.forEach(producto => {
       let $newProduct = {
            id: producto.getAttribute('class').split(' ')[1],
            item: producto.children[0].textContent,
            cantidad: producto.children[3].children[0].value,
            idPrecio: producto.children[4].id,
            total: producto.children[5].textContent.split(' ')[1]
        }
        $arrayProductosCot.push($newProduct);
    });
    //Llamamos a la funcion que envia la cotizacion al servidor y recibe estos parametros
    enviarNuevaCotizacion($datosCotizacion, $arrayProductosCot);
    estadoCot = 'Existente';
    alternarHiddenBotones();
    document.querySelectorAll('.new').forEach((elemento) => {
        elemento.classList.add('hidden');
    });
    $tbody.innerHTML = '';
    await validarDatosCotizacion();
});
let alternarHiddenBotones = () => {
    if(estadoCot=='Nueva'){
        document.querySelectorAll('.new').forEach((elemento) => {
            elemento.classList.remove('hidden');
        });
    } else {
        document.querySelectorAll('.exist').forEach((elemento) => {
            elemento.classList.remove('hidden');
        });
    }
}
let calcularResumenCotizacion = (elementosSumar, acumTotalSuma) => {
    elementosSumar.forEach((total) => {
        let totalInt = parseFloat(total);
        acumTotalSuma = acumTotalSuma + totalInt;
    });
    $resumenCotizacion.subtotal.textContent = `Lps. ${acumTotalSuma.toFixed(2)}`;
    $resumenCotizacion.descuento.textContent = `Lps. ${(acumTotalSuma * 0.03).toFixed(2)}`;
    $resumenCotizacion.subdescuento.textContent = `Lps. ${(acumTotalSuma - parseFloat($resumenCotizacion.descuento.textContent.split(' ')[1])).toFixed(2)}`;
    $resumenCotizacion.impuesto.textContent = `Lps. ${(parseFloat($resumenCotizacion.subdescuento.textContent.split(' ')[1]) * 0.15).toFixed(2)}`;
    $resumenCotizacion.total.textContent = `Lps. ${(parseFloat($resumenCotizacion.subdescuento.textContent.split(' ')[1]) + parseFloat($resumenCotizacion.impuesto.textContent.split(' ')[1])).toFixed(2)}`;
}

//nueva Cotizacion
let enviarNuevaCotizacion = ($datosCotizacion, $productosCotizacion) => {
    $.ajax({
        url: "../../../../Vista/rendimiento/cotizacion/nuevaCotizacion.php",
        type: "POST",
        datatype: "JSON",
        data: {
            "datosCotizacion": $datosCotizacion,
            "productos": $productosCotizacion
        },
        success: function(){
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
                  title: 'La cotización ha sido generada'
            });
        }
    });
}
let agregarEventoBorrar = ($deleteButton) => {
    let totalSuma = 0;
    if(!($deleteButton == null)){
        $deleteButton.addEventListener('click', () => {
            $deleteButton.parentElement.parentElement.parentElement.remove();
            calcularResumenCotizacion(document.querySelectorAll('.total-producto'), totalSuma);
            document.querySelectorAll('.item-num').forEach((item, index) => {
                contItem = index+1;
                item.textContent = contItem;
            });
        });
    }
}
let validarDatosCotizacion = async () => {
    const data = await obtenerDatosCotizacion(document.querySelector('.encabezado').id);
    if(!(data[0] == false)){
        document.getElementById('id-cotizacion').textContent = data.detalle.id_Cotizacion;
        document.getElementById('estado-cot').textContent = data.detalle.estado_Cotizacion;
        estadoCot = 'Existente';
        data.productos.forEach((product, index) => {
            contItem = index+1;
            insertarNewProduct(contItem, product, $tbody, 1);
            itemProdDB.push(product.item);
        });
        $resumenCotizacion.subtotal.textContent = `Lps. ${data.detalle.subTotal}`;
        $resumenCotizacion.descuento.textContent = `Lps. ${data.detalle.descuento}`;
        $resumenCotizacion.subdescuento.textContent = `Lps. ${data.detalle.subDescuento}`;
        $resumenCotizacion.impuesto.textContent = `Lps. ${data.detalle.isv}`;
        $resumenCotizacion.total.textContent = `Lps. ${data.detalle.total_Cotizacion}`;
    }
}
let obtenerDatosCotizacion = async ($idTarea) => {
    let dataCotizacion = '';
    try {
        dataCotizacion = await $.ajax({
            url: '../../../../Vista/rendimiento/cotizacion/obtenerDatosCotizacion.php',
            type: 'POST',
            datatype: 'JSON',
            data: {
                idTarea: $idTarea
            }
        });       
    } catch (error) {
        console.error(error);
    }
    return JSON.parse(dataCotizacion);
} 

let insertarNewProduct = (contItem, $addProduct, $tbody, referencia) => {
    (document.getElementById('row-temp') != null) ? document.getElementById('row-temp').remove() : '';
    //Creamos la fila para agregar los datos del neuvo producto
    let $fila = document.createElement('tr');
    $fila.setAttribute('class','new-product');
    // $fila.setAttribute('id', $addProduct.id);
    $fila.classList.add($addProduct.id);
    ((estadoCot == 'Existente') && (referencia == 0)) ? $fila.classList.add('addNewProduct') : '';
    let item = $fila.appendChild(document.createElement('td'));
    /*------------------- Agregamos el div con los iconos y sus clases a la columna de items ------------------*/
    item.setAttribute('class','icon-column');
    let divIcons = item.appendChild(document.createElement('div'));
    let label = item.appendChild(document.createElement('label'));
    label.setAttribute('class', 'item-num');
    divIcons.setAttribute('class', 'icon-container');
    
    /*---------------------------------------------------------------------------------------------------------*/ 
    let descripcion = $fila.appendChild(document.createElement('td'));
    let marca = $fila.appendChild(document.createElement('td'));
    let cantidad = $fila.appendChild(document.createElement('td'));
    let precio = $fila.appendChild(document.createElement('td'));
    precio.setAttribute('id', $addProduct.idPrecio);
    let total = $fila.appendChild(document.createElement('td'));
    total.setAttribute('class', 'total-producto');
    total.appendChild(document.createTextNode('Lps. 0.00'));

    if(referencia == 0) {
        //Ahora agregamos los datos 
        divIcons.innerHTML = `<i class="fa-regular fa-circle-xmark fa-circle-xmark-new icon"></i>`
        label.append(document.createTextNode(contItem));
        cantidad.innerHTML = `<input type="text" class="input-cant" placeholder="Ingresar...">`;
        descripcion.textContent = $addProduct.descripcion;
        marca.textContent = $addProduct.marca;
        precio.appendChild(document.createTextNode(`Lps. ${parseFloat($addProduct.precio).toFixed(2)}`));
        $tbody.appendChild($fila);
    } else {
        divIcons.innerHTML = `<i class="fa-regular fa-circle-xmark fa-circle-xmark-DB icon" hidden></i>`;
        label.append(document.createTextNode($addProduct.item));
        descripcion.textContent = $addProduct.descripcion;
        marca.textContent = $addProduct.marca; 
        cantidad.innerHTML = `<input type="text" class="input-cant new hidden" placeholder="Ingresar..." value=${$addProduct.cantidad}> 
        <label class="temp-label">${$addProduct.cantidad}</label>`;
        precio.textContent = `Lps. ${$addProduct.precio}`;
        total.textContent = `Lps. ${$addProduct.total}`;
        $tbody.appendChild($fila);
    }
}
$('#btn-productos').click(() => {
    if (document.getElementById('table-productos_wrapper') == null) {
        tableProductos = $('#table-productos').DataTable({
        "ajax": {
          "url": "../../../../Vista/rendimiento/cotizacion/obtenerProductosCotizados.php",
          "dataSrc": ""
        },
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
        },
        "columns": [
          { "data": "idProducto" },
          { "data": 'producto' },
          { "data": 'marca' },
          { "data": 'precio'},
          { "data": 'id_Precio'},
          {
            "defaultContent":
              `<button class="btns btn btn_article" ><i class="fa-solid-icon fa-solid fa-circle-check"></i></button>`
          }
        ]
      });
    } else {
        tableProductos.ajax.reload(null, false);
    }
    setTimeout(() => {
        document.querySelectorAll('.sorting_1').forEach(td => {
            td.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.setAttribute('hidden', 'true');
        });
    }, 100);
  });

  document.getElementById('btn-nueva-cot').addEventListener('click', () => {
    let estado = document.getElementById('estado-cot').textContent;
    let mensaje = "Se anulará la cotización actual, no podrás revertir esto";
    if(estado == 'Anulada' || estado =='Vencida'){
        mensaje = "Ahora, podrás generar una nueva cotización";
    }
    Swal.fire({
        title: '¿Está seguro de continuar?',
        text: mensaje,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33', 
        confirmButtonText: 'Si, continuar'
      }).then(async (result) => {
        if (result.isConfirmed) {
            if(estado == 'Vigente') {
                estado = await anularCotizacion(document.getElementById('id-cotizacion').textContent);
                estado = JSON.parse(estado);
            } else {
                estado = true;
            }
            mostrarElementosNuevaCotizacion(estado);
        }
      });
  });

let anularCotizacion = async ($idCotizacion) => {
    let estado = '';
    try {
        estado = await $.ajax({
            url: '../../../../Vista/rendimiento/cotizacion/anularCotizacion.php',
            datatype: 'JSON',
            type: 'POST',
            data: {idCotizacion: $idCotizacion}
        });
    } catch (error) {
        console.error(error);
    }
    return estado;
}
let mostrarElementosNuevaCotizacion = (estado) => {
    estadoCot = 'Nueva';
    //Creamos el toast que nos confirma la actualización de los permisos
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
    if(estado){
        document.querySelectorAll('.new').forEach((elemento) => {
            elemento.classList.remove('hidden');
        });
        document.querySelectorAll('.exist').forEach((elemento) => {
            elemento.classList.add('hidden');
        }); 
        document.querySelectorAll('.temp-label').forEach(label => {
            label.remove();
        });
        document.querySelectorAll('.fa-circle-xmark').forEach(xmark => {
            xmark.removeAttribute('hidden');
            agregarEventoBorrar(xmark);
        });
          //Mostramos el toast
          Toast.fire({
            icon: 'success',
            title: '¡La cotización ha sido anulada!'
          })
    } else {
        //Mostramos el toast
        Toast.fire({
            icon: 'error',
            title: 'No se ha podido anular la cotización'
        });
    }
}