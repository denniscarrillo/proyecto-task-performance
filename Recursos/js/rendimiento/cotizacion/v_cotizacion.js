const $tbody = document.getElementById('t-body');
const $btnAgregar = document.getElementById('btn-agregar-producto');
$(document).ready( async () => {
    await validarDatosCotizacion();
});
let contItem = 0;
let itemProdDB = [];
let estadoCot = 'Nueva';
let prodEliminar = [];
let prodModificar = [];
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
    let totalSuma = 0;
    contItem += 1;
    //Con el ultimo parametro indicamos desde donde se va a llenar los productos a la tabla, en este de la misma vista lo hara el usaurio
    insertarNewProduct(contItem, $addProduct, $tbody, 0);
    agregarEventoPencil();
    let xBtns = document.querySelectorAll('.fa-circle-xmark');
    xBtns.forEach((xbtn, index) => {
        if(index == (xBtns.length - 1)){
            agregarEventoBorrar([xBtns[index]]);
        }
    });
    // Obtener suma de totales
    calcularResumenCotizacion(document.querySelectorAll('.total-producto'), totalSuma);
    $addProduct.descripcion.value = '';
    $addProduct.marca.value = '';
    $addProduct.cantidad.value = '';
    $addProduct.precio.value = '';
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
    let classProduct = '.new-product';
    if(estadoCot == 'Existente') {
        classProduct = '.addNewProduct';
    }
    let $productosCot = document.querySelectorAll(classProduct);
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
    console.log($arrayProductosCot);
    document.querySelectorAll('.update-product').forEach(producto => {
        let $updateProduct = {
            item: producto.children[0].children[0].children[1].id,
            descripcion: producto.children[1].textContent,
            marca: producto.children[2].textContent,
            cantidad: producto.children[3].textContent,
            precio: producto.children[4].textContent,
            total: producto.children[5].textContent
        };
        if(prodModificar.length == 0) {
            prodModificar.push($updateProduct);
        } else {
            let existe = false;
            for(let i = 0; i < prodModificar.length; i++) {
                // console.log(prodModificar[i]);
                if(prodModificar[i].item == $updateProduct.item) {
                    existe = true;
                    break;  
                }   
            } 
            (!existe) ? prodModificar.push($updateProduct) : '';
        }
    });
    console.log(prodModificar);
    prodEliminar = [];
    prodModificar = [];
    //Llamamos a la funcion que envia la cotizacion al servidor y recibe estos parametros
    enviarNuevaCotizacion($datosCotizacion, $arrayProductosCot);
});
// 
let calcularResumenCotizacion = (elementosSumar, acumTotalSuma) => {
    elementosSumar.forEach((total) => {
        let totalInt = parseFloat(total.textContent);
        acumTotalSuma = acumTotalSuma + totalInt;
    });
    $resumenCotizacion.subtotal.textContent = `Lps. ${acumTotalSuma.toFixed(2)}`;
    $resumenCotizacion.descuento.textContent = `Lps. ${(acumTotalSuma * 0.03).toFixed(2)}`;
    $resumenCotizacion.subdescuento.textContent = `Lps. ${(acumTotalSuma - parseFloat($resumenCotizacion.descuento.textContent.split(' ')[1])).toFixed(2)}`;
    $resumenCotizacion.impuesto.textContent = `Lps. ${(parseFloat($resumenCotizacion.subdescuento.textContent.split(' ')[1]) * 0.15).toFixed(2)}`;
    $resumenCotizacion.total.textContent = `Lps. ${(parseFloat($resumenCotizacion.subdescuento.textContent.split(' ')[1]) - parseFloat($resumenCotizacion.impuesto.textContent.split(' ')[1])).toFixed(2)}`;
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
    let totalSuma = 0;
    let $editPencils = document.querySelectorAll('.fa-pencil');
    if(!($editPencils == null)) {
        $editPencils.forEach((pencil) => {
            pencil.addEventListener('click', () => {
                let editProduct = {
                    descripcion: pencil.parentElement.parentElement.parentElement.children[1],
                    marca: pencil.parentElement.parentElement.parentElement.children[2],
                    cantidad: pencil.parentElement.parentElement.parentElement.children[3],
                    precio: pencil.parentElement.parentElement.parentElement.children[4],
                    total: pencil.parentElement.parentElement.parentElement.children[5]
                };
                setearEditProduct($addProduct, editProduct);
                let divButtons = document.getElementById('button-container');
                divButtons.innerHTML = `
                    <i class="fa-regular fa-circle-check" id="btn-save" title="Guardar"></i>
                    <i class="fa-solid fa-ban" id="btn-cancel" title="Cancelar"></i>
                `;
                document.getElementById('btn-agregar-producto').setAttribute('hidden','true');
                //Esto es para cancelar la edición de un producto mientras se realizar la cotización
                if(document.getElementById('btn-cancel') != null) {
                    let $btnCancel = document.getElementById('btn-cancel');
                    let $btnSave = document.getElementById('btn-save');
                    $btnCancel.addEventListener('click', () => {
                        document.getElementById('btn-agregar-producto').removeAttribute('hidden');
                        $btnCancel.remove();
                        $btnSave.remove();
                    });
                    $btnSave.addEventListener('click', () => {
                        editProduct.descripcion.textContent =  $addProduct.descripcion.value;
                        editProduct.marca.textContent =  $addProduct.marca.value;
                        editProduct.cantidad.textContent =  $addProduct.cantidad.value;
                        editProduct.precio.textContent =  $addProduct.precio.value;
                        editProduct.total.textContent = parseFloat($addProduct.cantidad.value).toFixed(2) * parseFloat($addProduct.precio.value).toFixed(2);
                        calcularResumenCotizacion(document.querySelectorAll('.total-producto'), totalSuma);
                        document.getElementById('btn-agregar-producto').removeAttribute('hidden');
                        $btnCancel.remove();
                        $btnSave.remove();
                        $addProduct.descripcion.value = '';
                        $addProduct.marca.value = '';
                        $addProduct.cantidad.value = '';
                        $addProduct.precio.value = '';
                        let trProd = pencil.parentElement.parentElement.parentElement;
                        ((estadoCot == "Existente") && (!trProd.classList.contains('addNewProduct'))) ? trProd.classList.add('update-product') : '';
                    });
                }
            });
        });  
    }
}
let setearEditProduct = (inputs, values) => {
    inputs.descripcion.value = values.descripcion.textContent;
    inputs.marca.value = values.marca.textContent;
    inputs.cantidad.value = values.cantidad.textContent;
    inputs.precio.value = values.precio.textContent;
}
let agregarEventoBorrar = ($deleteButtons) => {
    let totalSuma = 0;
    if(!($deleteButtons == null)){
        $deleteButtons.forEach((button) => {
            button.addEventListener('click', () => {
                let itemP = parseInt(button.nextSibling.id);
                itemProdDB.forEach(item => {
                    (itemP == item) ? prodEliminar.push(itemP) : '';
                });
                button.parentElement.parentElement.parentElement.remove();
                calcularResumenCotizacion(document.querySelectorAll('.total-producto'), totalSuma);
                document.querySelectorAll('.item-num').forEach((item, index) => {
                    contItem = index+1;
                    item.textContent = contItem;
                });
                console.log(prodEliminar);
            });
        });
    }
}
let validarDatosCotizacion = async () => {
    const data = await obtenerDatosCotizacion(document.querySelector('.encabezado').id);
    if(!(data[0] == false)){
        estadoCot = 'Existente';
        data.productos.forEach((product, index) => {
            contItem = index+1;
            insertarNewProduct(contItem, product, $tbody, 1);
            itemProdDB.push(product.item);
        });
        agregarEventoPencil();
        agregarEventoBorrar(document.querySelectorAll('.fa-circle-xmark'));

        $resumenCotizacion.subtotal.textContent = `Lps. ${data.detalle.subTotal}`;
        $resumenCotizacion.descuento.textContent = `Lps. ${data.detalle.descuento}`;
        $resumenCotizacion.subdescuento.textContent = `Lps. ${data.detalle.subDescuento}`;
        $resumenCotizacion.impuesto.textContent = `Lps. ${data.detalle.isv}`;
        $resumenCotizacion.total.textContent = `Lps. ${data.detalle.total_Cotizacion}`;
    }
    // console.log(itemProdDB);
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
    ((estadoCot == 'Existente') && (referencia == 0)) ? $fila.classList.add('addNewProduct') : '';
    let item = $fila.appendChild(document.createElement('td'));
    /*------------------- Agregamos el div con los iconos y sus clases a la columna de items ------------------*/
    item.setAttribute('class','icon-column');
    let divIcons = item.appendChild(document.createElement('div'));
    let label = item.appendChild(document.createElement('label'));
    label.setAttribute('class', 'item-num');
    divIcons.setAttribute('class', 'icon-container');
    divIcons.innerHTML = `<i class="fa-regular fa-circle-xmark icon"></i><i class="fa-solid fa-pencil icon" id="${contItem}"></i>`
    /*---------------------------------------------------------------------------------------------------------*/ 
    let descripcion = $fila.appendChild(document.createElement('td'));
    let marca = $fila.appendChild(document.createElement('td'));
    let cantidad = $fila.appendChild(document.createElement('td'));
    let precio = $fila.appendChild(document.createElement('td'));
    let total = $fila.appendChild(document.createElement('td'));
    total.setAttribute('class', 'total-producto');

    if(referencia == 0) {
        //Ahora agregamos los datos 
        label.append(document.createTextNode(contItem));
        descripcion.textContent = $addProduct.descripcion.value
        marca.textContent = $addProduct.marca.value
        cantidad.textContent = $addProduct.cantidad.value
        precio.textContent = Number((parseFloat($addProduct.precio.value)).toFixed(2))
        total.textContent = Number(($addProduct.cantidad.value * $addProduct.precio.value).toFixed(2))
        $tbody.appendChild($fila);
    } else {
        label.append(document.createTextNode($addProduct.item));
        descripcion.textContent = $addProduct.descripcion
        marca.textContent = $addProduct.marca
        cantidad.textContent = $addProduct.cantidad
        precio.textContent = $addProduct.precio
        total.textContent = $addProduct.total
        $tbody.appendChild($fila);
    }
}