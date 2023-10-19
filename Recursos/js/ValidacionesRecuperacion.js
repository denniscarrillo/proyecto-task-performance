import *as funciones from './funcionesValidaciones.js';
let estadoEspacios = {
    estadoEspacioUsuario: true
}
let usuarioNoExiste = true;

const expresiones = {
    usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
}

const $form = document.getElementById('formRecuperacion');
const $usuario = document.getElementById('usuario');
