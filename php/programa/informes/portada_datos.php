<?php

    // =====================================================================================================
    // INFORMES (TABLA: informes)
    // =====================================================================================================

    function cargar_informe($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("
            SELECT
                id,
                nombre_informe,
                area_trabajo,
                nombre_1,
                nombre_2,
                nombre_3,
                nombre_4,
                proyecto,
                avance,
                solicitado_por,
                cargo,
                fecha_entrega,
                indice
            FROM informes
            WHERE id = ? AND id_usuario = ?
            LIMIT 1
        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if($resultado && $resultado->num_rows > 0){
            $fila = $resultado->fetch_assoc();
            $consulta->close();
            return $fila;
        }

        $consulta->close();
        return null;
    }

    function insertar_informe($mysqli, $datos, $id_usuario){
        $nombre_informe = $datos['nombre_informe'];
        $area_trabajo   = $datos['area_trabajo'];
        $nombre_1       = $datos['nombre_1'];
        $nombre_2       = $datos['nombre_2'];
        $nombre_3       = $datos['nombre_3'];
        $nombre_4       = $datos['nombre_4'];
        $proyecto       = $datos['proyecto'];
        $avance         = $datos['avance'];
        $solicitado_por = $datos['solicitado_por'];
        $cargo          = $datos['cargo'];
        $fecha_entrega  = $datos['fecha_entrega'];
        $indice         = $datos['indice'];

        $consulta = $mysqli->prepare("
            INSERT INTO informes (
                id_usuario,
                nombre_informe,
                area_trabajo,
                nombre_1,
                nombre_2,
                nombre_3,
                nombre_4,
                proyecto,
                avance,
                solicitado_por,
                cargo,
                fecha_entrega,
                indice,
                fecha_creacion
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        if(!$consulta){
            return false;
        }

        $consulta->bind_param(
            "issssssssssss",
            $id_usuario,
            $nombre_informe,
            $area_trabajo,
            $nombre_1,
            $nombre_2,
            $nombre_3,
            $nombre_4,
            $proyecto,
            $avance,
            $solicitado_por,
            $cargo,
            $fecha_entrega,
            $indice
        );

        if($consulta->execute()){
            $nuevo_id = (int)$consulta->insert_id;
            $consulta->close();
            return $nuevo_id;
        }

        $consulta->close();
        return false;
    }

    function actualizar_informe($mysqli, $datos, $id_informe, $id_usuario){
        $nombre_informe = $datos['nombre_informe'];
        $area_trabajo   = $datos['area_trabajo'];
        $nombre_1       = $datos['nombre_1'];
        $nombre_2       = $datos['nombre_2'];
        $nombre_3       = $datos['nombre_3'];
        $nombre_4       = $datos['nombre_4'];
        $proyecto       = $datos['proyecto'];
        $avance         = $datos['avance'];
        $solicitado_por = $datos['solicitado_por'];
        $cargo          = $datos['cargo'];
        $fecha_entrega  = $datos['fecha_entrega'];
        $indice         = $datos['indice'];

        $consulta = $mysqli->prepare("
            UPDATE informes
            SET
                nombre_informe = ?,
                area_trabajo = ?,
                nombre_1 = ?,
                nombre_2 = ?,
                nombre_3 = ?,
                nombre_4 = ?,
                proyecto = ?,
                avance = ?,
                solicitado_por = ?,
                cargo = ?,
                fecha_entrega = ?,
                indice = ?
            WHERE id = ? AND id_usuario = ?
        ");

        if(!$consulta){
            return false;
        }

        $consulta->bind_param(
            "ssssssssssssii",
            $nombre_informe,
            $area_trabajo,
            $nombre_1,
            $nombre_2,
            $nombre_3,
            $nombre_4,
            $proyecto,
            $avance,
            $solicitado_por,
            $cargo,
            $fecha_entrega,
            $indice,
            $id_informe,
            $id_usuario
        );

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    // =====================================================================================================
    // INTRODUCCION (TABLA: introduccion)
    // =====================================================================================================

    function cargar_introduccion_informe($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("
            SELECT
                intro.id_informe,
                intro.nivel_titulo,
                intro.numero_titulo,
                intro.texto_titulo,
                intro.texto_contenido
            FROM introduccion intro
            INNER JOIN informes i ON i.id = intro.id_informe
            WHERE intro.id_informe = ? AND i.id_usuario = ?
            LIMIT 1
        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if($resultado && $resultado->num_rows > 0){
            $fila = $resultado->fetch_assoc();
            $consulta->close();
            return $fila;
        }

        $consulta->close();
        return null;
    }

    function guardar_introduccion_informe($mysqli, $id_informe, $id_usuario, $datos){
        if(!cargar_informe($mysqli, $id_informe, $id_usuario)){
            return false;
        }

        $nivel_titulo    = $datos['nivel_titulo'];
        $numero_titulo   = $datos['numero_titulo'];
        $texto_titulo    = $datos['texto_titulo'];
        $texto_contenido = $datos['texto_contenido'];

        $consulta_existente = $mysqli->prepare("
            SELECT id FROM introduccion WHERE id_informe = ? LIMIT 1
        ");

        if(!$consulta_existente){
            return false;
        }

        $consulta_existente->bind_param("i", $id_informe);
        $consulta_existente->execute();
        $resultado_existente = $consulta_existente->get_result();
        $fila_existente = $resultado_existente ? $resultado_existente->fetch_assoc() : null;
        $consulta_existente->close();

        if($fila_existente){
            $consulta = $mysqli->prepare("
                UPDATE introduccion
                SET
                    nivel_titulo = ?,
                    numero_titulo = ?,
                    texto_titulo = ?,
                    texto_contenido = ?,
                    fecha_modificacion = NOW()
                WHERE id_informe = ?
            ");

            if(!$consulta){ return false; }

            $consulta->bind_param("ssssi", $nivel_titulo, $numero_titulo, $texto_titulo, $texto_contenido, $id_informe);
        }else{
            $consulta = $mysqli->prepare("
                INSERT INTO introduccion (
                    id_informe,
                    nivel_titulo,
                    numero_titulo,
                    texto_titulo,
                    texto_contenido,
                    fecha_creacion,
                    fecha_modificacion
                ) VALUES (?, ?, ?, ?, ?, NOW(), NOW())
            ");

            if(!$consulta){ return false; }

            $consulta->bind_param("issss", $id_informe, $nivel_titulo, $numero_titulo, $texto_titulo, $texto_contenido);
        }

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    // =====================================================================================================
    // CARPETA BASE DE DATOS (TABLA: base_datos)
    // =====================================================================================================

    function cargar_base_datos_informe($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                bd.id_informe,\n                bd.nivel_titulo,\n                bd.numero_titulo,\n                bd.texto_titulo,\n                bd.texto_contenido\n            FROM base_datos bd\n            INNER JOIN informes i ON i.id = bd.id_informe\n            WHERE bd.id_informe = ? AND i.id_usuario = ?\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if($resultado && $resultado->num_rows > 0){
            $fila = $resultado->fetch_assoc();
            $consulta->close();
            return $fila;
        }

        $consulta->close();
        return null;
    }

    function guardar_base_datos_informe($mysqli, $id_informe, $id_usuario, $datos){
        if(!cargar_informe($mysqli, $id_informe, $id_usuario)){
            return false;
        }

        $nivel_titulo = $datos['nivel_titulo'];
        $numero_titulo = $datos['numero_titulo'];
        $texto_titulo = $datos['texto_titulo'];
        $texto_contenido = $datos['texto_contenido'];

        $consulta_existente = $mysqli->prepare("\n            SELECT id\n            FROM base_datos\n            WHERE id_informe = ?\n            LIMIT 1\n        ");

        if(!$consulta_existente){
            return false;
        }

        $consulta_existente->bind_param("i", $id_informe);
        $consulta_existente->execute();
        $resultado_existente = $consulta_existente->get_result();
        $fila_existente = $resultado_existente ? $resultado_existente->fetch_assoc() : null;
        $consulta_existente->close();

        if($fila_existente){
            $consulta = $mysqli->prepare("\n                UPDATE base_datos\n                SET\n                    nivel_titulo = ?,\n                    numero_titulo = ?,\n                    texto_titulo = ?,\n                    texto_contenido = ?,\n                    fecha_modificacion = NOW()\n                WHERE id_informe = ?\n            ");

            if(!$consulta){
                return false;
            }

            $consulta->bind_param(
                "ssssi",
                $nivel_titulo,
                $numero_titulo,
                $texto_titulo,
                $texto_contenido,
                $id_informe
            );
        }else{
            $consulta = $mysqli->prepare("\n                INSERT INTO base_datos (\n                    id_informe,\n                    nivel_titulo,\n                    numero_titulo,\n                    texto_titulo,\n                    texto_contenido,\n                    fecha_creacion,\n                    fecha_modificacion\n                ) VALUES (?, ?, ?, ?, ?, NOW(), NOW())\n            ");

            if(!$consulta){
                return false;
            }

            $consulta->bind_param(
                "issss",
                $id_informe,
                $nivel_titulo,
                $numero_titulo,
                $texto_titulo,
                $texto_contenido
            );
        }

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    // =====================================================================================================
    // CARPETA DOCUMENTACION / CASO DE USO (TABLA: documentacion_caso_uso)
    // =====================================================================================================

    function cargar_documentacion_caso_uso_informe($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                doc.id_informe,\n                doc.nivel_titulo_1,\n                doc.numero_titulo_1,\n                doc.texto_titulo_1,\n                doc.nivel_titulo_2,\n                doc.numero_titulo_2,\n                doc.texto_titulo_2,\n                doc.nivel_titulo_3,\n                doc.numero_titulo_3,\n                doc.texto_titulo_3,\n                doc.texto_contenido\n            FROM documentacion_caso_uso doc\n            INNER JOIN informes i ON i.id = doc.id_informe\n            WHERE doc.id_informe = ? AND i.id_usuario = ?\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if($resultado && $resultado->num_rows > 0){
            $fila = $resultado->fetch_assoc();
            $consulta->close();
            return $fila;
        }

        $consulta->close();
        return null;
    }

    function guardar_documentacion_caso_uso_informe($mysqli, $id_informe, $id_usuario, $datos){
        if(!cargar_informe($mysqli, $id_informe, $id_usuario)){
            return false;
        }

        $nivel_titulo_1 = $datos['nivel_titulo_1'];
        $numero_titulo_1 = $datos['numero_titulo_1'];
        $texto_titulo_1 = $datos['texto_titulo_1'];
        $nivel_titulo_2 = $datos['nivel_titulo_2'];
        $numero_titulo_2 = $datos['numero_titulo_2'];
        $texto_titulo_2 = $datos['texto_titulo_2'];
        $nivel_titulo_3 = $datos['nivel_titulo_3'];
        $numero_titulo_3 = $datos['numero_titulo_3'];
        $texto_titulo_3 = $datos['texto_titulo_3'];
        $texto_contenido = $datos['texto_contenido'];

        $consulta_existente = $mysqli->prepare("\n            SELECT id\n            FROM documentacion_caso_uso\n            WHERE id_informe = ?\n            LIMIT 1\n        ");

        if(!$consulta_existente){
            return false;
        }

        $consulta_existente->bind_param("i", $id_informe);
        $consulta_existente->execute();
        $resultado_existente = $consulta_existente->get_result();
        $fila_existente = $resultado_existente ? $resultado_existente->fetch_assoc() : null;
        $consulta_existente->close();

        if($fila_existente){
            $consulta = $mysqli->prepare("\n                UPDATE documentacion_caso_uso\n                SET\n                    nivel_titulo_1 = ?,\n                    numero_titulo_1 = ?,\n                    texto_titulo_1 = ?,\n                    nivel_titulo_2 = ?,\n                    numero_titulo_2 = ?,\n                    texto_titulo_2 = ?,\n                    nivel_titulo_3 = ?,\n                    numero_titulo_3 = ?,\n                    texto_titulo_3 = ?,\n                    texto_contenido = ?,\n                    fecha_modificacion = NOW()\n                WHERE id_informe = ?\n            ");

            if(!$consulta){
                return false;
            }

            $consulta->bind_param(
                "ssssssssssi",
                $nivel_titulo_1,
                $numero_titulo_1,
                $texto_titulo_1,
                $nivel_titulo_2,
                $numero_titulo_2,
                $texto_titulo_2,
                $nivel_titulo_3,
                $numero_titulo_3,
                $texto_titulo_3,
                $texto_contenido,
                $id_informe
            );
        }else{
            $consulta = $mysqli->prepare("\n                INSERT INTO documentacion_caso_uso (\n                    id_informe,\n                    nivel_titulo_1,\n                    numero_titulo_1,\n                    texto_titulo_1,\n                    nivel_titulo_2,\n                    numero_titulo_2,\n                    texto_titulo_2,\n                    nivel_titulo_3,\n                    numero_titulo_3,\n                    texto_titulo_3,\n                    texto_contenido,\n                    fecha_creacion,\n                    fecha_modificacion\n                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())\n            ");

            if(!$consulta){
                return false;
            }

            $consulta->bind_param(
                "issssssssss",
                $id_informe,
                $nivel_titulo_1,
                $numero_titulo_1,
                $texto_titulo_1,
                $nivel_titulo_2,
                $numero_titulo_2,
                $texto_titulo_2,
                $nivel_titulo_3,
                $numero_titulo_3,
                $texto_titulo_3,
                $texto_contenido
            );
        }

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    // =====================================================================================================
    // CASO DE USO CON IMAGENES (TABLA: caso_uso_imagen)
    // =====================================================================================================

    function cargar_primer_caso_uso_imagen($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cu.id,\n                cu.id_informe,\n                cu.orden,\n                cu.nivel_titulo_1,\n                cu.numero_titulo_1,\n                cu.texto_titulo_1,\n                cu.titulo_1_bloqueado,\n                cu.nivel_titulo_2,\n                cu.numero_titulo_2,\n                cu.texto_titulo_2,\n                cu.nombre_imagen,\n                cu.ruta_imagen\n            FROM caso_uso_imagen cu\n            INNER JOIN informes i ON i.id = cu.id_informe\n            WHERE cu.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cu.orden ASC, cu.id ASC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function cargar_ultimo_caso_uso_imagen($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cu.id,\n                cu.id_informe,\n                cu.orden,\n                cu.nivel_titulo_1,\n                cu.numero_titulo_1,\n                cu.texto_titulo_1,\n                cu.titulo_1_bloqueado,\n                cu.nivel_titulo_2,\n                cu.numero_titulo_2,\n                cu.texto_titulo_2,\n                cu.nombre_imagen,\n                cu.ruta_imagen\n            FROM caso_uso_imagen cu\n            INNER JOIN informes i ON i.id = cu.id_informe\n            WHERE cu.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cu.orden DESC, cu.id DESC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function obtener_siguiente_orden_caso_uso_imagen($mysqli, $id_informe){
        $consulta = $mysqli->prepare("\n            SELECT COALESCE(MAX(orden), 0) + 1 AS siguiente_orden\n            FROM caso_uso_imagen\n            WHERE id_informe = ?\n            LIMIT 1\n        ");

        if(!$consulta){
            return 1;
        }

        $consulta->bind_param("i", $id_informe);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();

        if(!$fila || !isset($fila['siguiente_orden'])){
            return 1;
        }

        return max(1, (int)$fila['siguiente_orden']);
    }

    function insertar_caso_uso_imagen($mysqli, $id_informe, $id_usuario, $datos){
        if(!cargar_informe($mysqli, $id_informe, $id_usuario)){
            return false;
        }

        $orden = isset($datos['orden']) ? (int)$datos['orden'] : 1;
        if($orden < 1){
            $orden = 1;
        }

        $nivel_titulo_1 = $datos['nivel_titulo_1'];
        $numero_titulo_1 = $datos['numero_titulo_1'];
        $texto_titulo_1 = $datos['texto_titulo_1'];
        $titulo_1_bloqueado = isset($datos['titulo_1_bloqueado']) ? (int)$datos['titulo_1_bloqueado'] : 1;
        $nivel_titulo_2 = $datos['nivel_titulo_2'];
        $numero_titulo_2 = $datos['numero_titulo_2'];
        $texto_titulo_2 = $datos['texto_titulo_2'];
        $nombre_imagen = $datos['nombre_imagen'];
        $ruta_imagen = $datos['ruta_imagen'];

        $consulta = $mysqli->prepare("\n            INSERT INTO caso_uso_imagen (\n                id_informe,\n                orden,\n                nivel_titulo_1,\n                numero_titulo_1,\n                texto_titulo_1,\n                titulo_1_bloqueado,\n                nivel_titulo_2,\n                numero_titulo_2,\n                texto_titulo_2,\n                nombre_imagen,\n                ruta_imagen,\n                fecha_creacion,\n                fecha_modificacion\n            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())\n        ");

        if(!$consulta){
            return false;
        }

        $consulta->bind_param(
            "iisssisssss",
            $id_informe,
            $orden,
            $nivel_titulo_1,
            $numero_titulo_1,
            $texto_titulo_1,
            $titulo_1_bloqueado,
            $nivel_titulo_2,
            $numero_titulo_2,
            $texto_titulo_2,
            $nombre_imagen,
            $ruta_imagen
        );

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    function cargar_todas_caso_uso_imagenes($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("
            SELECT
                cu.id,
                cu.id_informe,
                cu.orden,
                cu.nivel_titulo_1,
                cu.numero_titulo_1,
                cu.texto_titulo_1,
                cu.titulo_1_bloqueado,
                cu.nivel_titulo_2,
                cu.numero_titulo_2,
                cu.texto_titulo_2,
                cu.nombre_imagen,
                cu.ruta_imagen
            FROM caso_uso_imagen cu
            INNER JOIN informes i ON i.id = cu.id_informe
            WHERE cu.id_informe = ? AND i.id_usuario = ?
            ORDER BY cu.orden ASC, cu.id ASC
        ");

        if(!$consulta){
            return array();
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $filas = array();

        if($resultado && $resultado->num_rows > 0){
            while($fila = $resultado->fetch_assoc()){
                $filas[] = $fila;
            }
        }

        $consulta->close();
        return $filas;
    }

    // =====================================================================================================
    // CARPETA DIAGRAMAS (TABLA: carpeta_diagramas)
    // =====================================================================================================

    function cargar_primer_carpeta_diagrama($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cd.id,\n                cd.id_informe,\n                cd.orden,\n                cd.nivel_titulo_1,\n                cd.numero_titulo_1,\n                cd.texto_titulo_1,\n                cd.titulo_1_bloqueado,\n                cd.nivel_titulo_2,\n                cd.numero_titulo_2,\n                cd.texto_titulo_2,\n                cd.nombre_imagen,\n                cd.ruta_imagen\n            FROM carpeta_diagramas cd\n            INNER JOIN informes i ON i.id = cd.id_informe\n            WHERE cd.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cd.orden ASC, cd.id ASC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function cargar_ultimo_carpeta_diagrama($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cd.id,\n                cd.id_informe,\n                cd.orden,\n                cd.nivel_titulo_1,\n                cd.numero_titulo_1,\n                cd.texto_titulo_1,\n                cd.titulo_1_bloqueado,\n                cd.nivel_titulo_2,\n                cd.numero_titulo_2,\n                cd.texto_titulo_2,\n                cd.nombre_imagen,\n                cd.ruta_imagen\n            FROM carpeta_diagramas cd\n            INNER JOIN informes i ON i.id = cd.id_informe\n            WHERE cd.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cd.orden DESC, cd.id DESC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function obtener_siguiente_orden_carpeta_diagrama($mysqli, $id_informe){
        $consulta = $mysqli->prepare("\n            SELECT COALESCE(MAX(orden), 0) + 1 AS siguiente_orden\n            FROM carpeta_diagramas\n            WHERE id_informe = ?\n            LIMIT 1\n        ");

        if(!$consulta){
            return 1;
        }

        $consulta->bind_param("i", $id_informe);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();

        if(!$fila || !isset($fila['siguiente_orden'])){
            return 1;
        }

        return max(1, (int)$fila['siguiente_orden']);
    }

    function insertar_carpeta_diagrama($mysqli, $id_informe, $id_usuario, $datos){
        if(!cargar_informe($mysqli, $id_informe, $id_usuario)){
            return false;
        }

        $orden = isset($datos['orden']) ? (int)$datos['orden'] : 1;
        if($orden < 1){
            $orden = 1;
        }

        $nivel_titulo_1 = $datos['nivel_titulo_1'];
        $numero_titulo_1 = $datos['numero_titulo_1'];
        $texto_titulo_1 = $datos['texto_titulo_1'];
        $titulo_1_bloqueado = isset($datos['titulo_1_bloqueado']) ? (int)$datos['titulo_1_bloqueado'] : 1;
        $nivel_titulo_2 = $datos['nivel_titulo_2'];
        $numero_titulo_2 = $datos['numero_titulo_2'];
        $texto_titulo_2 = $datos['texto_titulo_2'];
        $nombre_imagen = $datos['nombre_imagen'];
        $ruta_imagen = $datos['ruta_imagen'];

        $consulta = $mysqli->prepare("\n            INSERT INTO carpeta_diagramas (\n                id_informe,\n                orden,\n                nivel_titulo_1,\n                numero_titulo_1,\n                texto_titulo_1,\n                titulo_1_bloqueado,\n                nivel_titulo_2,\n                numero_titulo_2,\n                texto_titulo_2,\n                nombre_imagen,\n                ruta_imagen,\n                fecha_creacion,\n                fecha_modificacion\n            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())\n        ");

        if(!$consulta){
            return false;
        }

        $consulta->bind_param(
            "iisssisssss",
            $id_informe,
            $orden,
            $nivel_titulo_1,
            $numero_titulo_1,
            $texto_titulo_1,
            $titulo_1_bloqueado,
            $nivel_titulo_2,
            $numero_titulo_2,
            $texto_titulo_2,
            $nombre_imagen,
            $ruta_imagen
        );

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    function cargar_todas_carpeta_diagramas($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cd.id,\n                cd.id_informe,\n                cd.orden,\n                cd.nivel_titulo_1,\n                cd.numero_titulo_1,\n                cd.texto_titulo_1,\n                cd.titulo_1_bloqueado,\n                cd.nivel_titulo_2,\n                cd.numero_titulo_2,\n                cd.texto_titulo_2,\n                cd.nombre_imagen,\n                cd.ruta_imagen\n            FROM carpeta_diagramas cd\n            INNER JOIN informes i ON i.id = cd.id_informe\n            WHERE cd.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cd.orden ASC, cd.id ASC\n        ");

        if(!$consulta){
            return array();
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $filas = array();

        if($resultado && $resultado->num_rows > 0){
            while($fila = $resultado->fetch_assoc()){
                $filas[] = $fila;
            }
        }

        $consulta->close();
        return $filas;
    }

    // =====================================================================================================
    // CARPETA PANTALLAZOS PROGRAMAS (TABLA: carpeta_pantallazos_programas)
    // =====================================================================================================

    function cargar_primer_carpeta_pantallazos_programa($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cp.id,\n                cp.id_informe,\n                cp.orden,\n                cp.nivel_titulo_1,\n                cp.numero_titulo_1,\n                cp.texto_titulo_1,\n                cp.titulo_1_bloqueado,\n                cp.nivel_titulo_2,\n                cp.numero_titulo_2,\n                cp.texto_titulo_2,\n                cp.nombre_imagen,\n                cp.ruta_imagen\n            FROM carpeta_pantallazos_programas cp\n            INNER JOIN informes i ON i.id = cp.id_informe\n            WHERE cp.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cp.orden ASC, cp.id ASC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function cargar_ultimo_carpeta_pantallazos_programa($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cp.id,\n                cp.id_informe,\n                cp.orden,\n                cp.nivel_titulo_1,\n                cp.numero_titulo_1,\n                cp.texto_titulo_1,\n                cp.titulo_1_bloqueado,\n                cp.nivel_titulo_2,\n                cp.numero_titulo_2,\n                cp.texto_titulo_2,\n                cp.nombre_imagen,\n                cp.ruta_imagen\n            FROM carpeta_pantallazos_programas cp\n            INNER JOIN informes i ON i.id = cp.id_informe\n            WHERE cp.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cp.orden DESC, cp.id DESC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function obtener_siguiente_orden_carpeta_pantallazos_programa($mysqli, $id_informe){
        $consulta = $mysqli->prepare("\n            SELECT COALESCE(MAX(orden), 0) + 1 AS siguiente_orden\n            FROM carpeta_pantallazos_programas\n            WHERE id_informe = ?\n            LIMIT 1\n        ");

        if(!$consulta){
            return 1;
        }

        $consulta->bind_param("i", $id_informe);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();

        if(!$fila || !isset($fila['siguiente_orden'])){
            return 1;
        }

        return max(1, (int)$fila['siguiente_orden']);
    }

    function insertar_carpeta_pantallazos_programa($mysqli, $id_informe, $id_usuario, $datos){
        if(!cargar_informe($mysqli, $id_informe, $id_usuario)){
            return false;
        }

        $orden = isset($datos['orden']) ? (int)$datos['orden'] : 1;
        if($orden < 1){
            $orden = 1;
        }

        $nivel_titulo_1 = $datos['nivel_titulo_1'];
        $numero_titulo_1 = $datos['numero_titulo_1'];
        $texto_titulo_1 = $datos['texto_titulo_1'];
        $titulo_1_bloqueado = isset($datos['titulo_1_bloqueado']) ? (int)$datos['titulo_1_bloqueado'] : 1;
        $nivel_titulo_2 = $datos['nivel_titulo_2'];
        $numero_titulo_2 = $datos['numero_titulo_2'];
        $texto_titulo_2 = $datos['texto_titulo_2'];
        $nombre_imagen = $datos['nombre_imagen'];
        $ruta_imagen = $datos['ruta_imagen'];

        $consulta = $mysqli->prepare("\n            INSERT INTO carpeta_pantallazos_programas (\n                id_informe,\n                orden,\n                nivel_titulo_1,\n                numero_titulo_1,\n                texto_titulo_1,\n                titulo_1_bloqueado,\n                nivel_titulo_2,\n                numero_titulo_2,\n                texto_titulo_2,\n                nombre_imagen,\n                ruta_imagen,\n                fecha_creacion,\n                fecha_modificacion\n            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())\n        ");

        if(!$consulta){
            return false;
        }

        $consulta->bind_param(
            "iisssisssss",
            $id_informe,
            $orden,
            $nivel_titulo_1,
            $numero_titulo_1,
            $texto_titulo_1,
            $titulo_1_bloqueado,
            $nivel_titulo_2,
            $numero_titulo_2,
            $texto_titulo_2,
            $nombre_imagen,
            $ruta_imagen
        );

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    function cargar_todas_carpeta_pantallazos_programas($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cp.id,\n                cp.id_informe,\n                cp.orden,\n                cp.nivel_titulo_1,\n                cp.numero_titulo_1,\n                cp.texto_titulo_1,\n                cp.titulo_1_bloqueado,\n                cp.nivel_titulo_2,\n                cp.numero_titulo_2,\n                cp.texto_titulo_2,\n                cp.nombre_imagen,\n                cp.ruta_imagen\n            FROM carpeta_pantallazos_programas cp\n            INNER JOIN informes i ON i.id = cp.id_informe\n            WHERE cp.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cp.orden ASC, cp.id ASC\n        ");

        if(!$consulta){
            return array();
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $filas = array();

        if($resultado && $resultado->num_rows > 0){
            while($fila = $resultado->fetch_assoc()){
                $filas[] = $fila;
            }
        }

        $consulta->close();
        return $filas;
    }

    // =====================================================================================================
    // CARPETA INFORMES PROGRAMAS (TABLA: carpeta_informes_programas)
    // =====================================================================================================

    function cargar_primer_carpeta_informes_programa($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cip.id,\n                cip.id_informe,\n                cip.orden,\n                cip.nivel_titulo_1,\n                cip.numero_titulo_1,\n                cip.texto_titulo_1,\n                cip.titulo_1_bloqueado,\n                cip.nivel_titulo_2,\n                cip.numero_titulo_2,\n                cip.texto_titulo_2,\n                cip.ruta_principal,\n                cip.sin_manual_momento,\n                cip.carpeta,\n                cip.archivo,\n                cip.extension,\n                cip.ruta_extra_1,\n                cip.ruta_extra_2,\n                cip.ruta_extra_3,\n                cip.ruta_extra_4\n            FROM carpeta_informes_programas cip\n            INNER JOIN informes i ON i.id = cip.id_informe\n            WHERE cip.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cip.orden ASC, cip.id ASC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function cargar_ultimo_carpeta_informes_programa($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cip.id,\n                cip.id_informe,\n                cip.orden,\n                cip.nivel_titulo_1,\n                cip.numero_titulo_1,\n                cip.texto_titulo_1,\n                cip.titulo_1_bloqueado,\n                cip.nivel_titulo_2,\n                cip.numero_titulo_2,\n                cip.texto_titulo_2,\n                cip.ruta_principal,\n                cip.sin_manual_momento,\n                cip.carpeta,\n                cip.archivo,\n                cip.extension,\n                cip.ruta_extra_1,\n                cip.ruta_extra_2,\n                cip.ruta_extra_3,\n                cip.ruta_extra_4\n            FROM carpeta_informes_programas cip\n            INNER JOIN informes i ON i.id = cip.id_informe\n            WHERE cip.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cip.orden DESC, cip.id DESC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function obtener_siguiente_orden_carpeta_informes_programa($mysqli, $id_informe){
        $consulta = $mysqli->prepare("\n            SELECT COALESCE(MAX(orden), 0) + 1 AS siguiente_orden\n            FROM carpeta_informes_programas\n            WHERE id_informe = ?\n            LIMIT 1\n        ");

        if(!$consulta){
            return 1;
        }

        $consulta->bind_param("i", $id_informe);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();

        if(!$fila || !isset($fila['siguiente_orden'])){
            return 1;
        }

        return max(1, (int)$fila['siguiente_orden']);
    }

    function insertar_carpeta_informes_programa($mysqli, $id_informe, $id_usuario, $datos){
        if(!cargar_informe($mysqli, $id_informe, $id_usuario)){
            return false;
        }

        $orden = isset($datos['orden']) ? (int)$datos['orden'] : 1;
        if($orden < 1){
            $orden = 1;
        }

        $nivel_titulo_1 = $datos['nivel_titulo_1'];
        $numero_titulo_1 = $datos['numero_titulo_1'];
        $texto_titulo_1 = $datos['texto_titulo_1'];
        $titulo_1_bloqueado = isset($datos['titulo_1_bloqueado']) ? (int)$datos['titulo_1_bloqueado'] : 1;
        $nivel_titulo_2 = $datos['nivel_titulo_2'];
        $numero_titulo_2 = $datos['numero_titulo_2'];
        $texto_titulo_2 = $datos['texto_titulo_2'];
        $ruta_principal = $datos['ruta_principal'];
        $sin_manual_momento = isset($datos['sin_manual_momento']) ? (int)$datos['sin_manual_momento'] : 0;
        $carpeta = $datos['carpeta'];
        $archivo = $datos['archivo'];
        $extension = $datos['extension'];
        $ruta_extra_1 = $datos['ruta_extra_1'];
        $ruta_extra_2 = $datos['ruta_extra_2'];
        $ruta_extra_3 = $datos['ruta_extra_3'];
        $ruta_extra_4 = $datos['ruta_extra_4'];

        $consulta = $mysqli->prepare("\n            INSERT INTO carpeta_informes_programas (\n                id_informe,\n                orden,\n                nivel_titulo_1,\n                numero_titulo_1,\n                texto_titulo_1,\n                titulo_1_bloqueado,\n                nivel_titulo_2,\n                numero_titulo_2,\n                texto_titulo_2,\n                ruta_principal,\n                sin_manual_momento,\n                carpeta,\n                archivo,\n                extension,\n                ruta_extra_1,\n                ruta_extra_2,\n                ruta_extra_3,\n                ruta_extra_4,\n                fecha_creacion,\n                fecha_modificacion\n            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())\n        ");

        if(!$consulta){
            return false;
        }

        $consulta->bind_param(
            "iisssissssisssssss",
            $id_informe,
            $orden,
            $nivel_titulo_1,
            $numero_titulo_1,
            $texto_titulo_1,
            $titulo_1_bloqueado,
            $nivel_titulo_2,
            $numero_titulo_2,
            $texto_titulo_2,
            $ruta_principal,
            $sin_manual_momento,
            $carpeta,
            $archivo,
            $extension,
            $ruta_extra_1,
            $ruta_extra_2,
            $ruta_extra_3,
            $ruta_extra_4
        );

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    function cargar_todas_carpeta_informes_programas($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cip.id,\n                cip.id_informe,\n                cip.orden,\n                cip.nivel_titulo_1,\n                cip.numero_titulo_1,\n                cip.texto_titulo_1,\n                cip.titulo_1_bloqueado,\n                cip.nivel_titulo_2,\n                cip.numero_titulo_2,\n                cip.texto_titulo_2,\n                cip.ruta_principal,\n                cip.sin_manual_momento,\n                cip.carpeta,\n                cip.archivo,\n                cip.extension,\n                cip.ruta_extra_1,\n                cip.ruta_extra_2,\n                cip.ruta_extra_3,\n                cip.ruta_extra_4\n            FROM carpeta_informes_programas cip\n            INNER JOIN informes i ON i.id = cip.id_informe\n            WHERE cip.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cip.orden ASC, cip.id ASC\n        ");

        if(!$consulta){
            return array();
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $filas = array();

        if($resultado && $resultado->num_rows > 0){
            while($fila = $resultado->fetch_assoc()){
                $filas[] = $fila;
            }
        }

        $consulta->close();
        return $filas;
    }

    // =====================================================================================================
    // CARPETAS RUTAS ESTRUCTURALES (TABLA: carpeta_rutas_estructurales)
    // =====================================================================================================

    function cargar_primer_ruta_estructural($mysqli, $id_informe, $id_usuario, $seccion){
        $consulta = $mysqli->prepare("\n            SELECT\n                cr.id,\n                cr.id_informe,\n                cr.seccion,\n                cr.orden,\n                cr.nivel_titulo_1,\n                cr.numero_titulo_1,\n                cr.texto_titulo_1,\n                cr.titulo_1_bloqueado,\n                cr.nivel_titulo_2,\n                cr.numero_titulo_2,\n                cr.texto_titulo_2,\n                cr.ruta_principal,\n                cr.sin_manual_momento,\n                cr.carpeta,\n                cr.archivo,\n                cr.extension,\n                cr.ruta_extra_1,\n                cr.ruta_extra_2,\n                cr.ruta_extra_3,\n                cr.ruta_extra_4\n            FROM carpeta_rutas_estructurales cr\n            INNER JOIN informes i ON i.id = cr.id_informe\n            WHERE cr.id_informe = ? AND i.id_usuario = ? AND cr.seccion = ?\n            ORDER BY cr.orden ASC, cr.id ASC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("iis", $id_informe, $id_usuario, $seccion);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function cargar_ultimo_ruta_estructural($mysqli, $id_informe, $id_usuario, $seccion){
        $consulta = $mysqli->prepare("\n            SELECT\n                cr.id,\n                cr.id_informe,\n                cr.seccion,\n                cr.orden,\n                cr.nivel_titulo_1,\n                cr.numero_titulo_1,\n                cr.texto_titulo_1,\n                cr.titulo_1_bloqueado,\n                cr.nivel_titulo_2,\n                cr.numero_titulo_2,\n                cr.texto_titulo_2,\n                cr.ruta_principal,\n                cr.sin_manual_momento,\n                cr.carpeta,\n                cr.archivo,\n                cr.extension,\n                cr.ruta_extra_1,\n                cr.ruta_extra_2,\n                cr.ruta_extra_3,\n                cr.ruta_extra_4\n            FROM carpeta_rutas_estructurales cr\n            INNER JOIN informes i ON i.id = cr.id_informe\n            WHERE cr.id_informe = ? AND i.id_usuario = ? AND cr.seccion = ?\n            ORDER BY cr.orden DESC, cr.id DESC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("iis", $id_informe, $id_usuario, $seccion);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function obtener_siguiente_orden_ruta_estructural($mysqli, $id_informe, $seccion){
        $consulta = $mysqli->prepare("\n            SELECT COALESCE(MAX(orden), 0) + 1 AS siguiente_orden\n            FROM carpeta_rutas_estructurales\n            WHERE id_informe = ? AND seccion = ?\n            LIMIT 1\n        ");

        if(!$consulta){
            return 1;
        }

        $consulta->bind_param("is", $id_informe, $seccion);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();

        if(!$fila || !isset($fila['siguiente_orden'])){
            return 1;
        }

        return max(1, (int)$fila['siguiente_orden']);
    }

    function insertar_ruta_estructural($mysqli, $id_informe, $id_usuario, $seccion, $datos){
        if(!cargar_informe($mysqli, $id_informe, $id_usuario)){
            return false;
        }

        $orden = isset($datos['orden']) ? (int)$datos['orden'] : 1;
        if($orden < 1){
            $orden = 1;
        }

        $nivel_titulo_1 = $datos['nivel_titulo_1'];
        $numero_titulo_1 = $datos['numero_titulo_1'];
        $texto_titulo_1 = $datos['texto_titulo_1'];
        $titulo_1_bloqueado = isset($datos['titulo_1_bloqueado']) ? (int)$datos['titulo_1_bloqueado'] : 1;
        $nivel_titulo_2 = $datos['nivel_titulo_2'];
        $numero_titulo_2 = $datos['numero_titulo_2'];
        $texto_titulo_2 = $datos['texto_titulo_2'];
        $ruta_principal = $datos['ruta_principal'];
        $sin_manual_momento = isset($datos['sin_manual_momento']) ? (int)$datos['sin_manual_momento'] : 0;
        $carpeta = $datos['carpeta'];
        $archivo = $datos['archivo'];
        $extension = $datos['extension'];
        $ruta_extra_1 = $datos['ruta_extra_1'];
        $ruta_extra_2 = $datos['ruta_extra_2'];
        $ruta_extra_3 = $datos['ruta_extra_3'];
        $ruta_extra_4 = $datos['ruta_extra_4'];

        $consulta = $mysqli->prepare("\n            INSERT INTO carpeta_rutas_estructurales (\n                id_informe,\n                seccion,\n                orden,\n                nivel_titulo_1,\n                numero_titulo_1,\n                texto_titulo_1,\n                titulo_1_bloqueado,\n                nivel_titulo_2,\n                numero_titulo_2,\n                texto_titulo_2,\n                ruta_principal,\n                sin_manual_momento,\n                carpeta,\n                archivo,\n                extension,\n                ruta_extra_1,\n                ruta_extra_2,\n                ruta_extra_3,\n                ruta_extra_4,\n                fecha_creacion,\n                fecha_modificacion\n            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())\n        ");

        if(!$consulta){
            return false;
        }

        $consulta->bind_param(
            "isisssissssisssssss",
            $id_informe,
            $seccion,
            $orden,
            $nivel_titulo_1,
            $numero_titulo_1,
            $texto_titulo_1,
            $titulo_1_bloqueado,
            $nivel_titulo_2,
            $numero_titulo_2,
            $texto_titulo_2,
            $ruta_principal,
            $sin_manual_momento,
            $carpeta,
            $archivo,
            $extension,
            $ruta_extra_1,
            $ruta_extra_2,
            $ruta_extra_3,
            $ruta_extra_4
        );

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    function cargar_todas_rutas_estructurales_por_seccion($mysqli, $id_informe, $id_usuario, $seccion){
        $consulta = $mysqli->prepare("\n            SELECT\n                cr.id,\n                cr.id_informe,\n                cr.seccion,\n                cr.orden,\n                cr.nivel_titulo_1,\n                cr.numero_titulo_1,\n                cr.texto_titulo_1,\n                cr.titulo_1_bloqueado,\n                cr.nivel_titulo_2,\n                cr.numero_titulo_2,\n                cr.texto_titulo_2,\n                cr.ruta_principal,\n                cr.sin_manual_momento,\n                cr.carpeta,\n                cr.archivo,\n                cr.extension,\n                cr.ruta_extra_1,\n                cr.ruta_extra_2,\n                cr.ruta_extra_3,\n                cr.ruta_extra_4\n            FROM carpeta_rutas_estructurales cr\n            INNER JOIN informes i ON i.id = cr.id_informe\n            WHERE cr.id_informe = ? AND i.id_usuario = ? AND cr.seccion = ?\n            ORDER BY cr.orden ASC, cr.id ASC\n        ");

        if(!$consulta){
            return array();
        }

        $consulta->bind_param("iis", $id_informe, $id_usuario, $seccion);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $filas = array();

        if($resultado && $resultado->num_rows > 0){
            while($fila = $resultado->fetch_assoc()){
                $filas[] = $fila;
            }
        }

        $consulta->close();
        return $filas;
    }

    function cargar_todas_rutas_estructurales($mysqli, $id_informe, $id_usuario){
        $consulta = $mysqli->prepare("\n            SELECT\n                cr.id,\n                cr.id_informe,\n                cr.seccion,\n                cr.orden,\n                cr.nivel_titulo_1,\n                cr.numero_titulo_1,\n                cr.texto_titulo_1,\n                cr.titulo_1_bloqueado,\n                cr.nivel_titulo_2,\n                cr.numero_titulo_2,\n                cr.texto_titulo_2,\n                cr.ruta_principal,\n                cr.sin_manual_momento,\n                cr.carpeta,\n                cr.archivo,\n                cr.extension,\n                cr.ruta_extra_1,\n                cr.ruta_extra_2,\n                cr.ruta_extra_3,\n                cr.ruta_extra_4\n            FROM carpeta_rutas_estructurales cr\n            INNER JOIN informes i ON i.id = cr.id_informe\n            WHERE cr.id_informe = ? AND i.id_usuario = ?\n            ORDER BY cr.seccion ASC, cr.orden ASC, cr.id ASC\n        ");

        if(!$consulta){
            return array();
        }

        $consulta->bind_param("ii", $id_informe, $id_usuario);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $filas = array();

        if($resultado && $resultado->num_rows > 0){
            while($fila = $resultado->fetch_assoc()){
                $filas[] = $fila;
            }
        }

        $consulta->close();
        return $filas;
    }

    // =====================================================================================================
    // CARPETA FUENTES DETALLE (TABLA: carpeta_fuentes_detalle)
    // =====================================================================================================

    function cargar_primer_fuente_detalle($mysqli, $id_informe, $id_usuario, $seccion){
        $consulta = $mysqli->prepare("\n            SELECT\n                cf.id,\n                cf.id_informe,\n                cf.seccion,\n                cf.orden,\n                cf.nivel_titulo_1,\n                cf.numero_titulo_1,\n                cf.texto_titulo_1,\n                cf.titulo_1_bloqueado,\n                cf.nivel_titulo_2,\n                cf.numero_titulo_2,\n                cf.texto_titulo_2,\n                cf.nombre_fuente\n            FROM carpeta_fuentes_detalle cf\n            INNER JOIN informes i ON i.id = cf.id_informe\n            WHERE cf.id_informe = ? AND i.id_usuario = ? AND cf.seccion = ?\n            ORDER BY cf.orden ASC, cf.id ASC\n            LIMIT 1\n        ");

        if(!$consulta){
            return null;
        }

        $consulta->bind_param("iis", $id_informe, $id_usuario, $seccion);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();
        return $fila;
    }

    function cargar_todas_fuentes_detalle_por_seccion($mysqli, $id_informe, $id_usuario, $seccion){
        $consulta = $mysqli->prepare("\n            SELECT\n                cf.id,\n                cf.id_informe,\n                cf.seccion,\n                cf.orden,\n                cf.nivel_titulo_1,\n                cf.numero_titulo_1,\n                cf.texto_titulo_1,\n                cf.titulo_1_bloqueado,\n                cf.nivel_titulo_2,\n                cf.numero_titulo_2,\n                cf.texto_titulo_2,\n                cf.nombre_fuente\n            FROM carpeta_fuentes_detalle cf\n            INNER JOIN informes i ON i.id = cf.id_informe\n            WHERE cf.id_informe = ? AND i.id_usuario = ? AND cf.seccion = ?\n            ORDER BY cf.orden ASC, cf.id ASC\n        ");

        if(!$consulta){
            return array();
        }

        $consulta->bind_param("iis", $id_informe, $id_usuario, $seccion);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $filas = array();

        if($resultado && $resultado->num_rows > 0){
            while($fila = $resultado->fetch_assoc()){
                $filas[] = $fila;
            }
        }

        $consulta->close();
        return $filas;
    }

    function obtener_siguiente_orden_fuente_detalle($mysqli, $id_informe, $seccion){
        $consulta = $mysqli->prepare("\n            SELECT COALESCE(MAX(orden), 0) + 1 AS siguiente_orden\n            FROM carpeta_fuentes_detalle\n            WHERE id_informe = ? AND seccion = ?\n            LIMIT 1\n        ");

        if(!$consulta){
            return 1;
        }

        $consulta->bind_param("is", $id_informe, $seccion);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $fila = ($resultado && $resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
        $consulta->close();

        if(!$fila || !isset($fila['siguiente_orden'])){
            return 1;
        }

        return max(1, (int)$fila['siguiente_orden']);
    }

    function insertar_fuente_detalle($mysqli, $id_informe, $id_usuario, $seccion, $datos){
        if(!cargar_informe($mysqli, $id_informe, $id_usuario)){
            return false;
        }

        $orden = isset($datos['orden']) ? (int)$datos['orden'] : 1;
        if($orden < 1){
            $orden = 1;
        }

        $nivel_titulo_1 = $datos['nivel_titulo_1'];
        $numero_titulo_1 = $datos['numero_titulo_1'];
        $texto_titulo_1 = $datos['texto_titulo_1'];
        $titulo_1_bloqueado = isset($datos['titulo_1_bloqueado']) ? (int)$datos['titulo_1_bloqueado'] : 1;
        $nivel_titulo_2 = $datos['nivel_titulo_2'];
        $numero_titulo_2 = $datos['numero_titulo_2'];
        $texto_titulo_2 = $datos['texto_titulo_2'];
        $nombre_fuente = $datos['nombre_fuente'];

        $consulta = $mysqli->prepare("\n            INSERT INTO carpeta_fuentes_detalle (\n                id_informe,\n                seccion,\n                orden,\n                nivel_titulo_1,\n                numero_titulo_1,\n                texto_titulo_1,\n                titulo_1_bloqueado,\n                nivel_titulo_2,\n                numero_titulo_2,\n                texto_titulo_2,\n                nombre_fuente,\n                fecha_creacion,\n                fecha_modificacion\n            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())\n        ");

        if(!$consulta){
            return false;
        }

        $consulta->bind_param(
            "isisssissss",
            $id_informe,
            $seccion,
            $orden,
            $nivel_titulo_1,
            $numero_titulo_1,
            $texto_titulo_1,
            $titulo_1_bloqueado,
            $nivel_titulo_2,
            $numero_titulo_2,
            $texto_titulo_2,
            $nombre_fuente
        );

        $exito = $consulta->execute();
        $consulta->close();
        return $exito;
    }

    // =====================================================================================================
    // INDICE DINAMICO (FUNCIONES DE COMPOSICION TRANSVERSAL)
    // =====================================================================================================

    function construir_indice_desde_secciones($mysqli, $id_informe, $id_usuario){
        $filas_indice = array();

        $introduccion = cargar_introduccion_informe($mysqli, $id_informe, $id_usuario);
        if($introduccion){
            $numero_intro = trim((string)$introduccion['numero_titulo']);
            $texto_intro  = trim((string)$introduccion['texto_titulo']);
            $nivel_intro  = trim((string)$introduccion['nivel_titulo']);

            if($texto_intro !== ''){
                $titulo_intro = $numero_intro !== '' ? $numero_intro . ' ' . $texto_intro : $texto_intro;
                $filas_indice[] = array(
                    'nivel'  => $nivel_intro !== '' ? $nivel_intro : '0',
                    'titulo' => $titulo_intro,
                    'pagina' => '',
                    'ancla'  => construir_id_ancla_indice('introduccion', $numero_intro, $texto_intro)
                );
            }
        }

        $base_datos = cargar_base_datos_informe($mysqli, $id_informe, $id_usuario);
        if($base_datos){
            $numero_bd = trim((string)$base_datos['numero_titulo']);
            $texto_bd  = trim((string)$base_datos['texto_titulo']);
            $nivel_bd  = trim((string)$base_datos['nivel_titulo']);

            if($texto_bd !== ''){
                $titulo_bd = $numero_bd !== '' ? $numero_bd . ' ' . $texto_bd : $texto_bd;
                $filas_indice[] = array(
                    'nivel'  => $nivel_bd !== '' ? $nivel_bd : '0',
                    'titulo' => $titulo_bd,
                    'pagina' => '',
                    'ancla'  => construir_id_ancla_indice('base_datos', $numero_bd, $texto_bd)
                );
            }
        }

        $documentacion = cargar_documentacion_caso_uso_informe($mysqli, $id_informe, $id_usuario);
        if($documentacion){
            $niveles_doc = array(
                array('nivel' => 'nivel_titulo_1', 'numero' => 'numero_titulo_1', 'texto' => 'texto_titulo_1'),
                array('nivel' => 'nivel_titulo_2', 'numero' => 'numero_titulo_2', 'texto' => 'texto_titulo_2'),
                array('nivel' => 'nivel_titulo_3', 'numero' => 'numero_titulo_3', 'texto' => 'texto_titulo_3'),
            );

            foreach($niveles_doc as $n){
                $texto  = trim((string)$documentacion[$n['texto']]);
                $numero = trim((string)$documentacion[$n['numero']]);
                $nivel  = trim((string)$documentacion[$n['nivel']]);

                if($texto !== ''){
                    $titulo = $numero !== '' ? $numero . ' ' . $texto : $texto;
                    $filas_indice[] = array(
                        'nivel'  => $nivel !== '' ? $nivel : '1',
                        'titulo' => $titulo,
                        'pagina' => '',
                        'ancla'  => construir_id_ancla_indice('documentacion_caso_uso', $numero, $texto)
                    );
                }
            }
        }

        $imagenes = cargar_todas_caso_uso_imagenes($mysqli, $id_informe, $id_usuario);
        $titulos_cu_vistos = array();
        foreach($imagenes as $imagen){
            $niveles_cu = array(
                array('nivel' => 'nivel_titulo_1', 'numero' => 'numero_titulo_1', 'texto' => 'texto_titulo_1'),
                array('nivel' => 'nivel_titulo_2', 'numero' => 'numero_titulo_2', 'texto' => 'texto_titulo_2'),
            );

            foreach($niveles_cu as $n){
                $texto  = trim((string)$imagen[$n['texto']]);
                $numero = trim((string)$imagen[$n['numero']]);
                $nivel  = trim((string)$imagen[$n['nivel']]);

                if($texto !== ''){
                    $titulo = $numero !== '' ? $numero . ' ' . $texto : $texto;

                    if(isset($titulos_cu_vistos[$titulo])){
                        continue;
                    }

                    $titulos_cu_vistos[$titulo] = true;
                    $filas_indice[] = array(
                        'nivel'  => $nivel !== '' ? $nivel : '2',
                        'titulo' => $titulo,
                        'pagina' => '',
                        'ancla'  => construir_id_ancla_indice('caso_uso_imagen', $numero, $texto)
                    );
                }
            }
        }

        $diagramas = cargar_todas_carpeta_diagramas($mysqli, $id_informe, $id_usuario);
        $titulos_diagrama_vistos = array();
        foreach($diagramas as $diagrama){
            $niveles_diagrama = array(
                array('nivel' => 'nivel_titulo_1', 'numero' => 'numero_titulo_1', 'texto' => 'texto_titulo_1'),
                array('nivel' => 'nivel_titulo_2', 'numero' => 'numero_titulo_2', 'texto' => 'texto_titulo_2'),
            );

            foreach($niveles_diagrama as $n){
                $texto  = trim((string)$diagrama[$n['texto']]);
                $numero = trim((string)$diagrama[$n['numero']]);
                $nivel  = trim((string)$diagrama[$n['nivel']]);

                if($texto !== ''){
                    $titulo = $numero !== '' ? $numero . ' ' . $texto : $texto;

                    if(isset($titulos_diagrama_vistos[$titulo])){
                        continue;
                    }

                    $titulos_diagrama_vistos[$titulo] = true;
                    $filas_indice[] = array(
                        'nivel'  => $nivel !== '' ? $nivel : '2',
                        'titulo' => $titulo,
                        'pagina' => '',
                        'ancla'  => construir_id_ancla_indice('carpeta_diagramas', $numero, $texto)
                    );
                }
            }
        }

        $informes_programas = cargar_todas_carpeta_informes_programas($mysqli, $id_informe, $id_usuario);
        $titulos_informes_programas_vistos = array();
        foreach($informes_programas as $programa){
            $niveles_programa = array(
                array('nivel' => 'nivel_titulo_1', 'numero' => 'numero_titulo_1', 'texto' => 'texto_titulo_1'),
                array('nivel' => 'nivel_titulo_2', 'numero' => 'numero_titulo_2', 'texto' => 'texto_titulo_2'),
            );

            foreach($niveles_programa as $n){
                $texto  = trim((string)$programa[$n['texto']]);
                $numero = trim((string)$programa[$n['numero']]);
                $nivel  = trim((string)$programa[$n['nivel']]);

                if($texto !== ''){
                    $titulo = $numero !== '' ? $numero . ' ' . $texto : $texto;

                    if(isset($titulos_informes_programas_vistos[$titulo])){
                        continue;
                    }

                    $titulos_informes_programas_vistos[$titulo] = true;
                    $filas_indice[] = array(
                        'nivel'  => $nivel !== '' ? $nivel : '2',
                        'titulo' => $titulo,
                        'pagina' => '',
                        'ancla'  => construir_id_ancla_indice('carpeta_informes_programas', $numero, $texto)
                    );
                }
            }
        }

        $pantallazos_programas = cargar_todas_carpeta_pantallazos_programas($mysqli, $id_informe, $id_usuario);
        $titulos_pantallazos_vistos = array();
        foreach($pantallazos_programas as $pantallazo){
            $niveles_pantallazo = array(
                array('nivel' => 'nivel_titulo_1', 'numero' => 'numero_titulo_1', 'texto' => 'texto_titulo_1'),
                array('nivel' => 'nivel_titulo_2', 'numero' => 'numero_titulo_2', 'texto' => 'texto_titulo_2'),
            );

            foreach($niveles_pantallazo as $n){
                $texto  = trim((string)$pantallazo[$n['texto']]);
                $numero = trim((string)$pantallazo[$n['numero']]);
                $nivel  = trim((string)$pantallazo[$n['nivel']]);

                if($texto !== ''){
                    $titulo = $numero !== '' ? $numero . ' ' . $texto : $texto;

                    if(isset($titulos_pantallazos_vistos[$titulo])){
                        continue;
                    }

                    $titulos_pantallazos_vistos[$titulo] = true;
                    $filas_indice[] = array(
                        'nivel'  => $nivel !== '' ? $nivel : '2',
                        'titulo' => $titulo,
                        'pagina' => '',
                        'ancla'  => construir_id_ancla_indice('carpeta_pantallazos_programas', $numero, $texto)
                    );
                }
            }
        }

        $rutas_estructurales = cargar_todas_rutas_estructurales($mysqli, $id_informe, $id_usuario);
        $titulos_rutas_estructurales_vistos = array();
        foreach($rutas_estructurales as $ruta){
            $niveles_ruta = array(
                array('nivel' => 'nivel_titulo_1', 'numero' => 'numero_titulo_1', 'texto' => 'texto_titulo_1'),
                array('nivel' => 'nivel_titulo_2', 'numero' => 'numero_titulo_2', 'texto' => 'texto_titulo_2'),
            );

            foreach($niveles_ruta as $n){
                $texto  = trim((string)$ruta[$n['texto']]);
                $numero = trim((string)$ruta[$n['numero']]);
                $nivel  = trim((string)$ruta[$n['nivel']]);

                if($texto !== ''){
                    $titulo = $numero !== '' ? $numero . ' ' . $texto : $texto;

                    if(isset($titulos_rutas_estructurales_vistos[$titulo])){
                        continue;
                    }

                    $titulos_rutas_estructurales_vistos[$titulo] = true;
                    $filas_indice[] = array(
                        'nivel'  => $nivel !== '' ? $nivel : '2',
                        'titulo' => $titulo,
                        'pagina' => '',
                        'ancla'  => construir_id_ancla_indice('ruta_estructural_' . (isset($ruta['seccion']) ? $ruta['seccion'] : ''), $numero, $texto)
                    );
                }
            }
        }

        $fuentes_clientes = cargar_todas_fuentes_detalle_por_seccion($mysqli, $id_informe, $id_usuario, 'fuentes_clientes');
        $fuentes_word = cargar_todas_fuentes_detalle_por_seccion($mysqli, $id_informe, $id_usuario, 'fuentes_word');
        $fuentes_unificadas = array_merge($fuentes_clientes, $fuentes_word);
        $titulos_fuentes_vistos = array();
        foreach($fuentes_unificadas as $fuente){
            $niveles_fuente = array(
                array('nivel' => 'nivel_titulo_1', 'numero' => 'numero_titulo_1', 'texto' => 'texto_titulo_1'),
                array('nivel' => 'nivel_titulo_2', 'numero' => 'numero_titulo_2', 'texto' => 'texto_titulo_2'),
            );

            foreach($niveles_fuente as $n){
                $texto  = trim((string)$fuente[$n['texto']]);
                $numero = trim((string)$fuente[$n['numero']]);
                $nivel  = trim((string)$fuente[$n['nivel']]);

                if($texto !== ''){
                    $titulo = $numero !== '' ? $numero . ' ' . $texto : $texto;

                    if(isset($titulos_fuentes_vistos[$titulo])){
                        continue;
                    }

                    $titulos_fuentes_vistos[$titulo] = true;
                    $filas_indice[] = array(
                        'nivel'  => $nivel !== '' ? $nivel : '3',
                        'titulo' => $titulo,
                        'pagina' => '',
                        'ancla'  => construir_id_ancla_indice('fuentes_' . (isset($fuente['seccion']) ? $fuente['seccion'] : ''), $numero, $texto)
                    );
                }
            }
        }

        return $filas_indice;
    }


