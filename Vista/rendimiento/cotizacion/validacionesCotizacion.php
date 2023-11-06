<?php
session_start(); //Reanudamos sesion
require_once('../../../db/Conexion.php');
require_once('../../../Modelo/Bitacora.php');
require_once('../../../Controlador/ControladorBitacora.php');
require_once('../../../Modelo/Tarea.php');
require_once('../../../Controlador/ControladorTarea.php');