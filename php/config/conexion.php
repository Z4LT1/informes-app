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

/* ------------------------------------------------------------------------------------------------------------
   ---------------------------------- INICIO ITred Spa conexion .PHP -----------------------------------------
   ------------------------------------------------------------------------------------------------------------ */

/* ------------------------------
   -- INICIO BUFFER DE SALIDA ---
   ------------------------------ */

// Permite usar header() y session_start() aunque ya se haya escrito HTML
if (ob_get_level() === 0) {
    ob_start();
}

/* ---------------------------
   -- FIN BUFFER DE SALIDA ---
   --------------------------- */

/* ------------------------------
   -- INICIO CONFIGURACION BD ---
   ------------------------------ */

// Valores por defecto para XAMPP local
$configuracion_bd = array(
    'host'     => 'localhost',
    'usuario'  => 'root',
    'password' => '',
    'nombre'   => 'informes_app',
    'puerto'   => 3306,
);

// Si existe config.php (no se sube a GitHub), sobrescribe los valores por defecto
if (is_file(__DIR__ . '/config.php')) {
    $configuracion_bd = array_merge($configuracion_bd, require __DIR__ . '/config.php');
}

// Las variables de entorno tienen prioridad (hostings como Railway o Render)
$variables_entorno_bd = array(
    'host'     => 'DB_HOST',
    'usuario'  => 'DB_USER',
    'password' => 'DB_PASSWORD',
    'nombre'   => 'DB_NAME',
    'puerto'   => 'DB_PORT',
);

foreach ($variables_entorno_bd as $clave => $variable) {
    $valor = getenv($variable);
    if ($valor !== false && $valor !== '') {
        $configuracion_bd[$clave] = $valor;
    }
}

/* ---------------------------
   -- FIN CONFIGURACION BD ---
   --------------------------- */

/* ------------------------
   -- INICIO CONEXION BD --
   ------------------------ */

// Mantiene el comportamiento clasico de mysqli (retorna false en vez de lanzar excepciones en PHP 8.1+)
mysqli_report(MYSQLI_REPORT_OFF);

// Establece la conexión a la base de datos de informes_app
$mysqli = @new mysqli(
    $configuracion_bd['host'],
    $configuracion_bd['usuario'],
    $configuracion_bd['password'],
    $configuracion_bd['nombre'],
    (int)$configuracion_bd['puerto']
);

// Valida si hubo error de conexión
if ($mysqli->connect_error) {
    http_response_code(500);
    exit('No se pudo conectar a la base de datos. Revisa php/config/config.php.');
}

// Establecer el charset a utf8mb4
$mysqli->set_charset('utf8mb4');

/* ---------------------
   -- FIN CONEXION BD --
   --------------------- */

/* ------------------------------------------------------------------------------------------------------------
   ----------------------------------- FIN ITred Spa conexion .PHP -------------------------------------------
   ------------------------------------------------------------------------------------------------------------ */
