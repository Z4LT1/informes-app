<?php require_once '_init.php'; ?>



    <?php
        // Inicializa el nombre del informe
        $nombre_informe = '';

        // Inicializa el mensaje del panel
        $mensaje_panel = '';

        // Inicializa la clase del mensaje
        $clase_mensaje_panel = '';

        // Define la vista actual del panel
        $vista_panel = 'nuevo';
    ?>





    <?php
        // Valida si se recibió una vista por GET
        if(isset($_GET['vista'])){

            // Guarda la vista solicitada
            $vista_recibida = trim($_GET['vista']);

            // Valida las vistas permitidas
            if($vista_recibida === 'buscar'){
                $vista_panel = 'buscar';
            }else{
                $vista_panel = 'nuevo';
            }
        }
    ?>





    <?php
        // Valida si se envió el formulario para crear un nuevo informe
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_informe'])){

            // Fuerza la vista nuevo informe
            $vista_panel = 'nuevo';

            // Guarda y limpia el nombre del informe
            $nombre_informe = isset($_POST['nombre_informe']) ? trim($_POST['nombre_informe']) : '';

            // Valida si el nombre viene vacío
            if($nombre_informe === ''){

                // Guarda mensaje de error
                $mensaje_panel = 'Debe ingresar el nombre del informe.';
                $clase_mensaje_panel = 'panel_mensaje_error';

            }else{

                // Prepara la insercion del informe
                $insertar_informe = $mysqli->prepare("
                    INSERT INTO informes (
                        id_usuario,
                        nombre_informe,
                        solicitado_por,
                        cargo,
                        fecha_creacion
                    ) VALUES (?, ?, '', '', NOW())
                ");

                // Valida si la consulta preparada existe
                if($insertar_informe){

                    // Asigna los valores a la consulta preparada
                    $insertar_informe->bind_param("is", $id_usuario, $nombre_informe);

                    // Ejecuta la insercion del informe
                    if($insertar_informe->execute()){

                        // Guarda el id del nuevo informe creado
                        $id_informe_nuevo = (int)$insertar_informe->insert_id;

                        // Cierra la consulta preparada
                        $insertar_informe->close();

                        // Redirecciona de inmediato a la portada del informe nuevo
                        header('Location: portada.php?id_informe=' . $id_informe_nuevo);
                        exit();

                    }else{

                        // Guarda mensaje de error
                        $mensaje_panel = 'Ocurrió un error al crear el informe.';
                        $clase_mensaje_panel = 'panel_mensaje_error';

                        // Cierra la consulta preparada
                        $insertar_informe->close();
                    }

                }else{

                    // Guarda mensaje de error
                    $mensaje_panel = 'Ocurrió un error al preparar el nuevo informe.';
                    $clase_mensaje_panel = 'panel_mensaje_error';
                }
            }
        }
    ?>





    <?php
        // Inicializa el texto de búsqueda
        $buscar_informe = '';

        // Inicializa el resultado de búsqueda
        $resultado_busqueda = false;

        // Valida si se envió el formulario de buscar informe
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buscar_informe_submit'])){

            // Fuerza la vista buscar informe
            $vista_panel = 'buscar';

            // Guarda y limpia el nombre a buscar
            $buscar_informe = isset($_POST['buscar_informe']) ? trim($_POST['buscar_informe']) : '';

            // Valida si el campo de búsqueda está vacío
            if($buscar_informe === ''){

                // Guarda mensaje de error
                $mensaje_panel = 'Debe ingresar un nombre para buscar.';
                $clase_mensaje_panel = 'panel_mensaje_error';

            }else{

                // Redirecciona al listado real de informes del usuario
                header('Location: mis_informes.php?buscar=' . urlencode($buscar_informe));
                exit();
            }
        }
    ?>



<!DOCTYPE html>
<html lang="es">
<head>

    

        
        <meta charset="UTF-8">

        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        
        <title>panel</title>

        

            
            <link rel="stylesheet" href="../../../css/programa/informes/panel.css">

