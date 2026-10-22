<?php require_once '_init.php'; ?>



    <?php
        // Inicializa el texto de búsqueda
        $buscar = '';

        // Inicializa mensaje del módulo
        $mensaje_mis_informes = '';

        // Inicializa clase visual del mensaje
        $clase_mensaje_mis_informes = '';

        // Valida si llega un texto de búsqueda por GET
        if(isset($_GET['buscar'])){

            // Guarda y limpia el texto recibido
            $buscar = trim($_GET['buscar']);
        }

        // Valida si llega un texto de búsqueda por POST
        if(isset($_POST['buscar'])){

            // Guarda y limpia el texto recibido
            $buscar = trim($_POST['buscar']);
        }
    ?>





    <?php
        // Valida si existe un mensaje previo del sistema en sesion
        if(isset($_SESSION['mensaje_mis_informes'])){

            // Guarda el mensaje recibido
            $mensaje_mis_informes = $_SESSION['mensaje_mis_informes'];

            // Define clase visual de mensaje
            $clase_mensaje_mis_informes = 'mis_informes_respuesta_ok';

            // Elimina el mensaje despues de leerlo
            unset($_SESSION['mensaje_mis_informes']);
        }
    ?>





    <?php
        // Valida si existe búsqueda ingresada
        if($buscar !== ''){

            // Agrega comodines para la consulta LIKE
            $buscar_like = '%' . $buscar . '%';

            // Prepara la consulta filtrada de informes asociados al usuario
            $consulta_informes = $mysqli->prepare("
                SELECT id, nombre_informe, fecha_creacion
                FROM informes
                WHERE id_usuario = ?
                AND nombre_informe LIKE ?
                ORDER BY id DESC
            ");

            // Valida si la consulta preparada fallo
            if(!$consulta_informes){

                // Guarda mensaje de error en sesion
                $_SESSION['mensaje_mis_informes'] = 'Ocurrió un error al preparar la búsqueda de informes.';

                // Redirecciona al panel principal
                header('Location: panel.php?vista=buscar');
                exit();
            }

            // Asigna el id del usuario y el texto de busqueda a la consulta preparada
            $consulta_informes->bind_param("is", $id_usuario, $buscar_like);

        }else{

            // Prepara la consulta completa de informes asociados al usuario
            $consulta_informes = $mysqli->prepare("
                SELECT id, nombre_informe, fecha_creacion
                FROM informes
                WHERE id_usuario = ?
                ORDER BY id DESC
            ");

            // Valida si la consulta preparada fallo
            if(!$consulta_informes){

                // Guarda mensaje de error en sesion
                $_SESSION['mensaje_mis_informes'] = 'Ocurrió un error al preparar la consulta de informes.';

                // Redirecciona al panel principal
                header('Location: panel.php?vista=buscar');
                exit();
            }

            // Asigna el id del usuario a la consulta preparada
            $consulta_informes->bind_param("i", $id_usuario);
        }

        // Ejecuta la consulta preparada
        $consulta_informes->execute();

        // Obtiene el resultado de la consulta
        $resultado_informes = $consulta_informes->get_result();
    ?>



<!DOCTYPE html>
<html lang="es">
<head>

    

        
        <meta charset="UTF-8">

        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        
        <title>mis_informes</title>

        

            
            <link rel="stylesheet" href="../../../css/programa/informes/mis_informes.css">

</head>



    <body>

        

            
            <main class="mis_informes_contenedor_principal">

                

                    
                    <section class="mis_informes_cabecera_superior">

                        

                            
                            <div class="mis_informes_cabecera_izquierda">

                                

                                    
                                    <div class="mis_informes_flechas">

                                        
                                        <a href="panel.php?vista=nuevo" class="mis_informes_flecha" aria-label="Ir a nuevo informe">&larr;</a>

                                        
                                        <a href="panel.php?vista=buscar" class="mis_informes_flecha" aria-label="Ir a buscar informe">&rarr;</a>

                                    </div>


                                

                                    
                                    <a href="panel.php?vista=nuevo" class="mis_informes_boton_cabecera">
                                        NUEVO INFORME
                                    </a>


                                

                                    
                                    <a href="mis_informes.php" class="mis_informes_boton_cabecera mis_informes_boton_cabecera_activo">
                                        BUSCAR INFORME
                                    </a>

                            </div>


                        

                            
                            <div class="mis_informes_cabecera_derecha">

                                

                                    
                                    <p class="mis_informes_usuario">
                                        USUARIO:
                                        <span class="mis_informes_usuario_nombre">
                                            <?php
                                                // Muestra el nombre del usuario autenticado
                                                echo htmlspecialchars($nombre_usuario);
                                            ?>
                                        </span>
                                    </p>


                                

                                    
                                    <form method="POST" action="../login/cerrar_sesion.php" class="mis_informes_formulario_cerrar_sesion">

                                        
                                        <button type="submit" name="cerrar_sesion" value="1" class="mis_informes_boton_cerrar_sesion">
                                            CERRAR SESI&Oacute;N
                                        </button>

                                    </form>

                            </div>

                    </section>


                

                    
                    <section class="mis_informes_contenido">

                        

                            
                            <h1 class="mis_informes_titulo_principal">BUSCAR INFORME</h1>


                        

                            
                            <form method="GET" action="mis_informes.php" class="mis_informes_formulario_busqueda">

                                
                                <label for="buscar" class="mis_informes_etiqueta_principal">
                                    INGRESAR NOMBRE INFORME:
                                </label>

                                
                                <input
                                    type="text"
                                    name="buscar"
                                    id="buscar"
                                    class="mis_informes_input_principal"
                                    value="<?php echo htmlspecialchars($buscar); ?>"
                                    placeholder="Nombre del informe"
                                >

                                
                                <button type="submit" class="mis_informes_boton_principal mis_informes_boton_principal_buscar" aria-label="Buscar informe">
                                    &#128269;
                                </button>

                            </form>


                        

                            
                            <?php
                                if($mensaje_mis_informes !== ''){
                            ?>
                                <p class="mis_informes_respuesta <?php echo $clase_mensaje_mis_informes; ?>">
                                    <?php
                                        // Muestra el mensaje almacenado
                                        echo htmlspecialchars($mensaje_mis_informes);
                                    ?>
                                </p>
                            <?php
                                }
                            ?>


                        

                            
                            <div class="mis_informes_listado">

                                <?php
                                    // Valida si no existen informes para el usuario o para el filtro aplicado
                                    if($resultado_informes->num_rows <= 0){
                                ?>

                                    

                                        
                                        <p class="mis_informes_sin_registros">
                                            <?php
                                                // Valida si se buscó un nombre especifico
                                                if($buscar !== ''){
                                                    echo 'No se encontraron informes para la búsqueda ingresada.';
                                                }else{
                                                    echo 'No tienes informes registrados.';
                                                }
                                            ?>
                                        </p>

                                <?php
                                    }else{
                                        // Recorre cada informe obtenido en la consulta
                                        while($fila_informe = $resultado_informes->fetch_assoc()){
                                ?>

                                    

                                        
                                        <div class="mis_informes_tarjeta">

                                            

                                                
                                                <div class="mis_informes_datos">

                                                    
                                                    <h2 class="mis_informes_nombre">
                                                        <?php
                                                            // Muestra el nombre del informe
                                                            echo htmlspecialchars($fila_informe['nombre_informe']);
                                                        ?>
                                                    </h2>

                                                    
                                                    <p class="mis_informes_fecha">
                                                        FECHA:
                                                        <?php
                                                            // Valida si el informe tiene fecha de creacion registrada
                                                            if(!empty($fila_informe['fecha_creacion'])){

                                                                // Muestra la fecha de creacion del informe
                                                                echo htmlspecialchars($fila_informe['fecha_creacion']);
                                                            }else{

                                                                // Muestra texto por defecto si no existe fecha
                                                                echo 'Sin fecha registrada';
                                                            }
                                                        ?>
                                                    </p>

                                                </div>


                                            

                                                
                                                <div class="mis_informes_acciones">

                                                    

                                                        
                                                        <form method="GET" action="portada.php" class="mis_informes_accion">

                                                            
                                                            <input type="hidden" name="id_informe" value="<?php echo (int)$fila_informe['id']; ?>">

                                                            
                                                            <button type="submit" class="mis_informes_boton_accion">
                                                                ABRIR INFORME
                                                            </button>

                                                        </form>


                                                    

                                                        
                                                        <form method="GET" action="eliminar_informe.php" class="mis_informes_accion">

                                                            
                                                            <input type="hidden" name="id_informe" value="<?php echo (int)$fila_informe['id']; ?>">

                                                            
                                                            <button type="submit" class="mis_informes_boton_accion">
                                                                ELIMINAR INFORME
                                                            </button>

                                                        </form>

                                                </div>

                                        </div>

                                <?php
                                        }
                                    }
                                ?>

                            </div>


                        

                            
                            <div class="mis_informes_logo_inferior">

                                
                                <img
                                    src="../../../imagenes/logo_itred.png"
                                    alt="Logo Itred"
                                    class="mis_informes_logo_imagen"
                                    onerror="
                                        if(this.dataset.intento !== '1'){
                                            this.dataset.intento='1';
                                            this.src='../../../imagenes/programa/logo_itred.png';
                                        }else if(this.dataset.intento !== '2'){
                                            this.dataset.intento='2';
                                            this.src='../../../img/logo_itred.png';
                                        }else if(this.dataset.intento !== '3'){
                                            this.dataset.intento='3';
                                            this.src='../../../logo_itred.png';
                                        }else{
                                            this.style.display='none';
                                        }
                                    "
                                >

                            </div>

                    </section>

            </main>


        

            
            <script src="../../../js/programa/informes/mis_informes.js"></script>

    </body>
</html>



    <?php
        // Cierra la consulta preparada
        $consulta_informes->close();

        // Cierra la conexion a la base de datos
        $mysqli->close();
    ?>






