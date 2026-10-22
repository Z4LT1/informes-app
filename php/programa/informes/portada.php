<?php
    require_once __DIR__ . '/../../config/conexion.php';

    session_start();

    if(!isset($_SESSION['id_usuario'])){
        header('Location: ../../../index.php');
        exit();
    }

    require_once 'portada_funciones.php';
    require_once 'portada_exportacion.php';
    require_once 'portada_datos.php';

    $id_usuario = (int)$_SESSION['id_usuario'];
    $nombre_usuario_sesion = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : '';

    $id_informe = 0;
    $nombre_informe = '';
    $area_trabajo = '';
    $nombre_1 = '';
    $nombre_2 = '';
    $nombre_3 = '';
    $nombre_4 = '';
    $proyecto = '';
    $avance = '';
    $solicitado_por = 'Barner Piña Jara';
    $cargo = 'CEO';
    $fecha_entrega = '';
    $indice = '';
    $filas_indice = array();
    $mensaje_portada = '';
    $clase_mensaje_portada = '';

    $es_informe_existente = false;
    $modo_edicion = true;

    function actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario){
        $filas_indice_nuevas = construir_indice_desde_secciones($mysqli, $id_informe, $id_usuario);
        $texto_indice_nuevo = generar_texto_indice_desde_array($filas_indice_nuevas);

        $informe_actual = cargar_informe($mysqli, $id_informe, $id_usuario);
        if(!$informe_actual){
            return false;
        }

        $informe_actual['indice'] = $texto_indice_nuevo;
        return actualizar_informe($mysqli, $informe_actual, $id_informe, $id_usuario);
    }

    function normalizar_nivel_titulo($nivel, $default = '1'){
        $nivel = trim((string)$nivel);
        if(!ctype_digit($nivel)){
            return (string)$default;
        }

        $nivel_entero = (int)$nivel;
        if($nivel_entero < 1 || $nivel_entero > 20){
            return (string)$default;
        }

        return (string)$nivel_entero;
    }

    if(isset($_GET['id_informe'])){
        $id_informe = (int)$_GET['id_informe'];
    }

    if(isset($_POST['id_informe'])){
        $id_informe = (int)$_POST['id_informe'];
    }

    if($id_informe > 0){
        $fila_portada = cargar_informe($mysqli, $id_informe, $id_usuario);

        if($fila_portada){
            $es_informe_existente = true;
            $modo_edicion = false;

            $nombre_informe = isset($fila_portada['nombre_informe']) ? $fila_portada['nombre_informe'] : '';
            $area_trabajo = isset($fila_portada['area_trabajo']) ? $fila_portada['area_trabajo'] : '';
            $nombre_1 = isset($fila_portada['nombre_1']) ? $fila_portada['nombre_1'] : '';
            $nombre_2 = isset($fila_portada['nombre_2']) ? $fila_portada['nombre_2'] : '';
            $nombre_3 = isset($fila_portada['nombre_3']) ? $fila_portada['nombre_3'] : '';
            $nombre_4 = isset($fila_portada['nombre_4']) ? $fila_portada['nombre_4'] : '';
            $proyecto = isset($fila_portada['proyecto']) ? $fila_portada['proyecto'] : '';
            $avance = isset($fila_portada['avance']) ? $fila_portada['avance'] : '';
            $solicitado_por = isset($fila_portada['solicitado_por']) ? $fila_portada['solicitado_por'] : '';
            $cargo = isset($fila_portada['cargo']) ? $fila_portada['cargo'] : '';
            $fecha_entrega = isset($fila_portada['fecha_entrega']) ? $fila_portada['fecha_entrega'] : '';
            $indice = isset($fila_portada['indice']) ? $fila_portada['indice'] : '';
        }
    }

    if($es_informe_existente && isset($_GET['editar']) && $_GET['editar'] === '1'){
        $modo_edicion = true;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_portada'])){

        $nombre_informe = isset($_POST['nombre_informe']) ? trim($_POST['nombre_informe']) : '';
        $area_trabajo = isset($_POST['area_trabajo']) ? trim($_POST['area_trabajo']) : '';
        $nombre_1 = isset($_POST['nombre_1']) ? trim($_POST['nombre_1']) : '';
        $nombre_2 = isset($_POST['nombre_2']) ? trim($_POST['nombre_2']) : '';
        $nombre_3 = isset($_POST['nombre_3']) ? trim($_POST['nombre_3']) : '';
        $nombre_4 = isset($_POST['nombre_4']) ? trim($_POST['nombre_4']) : '';
        $proyecto = isset($_POST['proyecto']) ? trim($_POST['proyecto']) : '';
        $avance = isset($_POST['avance']) ? trim($_POST['avance']) : '';
        $solicitado_por = isset($_POST['solicitado_por']) ? trim($_POST['solicitado_por']) : '';
        $cargo = isset($_POST['cargo']) ? trim($_POST['cargo']) : '';
        $fecha_entrega = isset($_POST['fecha_entrega']) ? trim($_POST['fecha_entrega']) : '';

        $filas_indice_guardado = convertir_texto_a_indice($indice);

        $indice = generar_texto_indice_desde_array($filas_indice_guardado);

        if($nombre_informe === ''){
            $mensaje_portada = 'Debe ingresar el nombre del informe.';
            $clase_mensaje_portada = 'portada_respuesta_error';
            $modo_edicion = true;
        }else{

            $datos_guardado = array(
                'nombre_informe' => $nombre_informe,
                'area_trabajo'   => $area_trabajo,
                'nombre_1'       => $nombre_1,
                'nombre_2'       => $nombre_2,
                'nombre_3'       => $nombre_3,
                'nombre_4'       => $nombre_4,
                'proyecto'       => $proyecto,
                'avance'         => $avance,
                'solicitado_por' => $solicitado_por,
                'cargo'          => $cargo,
                'fecha_entrega'  => $fecha_entrega,
                'indice'         => $indice
            );

            if($es_informe_existente){

                if(actualizar_informe($mysqli, $datos_guardado, $id_informe, $id_usuario)){
                    header('Location: portada.php?id_informe=' . (int)$id_informe . '&guardado=1');
                    exit();
                }else{
                    $mensaje_portada = 'Ocurrió un error al actualizar la portada del informe.';
                    $clase_mensaje_portada = 'portada_respuesta_error';
                    $modo_edicion = true;
                }

            }else{

                $nuevo_id = insertar_informe($mysqli, $datos_guardado, $id_usuario);

                if($nuevo_id !== false){
                    header('Location: portada.php?id_informe=' . $nuevo_id . '&guardado=1');
                    exit();
                }else{
                    $mensaje_portada = 'Ocurrió un error al crear el informe.';
                    $clase_mensaje_portada = 'portada_respuesta_error';
                    $modo_edicion = true;
                }
            }
        }
    }

    if(isset($_GET['guardado']) && $_GET['guardado'] === '1'){
        $mensaje_portada = 'El informe fue guardado correctamente.';
        $clase_mensaje_portada = 'portada_respuesta_ok';
    }

    $filas_indice = convertir_texto_a_indice($indice);

    $logo_itred = obtener_url_logo_itred();
    $texto_nombre_informe = $nombre_informe !== '' ? $nombre_informe : 'Nombre del informe';
    $texto_fecha_entrega = $fecha_entrega !== '' ? $fecha_entrega : '';

    $mostrar_boton_modificar = $es_informe_existente && !$modo_edicion;
    $guardar_habilitado = !$es_informe_existente || $modo_edicion;
    $nombre_archivo_base = limpiar_nombre_archivo($texto_nombre_informe);

    $mensaje_introduccion = '';
    $clase_mensaje_introduccion = '';
    $nivel_titulo = '1';
    $numero_titulo = '';
    $texto_titulo = '';
    $texto_contenido = '';

    if($id_informe > 0){
        $fila_introduccion = cargar_introduccion_informe($mysqli, $id_informe, $id_usuario);

        if($fila_introduccion){
            $nivel_titulo    = isset($fila_introduccion['nivel_titulo'])    ? trim((string)$fila_introduccion['nivel_titulo'])    : $nivel_titulo;
            $numero_titulo   = isset($fila_introduccion['numero_titulo'])   ? trim((string)$fila_introduccion['numero_titulo'])   : $numero_titulo;
            $texto_titulo    = isset($fila_introduccion['texto_titulo'])    ? trim((string)$fila_introduccion['texto_titulo'])    : $texto_titulo;
            $texto_contenido = isset($fila_introduccion['texto_contenido']) ? trim((string)$fila_introduccion['texto_contenido']) : $texto_contenido;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_introduccion_base'])){
        $nivel_titulo    = isset($_POST['nivel_titulo'])    ? trim((string)$_POST['nivel_titulo'])    : $nivel_titulo;
        $numero_titulo   = isset($_POST['numero_titulo'])   ? trim((string)$_POST['numero_titulo'])   : $numero_titulo;
        $texto_titulo    = isset($_POST['texto_titulo'])    ? trim((string)$_POST['texto_titulo'])    : $texto_titulo;
        $texto_contenido = isset($_POST['texto_contenido']) ? trim((string)$_POST['texto_contenido']) : $texto_contenido;

        if(!ctype_digit($nivel_titulo) || (int)$nivel_titulo < 1 || (int)$nivel_titulo > 20){
            $nivel_titulo = '1';
        }

        if($id_informe <= 0 || !$es_informe_existente){
            $mensaje_introduccion = 'Debe guardar primero la portada del informe antes de registrar la Introducción.';
            $clase_mensaje_introduccion = 'portada_respuesta_error';
        }else{
            $datos_introduccion = array(
                'nivel_titulo'    => $nivel_titulo,
                'numero_titulo'   => $numero_titulo,
                'texto_titulo'    => $texto_titulo,
                'texto_contenido' => $texto_contenido
            );

            if(guardar_introduccion_informe($mysqli, $id_informe, $id_usuario, $datos_introduccion)){
                actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario);

                header('Location: portada.php?id_informe=' . (int)$id_informe . '&introduccion_guardada=1');
                exit();
            }

            $mensaje_introduccion = 'Ocurrió un error al guardar la sección Introducción.';
            $clase_mensaje_introduccion = 'portada_respuesta_error';
        }
    }

    if(isset($_GET['introduccion_guardada']) && $_GET['introduccion_guardada'] === '1'){
        $mensaje_introduccion = 'La sección Introducción fue guardada correctamente.';
        $clase_mensaje_introduccion = 'portada_respuesta_ok';
    }

    $nivel_titulo = normalizar_nivel_titulo($nivel_titulo, '1');

    $mensaje_base_datos = '';
    $clase_mensaje_base_datos = '';
    $nivel_titulo_bd = '1';
    $numero_titulo_bd = '';
    $texto_titulo_bd = '';
    $texto_contenido_bd = '';

    if($id_informe > 0){
        $fila_base_datos = cargar_base_datos_informe($mysqli, $id_informe, $id_usuario);

        if($fila_base_datos){
            $nivel_titulo_bd = isset($fila_base_datos['nivel_titulo']) ? trim((string)$fila_base_datos['nivel_titulo']) : $nivel_titulo_bd;
            $numero_titulo_bd = isset($fila_base_datos['numero_titulo']) ? trim((string)$fila_base_datos['numero_titulo']) : $numero_titulo_bd;
            $texto_titulo_bd = isset($fila_base_datos['texto_titulo']) ? trim((string)$fila_base_datos['texto_titulo']) : $texto_titulo_bd;
            $texto_contenido_bd = isset($fila_base_datos['texto_contenido']) ? trim((string)$fila_base_datos['texto_contenido']) : $texto_contenido_bd;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_base_datos_base'])){
        $nivel_titulo_bd = isset($_POST['nivel_titulo_bd']) ? trim((string)$_POST['nivel_titulo_bd']) : $nivel_titulo_bd;
        $numero_titulo_bd = isset($_POST['numero_titulo_bd']) ? trim((string)$_POST['numero_titulo_bd']) : $numero_titulo_bd;
        $texto_titulo_bd = isset($_POST['texto_titulo_bd']) ? trim((string)$_POST['texto_titulo_bd']) : $texto_titulo_bd;
        $texto_contenido_bd = isset($_POST['texto_contenido_bd']) ? trim((string)$_POST['texto_contenido_bd']) : $texto_contenido_bd;
    }

    $nivel_titulo_bd = normalizar_nivel_titulo($nivel_titulo_bd, '1');

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_base_datos_base'])){
        if($id_informe <= 0 || !$es_informe_existente){
            $mensaje_base_datos = 'Debe guardar primero la portada del informe antes de registrar la sección Carpeta Base de Datos.';
            $clase_mensaje_base_datos = 'portada_respuesta_error';
        }else{
            $datos_base_datos = array(
                'nivel_titulo' => $nivel_titulo_bd,
                'numero_titulo' => $numero_titulo_bd,
                'texto_titulo' => $texto_titulo_bd,
                'texto_contenido' => $texto_contenido_bd
            );

            if(guardar_base_datos_informe($mysqli, $id_informe, $id_usuario, $datos_base_datos)){
                actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario);

                header('Location: portada.php?id_informe=' . (int)$id_informe . '&base_datos_guardado=1');
                exit();
            }

            $mensaje_base_datos = 'Ocurrió un error al guardar la sección Carpeta Base de Datos.';
            $clase_mensaje_base_datos = 'portada_respuesta_error';
        }
    }

    if(isset($_GET['base_datos_guardado']) && $_GET['base_datos_guardado'] === '1'){
        $mensaje_base_datos = 'La sección Carpeta Base de Datos fue guardada correctamente.';
        $clase_mensaje_base_datos = 'portada_respuesta_ok';
    }

    $mensaje_documentacion_caso_uso = '';
    $clase_mensaje_documentacion_caso_uso = '';
    $nivel_titulo_doc_1 = '1';
    $numero_titulo_doc_1 = '';
    $texto_titulo_doc_1 = '';
    $nivel_titulo_doc_2 = '2';
    $numero_titulo_doc_2 = '';
    $texto_titulo_doc_2 = '';
    $nivel_titulo_doc_3 = '3';
    $numero_titulo_doc_3 = '';
    $texto_titulo_doc_3 = '';
    $texto_contenido_doc = '';

    if($id_informe > 0){
        $fila_documentacion_caso_uso = cargar_documentacion_caso_uso_informe($mysqli, $id_informe, $id_usuario);

        if($fila_documentacion_caso_uso){
            $nivel_titulo_doc_1 = isset($fila_documentacion_caso_uso['nivel_titulo_1']) ? trim((string)$fila_documentacion_caso_uso['nivel_titulo_1']) : $nivel_titulo_doc_1;
            $numero_titulo_doc_1 = isset($fila_documentacion_caso_uso['numero_titulo_1']) ? trim((string)$fila_documentacion_caso_uso['numero_titulo_1']) : $numero_titulo_doc_1;
            $texto_titulo_doc_1 = isset($fila_documentacion_caso_uso['texto_titulo_1']) ? trim((string)$fila_documentacion_caso_uso['texto_titulo_1']) : $texto_titulo_doc_1;
            $nivel_titulo_doc_2 = isset($fila_documentacion_caso_uso['nivel_titulo_2']) ? trim((string)$fila_documentacion_caso_uso['nivel_titulo_2']) : $nivel_titulo_doc_2;
            $numero_titulo_doc_2 = isset($fila_documentacion_caso_uso['numero_titulo_2']) ? trim((string)$fila_documentacion_caso_uso['numero_titulo_2']) : $numero_titulo_doc_2;
            $texto_titulo_doc_2 = isset($fila_documentacion_caso_uso['texto_titulo_2']) ? trim((string)$fila_documentacion_caso_uso['texto_titulo_2']) : $texto_titulo_doc_2;
            $nivel_titulo_doc_3 = isset($fila_documentacion_caso_uso['nivel_titulo_3']) ? trim((string)$fila_documentacion_caso_uso['nivel_titulo_3']) : $nivel_titulo_doc_3;
            $numero_titulo_doc_3 = isset($fila_documentacion_caso_uso['numero_titulo_3']) ? trim((string)$fila_documentacion_caso_uso['numero_titulo_3']) : $numero_titulo_doc_3;
            $texto_titulo_doc_3 = isset($fila_documentacion_caso_uso['texto_titulo_3']) ? trim((string)$fila_documentacion_caso_uso['texto_titulo_3']) : $texto_titulo_doc_3;
            $texto_contenido_doc = isset($fila_documentacion_caso_uso['texto_contenido']) ? trim((string)$fila_documentacion_caso_uso['texto_contenido']) : $texto_contenido_doc;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_documentacion_caso_uso_base'])){
        $nivel_titulo_doc_1 = isset($_POST['nivel_titulo_doc_1']) ? trim((string)$_POST['nivel_titulo_doc_1']) : $nivel_titulo_doc_1;
        $numero_titulo_doc_1 = isset($_POST['numero_titulo_doc_1']) ? trim((string)$_POST['numero_titulo_doc_1']) : $numero_titulo_doc_1;
        $texto_titulo_doc_1 = isset($_POST['texto_titulo_doc_1']) ? trim((string)$_POST['texto_titulo_doc_1']) : $texto_titulo_doc_1;
        $nivel_titulo_doc_2 = isset($_POST['nivel_titulo_doc_2']) ? trim((string)$_POST['nivel_titulo_doc_2']) : $nivel_titulo_doc_2;
        $numero_titulo_doc_2 = isset($_POST['numero_titulo_doc_2']) ? trim((string)$_POST['numero_titulo_doc_2']) : $numero_titulo_doc_2;
        $texto_titulo_doc_2 = isset($_POST['texto_titulo_doc_2']) ? trim((string)$_POST['texto_titulo_doc_2']) : $texto_titulo_doc_2;
        $nivel_titulo_doc_3 = isset($_POST['nivel_titulo_doc_3']) ? trim((string)$_POST['nivel_titulo_doc_3']) : $nivel_titulo_doc_3;
        $numero_titulo_doc_3 = isset($_POST['numero_titulo_doc_3']) ? trim((string)$_POST['numero_titulo_doc_3']) : $numero_titulo_doc_3;
        $texto_titulo_doc_3 = isset($_POST['texto_titulo_doc_3']) ? trim((string)$_POST['texto_titulo_doc_3']) : $texto_titulo_doc_3;
        $texto_contenido_doc = isset($_POST['texto_contenido_doc']) ? trim((string)$_POST['texto_contenido_doc']) : $texto_contenido_doc;
    }

    $niveles_doc = array(
        normalizar_nivel_titulo($nivel_titulo_doc_1, '1'),
        normalizar_nivel_titulo($nivel_titulo_doc_2, '1'),
        normalizar_nivel_titulo($nivel_titulo_doc_3, '1')
    );

    $nivel_titulo_doc_1 = $niveles_doc[0];
    $nivel_titulo_doc_2 = $niveles_doc[1];
    $nivel_titulo_doc_3 = $niveles_doc[2];

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_documentacion_caso_uso_base'])){
        if($id_informe <= 0 || !$es_informe_existente){
            $mensaje_documentacion_caso_uso = 'Debe guardar primero la portada del informe antes de registrar la sección Carpeta Documentación / Caso de Uso.';
            $clase_mensaje_documentacion_caso_uso = 'portada_respuesta_error';
        }else{
            $datos_documentacion_caso_uso = array(
                'nivel_titulo_1' => $nivel_titulo_doc_1,
                'numero_titulo_1' => $numero_titulo_doc_1,
                'texto_titulo_1' => $texto_titulo_doc_1,
                'nivel_titulo_2' => $nivel_titulo_doc_2,
                'numero_titulo_2' => $numero_titulo_doc_2,
                'texto_titulo_2' => $texto_titulo_doc_2,
                'nivel_titulo_3' => $nivel_titulo_doc_3,
                'numero_titulo_3' => $numero_titulo_doc_3,
                'texto_titulo_3' => $texto_titulo_doc_3,
                'texto_contenido' => $texto_contenido_doc
            );

            if(guardar_documentacion_caso_uso_informe($mysqli, $id_informe, $id_usuario, $datos_documentacion_caso_uso)){
                actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario);

                header('Location: portada.php?id_informe=' . (int)$id_informe . '&documentacion_caso_uso_guardado=1');
                exit();
            }

            $mensaje_documentacion_caso_uso = 'Ocurrió un error al guardar la sección Carpeta Documentación / Caso de Uso.';
            $clase_mensaje_documentacion_caso_uso = 'portada_respuesta_error';
        }
    }

    if(isset($_GET['documentacion_caso_uso_guardado']) && $_GET['documentacion_caso_uso_guardado'] === '1'){
        $mensaje_documentacion_caso_uso = 'La sección Carpeta Documentación / Caso de Uso fue guardada correctamente.';
        $clase_mensaje_documentacion_caso_uso = 'portada_respuesta_ok';
    }

    $mensaje_caso_uso_imagen = '';
    $clase_mensaje_caso_uso_imagen = '';
    $caso_uso_primer_titulo_bloqueado = false;
    $nivel_titulo_cu_1 = '2';
    $numero_titulo_cu_1 = '';
    $texto_titulo_cu_1 = '';
    $nivel_titulo_cu_2 = '3';
    $numero_titulo_cu_2 = '';
    $texto_titulo_cu_2 = '';
    $nombre_imagen_cu = '';
    $ruta_imagen_cu = '';

    if($id_informe > 0){
        $fila_caso_uso_primera = cargar_primer_caso_uso_imagen($mysqli, $id_informe, $id_usuario);
        if($fila_caso_uso_primera){
            $caso_uso_primer_titulo_bloqueado = true;
            $nivel_titulo_cu_1 = isset($fila_caso_uso_primera['nivel_titulo_1']) ? trim((string)$fila_caso_uso_primera['nivel_titulo_1']) : $nivel_titulo_cu_1;
            $numero_titulo_cu_1 = isset($fila_caso_uso_primera['numero_titulo_1']) ? trim((string)$fila_caso_uso_primera['numero_titulo_1']) : $numero_titulo_cu_1;
            $texto_titulo_cu_1 = isset($fila_caso_uso_primera['texto_titulo_1']) ? trim((string)$fila_caso_uso_primera['texto_titulo_1']) : $texto_titulo_cu_1;
        }

        $fila_caso_uso_ultima = cargar_ultimo_caso_uso_imagen($mysqli, $id_informe, $id_usuario);
        if($fila_caso_uso_ultima){
            $nivel_titulo_cu_2 = isset($fila_caso_uso_ultima['nivel_titulo_2']) ? trim((string)$fila_caso_uso_ultima['nivel_titulo_2']) : $nivel_titulo_cu_2;
            $numero_titulo_cu_2 = isset($fila_caso_uso_ultima['numero_titulo_2']) ? trim((string)$fila_caso_uso_ultima['numero_titulo_2']) : $numero_titulo_cu_2;
            $texto_titulo_cu_2 = isset($fila_caso_uso_ultima['texto_titulo_2']) ? trim((string)$fila_caso_uso_ultima['texto_titulo_2']) : $texto_titulo_cu_2;
            $nombre_imagen_cu = isset($fila_caso_uso_ultima['nombre_imagen']) ? trim((string)$fila_caso_uso_ultima['nombre_imagen']) : $nombre_imagen_cu;
            $ruta_imagen_cu = isset($fila_caso_uso_ultima['ruta_imagen']) ? trim((string)$fila_caso_uso_ultima['ruta_imagen']) : $ruta_imagen_cu;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_caso_uso_imagen_base'])){
        $caso_uso_primer_titulo_bloqueado = isset($_POST['caso_uso_primer_titulo_bloqueado']) && $_POST['caso_uso_primer_titulo_bloqueado'] === '1';

        $nivel_titulo_cu_1 = isset($_POST['nivel_titulo_cu_1'])
            ? trim((string)$_POST['nivel_titulo_cu_1'])
            : (isset($_POST['nivel_titulo_cu_1_fijo']) ? trim((string)$_POST['nivel_titulo_cu_1_fijo']) : $nivel_titulo_cu_1);
        $numero_titulo_cu_1 = isset($_POST['numero_titulo_cu_1'])
            ? trim((string)$_POST['numero_titulo_cu_1'])
            : (isset($_POST['numero_titulo_cu_1_fijo']) ? trim((string)$_POST['numero_titulo_cu_1_fijo']) : $numero_titulo_cu_1);
        $texto_titulo_cu_1 = isset($_POST['texto_titulo_cu_1'])
            ? trim((string)$_POST['texto_titulo_cu_1'])
            : (isset($_POST['texto_titulo_cu_1_fijo']) ? trim((string)$_POST['texto_titulo_cu_1_fijo']) : $texto_titulo_cu_1);

        $nivel_titulo_cu_2 = isset($_POST['nivel_titulo_cu_2']) ? trim((string)$_POST['nivel_titulo_cu_2']) : $nivel_titulo_cu_2;
        $numero_titulo_cu_2 = isset($_POST['numero_titulo_cu_2']) ? trim((string)$_POST['numero_titulo_cu_2']) : $numero_titulo_cu_2;
        $texto_titulo_cu_2 = isset($_POST['texto_titulo_cu_2']) ? trim((string)$_POST['texto_titulo_cu_2']) : $texto_titulo_cu_2;
        $nombre_imagen_cu = isset($_POST['nombre_imagen_cu']) ? trim((string)$_POST['nombre_imagen_cu']) : $nombre_imagen_cu;
    }

    $niveles_cu = array(
        normalizar_nivel_titulo($nivel_titulo_cu_1, '1'),
        normalizar_nivel_titulo($nivel_titulo_cu_2, '1')
    );

    $nivel_titulo_cu_1 = $niveles_cu[0];
    $nivel_titulo_cu_2 = $niveles_cu[1];

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_caso_uso_imagen_base'])){
        if($id_informe <= 0 || !$es_informe_existente){
            $mensaje_caso_uso_imagen = 'Debe guardar primero la portada del informe antes de registrar imagenes de Caso de Uso.';
            $clase_mensaje_caso_uso_imagen = 'portada_respuesta_error';
        }else{
            if(!isset($_FILES['archivo_caso_uso']) || (int)$_FILES['archivo_caso_uso']['error'] !== UPLOAD_ERR_OK){
                $clase_mensaje_caso_uso_imagen = 'portada_respuesta_error';
            }else{
                $archivo_imagen = $_FILES['archivo_caso_uso'];
                $extension = strtolower(pathinfo($archivo_imagen['name'], PATHINFO_EXTENSION));
                $extensiones_permitidas = array('jpg', 'jpeg', 'png', 'gif', 'webp');

                if(!in_array($extension, $extensiones_permitidas, true)){
                    $mensaje_caso_uso_imagen = 'Formato de imagen no permitido. Use JPG, JPEG, PNG, GIF o WEBP.';
                    $clase_mensaje_caso_uso_imagen = 'portada_respuesta_error';
                }elseif((int)$archivo_imagen['size'] <= 0 || (int)$archivo_imagen['size'] > (10 * 1024 * 1024)){
                    $mensaje_caso_uso_imagen = 'La imagen excede el tamano permitido (maximo 10MB).';
                    $clase_mensaje_caso_uso_imagen = 'portada_respuesta_error';
                }else{
                    $directorio_destino = __DIR__ . '/../../../imagenes/programa/caso_uso_imagen';

                    if(!is_dir($directorio_destino) && !mkdir($directorio_destino, 0777, true)){
                        $mensaje_caso_uso_imagen = 'No se pudo crear la carpeta de destino para las imagenes.';
                        $clase_mensaje_caso_uso_imagen = 'portada_respuesta_error';
                    }else{
                        $nombre_archivo = 'informe_' . (int)$id_informe . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
                        $ruta_destino = $directorio_destino . '/' . $nombre_archivo;
                        $ruta_relativa_bd = 'imagenes/programa/caso_uso_imagen/' . $nombre_archivo;

                        if(!move_uploaded_file($archivo_imagen['tmp_name'], $ruta_destino)){
                            $mensaje_caso_uso_imagen = 'No se pudo subir la imagen al servidor.';
                            $clase_mensaje_caso_uso_imagen = 'portada_respuesta_error';
                        }else{
                            $siguiente_orden_cu = obtener_siguiente_orden_caso_uso_imagen($mysqli, $id_informe);
                            $datos_caso_uso_imagen = array(
                                'orden' => $siguiente_orden_cu,
                                'nivel_titulo_1' => $nivel_titulo_cu_1,
                                'numero_titulo_1' => $numero_titulo_cu_1,
                                'texto_titulo_1' => $texto_titulo_cu_1,
                                'titulo_1_bloqueado' => 1,
                                'nivel_titulo_2' => $nivel_titulo_cu_2,
                                'numero_titulo_2' => $numero_titulo_cu_2,
                                'texto_titulo_2' => $texto_titulo_cu_2,
                                'nombre_imagen' => $nombre_imagen_cu,
                                'ruta_imagen' => $ruta_relativa_bd
                            );

                            if(insertar_caso_uso_imagen($mysqli, $id_informe, $id_usuario, $datos_caso_uso_imagen)){
                                actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario);

                                header('Location: portada.php?id_informe=' . (int)$id_informe . '&caso_uso_imagen_guardado=1');
                                exit();
                            }

                            @unlink($ruta_destino);
                            $mensaje_caso_uso_imagen = 'Ocurrio un error al guardar el registro de imagen en la base de datos.';
                            $clase_mensaje_caso_uso_imagen = 'portada_respuesta_error';
                        }
                    }
                }
            }
        }
    }

    if(isset($_GET['caso_uso_imagen_guardado']) && $_GET['caso_uso_imagen_guardado'] === '1'){
        $caso_uso_primer_titulo_bloqueado = true;
        $nivel_titulo_cu_2 = '3';
        $numero_titulo_cu_2 = '';
        $texto_titulo_cu_2 = '';
        $nombre_imagen_cu = '';
        $mensaje_caso_uso_imagen = 'La imagen de caso de uso fue guardada correctamente.';
        $clase_mensaje_caso_uso_imagen = 'portada_respuesta_ok';
    }

    $mensaje_carpeta_diagramas = '';
    $clase_mensaje_carpeta_diagramas = '';
    $carpeta_diagramas_primer_titulo_bloqueado = false;
    $nivel_titulo_cd_1 = '2';
    $numero_titulo_cd_1 = '';
    $texto_titulo_cd_1 = '';
    $nivel_titulo_cd_2 = '3';
    $numero_titulo_cd_2 = '';
    $texto_titulo_cd_2 = '';
    $nombre_imagen_cd = '';
    $ruta_imagen_cd = '';

    if($id_informe > 0){
        $fila_diagrama_primera = cargar_primer_carpeta_diagrama($mysqli, $id_informe, $id_usuario);
        if($fila_diagrama_primera){
            $carpeta_diagramas_primer_titulo_bloqueado = true;
            $nivel_titulo_cd_1 = isset($fila_diagrama_primera['nivel_titulo_1']) ? trim((string)$fila_diagrama_primera['nivel_titulo_1']) : $nivel_titulo_cd_1;
            $numero_titulo_cd_1 = isset($fila_diagrama_primera['numero_titulo_1']) ? trim((string)$fila_diagrama_primera['numero_titulo_1']) : $numero_titulo_cd_1;
            $texto_titulo_cd_1 = isset($fila_diagrama_primera['texto_titulo_1']) ? trim((string)$fila_diagrama_primera['texto_titulo_1']) : $texto_titulo_cd_1;
        }

        $fila_diagrama_ultima = cargar_ultimo_carpeta_diagrama($mysqli, $id_informe, $id_usuario);
        if($fila_diagrama_ultima){
            $nivel_titulo_cd_2 = isset($fila_diagrama_ultima['nivel_titulo_2']) ? trim((string)$fila_diagrama_ultima['nivel_titulo_2']) : $nivel_titulo_cd_2;
            $numero_titulo_cd_2 = isset($fila_diagrama_ultima['numero_titulo_2']) ? trim((string)$fila_diagrama_ultima['numero_titulo_2']) : $numero_titulo_cd_2;
            $texto_titulo_cd_2 = isset($fila_diagrama_ultima['texto_titulo_2']) ? trim((string)$fila_diagrama_ultima['texto_titulo_2']) : $texto_titulo_cd_2;
            $nombre_imagen_cd = isset($fila_diagrama_ultima['nombre_imagen']) ? trim((string)$fila_diagrama_ultima['nombre_imagen']) : $nombre_imagen_cd;
            $ruta_imagen_cd = isset($fila_diagrama_ultima['ruta_imagen']) ? trim((string)$fila_diagrama_ultima['ruta_imagen']) : $ruta_imagen_cd;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_carpeta_diagramas_base'])){
        $carpeta_diagramas_primer_titulo_bloqueado = isset($_POST['carpeta_diagramas_primer_titulo_bloqueado']) && $_POST['carpeta_diagramas_primer_titulo_bloqueado'] === '1';

        $nivel_titulo_cd_1 = isset($_POST['nivel_titulo_cd_1'])
            ? trim((string)$_POST['nivel_titulo_cd_1'])
            : (isset($_POST['nivel_titulo_cd_1_fijo']) ? trim((string)$_POST['nivel_titulo_cd_1_fijo']) : $nivel_titulo_cd_1);
        $numero_titulo_cd_1 = isset($_POST['numero_titulo_cd_1'])
            ? trim((string)$_POST['numero_titulo_cd_1'])
            : (isset($_POST['numero_titulo_cd_1_fijo']) ? trim((string)$_POST['numero_titulo_cd_1_fijo']) : $numero_titulo_cd_1);
        $texto_titulo_cd_1 = isset($_POST['texto_titulo_cd_1'])
            ? trim((string)$_POST['texto_titulo_cd_1'])
            : (isset($_POST['texto_titulo_cd_1_fijo']) ? trim((string)$_POST['texto_titulo_cd_1_fijo']) : $texto_titulo_cd_1);

        $nivel_titulo_cd_2 = isset($_POST['nivel_titulo_cd_2']) ? trim((string)$_POST['nivel_titulo_cd_2']) : $nivel_titulo_cd_2;
        $numero_titulo_cd_2 = isset($_POST['numero_titulo_cd_2']) ? trim((string)$_POST['numero_titulo_cd_2']) : $numero_titulo_cd_2;
        $texto_titulo_cd_2 = isset($_POST['texto_titulo_cd_2']) ? trim((string)$_POST['texto_titulo_cd_2']) : $texto_titulo_cd_2;
        $nombre_imagen_cd = isset($_POST['nombre_imagen_cd']) ? trim((string)$_POST['nombre_imagen_cd']) : $nombre_imagen_cd;
    }

    $niveles_cd = array(
        normalizar_nivel_titulo($nivel_titulo_cd_1, '1'),
        normalizar_nivel_titulo($nivel_titulo_cd_2, '1')
    );

    $nivel_titulo_cd_1 = $niveles_cd[0];
    $nivel_titulo_cd_2 = $niveles_cd[1];

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_carpeta_diagramas_base'])){
        if($id_informe <= 0 || !$es_informe_existente){
            $mensaje_carpeta_diagramas = 'Debe guardar primero la portada del informe antes de registrar imagenes de Carpeta Diagramas.';
            $clase_mensaje_carpeta_diagramas = 'portada_respuesta_error';
        }else{
            if(!isset($_FILES['archivo_carpeta_diagramas']) || (int)$_FILES['archivo_carpeta_diagramas']['error'] !== UPLOAD_ERR_OK){
                $clase_mensaje_carpeta_diagramas = 'portada_respuesta_error';
            }else{
                $archivo_imagen_diagrama = $_FILES['archivo_carpeta_diagramas'];
                $extension_diagrama = strtolower(pathinfo($archivo_imagen_diagrama['name'], PATHINFO_EXTENSION));
                $extensiones_permitidas_diagrama = array('jpg', 'jpeg', 'png', 'gif', 'webp');

                if(!in_array($extension_diagrama, $extensiones_permitidas_diagrama, true)){
                    $mensaje_carpeta_diagramas = 'Formato de imagen no permitido. Use JPG, JPEG, PNG, GIF o WEBP.';
                    $clase_mensaje_carpeta_diagramas = 'portada_respuesta_error';
                }elseif((int)$archivo_imagen_diagrama['size'] <= 0 || (int)$archivo_imagen_diagrama['size'] > (10 * 1024 * 1024)){
                    $mensaje_carpeta_diagramas = 'La imagen excede el tamano permitido (maximo 10MB).';
                    $clase_mensaje_carpeta_diagramas = 'portada_respuesta_error';
                }else{
                    $directorio_destino_diagrama = __DIR__ . '/../../../imagenes/programa/carpeta_diagramas';

                    if(!is_dir($directorio_destino_diagrama) && !mkdir($directorio_destino_diagrama, 0777, true)){
                        $mensaje_carpeta_diagramas = 'No se pudo crear la carpeta de destino para las imagenes.';
                        $clase_mensaje_carpeta_diagramas = 'portada_respuesta_error';
                    }else{
                        $nombre_archivo_diagrama = 'informe_' . (int)$id_informe . '_diagrama_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension_diagrama;
                        $ruta_destino_diagrama = $directorio_destino_diagrama . '/' . $nombre_archivo_diagrama;
                        $ruta_relativa_bd_diagrama = 'imagenes/programa/carpeta_diagramas/' . $nombre_archivo_diagrama;

                        if(!move_uploaded_file($archivo_imagen_diagrama['tmp_name'], $ruta_destino_diagrama)){
                            $mensaje_carpeta_diagramas = 'No se pudo subir la imagen al servidor.';
                            $clase_mensaje_carpeta_diagramas = 'portada_respuesta_error';
                        }else{
                            $siguiente_orden_cd = obtener_siguiente_orden_carpeta_diagrama($mysqli, $id_informe);
                            $datos_carpeta_diagrama = array(
                                'orden' => $siguiente_orden_cd,
                                'nivel_titulo_1' => $nivel_titulo_cd_1,
                                'numero_titulo_1' => $numero_titulo_cd_1,
                                'texto_titulo_1' => $texto_titulo_cd_1,
                                'titulo_1_bloqueado' => 1,
                                'nivel_titulo_2' => $nivel_titulo_cd_2,
                                'numero_titulo_2' => $numero_titulo_cd_2,
                                'texto_titulo_2' => $texto_titulo_cd_2,
                                'nombre_imagen' => $nombre_imagen_cd,
                                'ruta_imagen' => $ruta_relativa_bd_diagrama
                            );

                            if(insertar_carpeta_diagrama($mysqli, $id_informe, $id_usuario, $datos_carpeta_diagrama)){
                                actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario);

                                header('Location: portada.php?id_informe=' . (int)$id_informe . '&carpeta_diagramas_guardado=1');
                                exit();
                            }

                            @unlink($ruta_destino_diagrama);
                            $mensaje_carpeta_diagramas = 'Ocurrio un error al guardar el registro de imagen en la base de datos.';
                            $clase_mensaje_carpeta_diagramas = 'portada_respuesta_error';
                        }
                    }
                }
            }
        }
    }

    if(isset($_GET['carpeta_diagramas_guardado']) && $_GET['carpeta_diagramas_guardado'] === '1'){
        $carpeta_diagramas_primer_titulo_bloqueado = true;
        $nivel_titulo_cd_2 = '3';
        $numero_titulo_cd_2 = '';
        $texto_titulo_cd_2 = '';
        $nombre_imagen_cd = '';
        $mensaje_carpeta_diagramas = 'La imagen de carpeta diagramas fue guardada correctamente.';
        $clase_mensaje_carpeta_diagramas = 'portada_respuesta_ok';
    }

    $mensaje_carpeta_pantallazos_programas = '';
    $clase_mensaje_carpeta_pantallazos_programas = '';
    $carpeta_pantallazos_primer_titulo_bloqueado = false;
    $nivel_titulo_cp_1 = '2';
    $numero_titulo_cp_1 = '';
    $texto_titulo_cp_1 = '';
    $nivel_titulo_cp_2 = '3';
    $numero_titulo_cp_2 = '';
    $texto_titulo_cp_2 = '';
    $nombre_imagen_cp = '';
    $ruta_imagen_cp = '';

    if($id_informe > 0){
        $fila_pantallazo_primera = cargar_primer_carpeta_pantallazos_programa($mysqli, $id_informe, $id_usuario);
        if($fila_pantallazo_primera){
            $carpeta_pantallazos_primer_titulo_bloqueado = true;
            $nivel_titulo_cp_1 = isset($fila_pantallazo_primera['nivel_titulo_1']) ? trim((string)$fila_pantallazo_primera['nivel_titulo_1']) : $nivel_titulo_cp_1;
            $numero_titulo_cp_1 = isset($fila_pantallazo_primera['numero_titulo_1']) ? trim((string)$fila_pantallazo_primera['numero_titulo_1']) : $numero_titulo_cp_1;
            $texto_titulo_cp_1 = isset($fila_pantallazo_primera['texto_titulo_1']) ? trim((string)$fila_pantallazo_primera['texto_titulo_1']) : $texto_titulo_cp_1;
        }

        $fila_pantallazo_ultima = cargar_ultimo_carpeta_pantallazos_programa($mysqli, $id_informe, $id_usuario);
        if($fila_pantallazo_ultima){
            $nivel_titulo_cp_2 = isset($fila_pantallazo_ultima['nivel_titulo_2']) ? trim((string)$fila_pantallazo_ultima['nivel_titulo_2']) : $nivel_titulo_cp_2;
            $numero_titulo_cp_2 = isset($fila_pantallazo_ultima['numero_titulo_2']) ? trim((string)$fila_pantallazo_ultima['numero_titulo_2']) : $numero_titulo_cp_2;
            $texto_titulo_cp_2 = isset($fila_pantallazo_ultima['texto_titulo_2']) ? trim((string)$fila_pantallazo_ultima['texto_titulo_2']) : $texto_titulo_cp_2;
            $nombre_imagen_cp = isset($fila_pantallazo_ultima['nombre_imagen']) ? trim((string)$fila_pantallazo_ultima['nombre_imagen']) : $nombre_imagen_cp;
            $ruta_imagen_cp = isset($fila_pantallazo_ultima['ruta_imagen']) ? trim((string)$fila_pantallazo_ultima['ruta_imagen']) : $ruta_imagen_cp;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_carpeta_pantallazos_programas_base'])){
        $carpeta_pantallazos_primer_titulo_bloqueado = isset($_POST['carpeta_pantallazos_primer_titulo_bloqueado']) && $_POST['carpeta_pantallazos_primer_titulo_bloqueado'] === '1';

        $nivel_titulo_cp_1 = isset($_POST['nivel_titulo_cp_1'])
            ? trim((string)$_POST['nivel_titulo_cp_1'])
            : (isset($_POST['nivel_titulo_cp_1_fijo']) ? trim((string)$_POST['nivel_titulo_cp_1_fijo']) : $nivel_titulo_cp_1);
        $numero_titulo_cp_1 = isset($_POST['numero_titulo_cp_1'])
            ? trim((string)$_POST['numero_titulo_cp_1'])
            : (isset($_POST['numero_titulo_cp_1_fijo']) ? trim((string)$_POST['numero_titulo_cp_1_fijo']) : $numero_titulo_cp_1);
        $texto_titulo_cp_1 = isset($_POST['texto_titulo_cp_1'])
            ? trim((string)$_POST['texto_titulo_cp_1'])
            : (isset($_POST['texto_titulo_cp_1_fijo']) ? trim((string)$_POST['texto_titulo_cp_1_fijo']) : $texto_titulo_cp_1);

        $nivel_titulo_cp_2 = isset($_POST['nivel_titulo_cp_2']) ? trim((string)$_POST['nivel_titulo_cp_2']) : $nivel_titulo_cp_2;
        $numero_titulo_cp_2 = isset($_POST['numero_titulo_cp_2']) ? trim((string)$_POST['numero_titulo_cp_2']) : $numero_titulo_cp_2;
        $texto_titulo_cp_2 = isset($_POST['texto_titulo_cp_2']) ? trim((string)$_POST['texto_titulo_cp_2']) : $texto_titulo_cp_2;
        $nombre_imagen_cp = isset($_POST['nombre_imagen_cp']) ? trim((string)$_POST['nombre_imagen_cp']) : $nombre_imagen_cp;
    }

    $niveles_cp = array(
        normalizar_nivel_titulo($nivel_titulo_cp_1, '1'),
        normalizar_nivel_titulo($nivel_titulo_cp_2, '1')
    );

    $nivel_titulo_cp_1 = $niveles_cp[0];
    $nivel_titulo_cp_2 = $niveles_cp[1];

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_carpeta_pantallazos_programas_base'])){
        if($id_informe <= 0 || !$es_informe_existente){
            $mensaje_carpeta_pantallazos_programas = 'Debe guardar primero la portada del informe antes de registrar imagenes de Carpeta Pantallazos Programas.';
            $clase_mensaje_carpeta_pantallazos_programas = 'portada_respuesta_error';
        }else{
            if(!isset($_FILES['archivo_carpeta_pantallazos']) || (int)$_FILES['archivo_carpeta_pantallazos']['error'] !== UPLOAD_ERR_OK){
                $clase_mensaje_carpeta_pantallazos_programas = 'portada_respuesta_error';
            }else{
                $archivo_imagen_pantallazo = $_FILES['archivo_carpeta_pantallazos'];
                $extension_pantallazo = strtolower(pathinfo($archivo_imagen_pantallazo['name'], PATHINFO_EXTENSION));
                $extensiones_permitidas_pantallazo = array('jpg', 'jpeg', 'png', 'gif', 'webp');

                if(!in_array($extension_pantallazo, $extensiones_permitidas_pantallazo, true)){
                    $mensaje_carpeta_pantallazos_programas = 'Formato de imagen no permitido. Use JPG, JPEG, PNG, GIF o WEBP.';
                    $clase_mensaje_carpeta_pantallazos_programas = 'portada_respuesta_error';
                }elseif((int)$archivo_imagen_pantallazo['size'] <= 0 || (int)$archivo_imagen_pantallazo['size'] > (10 * 1024 * 1024)){
                    $mensaje_carpeta_pantallazos_programas = 'La imagen excede el tamano permitido (maximo 10MB).';
                    $clase_mensaje_carpeta_pantallazos_programas = 'portada_respuesta_error';
                }else{
                    $directorio_destino_pantallazo = __DIR__ . '/../../../imagenes/programa/carpeta_pantallazos_programas';

                    if(!is_dir($directorio_destino_pantallazo) && !mkdir($directorio_destino_pantallazo, 0777, true)){
                        $mensaje_carpeta_pantallazos_programas = 'No se pudo crear la carpeta de destino para las imagenes.';
                        $clase_mensaje_carpeta_pantallazos_programas = 'portada_respuesta_error';
                    }else{
                        $nombre_archivo_pantallazo = 'informe_' . (int)$id_informe . '_pantallazo_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $extension_pantallazo;
                        $ruta_destino_pantallazo = $directorio_destino_pantallazo . '/' . $nombre_archivo_pantallazo;
                        $ruta_relativa_bd_pantallazo = 'imagenes/programa/carpeta_pantallazos_programas/' . $nombre_archivo_pantallazo;

                        if(!move_uploaded_file($archivo_imagen_pantallazo['tmp_name'], $ruta_destino_pantallazo)){
                            $mensaje_carpeta_pantallazos_programas = 'No se pudo subir la imagen al servidor.';
                            $clase_mensaje_carpeta_pantallazos_programas = 'portada_respuesta_error';
                        }else{
                            $siguiente_orden_cp = obtener_siguiente_orden_carpeta_pantallazos_programa($mysqli, $id_informe);
                            $datos_carpeta_pantallazo = array(
                                'orden' => $siguiente_orden_cp,
                                'nivel_titulo_1' => $nivel_titulo_cp_1,
                                'numero_titulo_1' => $numero_titulo_cp_1,
                                'texto_titulo_1' => $texto_titulo_cp_1,
                                'titulo_1_bloqueado' => 1,
                                'nivel_titulo_2' => $nivel_titulo_cp_2,
                                'numero_titulo_2' => $numero_titulo_cp_2,
                                'texto_titulo_2' => $texto_titulo_cp_2,
                                'nombre_imagen' => $nombre_imagen_cp,
                                'ruta_imagen' => $ruta_relativa_bd_pantallazo
                            );

                            if(insertar_carpeta_pantallazos_programa($mysqli, $id_informe, $id_usuario, $datos_carpeta_pantallazo)){
                                actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario);
                                header('Location: portada.php?id_informe=' . (int)$id_informe . '&carpeta_pantallazos_programas_guardado=1');
                                exit();
                            }

                            @unlink($ruta_destino_pantallazo);
                            $mensaje_carpeta_pantallazos_programas = 'Ocurrio un error al guardar el registro de imagen en la base de datos.';
                            $clase_mensaje_carpeta_pantallazos_programas = 'portada_respuesta_error';
                        }
                    }
                }
            }
        }
    }

    if(isset($_GET['carpeta_pantallazos_programas_guardado']) && $_GET['carpeta_pantallazos_programas_guardado'] === '1'){
        $carpeta_pantallazos_primer_titulo_bloqueado = true;
        $nivel_titulo_cp_2 = '3';
        $numero_titulo_cp_2 = '';
        $texto_titulo_cp_2 = '';
        $nombre_imagen_cp = '';
        $mensaje_carpeta_pantallazos_programas = 'La imagen de carpeta pantallazos programas fue guardada correctamente.';
        $clase_mensaje_carpeta_pantallazos_programas = 'portada_respuesta_ok';
    }

    $mensaje_carpeta_informes_programas = '';
    $clase_mensaje_carpeta_informes_programas = '';
    $carpeta_informes_programas_primer_titulo_bloqueado = false;
    $nivel_titulo_cip_1 = '2';
    $numero_titulo_cip_1 = '';
    $texto_titulo_cip_1 = '';
    $nivel_titulo_cip_2 = '3';
    $numero_titulo_cip_2 = '';
    $texto_titulo_cip_2 = '';
    $ruta_principal_cip = '';
    $sin_manual_momento_cip = false;
    $carpeta_cip = '';
    $archivo_cip = '';
    $extension_cip = '';
    $ruta_extra_1_cip = '';
    $ruta_extra_2_cip = '';
    $ruta_extra_3_cip = '';
    $ruta_extra_4_cip = '';

    if($id_informe > 0){
        $fila_cip_primera = cargar_primer_carpeta_informes_programa($mysqli, $id_informe, $id_usuario);
        if($fila_cip_primera){
            $carpeta_informes_programas_primer_titulo_bloqueado = true;
            $nivel_titulo_cip_1 = isset($fila_cip_primera['nivel_titulo_1']) ? trim((string)$fila_cip_primera['nivel_titulo_1']) : $nivel_titulo_cip_1;
            $numero_titulo_cip_1 = isset($fila_cip_primera['numero_titulo_1']) ? trim((string)$fila_cip_primera['numero_titulo_1']) : $numero_titulo_cip_1;
            $texto_titulo_cip_1 = isset($fila_cip_primera['texto_titulo_1']) ? trim((string)$fila_cip_primera['texto_titulo_1']) : $texto_titulo_cip_1;
        }

        $fila_cip_ultima = cargar_ultimo_carpeta_informes_programa($mysqli, $id_informe, $id_usuario);
        if($fila_cip_ultima){
            $nivel_titulo_cip_2 = isset($fila_cip_ultima['nivel_titulo_2']) ? trim((string)$fila_cip_ultima['nivel_titulo_2']) : $nivel_titulo_cip_2;
            $numero_titulo_cip_2 = isset($fila_cip_ultima['numero_titulo_2']) ? trim((string)$fila_cip_ultima['numero_titulo_2']) : $numero_titulo_cip_2;
            $texto_titulo_cip_2 = isset($fila_cip_ultima['texto_titulo_2']) ? trim((string)$fila_cip_ultima['texto_titulo_2']) : $texto_titulo_cip_2;
            $ruta_principal_cip = isset($fila_cip_ultima['ruta_principal']) ? trim((string)$fila_cip_ultima['ruta_principal']) : $ruta_principal_cip;
            $sin_manual_momento_cip = isset($fila_cip_ultima['sin_manual_momento']) && (int)$fila_cip_ultima['sin_manual_momento'] === 1;
            $carpeta_cip = isset($fila_cip_ultima['carpeta']) ? trim((string)$fila_cip_ultima['carpeta']) : $carpeta_cip;
            $archivo_cip = isset($fila_cip_ultima['archivo']) ? trim((string)$fila_cip_ultima['archivo']) : $archivo_cip;
            $extension_cip = isset($fila_cip_ultima['extension']) ? trim((string)$fila_cip_ultima['extension']) : $extension_cip;
            $ruta_extra_1_cip = isset($fila_cip_ultima['ruta_extra_1']) ? trim((string)$fila_cip_ultima['ruta_extra_1']) : $ruta_extra_1_cip;
            $ruta_extra_2_cip = isset($fila_cip_ultima['ruta_extra_2']) ? trim((string)$fila_cip_ultima['ruta_extra_2']) : $ruta_extra_2_cip;
            $ruta_extra_3_cip = isset($fila_cip_ultima['ruta_extra_3']) ? trim((string)$fila_cip_ultima['ruta_extra_3']) : $ruta_extra_3_cip;
            $ruta_extra_4_cip = isset($fila_cip_ultima['ruta_extra_4']) ? trim((string)$fila_cip_ultima['ruta_extra_4']) : $ruta_extra_4_cip;
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_carpeta_informes_programas_base'])){
        $carpeta_informes_programas_primer_titulo_bloqueado = isset($_POST['carpeta_informes_programas_primer_titulo_bloqueado']) && $_POST['carpeta_informes_programas_primer_titulo_bloqueado'] === '1';

        $nivel_titulo_cip_1 = isset($_POST['nivel_titulo_cip_1'])
            ? trim((string)$_POST['nivel_titulo_cip_1'])
            : (isset($_POST['nivel_titulo_cip_1_fijo']) ? trim((string)$_POST['nivel_titulo_cip_1_fijo']) : $nivel_titulo_cip_1);
        $numero_titulo_cip_1 = isset($_POST['numero_titulo_cip_1'])
            ? trim((string)$_POST['numero_titulo_cip_1'])
            : (isset($_POST['numero_titulo_cip_1_fijo']) ? trim((string)$_POST['numero_titulo_cip_1_fijo']) : $numero_titulo_cip_1);
        $texto_titulo_cip_1 = isset($_POST['texto_titulo_cip_1'])
            ? trim((string)$_POST['texto_titulo_cip_1'])
            : (isset($_POST['texto_titulo_cip_1_fijo']) ? trim((string)$_POST['texto_titulo_cip_1_fijo']) : $texto_titulo_cip_1);

        $nivel_titulo_cip_2 = isset($_POST['nivel_titulo_cip_2']) ? trim((string)$_POST['nivel_titulo_cip_2']) : $nivel_titulo_cip_2;
        $numero_titulo_cip_2 = isset($_POST['numero_titulo_cip_2']) ? trim((string)$_POST['numero_titulo_cip_2']) : $numero_titulo_cip_2;
        $texto_titulo_cip_2 = isset($_POST['texto_titulo_cip_2']) ? trim((string)$_POST['texto_titulo_cip_2']) : $texto_titulo_cip_2;
        $ruta_principal_cip = isset($_POST['ruta_principal_cip']) ? trim((string)$_POST['ruta_principal_cip']) : $ruta_principal_cip;
        $sin_manual_momento_cip = isset($_POST['sin_manual_momento_cip']) && $_POST['sin_manual_momento_cip'] === '1';
        $carpeta_cip = isset($_POST['carpeta_cip']) ? trim((string)$_POST['carpeta_cip']) : $carpeta_cip;
        $archivo_cip = isset($_POST['archivo_cip']) ? trim((string)$_POST['archivo_cip']) : $archivo_cip;
        $extension_cip = isset($_POST['extension_cip']) ? trim((string)$_POST['extension_cip']) : $extension_cip;
        $ruta_extra_1_cip = isset($_POST['ruta_extra_1_cip']) ? trim((string)$_POST['ruta_extra_1_cip']) : $ruta_extra_1_cip;
        $ruta_extra_2_cip = isset($_POST['ruta_extra_2_cip']) ? trim((string)$_POST['ruta_extra_2_cip']) : $ruta_extra_2_cip;
        $ruta_extra_3_cip = isset($_POST['ruta_extra_3_cip']) ? trim((string)$_POST['ruta_extra_3_cip']) : $ruta_extra_3_cip;
        $ruta_extra_4_cip = isset($_POST['ruta_extra_4_cip']) ? trim((string)$_POST['ruta_extra_4_cip']) : $ruta_extra_4_cip;
    }

    $niveles_cip = array(
        normalizar_nivel_titulo($nivel_titulo_cip_1, '1'),
        normalizar_nivel_titulo($nivel_titulo_cip_2, '1')
    );

    $nivel_titulo_cip_1 = $niveles_cip[0];
    $nivel_titulo_cip_2 = $niveles_cip[1];

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_carpeta_informes_programas_base'])){
        if($id_informe <= 0 || !$es_informe_existente){
            $mensaje_carpeta_informes_programas = 'Debe guardar primero la portada del informe antes de registrar Carpeta Informes Programas.';
            $clase_mensaje_carpeta_informes_programas = 'portada_respuesta_error';
        }elseif($ruta_principal_cip === '' && $archivo_cip === '' && $extension_cip === ''){
            $mensaje_carpeta_informes_programas = 'Debe completar al menos la ruta principal o los datos del archivo.';
            $clase_mensaje_carpeta_informes_programas = 'portada_respuesta_error';
        }else{
            $siguiente_orden_cip = obtener_siguiente_orden_carpeta_informes_programa($mysqli, $id_informe);
            $datos_cip = array(
                'orden' => $siguiente_orden_cip,
                'nivel_titulo_1' => $nivel_titulo_cip_1,
                'numero_titulo_1' => $numero_titulo_cip_1,
                'texto_titulo_1' => $texto_titulo_cip_1,
                'titulo_1_bloqueado' => 1,
                'nivel_titulo_2' => $nivel_titulo_cip_2,
                'numero_titulo_2' => $numero_titulo_cip_2,
                'texto_titulo_2' => $texto_titulo_cip_2,
                'ruta_principal' => $ruta_principal_cip,
                'sin_manual_momento' => $sin_manual_momento_cip ? 1 : 0,
                'carpeta' => $carpeta_cip,
                'archivo' => $archivo_cip,
                'extension' => $extension_cip,
                'ruta_extra_1' => $ruta_extra_1_cip,
                'ruta_extra_2' => $ruta_extra_2_cip,
                'ruta_extra_3' => $ruta_extra_3_cip,
                'ruta_extra_4' => $ruta_extra_4_cip
            );

            if(insertar_carpeta_informes_programa($mysqli, $id_informe, $id_usuario, $datos_cip)){
                actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario);

                header('Location: portada.php?id_informe=' . (int)$id_informe . '&carpeta_informes_programas_guardado=1');
                exit();
            }

            $mensaje_carpeta_informes_programas = 'Ocurrio un error al guardar el registro de Carpeta Informes Programas.';
            $clase_mensaje_carpeta_informes_programas = 'portada_respuesta_error';
        }
    }

    if(isset($_GET['carpeta_informes_programas_guardado']) && $_GET['carpeta_informes_programas_guardado'] === '1'){
        $carpeta_informes_programas_primer_titulo_bloqueado = true;
        $nivel_titulo_cip_2 = '3';
        $numero_titulo_cip_2 = '';
        $texto_titulo_cip_2 = '';
        $ruta_principal_cip = '';
        $sin_manual_momento_cip = false;
        $carpeta_cip = '';
        $archivo_cip = '';
        $extension_cip = '';
        $ruta_extra_1_cip = '';
        $ruta_extra_2_cip = '';
        $ruta_extra_3_cip = '';
        $ruta_extra_4_cip = '';
        $mensaje_carpeta_informes_programas = 'La seccion Carpeta Informes Programas fue guardada correctamente.';
        $clase_mensaje_carpeta_informes_programas = 'portada_respuesta_ok';
    }

    $secciones_rutas_config = array(
        'medios_pago' => array(
            'id_html' => 'seccion_carpeta_medios_pago',
            'documento_titulo' => "CARPETA DOCUMENTACION\nCARPETA INFORMES\nCARPETA MEDIOS PAGO",
            'nivel_titulo_1_default' => '2',
            'numero_titulo_1_default' => '',
            'texto_titulo_1_default' => '',
            'nivel_titulo_2_default' => '3',
            'numero_titulo_2_default' => '',
            'texto_titulo_2_default' => '',
            'texto_apoyo' => 'Ruta informe flow o webpay (agregar la ruta donde se guarda el informe)',
            'footer_numero' => '9'
        ),
        'medios_envio' => array(
            'id_html' => 'seccion_carpeta_medios_envio',
            'documento_titulo' => "CARPETA DOCUMENTACION\nCARPETA INFORMES\nCARPETA MEDIOS ENVIO",
            'nivel_titulo_1_default' => '2',
            'numero_titulo_1_default' => '',
            'texto_titulo_1_default' => '',
            'nivel_titulo_2_default' => '3',
            'numero_titulo_2_default' => '',
            'texto_titulo_2_default' => '',
            'texto_apoyo' => 'Ruta informe chilexpress o starken (agregar la ruta donde se guarda el informe)',
            'footer_numero' => '10'
        ),
        'medios_reparto' => array(
            'id_html' => 'seccion_carpeta_medios_reparto',
            'documento_titulo' => 'CARPETA MEDIOS REPARTO',
            'nivel_titulo_1_default' => '2',
            'numero_titulo_1_default' => '',
            'texto_titulo_1_default' => '',
            'nivel_titulo_2_default' => '3',
            'numero_titulo_2_default' => '',
            'texto_titulo_2_default' => '',
            'texto_apoyo' => 'Ruta informe programa (agregar la ruta donde se guarda el informe)',
            'footer_numero' => '11'
        ),
        'manuales_clientes' => array(
            'id_html' => 'seccion_carpeta_manuales_clientes',
            'documento_titulo' => 'CARPETA MANUALES CLIENTES',
            'nivel_titulo_1_default' => '2',
            'numero_titulo_1_default' => '',
            'texto_titulo_1_default' => '',
            'nivel_titulo_2_default' => '3',
            'numero_titulo_2_default' => '',
            'texto_titulo_2_default' => '',
            'texto_apoyo' => 'Ruta informe programa (agregar la ruta donde se guarda el informe)',
            'footer_numero' => '12'
        ),
        'manuales_tecnicos' => array(
            'id_html' => 'seccion_carpeta_manuales_tecnicos',
            'documento_titulo' => 'CARPETA MANUALES TECNICOS',
            'nivel_titulo_1_default' => '2',
            'numero_titulo_1_default' => '',
            'texto_titulo_1_default' => '',
            'nivel_titulo_2_default' => '3',
            'numero_titulo_2_default' => '',
            'texto_titulo_2_default' => '',
            'texto_apoyo' => 'Ruta informe programa (agregar la ruta donde se guarda el informe)',
            'footer_numero' => '13'
        )
    );

    $secciones_rutas_estado = array();
    foreach($secciones_rutas_config as $clave_ruta => $cfg_ruta){
        $estado_ruta = array(
            'clave' => $clave_ruta,
            'id_html' => $cfg_ruta['id_html'],
            'documento_titulo' => $cfg_ruta['documento_titulo'],
            'texto_apoyo' => $cfg_ruta['texto_apoyo'],
            'footer_numero' => $cfg_ruta['footer_numero'],
            'mensaje' => '',
            'clase_mensaje' => '',
            'primer_titulo_bloqueado' => false,
            'nivel_titulo_1' => $cfg_ruta['nivel_titulo_1_default'],
            'numero_titulo_1' => $cfg_ruta['numero_titulo_1_default'],
            'texto_titulo_1' => $cfg_ruta['texto_titulo_1_default'],
            'nivel_titulo_2' => $cfg_ruta['nivel_titulo_2_default'],
            'numero_titulo_2' => $cfg_ruta['numero_titulo_2_default'],
            'texto_titulo_2' => $cfg_ruta['texto_titulo_2_default'],
            'ruta_principal' => '',
            'sin_manual_momento' => false,
            'carpeta' => '',
            'archivo' => '',
            'extension' => '',
            'ruta_extra_1' => '',
            'ruta_extra_2' => '',
            'ruta_extra_3' => '',
            'ruta_extra_4' => '',
            'registros' => array()
        );

        if($id_informe > 0){
            $fila_ruta_primera = cargar_primer_ruta_estructural($mysqli, $id_informe, $id_usuario, $clave_ruta);
            if($fila_ruta_primera){
                $estado_ruta['primer_titulo_bloqueado'] = true;
                $estado_ruta['nivel_titulo_1'] = isset($fila_ruta_primera['nivel_titulo_1']) ? trim((string)$fila_ruta_primera['nivel_titulo_1']) : $estado_ruta['nivel_titulo_1'];
                $estado_ruta['numero_titulo_1'] = isset($fila_ruta_primera['numero_titulo_1']) ? trim((string)$fila_ruta_primera['numero_titulo_1']) : $estado_ruta['numero_titulo_1'];
                $estado_ruta['texto_titulo_1'] = isset($fila_ruta_primera['texto_titulo_1']) ? trim((string)$fila_ruta_primera['texto_titulo_1']) : $estado_ruta['texto_titulo_1'];
            }

            $fila_ruta_ultima = cargar_ultimo_ruta_estructural($mysqli, $id_informe, $id_usuario, $clave_ruta);
            if($fila_ruta_ultima){
                $estado_ruta['nivel_titulo_2'] = isset($fila_ruta_ultima['nivel_titulo_2']) ? trim((string)$fila_ruta_ultima['nivel_titulo_2']) : $estado_ruta['nivel_titulo_2'];
                $estado_ruta['numero_titulo_2'] = isset($fila_ruta_ultima['numero_titulo_2']) ? trim((string)$fila_ruta_ultima['numero_titulo_2']) : $estado_ruta['numero_titulo_2'];
                $estado_ruta['texto_titulo_2'] = isset($fila_ruta_ultima['texto_titulo_2']) ? trim((string)$fila_ruta_ultima['texto_titulo_2']) : $estado_ruta['texto_titulo_2'];
            }

            $estado_ruta['registros'] = cargar_todas_rutas_estructurales_por_seccion($mysqli, $id_informe, $id_usuario, $clave_ruta);
        }

        if(isset($_GET['ruta_estructural_guardada']) && $_GET['ruta_estructural_guardada'] === $clave_ruta){
            $estado_ruta['primer_titulo_bloqueado'] = true;
            $estado_ruta['nivel_titulo_2'] = $cfg_ruta['nivel_titulo_2_default'];
            $estado_ruta['numero_titulo_2'] = '';
            $estado_ruta['texto_titulo_2'] = '';
            $estado_ruta['mensaje'] = 'La seccion fue guardada correctamente.';
            $estado_ruta['clase_mensaje'] = 'portada_respuesta_ok';
        }

        $secciones_rutas_estado[$clave_ruta] = $estado_ruta;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_ruta_estructural_base'])){
        $clave_post_ruta = isset($_POST['seccion_ruta_estructural']) ? trim((string)$_POST['seccion_ruta_estructural']) : '';

        if(isset($secciones_rutas_estado[$clave_post_ruta])){
            $estado_ruta_post = $secciones_rutas_estado[$clave_post_ruta];

            $estado_ruta_post['primer_titulo_bloqueado'] = isset($_POST['primer_titulo_bloqueado_ruta']) && $_POST['primer_titulo_bloqueado_ruta'] === '1';

            $estado_ruta_post['nivel_titulo_1'] = isset($_POST['nivel_titulo_1_ruta'])
                ? trim((string)$_POST['nivel_titulo_1_ruta'])
                : (isset($_POST['nivel_titulo_1_ruta_fijo']) ? trim((string)$_POST['nivel_titulo_1_ruta_fijo']) : $estado_ruta_post['nivel_titulo_1']);
            $estado_ruta_post['numero_titulo_1'] = isset($_POST['numero_titulo_1_ruta'])
                ? trim((string)$_POST['numero_titulo_1_ruta'])
                : (isset($_POST['numero_titulo_1_ruta_fijo']) ? trim((string)$_POST['numero_titulo_1_ruta_fijo']) : $estado_ruta_post['numero_titulo_1']);
            $estado_ruta_post['texto_titulo_1'] = isset($_POST['texto_titulo_1_ruta'])
                ? trim((string)$_POST['texto_titulo_1_ruta'])
                : (isset($_POST['texto_titulo_1_ruta_fijo']) ? trim((string)$_POST['texto_titulo_1_ruta_fijo']) : $estado_ruta_post['texto_titulo_1']);

            $estado_ruta_post['nivel_titulo_2'] = isset($_POST['nivel_titulo_2_ruta']) ? trim((string)$_POST['nivel_titulo_2_ruta']) : $estado_ruta_post['nivel_titulo_2'];
            $estado_ruta_post['numero_titulo_2'] = isset($_POST['numero_titulo_2_ruta']) ? trim((string)$_POST['numero_titulo_2_ruta']) : $estado_ruta_post['numero_titulo_2'];
            $estado_ruta_post['texto_titulo_2'] = isset($_POST['texto_titulo_2_ruta']) ? trim((string)$_POST['texto_titulo_2_ruta']) : $estado_ruta_post['texto_titulo_2'];
            $estado_ruta_post['ruta_principal'] = isset($_POST['ruta_principal_ruta']) ? trim((string)$_POST['ruta_principal_ruta']) : $estado_ruta_post['ruta_principal'];
            $estado_ruta_post['sin_manual_momento'] = isset($_POST['sin_manual_momento_ruta']) && $_POST['sin_manual_momento_ruta'] === '1';
            $estado_ruta_post['carpeta'] = isset($_POST['carpeta_ruta']) ? trim((string)$_POST['carpeta_ruta']) : $estado_ruta_post['carpeta'];
            $estado_ruta_post['archivo'] = isset($_POST['archivo_ruta']) ? trim((string)$_POST['archivo_ruta']) : $estado_ruta_post['archivo'];
            $estado_ruta_post['extension'] = isset($_POST['extension_ruta']) ? trim((string)$_POST['extension_ruta']) : $estado_ruta_post['extension'];
            $estado_ruta_post['ruta_extra_1'] = isset($_POST['ruta_extra_1_ruta']) ? trim((string)$_POST['ruta_extra_1_ruta']) : $estado_ruta_post['ruta_extra_1'];
            $estado_ruta_post['ruta_extra_2'] = isset($_POST['ruta_extra_2_ruta']) ? trim((string)$_POST['ruta_extra_2_ruta']) : $estado_ruta_post['ruta_extra_2'];
            $estado_ruta_post['ruta_extra_3'] = isset($_POST['ruta_extra_3_ruta']) ? trim((string)$_POST['ruta_extra_3_ruta']) : $estado_ruta_post['ruta_extra_3'];
            $estado_ruta_post['ruta_extra_4'] = isset($_POST['ruta_extra_4_ruta']) ? trim((string)$_POST['ruta_extra_4_ruta']) : $estado_ruta_post['ruta_extra_4'];

            $estado_ruta_post['nivel_titulo_1'] = normalizar_nivel_titulo($estado_ruta_post['nivel_titulo_1'], '2');
            $estado_ruta_post['nivel_titulo_2'] = normalizar_nivel_titulo($estado_ruta_post['nivel_titulo_2'], '3');

            if($id_informe <= 0 || !$es_informe_existente){
                $estado_ruta_post['mensaje'] = 'Debe guardar primero la portada del informe antes de registrar esta seccion.';
                $estado_ruta_post['clase_mensaje'] = 'portada_respuesta_error';
            }elseif(
                $estado_ruta_post['ruta_principal'] === '' &&
                $estado_ruta_post['archivo'] === '' &&
                $estado_ruta_post['extension'] === '' &&
                $estado_ruta_post['ruta_extra_1'] === '' &&
                $estado_ruta_post['ruta_extra_2'] === '' &&
                $estado_ruta_post['ruta_extra_3'] === '' &&
                $estado_ruta_post['ruta_extra_4'] === ''
            ){
                $estado_ruta_post['mensaje'] = 'Debe completar al menos una ruta o un archivo para guardar.';
                $estado_ruta_post['clase_mensaje'] = 'portada_respuesta_error';
            }else{
                $siguiente_orden_ruta = obtener_siguiente_orden_ruta_estructural($mysqli, $id_informe, $clave_post_ruta);

                $datos_ruta = array(
                    'orden' => $siguiente_orden_ruta,
                    'nivel_titulo_1' => $estado_ruta_post['nivel_titulo_1'],
                    'numero_titulo_1' => $estado_ruta_post['numero_titulo_1'],
                    'texto_titulo_1' => $estado_ruta_post['texto_titulo_1'],
                    'titulo_1_bloqueado' => 1,
                    'nivel_titulo_2' => $estado_ruta_post['nivel_titulo_2'],
                    'numero_titulo_2' => $estado_ruta_post['numero_titulo_2'],
                    'texto_titulo_2' => $estado_ruta_post['texto_titulo_2'],
                    'ruta_principal' => $estado_ruta_post['ruta_principal'],
                    'sin_manual_momento' => $estado_ruta_post['sin_manual_momento'] ? 1 : 0,
                    'carpeta' => $estado_ruta_post['carpeta'],
                    'archivo' => $estado_ruta_post['archivo'],
                    'extension' => $estado_ruta_post['extension'],
                    'ruta_extra_1' => $estado_ruta_post['ruta_extra_1'],
                    'ruta_extra_2' => $estado_ruta_post['ruta_extra_2'],
                    'ruta_extra_3' => $estado_ruta_post['ruta_extra_3'],
                    'ruta_extra_4' => $estado_ruta_post['ruta_extra_4']
                );

                if(insertar_ruta_estructural($mysqli, $id_informe, $id_usuario, $clave_post_ruta, $datos_ruta)){
                    actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario);
                    $ancla_ruta = isset($secciones_rutas_config[$clave_post_ruta]['id_html']) ? $secciones_rutas_config[$clave_post_ruta]['id_html'] : 'seccion_indice';
                    header('Location: portada.php?id_informe=' . (int)$id_informe . '&ruta_estructural_guardada=' . urlencode($clave_post_ruta) . '#' . $ancla_ruta);
                    exit();
                }

                $estado_ruta_post['mensaje'] = 'Ocurrio un error al guardar el registro de esta seccion.';
                $estado_ruta_post['clase_mensaje'] = 'portada_respuesta_error';
            }

            $estado_ruta_post['registros'] = cargar_todas_rutas_estructurales_por_seccion($mysqli, $id_informe, $id_usuario, $clave_post_ruta);
            $secciones_rutas_estado[$clave_post_ruta] = $estado_ruta_post;
        }
    }

    $secciones_fuentes_config = array(
        'fuentes_clientes' => array(
            'id_html' => 'seccion_carpeta_fuentes_clientes',
            'documento_titulo' => "CARPETA FUENTES\nFUENTES CLIENTES",
            'nivel_titulo_1_default' => '3',
            'numero_titulo_1_default' => '',
            'texto_titulo_1_default' => '',
            'nivel_titulo_2_default' => '4',
            'numero_titulo_2_default' => '',
            'texto_titulo_2_default' => '',
            'descripcion_preview' => '',
            'footer_numero' => '15'
        ),
        'fuentes_word' => array(
            'id_html' => 'seccion_carpeta_fuentes_word',
            'documento_titulo' => "CARPETA FUENTES\nFUENTES WORD",
            'nivel_titulo_1_default' => '3',
            'numero_titulo_1_default' => '',
            'texto_titulo_1_default' => '',
            'nivel_titulo_2_default' => '4',
            'numero_titulo_2_default' => '',
            'texto_titulo_2_default' => '',
            'descripcion_preview' => '',
            'footer_numero' => '16'
        )
    );

    $secciones_fuentes_estado = array();
    foreach($secciones_fuentes_config as $clave_fuente => $cfg_fuente){
        $estado_fuente = array(
            'clave' => $clave_fuente,
            'id_html' => $cfg_fuente['id_html'],
            'documento_titulo' => $cfg_fuente['documento_titulo'],
            'descripcion_preview' => $cfg_fuente['descripcion_preview'],
            'footer_numero' => $cfg_fuente['footer_numero'],
            'mensaje' => '',
            'clase_mensaje' => '',
            'nivel_titulo_1' => $cfg_fuente['nivel_titulo_1_default'],
            'numero_titulo_1' => $cfg_fuente['numero_titulo_1_default'],
            'texto_titulo_1' => $cfg_fuente['texto_titulo_1_default'],
            'nivel_titulo_2' => $cfg_fuente['nivel_titulo_2_default'],
            'numero_titulo_2' => $cfg_fuente['numero_titulo_2_default'],
            'texto_titulo_2' => $cfg_fuente['texto_titulo_2_default'],
            'nombre_fuente_nuevo' => '',
            'registros' => array()
        );

        if($id_informe > 0){
            $primera_fuente = cargar_primer_fuente_detalle($mysqli, $id_informe, $id_usuario, $clave_fuente);
            if($primera_fuente){
                $estado_fuente['nivel_titulo_1'] = isset($primera_fuente['nivel_titulo_1']) ? trim((string)$primera_fuente['nivel_titulo_1']) : $estado_fuente['nivel_titulo_1'];
                $estado_fuente['numero_titulo_1'] = isset($primera_fuente['numero_titulo_1']) ? trim((string)$primera_fuente['numero_titulo_1']) : $estado_fuente['numero_titulo_1'];
                $estado_fuente['texto_titulo_1'] = isset($primera_fuente['texto_titulo_1']) ? trim((string)$primera_fuente['texto_titulo_1']) : $estado_fuente['texto_titulo_1'];
                $estado_fuente['nivel_titulo_2'] = isset($primera_fuente['nivel_titulo_2']) ? trim((string)$primera_fuente['nivel_titulo_2']) : $estado_fuente['nivel_titulo_2'];
                $estado_fuente['numero_titulo_2'] = isset($primera_fuente['numero_titulo_2']) ? trim((string)$primera_fuente['numero_titulo_2']) : $estado_fuente['numero_titulo_2'];
                $estado_fuente['texto_titulo_2'] = isset($primera_fuente['texto_titulo_2']) ? trim((string)$primera_fuente['texto_titulo_2']) : $estado_fuente['texto_titulo_2'];
            }

            $estado_fuente['registros'] = cargar_todas_fuentes_detalle_por_seccion($mysqli, $id_informe, $id_usuario, $clave_fuente);
        }

        if(isset($_GET['fuente_guardada']) && $_GET['fuente_guardada'] === $clave_fuente){
            $estado_fuente['mensaje'] = 'La fuente fue guardada correctamente.';
            $estado_fuente['clase_mensaje'] = 'portada_respuesta_ok';
        }

        $secciones_fuentes_estado[$clave_fuente] = $estado_fuente;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_fuente_base'])){
        $clave_post_fuente = isset($_POST['seccion_fuente']) ? trim((string)$_POST['seccion_fuente']) : '';
        if(isset($secciones_fuentes_estado[$clave_post_fuente])){
            $estado_fuente_post = $secciones_fuentes_estado[$clave_post_fuente];
            $estado_fuente_post['nombre_fuente_nuevo'] = isset($_POST['nombre_fuente']) ? trim((string)$_POST['nombre_fuente']) : '';

            $estado_fuente_post['nivel_titulo_1'] = normalizar_nivel_titulo(
                isset($_POST['nivel_titulo_1_fuente']) ? trim((string)$_POST['nivel_titulo_1_fuente']) : $estado_fuente_post['nivel_titulo_1'],
                $estado_fuente_post['nivel_titulo_1']
            );
            $estado_fuente_post['numero_titulo_1'] = isset($_POST['numero_titulo_1_fuente'])
                ? trim((string)$_POST['numero_titulo_1_fuente'])
                : $estado_fuente_post['numero_titulo_1'];
            $estado_fuente_post['texto_titulo_1'] = isset($_POST['texto_titulo_1_fuente'])
                ? trim((string)$_POST['texto_titulo_1_fuente'])
                : $estado_fuente_post['texto_titulo_1'];
            $estado_fuente_post['nivel_titulo_2'] = normalizar_nivel_titulo(
                isset($_POST['nivel_titulo_2_fuente']) ? trim((string)$_POST['nivel_titulo_2_fuente']) : $estado_fuente_post['nivel_titulo_2'],
                $estado_fuente_post['nivel_titulo_2']
            );
            $estado_fuente_post['numero_titulo_2'] = isset($_POST['numero_titulo_2_fuente'])
                ? trim((string)$_POST['numero_titulo_2_fuente'])
                : $estado_fuente_post['numero_titulo_2'];
            $estado_fuente_post['texto_titulo_2'] = isset($_POST['texto_titulo_2_fuente'])
                ? trim((string)$_POST['texto_titulo_2_fuente'])
                : $estado_fuente_post['texto_titulo_2'];

            if($id_informe <= 0 || !$es_informe_existente){
                $estado_fuente_post['mensaje'] = 'Debe guardar primero la portada del informe antes de registrar fuentes.';
                $estado_fuente_post['clase_mensaje'] = 'portada_respuesta_error';
            }elseif($estado_fuente_post['nombre_fuente_nuevo'] === ''){
                $estado_fuente_post['mensaje'] = 'Debe ingresar el nombre de la fuente para guardar.';
                $estado_fuente_post['clase_mensaje'] = 'portada_respuesta_error';
            }else{
                $siguiente_orden_fuente = obtener_siguiente_orden_fuente_detalle($mysqli, $id_informe, $clave_post_fuente);
                $datos_fuente = array(
                    'orden' => $siguiente_orden_fuente,
                    'nivel_titulo_1' => $estado_fuente_post['nivel_titulo_1'],
                    'numero_titulo_1' => $estado_fuente_post['numero_titulo_1'],
                    'texto_titulo_1' => $estado_fuente_post['texto_titulo_1'],
                    'titulo_1_bloqueado' => 0,
                    'nivel_titulo_2' => $estado_fuente_post['nivel_titulo_2'],
                    'numero_titulo_2' => $estado_fuente_post['numero_titulo_2'],
                    'texto_titulo_2' => $estado_fuente_post['texto_titulo_2'],
                    'nombre_fuente' => $estado_fuente_post['nombre_fuente_nuevo']
                );

                if(insertar_fuente_detalle($mysqli, $id_informe, $id_usuario, $clave_post_fuente, $datos_fuente)){
                    actualizar_indice_informe_desde_secciones($mysqli, $id_informe, $id_usuario);
                    $ancla_fuente = isset($secciones_fuentes_config[$clave_post_fuente]['id_html']) ? $secciones_fuentes_config[$clave_post_fuente]['id_html'] : 'seccion_indice';
                    header('Location: portada.php?id_informe=' . (int)$id_informe . '&fuente_guardada=' . urlencode($clave_post_fuente) . '#' . $ancla_fuente);
                    exit();
                }

                $estado_fuente_post['mensaje'] = 'Ocurrio un error al guardar la fuente.';
                $estado_fuente_post['clase_mensaje'] = 'portada_respuesta_error';
            }

            $estado_fuente_post['registros'] = cargar_todas_fuentes_detalle_por_seccion($mysqli, $id_informe, $id_usuario, $clave_post_fuente);
            $secciones_fuentes_estado[$clave_post_fuente] = $estado_fuente_post;
        }
    }

    $caso_uso_imagenes_exportacion = array();
    if($id_informe > 0 && $es_informe_existente){
        $caso_uso_imagenes_exportacion = cargar_todas_caso_uso_imagenes($mysqli, $id_informe, $id_usuario);
    }

    $carpeta_diagramas_exportacion = array();
    if($id_informe > 0 && $es_informe_existente){
        $carpeta_diagramas_exportacion = cargar_todas_carpeta_diagramas($mysqli, $id_informe, $id_usuario);
    }

    $carpeta_informes_programas_exportacion = array();
    if($id_informe > 0 && $es_informe_existente){
        $carpeta_informes_programas_exportacion = cargar_todas_carpeta_informes_programas($mysqli, $id_informe, $id_usuario);
    }

    $carpeta_pantallazos_programas_exportacion = array();
    if($id_informe > 0 && $es_informe_existente){
        $carpeta_pantallazos_programas_exportacion = cargar_todas_carpeta_pantallazos_programas($mysqli, $id_informe, $id_usuario);
    }

    $rutas_estructurales_exportacion = array();
    if($id_informe > 0 && $es_informe_existente){
        foreach($secciones_rutas_config as $clave_ruta_exp => $cfg_ruta_exp){
            $rutas_estructurales_exportacion[$clave_ruta_exp] = cargar_todas_rutas_estructurales_por_seccion($mysqli, $id_informe, $id_usuario, $clave_ruta_exp);
        }
    }

    $fuentes_detalle_exportacion = array();
    if($id_informe > 0 && $es_informe_existente){
        foreach($secciones_fuentes_config as $clave_fuente_exp => $cfg_fuente_exp){
            $fuentes_detalle_exportacion[$clave_fuente_exp] = cargar_todas_fuentes_detalle_por_seccion($mysqli, $id_informe, $id_usuario, $clave_fuente_exp);
        }
    }

    if($id_informe > 0 && $es_informe_existente){
        $filas_indice = construir_indice_desde_secciones($mysqli, $id_informe, $id_usuario);
    }

    $datos_exportacion = array(
        'logo_itred' => $logo_itred,
        'texto_nombre_informe' => $texto_nombre_informe,
        'area_trabajo' => $area_trabajo,
        'nombre_1' => $nombre_1,
        'nombre_2' => $nombre_2,
        'nombre_3' => $nombre_3,
        'nombre_4' => $nombre_4,
        'proyecto' => $proyecto,
        'avance' => $avance,
        'solicitado_por' => $solicitado_por,
        'cargo' => $cargo,
        'texto_fecha_entrega' => $texto_fecha_entrega,
        'filas_indice' => $filas_indice,
        'introduccion' => array(
            'nivel_titulo' => $nivel_titulo,
            'numero_titulo' => $numero_titulo,
            'texto_titulo' => $texto_titulo,
            'texto_contenido' => $texto_contenido
        ),
        'base_datos' => array(
            'nivel_titulo' => $nivel_titulo_bd,
            'numero_titulo' => $numero_titulo_bd,
            'texto_titulo' => $texto_titulo_bd,
            'texto_contenido' => $texto_contenido_bd
        ),
        'documentacion_caso_uso' => array(
            'nivel_titulo_1' => $nivel_titulo_doc_1,
            'numero_titulo_1' => $numero_titulo_doc_1,
            'texto_titulo_1' => $texto_titulo_doc_1,
            'nivel_titulo_2' => $nivel_titulo_doc_2,
            'numero_titulo_2' => $numero_titulo_doc_2,
            'texto_titulo_2' => $texto_titulo_doc_2,
            'nivel_titulo_3' => $nivel_titulo_doc_3,
            'numero_titulo_3' => $numero_titulo_doc_3,
            'texto_titulo_3' => $texto_titulo_doc_3,
            'texto_contenido' => $texto_contenido_doc
        ),
        'caso_uso_imagenes' => $caso_uso_imagenes_exportacion,
        'carpeta_diagramas' => $carpeta_diagramas_exportacion,
        'carpeta_informes_programas' => $carpeta_informes_programas_exportacion,
        'carpeta_pantallazos_programas' => $carpeta_pantallazos_programas_exportacion,
        'rutas_estructurales' => $rutas_estructurales_exportacion,
        'fuentes_detalle' => $fuentes_detalle_exportacion
    );

    if(isset($_GET['exportar']) && $id_informe > 0){
        $tipo_exportacion = trim((string)$_GET['exportar']);
        if($es_informe_existente){
            $filas_indice_exportacion = construir_indice_desde_secciones($mysqli, $id_informe, $id_usuario);
            $datos_exportacion['filas_indice'] = $filas_indice_exportacion;
        }

        $html_exportacion = renderizar_html_exportacion($datos_exportacion, $tipo_exportacion);

        if($tipo_exportacion === 'word'){
            header('Content-Type: application/msword; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $nombre_archivo_base . '.doc"');
            echo $html_exportacion;
            exit();
        }

        if($tipo_exportacion === 'pdf'){
            echo $html_exportacion;
            exit();
        }

        if($tipo_exportacion === 'imprimir'){
            echo $html_exportacion;
            exit();
        }

        if($tipo_exportacion === 'preview_word'){
            echo $html_exportacion;
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>portada</title>
    <link rel="stylesheet" href="../../../css/programa/informes/portada.css">
    <link rel="stylesheet" href="../../../css/programa/informes/portada_vista_cabecera.css">
    <link rel="stylesheet" href="../../../css/programa/informes/portada_vista_indice_lateral.css">
    <link rel="stylesheet" href="../../../css/programa/informes/portada_vista_documento.css">
    <link rel="stylesheet" href="../../../css/programa/informes/portada_vista_indice.css">
    <link rel="stylesheet" href="../../../css/programa/informes/introduccion.css">
    <link rel="stylesheet" href="../../../css/programa/informes/base_datos.css">
    <link rel="stylesheet" href="../../../css/programa/informes/documentacion_caso_uso.css">
    <link rel="stylesheet" href="../../../css/programa/informes/caso_uso_imagen.css">
    <link rel="stylesheet" href="../../../css/programa/informes/carpeta_diagramas.css">
    <link rel="stylesheet" href="../../../css/programa/informes/secciones_rutas.css">
    <link rel="stylesheet" href="../../../css/programa/informes/secciones_fuentes.css">
    <script src="../../../js/programa/informes/portada_vista_cabecera.js" defer></script>
    <script src="../../../js/programa/informes/introduccion.js" defer></script>
    <script src="../../../js/programa/informes/base_datos.js" defer></script>
    <script src="../../../js/programa/informes/documentacion_caso_uso.js" defer></script>
    <script src="../../../js/programa/informes/caso_uso_imagen.js" defer></script>
    <script src="../../../js/programa/informes/carpeta_diagramas.js" defer></script>
    <script src="../../../js/programa/informes/carpeta_informes_programas.js" defer></script>
    <script src="../../../js/programa/informes/carpeta_pantallazos_programas.js" defer></script>
    <script src="../../../js/programa/informes/rutas_estructurales.js" defer></script>
    <script src="../../../js/programa/informes/fuentes_detalle.js" defer></script>
</head>
<body>

    
    
    <main class="portada_contenedor_principal">

        <?php require 'portada_vista_cabecera.php'; ?>

        
        
        <section class="portada_layout_general">

            <?php require 'portada_vista_indice_lateral.php'; ?>

            
            
            <section class="portada_columna_contenido">

                <?php require 'portada_vista_documento.php'; ?>

                <?php require 'portada_vista_indice.php'; ?>    

                <?php require 'portada_vista_introduccion.php'; ?>

                <?php require 'portada_vista_base_datos.php'; ?>

                <?php require 'portada_vista_documentacion_caso_uso.php'; ?>

                <?php require 'portada_vista_caso_uso_imagen.php'; ?>

                <?php require 'portada_vista_carpeta_diagramas.php'; ?>

                <?php require 'portada_vista_carpeta_informes_programas.php'; ?>

                <?php require 'portada_vista_carpeta_medios_pago.php'; ?>

                <?php require 'portada_vista_carpeta_medios_envio.php'; ?>

                <?php require 'portada_vista_carpeta_medios_reparto.php'; ?>

                <?php require 'portada_vista_carpeta_manuales_clientes.php'; ?>

                <?php require 'portada_vista_carpeta_manuales_tecnicos.php'; ?>

                <?php require 'portada_vista_carpeta_pantallazos_programas.php'; ?>

                <?php require 'portada_vista_carpeta_fuentes_clientes.php'; ?>

                <?php require 'portada_vista_carpeta_fuentes_word.php'; ?>

            </section>

        </section>

    </main>

</body>
</html>

<?php
    $mysqli->close();
?>