</head>



    <body>

        

            
            <main class="panel_contenedor_principal">

                

                    
                    <section class="panel_cabecera_superior">

                        

                            
                            <div class="panel_cabecera_izquierda">

                                

                                    
                                    <div class="panel_flechas">

                                        
                                        <a href="panel.php?vista=nuevo" class="panel_flecha" aria-label="Ir a nuevo informe">&larr;</a>

                                        
                                        <a href="panel.php?vista=buscar" class="panel_flecha" aria-label="Ir a buscar informe">&rarr;</a>

                                    </div>


                                

                                    
                                    <a
                                        href="panel.php?vista=nuevo"
                                        class="panel_boton_cabecera <?php echo ($vista_panel === 'nuevo') ? 'panel_boton_cabecera_activo' : ''; ?>"
                                    >
                                        NUEVO INFORME
                                    </a>


                                

                                    
                                    <a
                                        href="panel.php?vista=buscar"
                                        class="panel_boton_cabecera <?php echo ($vista_panel === 'buscar') ? 'panel_boton_cabecera_activo' : ''; ?>"
                                    >
                                        BUSCAR INFORME
                                    </a>

                            </div>


                        

                            
                            <div class="panel_cabecera_derecha">

                                

                                    
                                    <p class="panel_usuario">
                                        USUARIO:
                                        <span class="panel_usuario_nombre">
                                            <?php
                                                // Muestra el nombre del usuario autenticado
                                                echo htmlspecialchars($nombre_usuario);
                                            ?>
                                        </span>
                                    </p>


                                

                                    
                                    <form method="POST" action="../login/cerrar_sesion.php" class="panel_formulario_cerrar_sesion">

                                        
                                        <button type="submit" name="cerrar_sesion" value="1" class="panel_boton_cerrar_sesion">
                                            CERRAR SESI&Oacute;N
                                        </button>

                                    </form>

                            </div>

                    </section>


                

                    
                    <section class="panel_contenido">

                        

                            <?php
                                // Valida si existe un mensaje del sistema
                                if($mensaje_panel !== ''){
                            ?>
                                <p class="panel_mensaje <?php echo $clase_mensaje_panel; ?>">
                                    <?php
                                        // Muestra el mensaje del panel
                                        echo htmlspecialchars($mensaje_panel);
                                    ?>
                                </p>
                            <?php
                                }
                            ?>


                        <?php
                            // Valida la vista actual del panel
                            if($vista_panel === 'buscar'){
                        ?>

                            

                                
                                <section class="panel_bloque_central">

                                    
                                    <h1 class="panel_titulo_principal">BUSCAR INFORME</h1>

                                    
                                    <form method="POST" action="panel.php?vista=buscar" class="panel_formulario_principal">

                                        
                                        <label for="buscar_informe" class="panel_etiqueta_principal">
                                            INGRESAR NOMBRE INFORME:
                                        </label>

                                        
                                        <input
                                            type="text"
                                            name="buscar_informe"
                                            id="buscar_informe"
                                            class="panel_input_principal"
                                            value="<?php echo htmlspecialchars($buscar_informe); ?>"
                                            placeholder="Nombre del informe"
                                            required
                                        >

                                        
                                        <button type="submit" name="buscar_informe_submit" value="1" class="panel_boton_principal panel_boton_principal_buscar" aria-label="Buscar informe">
                                            &#128269;
                                        </button>

                                    </form>

                                </section>

                        <?php
                            }else{
                        ?>

                            

                                
                                <section class="panel_bloque_central">

                                    
                                    <h1 class="panel_titulo_principal">NUEVO INFORME</h1>

                                    
                                    <form method="POST" action="panel.php?vista=nuevo" class="panel_formulario_principal">

                                        
                                        <label for="nombre_informe" class="panel_etiqueta_principal">
                                            INGRESAR NOMBRE INFORME:
                                        </label>

                                        
                                        <input
                                            type="text"
                                            name="nombre_informe"
                                            id="nombre_informe"
                                            class="panel_input_principal"
                                            value="<?php echo htmlspecialchars($nombre_informe); ?>"
                                            placeholder="Nombre del informe"
                                            required
                                        >

                                        
                                        <button type="submit" name="crear_informe" value="1" class="panel_boton_principal">
                                            GUARDAR
                                        </button>

                                    </form>

                                </section>

                        <?php
                            }
                        ?>


                        

                            
                            <div class="panel_logo_inferior">

                                
                                <img
                                    src="../../../imagenes/logo_itred.png"
                                    alt="Logo Itred"
                                    class="panel_logo_imagen"
                                >

                            </div>

                    </section>

            </main>


        

            
            <script src="../../../js/programa/informes/panel.js"></script>

    </body>
</html>



    <?php
        // Cierra la conexion a la base de datos
        $mysqli->close();
    ?>






