
const $tbody = document.getElementById('t-body');
const $btnAgregar = document.getElementById('btn-agregar-producto');

let $addProduct = {
    id: document.getElementById('id-producto'),
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
    row += `
        <tr>
            <td>${$addProduct.id.value}</td>
            <td>${$addProduct.descripcion.value}</td>
            <td>${$addProduct.marca.value}</td>
            <td>${$addProduct.cantidad.value}</td>
            <td>${$addProduct.precio.value}</td>
            <td class="total-producto">${$addProduct.cantidad.value * $addProduct.precio.value}</td>
        </tr>
    `;
    $tbody.innerHTML = row;
    // Obtener suma de totales
    let $sumTotales = document.querySelectorAll('.total-producto');
    $sumTotales.forEach((total) => {
        let totalInt = parseInt(total.textContent);
        totalSuma = totalSuma + totalInt;
    });
    calcularResumenCotizacion(totalSuma);
});

let calcularResumenCotizacion = (totalSuma) => {
    $resumenCotizacion.subtotal.value = totalSuma;
    $resumenCotizacion.descuento.value = (totalSuma * 0.03);
    $resumenCotizacion.subdescuento.value = totalSuma - $resumenCotizacion.descuento.value;
    $resumenCotizacion.impuesto.value = $resumenCotizacion.subdescuento.value * 0.15;
    $resumenCotizacion.total.value = $resumenCotizacion.subdescuento.value - $resumenCotizacion.impuesto.value;
}
