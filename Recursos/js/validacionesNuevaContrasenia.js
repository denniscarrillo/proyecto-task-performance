
//  Cambiar tipo del candado para mostrar/ocultar contraseña
let iconClass = document.getElementsByClassName('type-lock');
let iconClass1 = document.getElementsByClassName('type-lock');
let icon_candado = document.querySelector('.lock');
let icon_candado1 = document.querySelector('.lock1');

//Ocultar o mostrar contrasenia
icon_candado.addEventListener('click', function() { 
    if(this.nextElementSibling.type === "password"){
        this.nextElementSibling.type = "text";
    } else {
        this.nextElementSibling.type = "password";
    }
});
icon_candado1.addEventListener('click', function() { 
    if(this.nextElementSibling.type === "password"){
        this.nextElementSibling.type = "text";
    } else {
        this.nextElementSibling.type = "password";
    }
});