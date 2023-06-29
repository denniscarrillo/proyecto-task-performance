<?php

class ControladorRol {
    public static function rolesUsuario(){
        return Rol::obtenerRolesUsuario();
    }
}