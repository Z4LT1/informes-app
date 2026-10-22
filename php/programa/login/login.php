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
     ------------------------------------ INICIO ITred Spa login .PHP ------------------------------------------
     ------------------------------------------------------------------------------------------------------------ -->

<!-- ------------------------
     -- INICIO CONEXION BD --
     ------------------------ -->

<?php
// Carga la conexión centralizada (ya incluida desde index.php)
require_once __DIR__ . '/../../config/conexion.php';
?>

<!-- ---------------------
     -- FIN CONEXION BD --
     --------------------- -->

<!-- ------------------------
     -- INICIO SESION PHP --
     ------------------------ -->

<?php
// Inicia la sesion solo si aun no existe
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- ---------------------
     -- FIN SESION PHP --
     --------------------- -->

<!-- TITULO LLAMADO ARCHIVO CSS -->
<link rel="stylesheet" href="css/programa/login/login.css">

<!-- TITULO CONTENEDOR LOGIN -->

<main class="login_contenedor_principal">

    <!-- TITULO BIENVENIDA -->

    <section class="login_bienvenida">

        <h1 class="login_bienvenida_titulo">
            BIENVENIDO A NUESTRO <br>
            CREADOR DE INFORME DE <br>
            PROYECTOS
        </h1>

    </section>


    <!-- TITULO CONTENEDOR LOGIN VISUAL -->

    <section class="login_area_central">

        <!-- TITULO LOGO ITRED -->

        <div class="login_logo">

            <!-- Ajustar ruta según tu carpeta imagenes -->
            <img src="imagenes/logo_itred.png" alt="Logo ITred">

        </div>


        <!-- TITULO FORMULARIO LOGIN -->

        <div class="login_contenedor_formulario">

            <form id="form_login" class="login_formulario" method="POST" action="php/programa/login/login_validar.php">

                <!-- TITULO CAMPO USUARIO -->

                <div class="login_grupo_campo">

                    <label for="usuario" class="login_usuario">
                        INGRESAR USUARIO
                    </label>

                    <input
                        type="text"
                        name="usuario"
                        id="usuario"
                        class="login_input"
                        maxlength="120"
                        autocomplete="username"
                        required
                    >

                </div>


                <!-- TITULO CAMPO PASSWORD -->

                <div class="login_grupo_campo">

                    <label for="password" class="login_etiqueta">
                        INGRESAR CONTRASEÑA
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="login_input"
                        maxlength="120"
                        autocomplete="current-password"
                        required
                    >

                </div>


                <!-- TITULO MENSAJE RESPUESTA LOGIN -->

                <p id="login_respuesta" class="login_respuesta">
                    <?php
                        if(isset($_SESSION['mensaje_error_login'])){
                            echo $_SESSION['mensaje_error_login'];
                            unset($_SESSION['mensaje_error_login']);
                        }
                    ?>
                </p>


                <!-- TITULO BOTON LOGIN -->

                <div class="login_contenedor_boton">

                    <button type="submit" class="login_boton">
                        INICIAR SESIÓN
                    </button>

                </div>

            </form>

        </div>

    </section>

</main>

<script src="js/programa/login/login.js"></script>

<!-- ------------------------------------------------------------------------------------------------------------
     ------------------------------------- FIN ITred Spa login .PHP --------------------------------------------
     ------------------------------------------------------------------------------------------------------------ -->