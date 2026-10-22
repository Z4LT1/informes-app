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
   -------------------------------- INICIO ITred Spa login_validar .PHP --------------------------------------
   ------------------------------------------------------------------------------------------------------------ */

/* ------------------------
   -- INICIO CONEXION BD --
   ------------------------ */

// Carga la conexión centralizada a la base de datos de informes_app
require_once __DIR__ . '/../../config/conexion.php';

/* ---------------------
   -- FIN CONEXION BD --
   --------------------- */

/* ------------------------
   -- INICIO SESION PHP --
   ------------------------ */

// Inicia o reanuda la sesion del usuario
session_start();

/* ---------------------
   -- FIN SESION PHP --
   --------------------- */

/* --------------------------------------
   -- INICIO VALIDACION METODO ENVIO ----
   -------------------------------------- */

// Valida que la peticion llegue por metodo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../../index.php');
    exit();
}

/* -----------------------------------
   -- FIN VALIDACION METODO ENVIO ----
   ----------------------------------- */

/* -------------------------------
   -- INICIO RECEPCION DATOS -----
   ------------------------------- */

// Guarda el valor del usuario recibido desde el formulario
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';

// Guarda el valor de la contraseña recibida desde el formulario
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

/* ----------------------------
   -- FIN RECEPCION DATOS -----
   ---------------------------- */

/* -----------------------------------
   -- INICIO VALIDACION CAMPOS -------
   ----------------------------------- */

// Valida si el campo usuario esta vacio
if ($usuario === '') {
    $_SESSION['mensaje_error_login'] = 'Debe ingresar su usuario.';
    header('Location: ../../../index.php');
    exit();
}

// Valida si el campo password esta vacio
if ($password === '') {
    $_SESSION['mensaje_error_login'] = 'Debe ingresar su contraseña.';
    header('Location: ../../../index.php');
    exit();
}

/* --------------------------------
   -- FIN VALIDACION CAMPOS -------
   -------------------------------- */

/* --------------------------------
   -- INICIO CONSULTA USUARIO -----
   -------------------------------- */

// Prepara la consulta del usuario en la base de datos
$consulta_usuario = $mysqli->prepare("
    SELECT id, usuario, password, nombre_usuario
    FROM usuarios
    WHERE usuario = ?
    LIMIT 1
");

// Valida si la consulta preparada fallo
if (!$consulta_usuario) {
    $_SESSION['mensaje_error_login'] = 'Ocurrio un error al preparar la consulta del usuario.';
    header('Location: ../../../index.php');
    exit();
}

// Asigna el parametro usuario a la consulta preparada
$consulta_usuario->bind_param("s", $usuario);

// Ejecuta la consulta preparada
$consulta_usuario->execute();

// Obtiene el resultado de la consulta
$resultado_usuario = $consulta_usuario->get_result();

/* -----------------------------
   -- FIN CONSULTA USUARIO -----
   ----------------------------- */

/* --------------------------------------
   -- INICIO VALIDACION EXISTENCIA ------
   -------------------------------------- */

// Valida si se encontro el usuario en la base de datos
if ($resultado_usuario->num_rows <= 0) {
    $_SESSION['mensaje_error_login'] = 'El usuario no existe en el sistema.';
    $consulta_usuario->close();
    $mysqli->close();
    header('Location: ../../../index.php');
    exit();
}

// Obtiene los datos del usuario encontrado
$fila_usuario = $resultado_usuario->fetch_assoc();

/* -----------------------------------
   -- FIN VALIDACION EXISTENCIA ------
   ----------------------------------- */

/* ------------------------------------
   -- INICIO VALIDACION PASSWORD ------
   ------------------------------------ */

// Guarda la contraseña almacenada en la base de datos
$password_bd = isset($fila_usuario['password']) ? $fila_usuario['password'] : '';

// Inicializa la validacion del acceso
$acceso_valido = false;

// Detecta si la contraseña almacenada ya corresponde a un hash
$informacion_hash = password_get_info($password_bd);

// Caso 1: la contraseña ya está hasheada
if (isset($informacion_hash['algo']) && $informacion_hash['algo'] !== 0) {
    if (password_verify($password, $password_bd)) {
        $acceso_valido = true;

        // Si el hash necesita actualizarse, se regenera automaticamente
        if (password_needs_rehash($password_bd, PASSWORD_DEFAULT)) {
            $nuevo_hash = password_hash($password, PASSWORD_DEFAULT);

            $actualizar_password = $mysqli->prepare("UPDATE usuarios SET password = ? WHERE id = ? LIMIT 1");
            if ($actualizar_password) {
                $actualizar_password->bind_param("si", $nuevo_hash, $fila_usuario['id']);
                $actualizar_password->execute();
                $actualizar_password->close();
            }
        }
    }
}
// Caso 2: la contraseña aún está en texto plano (compatibilidad temporal)
else {
    if ($password === $password_bd) {
        $acceso_valido = true;

        // Migra automaticamente la contraseña antigua a hash
        $nuevo_hash = password_hash($password, PASSWORD_DEFAULT);

        $actualizar_password = $mysqli->prepare("UPDATE usuarios SET password = ? WHERE id = ? LIMIT 1");
        if ($actualizar_password) {
            $actualizar_password->bind_param("si", $nuevo_hash, $fila_usuario['id']);
            $actualizar_password->execute();
            $actualizar_password->close();
        }
    }
}

// Valida si la contraseña ingresada coincide con la base de datos
if (!$acceso_valido) {
    $_SESSION['mensaje_error_login'] = 'La contraseña ingresada es incorrecta.';
    $consulta_usuario->close();
    $mysqli->close();
    header('Location: ../../../index.php');
    exit();
}

/* ---------------------------------
   -- FIN VALIDACION PASSWORD ------
   --------------------------------- */

/* -----------------------------------
   -- INICIO CREACION SESION USUARIO -
   ----------------------------------- */

// Regenera el id de sesion por seguridad
session_regenerate_id(true);

// Guarda el id del usuario autenticado en la sesion
$_SESSION['id_usuario'] = $fila_usuario['id'];

// Guarda el usuario autenticado en la sesion
$_SESSION['usuario'] = $fila_usuario['usuario'];

// Guarda el nombre del usuario autenticado en la sesion
$_SESSION['nombre_usuario'] = $fila_usuario['nombre_usuario'];

// Limpia mensajes antiguos si existieran
unset($_SESSION['mensaje_error_login']);

/* --------------------------------
   -- FIN CREACION SESION USUARIO -
   -------------------------------- */

/* -------------------------------
   -- INICIO CIERRE CONSULTA -----
   ------------------------------- */

// Cierra la consulta preparada
$consulta_usuario->close();

// Cierra la conexion a la base de datos
$mysqli->close();

/* ----------------------------
   -- FIN CIERRE CONSULTA -----
   ---------------------------- */

/* -------------------------------
   -- INICIO REDIRECCION PANEL ---
   ------------------------------- */

// Redirecciona al panel principal del sistema
header('Location: ../../../php/programa/informes/panel.php');
exit();

/* ----------------------------
   -- FIN REDIRECCION PANEL ---
   ---------------------------- */

/* ------------------------------------------------------------------------------------------------------------
   --------------------------------- FIN ITred Spa login_validar .PHP ----------------------------------------
   ------------------------------------------------------------------------------------------------------------ */
?>