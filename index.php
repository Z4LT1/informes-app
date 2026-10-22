<?php
    /* ------------------------
       -- INICIO CONEXION BD --
       ------------------------ */

    // Carga la conexión centralizada antes de cualquier HTML (activa el buffer de salida)
    require_once __DIR__ . '/php/config/conexion.php';

    /* ---------------------
       -- FIN CONEXION BD --
       --------------------- */
?>
<!--
Sitio Web Creado por ITred Spa.
Direccion: Guido Reni #4190
Pedro Aguirre Cerda - Santiago - Chile
contacto@itred.cl o itred.spa@gmail.com
https://www.itred.cl
Creado, Programado y Diseñado por ITred Spa.
BPPJ
-->

<!-- ------------------------------------------------------------------------------------------------------------
     ------------------------------------ INICIO ITred Spa index .PHP ------------------------------------------
     ------------------------------------------------------------------------------------------------------------ -->

<!DOCTYPE html>
<html lang="es">
<head>

    <!-- TITULO HEAD -->

        <!-- Define la codificacion de caracteres -->
        <meta charset="UTF-8">

        <!-- Permite la correcta adaptacion responsive -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- titulo de la pagina -->
        <title>index</title>

        <!-- icono de la pestaña del navegador -->
        <link rel="icon" type="image/png" href="imagenes/favicon.png">

</head>

<!-- TITULO BODY -->

    <body>

        <!-- TITULO LLAMADOS A LOS PHP -->

            <?php
                // Incluye el modulo de login del sistema
                include 'php/programa/login/login.php';
            ?>

    </body>
</html>

<!-- -------------------------------
     -- INICIO CIERRE CONEXION BD --
     ------------------------------- -->
    <!-- <?php
        // $mysqli->close();
    ?> -->
<!-- ----------------------------
     -- FIN CIERRE CONEXION BD --
     ---------------------------- -->

<!-- ------------------------------------------------------------------------------------------------------------
     ------------------------------------- FIN ITred Spa index .PHP --------------------------------------------
     ------------------------------------------------------------------------------------------------------------ -->

<!--
Sitio Web Creado por ITred Spa.
Direccion: Guido Reni #4190
Pedro Aguirre Cerda - Santiago - Chile
contacto@itred.cl o itred.spa@gmail.com
https://www.itred.cl
Creado, Programado y Diseñado por ITred Spa.
BPPJ
-->