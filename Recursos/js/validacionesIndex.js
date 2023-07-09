const $body = document.getElementById('body');
const $sidebar = document.getElementById('nav');
const $toogle = document.getElementById('toogle');

$toogle.addEventListener("click", e =>{
    $sidebar.classList.toggle("close");
})



// $password.addEventListener('keyup', e => {
//     validarEspacios(e, $password);
//     $("#userPassword").inputlimiter({
//         limit: 20
//     });
// });