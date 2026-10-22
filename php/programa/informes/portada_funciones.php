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

// INICIO FUNCIONES DE APOYO: utilidades puras para indice, logo y nombre.
// No dependen de BD ni de sesion.

    // Retorna el array base del indice cuando no existe uno guardado.
    function obtener_indice_base(){
        return array(
            array('nivel' => '0', 'titulo' => 'ÍNDICE', 'pagina' => '2'),
            array('nivel' => '0', 'titulo' => 'INSTRUCCIONES PARA LLENAR EL INFORME.', 'pagina' => '4'),
            array('nivel' => '0', 'titulo' => 'INTRODUCCIÓN.', 'pagina' => '5'),
            array('nivel' => '0', 'titulo' => '1.- CARPETA DOCUMENTACIÓN', 'pagina' => '6'),
            array('nivel' => '1', 'titulo' => '1.- CARPETA CASO DE USO', 'pagina' => '6'),
            array('nivel' => '2', 'titulo' => '1.1.- EXPLICACIÓN CASO DE USO', 'pagina' => '6'),
            array('nivel' => '2', 'titulo' => '1.2.- IMAGEN CASO DE USO PÁGINA 1', 'pagina' => '6'),
            array('nivel' => '1', 'titulo' => '2.- CARPETA DIAGRAMAS', 'pagina' => '7'),
            array('nivel' => '2', 'titulo' => '2.1.- DIAGRAMA PROGRAMA', 'pagina' => '7'),
            array('nivel' => '2', 'titulo' => '2.2.- DIAGRAMA BASE DE DATOS', 'pagina' => '7'),
            array('nivel' => '0', 'titulo' => 'CARPETA INFORMES', 'pagina' => '8'),
            array('nivel' => '1', 'titulo' => '1.- CARPETA INFORMES PROGRAMADOS', 'pagina' => '8'),
            array('nivel' => '1', 'titulo' => '2.- CARPETA MANUAL CLIENTE', 'pagina' => '11'),
            array('nivel' => '1', 'titulo' => '3.- CARPETA MANUAL TÉCNICO', 'pagina' => '11'),
            array('nivel' => '0', 'titulo' => 'CARPETA PANTALLAZOS PROGRAMA', 'pagina' => '12'),
            array('nivel' => '1', 'titulo' => '1.- PANTALLAZOS PROGRAMA COMPLETO', 'pagina' => '12'),
            array('nivel' => '1', 'titulo' => '2.- CARPETA BD', 'pagina' => '13'),
            array('nivel' => '2', 'titulo' => '2.1.- nombre_programa_db.sql', 'pagina' => '13'),
            array('nivel' => '0', 'titulo' => '3.- CARPETA FUENTES', 'pagina' => '13'),
            array('nivel' => '1', 'titulo' => '3.1.- FUENTES CLIENTE', 'pagina' => '13'),
            array('nivel' => '1', 'titulo' => '3.2.- FUENTES WORD', 'pagina' => '14'),
            array('nivel' => '0', 'titulo' => '4.- PROYECTO NOMBRE PROYECTO', 'pagina' => '14'),
            array('nivel' => '1', 'titulo' => '1.- ARCHIVO index.php', 'pagina' => '14')
        );
    }

    // Convierte texto plano separado por ||| en array de filas de indice.
    function convertir_texto_a_indice($texto_indice){
        $filas_indice = array();
        $texto_indice = trim((string)$texto_indice);

        if($texto_indice === ''){
            return $filas_indice;
        }

        $lineas_indice = preg_split("/\r\n|\n|\r/", $texto_indice);

        foreach($lineas_indice as $linea_indice){
            $linea_indice = trim($linea_indice);

            if($linea_indice === ''){
                continue;
            }

            if(strpos($linea_indice, '|||') !== false){
                $partes_linea = explode('|||', $linea_indice);
                $filas_indice[] = array(
                    'nivel'  => isset($partes_linea[0]) ? trim($partes_linea[0]) : '0',
                    'titulo' => isset($partes_linea[1]) ? trim($partes_linea[1]) : '',
                    'pagina' => isset($partes_linea[2]) ? trim($partes_linea[2]) : ''
                );
            }else{
                $filas_indice[] = array(
                    'nivel'  => '0',
                    'titulo' => $linea_indice,
                    'pagina' => ''
                );
            }
        }

        return $filas_indice;
    }

    // Convierte array de filas de indice a texto plano separado por |||.
    function generar_texto_indice_desde_array($filas_indice){
        $lineas_indice = array();

        foreach($filas_indice as $fila_indice){
            $nivel  = isset($fila_indice['nivel'])  ? trim((string)$fila_indice['nivel'])  : '0';
            $titulo = isset($fila_indice['titulo']) ? trim((string)$fila_indice['titulo']) : '';
            $pagina = isset($fila_indice['pagina']) ? trim((string)$fila_indice['pagina']) : '';

            if($titulo === ''){
                continue;
            }

            $lineas_indice[] = $nivel . '|||' . $titulo . '|||' . $pagina;
        }

        return implode("\n", $lineas_indice);
    }

    // Busca la primera ruta valida del logo de ITred.
    function obtener_url_logo_itred(){
        $rutas_logo = array(
            '../../../imagenes/logo_itred.png',
            '../../../imagenes/programa/logo_itred.png',
            '../../../img/logo_itred.png',
            '../../../logo_itred.png'
        );

        foreach($rutas_logo as $ruta_logo){
            if(file_exists($ruta_logo)){
                return $ruta_logo;
            }
        }

        return '../../../imagenes/logo_itred.png';
    }

    // Limpia y normaliza el nombre del informe para usarlo como nombre de archivo.
    function limpiar_nombre_archivo($texto){
        $texto = trim((string)$texto);

        if($texto === ''){
            return 'informe';
        }

        $texto = preg_replace('/[^\p{L}\p{N}\-_ ]/u', '', $texto);
        $texto = preg_replace('/\s+/', '_', $texto);
        $texto = trim($texto, '_');

        return ($texto !== '') ? strtolower($texto) : 'informe';
    }

    // Genera un slug ASCII estable para ids HTML de anclas.
    function generar_slug_ancla($texto){
        $texto = trim((string)$texto);
        if($texto === ''){
            return 'item';
        }

        if(function_exists('iconv')){
            $texto_ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $texto);
            if($texto_ascii !== false){
                $texto = $texto_ascii;
            }
        }

        $texto = strtolower($texto);
        $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
        $texto = trim((string)$texto, '-');

        return $texto !== '' ? $texto : 'item';
    }

    // Construye id de ancla para filas del indice y titulos de seccion.
    function construir_id_ancla_indice($seccion, $numero, $texto){
        $base = generar_slug_ancla($seccion);
        $numero_slug = generar_slug_ancla($numero);
        $texto_slug = generar_slug_ancla($texto);

        return 'ancla-' . $base . '-' . $numero_slug . '-' . $texto_slug;
    }

// FIN FUNCIONES DE APOYO
