
const $tbody = document.getElementById('t-body');
const $btnAgregar = document.getElementById('btn-agregar-producto');
let contItem = 0;
let $addProduct = {
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
    (document.getElementById('row-temp') != null) ? document.getElementById('row-temp').remove() : '';
    let totalSuma = 0;
    contItem += 1;
    //Creamos la fila para agregar los datos del neuvo producto
    let $fila = document.createElement('tr');
    $fila.setAttribute('class','new-product');
    let item = $fila.appendChild(document.createElement('td'));
    /*------------------- Agregamos el div con los iconos y sus clases a la columna de items ------------------*/
    item.setAttribute('class',' icon-column');
    let divIcons = item.appendChild(document.createElement('div'));
    divIcons.setAttribute('class', 'icon-container');
    divIcons.appendChild(document.createElement('i')).setAttribute('class', 'fa-regular fa-circle-xmark icon');
    divIcons.appendChild(document.createElement('i')).setAttribute('class', 'fa-solid fa-pencil icon');
    /*---------------------------------------------------------------------------------------------------------*/ 
    let descripcion = $fila.appendChild(document.createElement('td'));
    let marca = $fila.appendChild(document.createElement('td'));
    let cantidad = $fila.appendChild(document.createElement('td'));
    let precio = $fila.appendChild(document.createElement('td'));
    let total = $fila.appendChild(document.createElement('td'));

    //Ahora agregamos los datos 
    item.append(document.createTextNode = contItem);
    descripcion.textContent = $addProduct.descripcion.value
    marca.textContent = $addProduct.marca.value
    cantidad.textContent = $addProduct.cantidad.value
    precio.textContent = Number((parseFloat($addProduct.precio.value)).toFixed(2))
    total.textContent = Number(($addProduct.cantidad.value * $addProduct.precio.value).toFixed(2))
    $tbody.appendChild($fila);
    agregarEventoPencil();
    agregarEventoBorrar();
    // Obtener suma de totales
    let $sumTotales = document.querySelectorAll('.total-producto');
    $sumTotales.forEach((total) => {
        let totalInt = parseFloat(total.textContent);
        totalSuma = totalSuma + totalInt;
    });
    calcularResumenCotizacion(totalSuma);
});
document.getElementById('form-cotizacion').addEventListener('submit', (event) => {
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
    //Capturamos los productos
    let $productosCot = document.querySelectorAll('.new-product');
    let $arrayProductosCot = Array();
    $productosCot.forEach((producto) => {
        let $newProduct = {
            item: producto.children[0].textContent,
            descripcion: producto.children[1].textContent,
            marca: producto.children[2].textContent,
            cantidad: producto.children[3].textContent,
            precio: producto.children[4].textContent,
            total: producto.children[5].textContent
        }
        $arrayProductosCot.push($newProduct);
    });
    //Llamamos a la funcion que envia la cotizacion al servidor y recibe estos parametros
    enviarNuevaCotizacion($datosCotizacion, $arrayProductosCot);
});
// 
let calcularResumenCotizacion = (totalSuma) => {
    $resumenCotizacion.subtotal.textContent = `Lps. ${Number(totalSuma.toFixed(2))}`;
    $resumenCotizacion.descuento.textContent = `Lps. ${Number((totalSuma * 0.03).toFixed(2))}`;
    $resumenCotizacion.subdescuento.textContent = `Lps. ${Number((totalSuma - parseFloat($resumenCotizacion.descuento.textContent.split(' ')[1])).toFixed(2))}`;
    $resumenCotizacion.impuesto.textContent = `Lps. ${Number((parseFloat($resumenCotizacion.subdescuento.textContent.split(' ')[1]) * 0.15).toFixed(2))}`;
    $resumenCotizacion.total.textContent = `Lps. ${Number((parseFloat($resumenCotizacion.subdescuento.textContent.split(' ')[1]) - parseFloat($resumenCotizacion.impuesto.textContent.split(' ')[1])).toFixed(2))}`;
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
let agregarEventoPencil = () => {
    let $editPencils = document.querySelectorAll('.fa-pencil');
    $editPencils.forEach((pencil) => {
        pencil.addEventListener('click', () => {
            let editProduct = {
                descripcion: pencil.parentElement.parentElement.parentElement.children[1].textContent,
                marca: pencil.parentElement.parentElement.parentElement.children[2].textContent,
                cantidad: pencil.parentElement.parentElement.parentElement.children[3].textContent,
                precio: pencil.parentElement.parentElement.parentElement.children[4].textContent
            };
            setearEditProduct($addProduct, editProduct);
            let divButtons = document.getElementById('button-container');
            divButtons.innerHTML = `
                <i class="fa-regular fa-circle-check" id="btn-save" title="Guardar"></i>
                <i class="fa-solid fa-ban" id="btn-cancel" title="Cancelar"></i>
            `;
            document.getElementById('btn-agregar-producto').setAttribute('hidden','true');
        });
    });  
    // if(document.getElementById('btn-cancel') != null) {
    //     let $btnCancel = document.getElementById('btn-cancel');
    //     let $btnSave = document.getElementById('btn-save');
    //     $btnCancel.addEventListener('click', () => {
    //         console.log('ENTRO');
    //         document.getElementById('btn-agregar-producto').removeAttribute('hidden');
    //         $btnCancel.remove();
    //         $btnSave.remove();
    //     });
    // }
}
if(document.getElementById('btn-cancel') != null) {
    let $btnCancel = document.getElementById('btn-cancel');
    let $btnSave = document.getElementById('btn-save');
    $btnCancel.addEventListener('click', () => {
        console.log('ENTRO');
        document.getElementById('btn-agregar-producto').removeAttribute('hidden');
        $btnCancel.remove();
        $btnSave.remove();
    });
}
let setearEditProduct = (inputs, values) => {
    inputs.descripcion.value = values.descripcion;
    inputs.marca.value = values.marca;
    inputs.cantidad.value = values.cantidad;
    inputs.precio.value = values.precio;
}
let agregarEventoBorrar = () => {
    let $deleteButtons = document.querySelectorAll('.fa-circle-xmark');
    $deleteButtons.forEach((button) => {
        button.addEventListener('click', () => {
            button.parentElement.parentElement.parentElement.remove();
        })
    })
}