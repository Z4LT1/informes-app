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
   -------------------------------- INICIO ITred Spa cerrar_sesion .PHP --------------------------------------
   ------------------------------------------------------------------------------------------------------------ */

/* ------------------------
   -- INICIO SESION PHP --
   ------------------------ */

// Inicia o reanuda la sesion del usuario
session_start();

/* ---------------------
   -- FIN SESION PHP --
   --------------------- */

/* -------------------------------------
   -- INICIO ELIMINACION VARIABLES -----
   ------------------------------------- */

// Vacia todas las variables almacenadas en la sesion
$_SESSION = array();

/* ----------------------------------
   -- FIN ELIMINACION VARIABLES -----
   ---------------------------------- */

/* --------------------------------
   -- INICIO ELIMINACION COOKIE ----
   -------------------------------- */

// Valida si la sesion utiliza cookies
if (ini_get("session.use_cookies")) {
    $parametros_sesion = session_get_cookie_params();

    // Elimina la cookie de sesion
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $parametros_sesion["path"],
        $parametros_sesion["domain"],
        $parametros_sesion["secure"],
        $parametros_sesion["httponly"]
    );
}

/* -----------------------------
   -- FIN ELIMINACION COOKIE ---
   ----------------------------- */

/* ----------------------------
   -- INICIO DESTRUCCION ------
   ---------------------------- */

// Destruye completamente la sesion activa
session_destroy();

/* -------------------------
   -- FIN DESTRUCCION ------
   ------------------------- */

/* -------------------------------
   -- INICIO REDIRECCION LOGIN ---
   ------------------------------- */

// Redirecciona al index principal del sistema
header('Location: ../../../index.php');
exit();

/* ----------------------------
   -- FIN REDIRECCION LOGIN ---
   ---------------------------- */

/* ------------------------------------------------------------------------------------------------------------
   --------------------------------- FIN ITred Spa cerrar_sesion .PHP ----------------------------------------
   ------------------------------------------------------------------------------------------------------------ */
?>