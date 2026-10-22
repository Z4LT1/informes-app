<?php
/*
Sitio Web Creado por ITred Spa.
Direccion: Guido Reni #4190
Pedro Aguirre Cerda - Santiago - Chile
contacto@itred.cl o itred.spa@gmail.com
https://www.itred.cl
Creado, Programado y Diseñado por ITred Spa.
BPPJ
*/

require_once __DIR__ . '/../../config/conexion.php';

session_start();

if(!isset($_SESSION['id_usuario'])){
    header('Location: ../../../index.php');
    exit();
}

$id_usuario = (int)$_SESSION['id_usuario'];
$nombre_usuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : '';
