const $eUsuario = document.getElementById('E_nombre');

// VALIDAR EN MAYUSCULAS EL EDITAR USUARIO
$eUsuario.addEventListener('focusout', () => {
    let eNombreMayus = $eUsuario.value.toUpperCase();
    $eUsuario.value = eNombreMayus;
});

