<?php require_once '_init.php'; ?>



    <?php
        // Guarda el id del informe recibido por GET o POST
        $id_informe = 0;

        // Valida si llega el id del informe por metodo GET
        if(isset($_GET['id_informe'])){

            // Convierte el id recibido a numero entero
            $id_informe = (int)$_GET['id_informe'];
        }

        // Valida si llega el id del informe por metodo POST
        if(isset($_POST['id_informe'])){

            // Convierte el id recibido a numero entero
            $id_informe = (int)$_POST['id_informe'];
        }

        // Valida si no existe un id de informe valido
        if($id_informe <= 0){

            // Guarda mensaje de error en sesion
            $_SESSION['mensaje_mis_informes'] = 'El informe seleccionado no es válido.';

            // Redirecciona al listado de informes
            header('Location: mis_informes.php');
            exit();
        }
    ?>





    <?php
        // Prepara la consulta del informe asociado al usuario autenticado
        $consulta_informe = $mysqli->prepare("SELECT id, nombre_informe FROM informes WHERE id = ? AND id_usuario = ? LIMIT 1");

        // Valida si la consulta preparada fallo
        if(!$consulta_informe){

            // Guarda mensaje de error en sesion
            $_SESSION['mensaje_mis_informes'] = 'Ocurrió un error al preparar la consulta del informe.';

            // Redirecciona al listado de informes
            header('Location: mis_informes.php');
            exit();
        }

        // Asigna el id del informe y el id del usuario a la consulta preparada
        $consulta_informe->bind_param("ii", $id_informe, $id_usuario);

        // Ejecuta la consulta preparada
        $consulta_informe->execute();

        // Obtiene el resultado de la consulta
        $resultado_informe = $consulta_informe->get_result();

        // Valida si el informe no existe o no pertenece al usuario
        if($resultado_informe->num_rows <= 0){

            // Cierra la consulta preparada
            $consulta_informe->close();

            // Guarda mensaje de error en sesion
            $_SESSION['mensaje_mis_informes'] = 'No se encontró el informe solicitado.';

            // Redirecciona al listado de informes
            header('Location: mis_informes.php');
            exit();
        }

        // Obtiene los datos del informe encontrado
        $fila_informe = $resultado_informe->fetch_assoc();

        // Cierra la consulta preparada
        $consulta_informe->close();
    ?>





    <?php
        // Valida si la solicitud llega por POST con confirmacion de eliminacion
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_eliminacion'])){

            // Prepara la eliminacion del informe asociado al usuario autenticado
            $eliminar_informe = $mysqli->prepare("DELETE FROM informes WHERE id = ? AND id_usuario = ?");

            // Valida si la consulta preparada fallo
            if(!$eliminar_informe){

                // Guarda mensaje de error en sesion
                $_SESSION['mensaje_mis_informes'] = 'Ocurrió un error al preparar la eliminación del informe.';

                // Redirecciona al listado de informes
                header('Location: mis_informes.php');
                exit();
            }

            // Asigna el id del informe y el id del usuario a la consulta preparada
            $eliminar_informe->bind_param("ii", $id_informe, $id_usuario);

            // Ejecuta la eliminacion del informe
            $eliminar_informe->execute();

            // Valida si se elimino correctamente el informe
            if($eliminar_informe->affected_rows > 0){

                // Guarda mensaje de exito en sesion
                $_SESSION['mensaje_mis_informes'] = 'El informe fue eliminado correctamente.';
            }else{

                // Guarda mensaje de error en sesion
                $_SESSION['mensaje_mis_informes'] = 'No fue posible eliminar el informe seleccionado.';
            }

            // Cierra la consulta preparada
            $eliminar_informe->close();

            // Redirecciona al listado de informes
            header('Location: mis_informes.php');
            exit();
        }
    ?>



<!DOCTYPE html>
<html lang="es">
<head>

    

        
        <meta charset="UTF-8">

        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        
        <title>eliminar_informe</title>

        <!-- icono de la pestaña del navegador -->
        <link rel="icon" type="image/png" href="../../../imagenes/favicon.png">

        

            
            <link rel="stylesheet" href="../../../css/programa/informes/eliminar_informe.css">

</head>



    <body>

        

            
            <main class="eliminar_informe_contenedor_principal">

                

                    
                    <section class="eliminar_informe_contenido">

                        

                            
                            <h1 class="eliminar_informe_titulo">ELIMINAR INFORME</h1>


                        

                            
                            <p class="eliminar_informe_mensaje">
                                Estas seguro de que deseas eliminar este informe?
                            </p>


                        

                            
                            <p class="eliminar_informe_nombre">
                                <?php
                                    // Muestra el nombre del informe seleccionado
                                    echo htmlspecialchars($fila_informe['nombre_informe']);
                                ?>
                            </p>


                        

                            
                            <form method="POST" class="eliminar_informe_formulario">

                                
                                <input type="hidden" name="id_informe" value="<?php echo (int)$fila_informe['id']; ?>">

                                
                                <button type="submit" name="confirmar_eliminacion" value="1" class="eliminar_informe_boton">
                                    SI, ELIMINAR INFORME
                                </button>

                            </form>


                        

                            
                            <form method="POST" action="mis_informes.php" class="eliminar_informe_formulario">

                                
                                <button type="submit" class="eliminar_informe_boton">
                                    NO, VOLVER A MIS INFORMES
                                </button>

                            </form>

                    </section>

            </main>


        

            
            <script src="../../../js/programa/informes/eliminar_informe.js"></script>

    </body>
</html>


    





