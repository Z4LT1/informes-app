<?php

    function exportacion_obtener_src_imagen($ruta_imagen){
        $ruta_imagen = trim((string)$ruta_imagen);
        if($ruta_imagen === ''){
            return '';
        }

        if(stripos($ruta_imagen, 'data:image/') === 0){
            return $ruta_imagen;
        }

        if(preg_match('/^https?:\/\//i', $ruta_imagen)){
            return $ruta_imagen;
        }

        $ruta_normalizada = str_replace('\\', '/', $ruta_imagen);
        $raiz_proyecto = realpath(__DIR__ . '/../../../');
        $candidatos = array(
            $ruta_normalizada,
            __DIR__ . '/' . ltrim($ruta_normalizada, '/'),
            $raiz_proyecto ? $raiz_proyecto . '/' . ltrim($ruta_normalizada, '/') : ''
        );

        foreach($candidatos as $candidato){
            if($candidato === ''){
                continue;
            }

            if(is_file($candidato)){
                $contenido = @file_get_contents($candidato);
                if($contenido === false){
                    continue;
                }

                $extension = strtolower(pathinfo($candidato, PATHINFO_EXTENSION));
                $mime = 'image/png';
                if($extension === 'jpg' || $extension === 'jpeg'){
                    $mime = 'image/jpeg';
                }elseif($extension === 'gif'){
                    $mime = 'image/gif';
                }elseif($extension === 'webp'){
                    $mime = 'image/webp';
                }

                return 'data:' . $mime . ';base64,' . base64_encode($contenido);
            }
        }

        return $ruta_normalizada;
    }

    function exportacion_titulo_completo($numero, $texto){
        $numero = trim((string)$numero);
        $texto = trim((string)$texto);

        if($texto === ''){
            return '';
        }

        return $numero !== '' ? ($numero . ' ' . $texto) : $texto;
    }

    function renderizar_html_exportacion($datos, $tipo_exportacion = ''){
        $logo_itred = exportacion_obtener_src_imagen($datos['logo_itred']);
        $nombre_informe = htmlspecialchars($datos['texto_nombre_informe']);
        $area_trabajo = htmlspecialchars($datos['area_trabajo']);
        $nombre_1 = htmlspecialchars($datos['nombre_1']);
        $nombre_2 = htmlspecialchars($datos['nombre_2']);
        $nombre_3 = htmlspecialchars($datos['nombre_3']);
        $nombre_4 = htmlspecialchars($datos['nombre_4']);
        $proyecto = htmlspecialchars($datos['proyecto']);
        $avance = htmlspecialchars($datos['avance']);
        $solicitado_por = htmlspecialchars($datos['solicitado_por']);
        $cargo = htmlspecialchars($datos['cargo']);
        $fecha_entrega = htmlspecialchars($datos['texto_fecha_entrega']);
        $filas_indice = isset($datos['filas_indice']) && is_array($datos['filas_indice']) ? $datos['filas_indice'] : array();

        $introduccion = isset($datos['introduccion']) && is_array($datos['introduccion']) ? $datos['introduccion'] : array();
        $base_datos = isset($datos['base_datos']) && is_array($datos['base_datos']) ? $datos['base_datos'] : array();
        $documentacion = isset($datos['documentacion_caso_uso']) && is_array($datos['documentacion_caso_uso']) ? $datos['documentacion_caso_uso'] : array();
        $caso_uso_imagenes = isset($datos['caso_uso_imagenes']) && is_array($datos['caso_uso_imagenes']) ? $datos['caso_uso_imagenes'] : array();
        $carpeta_diagramas = isset($datos['carpeta_diagramas']) && is_array($datos['carpeta_diagramas']) ? $datos['carpeta_diagramas'] : array();
        $carpeta_informes_programas = isset($datos['carpeta_informes_programas']) && is_array($datos['carpeta_informes_programas']) ? $datos['carpeta_informes_programas'] : array();
        $carpeta_pantallazos_programas = isset($datos['carpeta_pantallazos_programas']) && is_array($datos['carpeta_pantallazos_programas']) ? $datos['carpeta_pantallazos_programas'] : array();
        $rutas_estructurales = isset($datos['rutas_estructurales']) && is_array($datos['rutas_estructurales']) ? $datos['rutas_estructurales'] : array();
        $fuentes_detalle = isset($datos['fuentes_detalle']) && is_array($datos['fuentes_detalle']) ? $datos['fuentes_detalle'] : array();

        $pagina_actual = 3;
        $paginas_por_titulo = array();

        $titulo_intro = exportacion_titulo_completo(
            isset($introduccion['numero_titulo']) ? $introduccion['numero_titulo'] : '',
            isset($introduccion['texto_titulo']) ? $introduccion['texto_titulo'] : ''
        );
        $contenido_intro = isset($introduccion['texto_contenido']) ? trim((string)$introduccion['texto_contenido']) : '';
        if($titulo_intro !== '' || $contenido_intro !== ''){
            if($titulo_intro !== '' && !isset($paginas_por_titulo[$titulo_intro])){
                $paginas_por_titulo[$titulo_intro] = $pagina_actual;
            }
            $pagina_actual++;
        }

        $titulo_bd = exportacion_titulo_completo(
            isset($base_datos['numero_titulo']) ? $base_datos['numero_titulo'] : '',
            isset($base_datos['texto_titulo']) ? $base_datos['texto_titulo'] : ''
        );
        $contenido_bd = isset($base_datos['texto_contenido']) ? trim((string)$base_datos['texto_contenido']) : '';
        if($titulo_bd !== '' || $contenido_bd !== ''){
            if($titulo_bd !== '' && !isset($paginas_por_titulo[$titulo_bd])){
                $paginas_por_titulo[$titulo_bd] = $pagina_actual;
            }
            $pagina_actual++;
        }

        $titulos_doc = array(
            exportacion_titulo_completo(isset($documentacion['numero_titulo_1']) ? $documentacion['numero_titulo_1'] : '', isset($documentacion['texto_titulo_1']) ? $documentacion['texto_titulo_1'] : ''),
            exportacion_titulo_completo(isset($documentacion['numero_titulo_2']) ? $documentacion['numero_titulo_2'] : '', isset($documentacion['texto_titulo_2']) ? $documentacion['texto_titulo_2'] : ''),
            exportacion_titulo_completo(isset($documentacion['numero_titulo_3']) ? $documentacion['numero_titulo_3'] : '', isset($documentacion['texto_titulo_3']) ? $documentacion['texto_titulo_3'] : '')
        );
        $contenido_doc = isset($documentacion['texto_contenido']) ? trim((string)$documentacion['texto_contenido']) : '';
        if($titulos_doc[0] !== '' || $titulos_doc[1] !== '' || $titulos_doc[2] !== '' || $contenido_doc !== ''){
            foreach($titulos_doc as $titulo_doc){
                if($titulo_doc !== '' && !isset($paginas_por_titulo[$titulo_doc])){
                    $paginas_por_titulo[$titulo_doc] = $pagina_actual;
                }
            }
            $pagina_actual++;
        }

        foreach($caso_uso_imagenes as $imagen_cu){
            $titulo_cu_1 = exportacion_titulo_completo(
                isset($imagen_cu['numero_titulo_1']) ? $imagen_cu['numero_titulo_1'] : '',
                isset($imagen_cu['texto_titulo_1']) ? $imagen_cu['texto_titulo_1'] : ''
            );
            $titulo_cu_2 = exportacion_titulo_completo(
                isset($imagen_cu['numero_titulo_2']) ? $imagen_cu['numero_titulo_2'] : '',
                isset($imagen_cu['texto_titulo_2']) ? $imagen_cu['texto_titulo_2'] : ''
            );

            if($titulo_cu_1 !== '' && !isset($paginas_por_titulo[$titulo_cu_1])){
                $paginas_por_titulo[$titulo_cu_1] = $pagina_actual;
            }
            if($titulo_cu_2 !== '' && !isset($paginas_por_titulo[$titulo_cu_2])){
                $paginas_por_titulo[$titulo_cu_2] = $pagina_actual;
            }
            $pagina_actual++;
        }

        foreach($carpeta_diagramas as $diagrama){
            $titulo_diagrama_1 = exportacion_titulo_completo(
                isset($diagrama['numero_titulo_1']) ? $diagrama['numero_titulo_1'] : '',
                isset($diagrama['texto_titulo_1']) ? $diagrama['texto_titulo_1'] : ''
            );
            $titulo_diagrama_2 = exportacion_titulo_completo(
                isset($diagrama['numero_titulo_2']) ? $diagrama['numero_titulo_2'] : '',
                isset($diagrama['texto_titulo_2']) ? $diagrama['texto_titulo_2'] : ''
            );

            if($titulo_diagrama_1 !== '' && !isset($paginas_por_titulo[$titulo_diagrama_1])){
                $paginas_por_titulo[$titulo_diagrama_1] = $pagina_actual;
            }
            if($titulo_diagrama_2 !== '' && !isset($paginas_por_titulo[$titulo_diagrama_2])){
                $paginas_por_titulo[$titulo_diagrama_2] = $pagina_actual;
            }
            $pagina_actual++;
        }

        foreach($carpeta_informes_programas as $programa){
            $titulo_programa_1 = exportacion_titulo_completo(
                isset($programa['numero_titulo_1']) ? $programa['numero_titulo_1'] : '',
                isset($programa['texto_titulo_1']) ? $programa['texto_titulo_1'] : ''
            );
            $titulo_programa_2 = exportacion_titulo_completo(
                isset($programa['numero_titulo_2']) ? $programa['numero_titulo_2'] : '',
                isset($programa['texto_titulo_2']) ? $programa['texto_titulo_2'] : ''
            );

            if($titulo_programa_1 !== '' && !isset($paginas_por_titulo[$titulo_programa_1])){
                $paginas_por_titulo[$titulo_programa_1] = $pagina_actual;
            }
            if($titulo_programa_2 !== '' && !isset($paginas_por_titulo[$titulo_programa_2])){
                $paginas_por_titulo[$titulo_programa_2] = $pagina_actual;
            }
            $pagina_actual++;
        }

        foreach($carpeta_pantallazos_programas as $pantallazo){
            $titulo_pantallazo_1 = exportacion_titulo_completo(
                isset($pantallazo['numero_titulo_1']) ? $pantallazo['numero_titulo_1'] : '',
                isset($pantallazo['texto_titulo_1']) ? $pantallazo['texto_titulo_1'] : ''
            );
            $titulo_pantallazo_2 = exportacion_titulo_completo(
                isset($pantallazo['numero_titulo_2']) ? $pantallazo['numero_titulo_2'] : '',
                isset($pantallazo['texto_titulo_2']) ? $pantallazo['texto_titulo_2'] : ''
            );

            if($titulo_pantallazo_1 !== '' && !isset($paginas_por_titulo[$titulo_pantallazo_1])){
                $paginas_por_titulo[$titulo_pantallazo_1] = $pagina_actual;
            }
            if($titulo_pantallazo_2 !== '' && !isset($paginas_por_titulo[$titulo_pantallazo_2])){
                $paginas_por_titulo[$titulo_pantallazo_2] = $pagina_actual;
            }
            $pagina_actual++;
        }

        foreach($rutas_estructurales as $ruta_seccion){
            if(!is_array($ruta_seccion)){
                continue;
            }

            foreach($ruta_seccion as $ruta){
                $titulo_ruta_1 = exportacion_titulo_completo(
                    isset($ruta['numero_titulo_1']) ? $ruta['numero_titulo_1'] : '',
                    isset($ruta['texto_titulo_1']) ? $ruta['texto_titulo_1'] : ''
                );
                $titulo_ruta_2 = exportacion_titulo_completo(
                    isset($ruta['numero_titulo_2']) ? $ruta['numero_titulo_2'] : '',
                    isset($ruta['texto_titulo_2']) ? $ruta['texto_titulo_2'] : ''
                );

                if($titulo_ruta_1 !== '' && !isset($paginas_por_titulo[$titulo_ruta_1])){
                    $paginas_por_titulo[$titulo_ruta_1] = $pagina_actual;
                }
                if($titulo_ruta_2 !== '' && !isset($paginas_por_titulo[$titulo_ruta_2])){
                    $paginas_por_titulo[$titulo_ruta_2] = $pagina_actual;
                }
                $pagina_actual++;
            }
        }

        foreach($fuentes_detalle as $fuente_seccion){
            if(!is_array($fuente_seccion) || count($fuente_seccion) === 0){
                continue;
            }

            $primera_fuente = $fuente_seccion[0];
            $titulo_fuente_1 = exportacion_titulo_completo(
                isset($primera_fuente['numero_titulo_1']) ? $primera_fuente['numero_titulo_1'] : '',
                isset($primera_fuente['texto_titulo_1']) ? $primera_fuente['texto_titulo_1'] : ''
            );
            $titulo_fuente_2 = exportacion_titulo_completo(
                isset($primera_fuente['numero_titulo_2']) ? $primera_fuente['numero_titulo_2'] : '',
                isset($primera_fuente['texto_titulo_2']) ? $primera_fuente['texto_titulo_2'] : ''
            );

            if($titulo_fuente_1 !== '' && !isset($paginas_por_titulo[$titulo_fuente_1])){
                $paginas_por_titulo[$titulo_fuente_1] = $pagina_actual;
            }
            if($titulo_fuente_2 !== '' && !isset($paginas_por_titulo[$titulo_fuente_2])){
                $paginas_por_titulo[$titulo_fuente_2] = $pagina_actual;
            }
            $pagina_actual++;
        }

        ob_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Exportacion Informe</title>
    <style>
        body{ margin:0; font-family:Arial, Helvetica, sans-serif; color:#111111; background:#ffffff; }
        .exportacion_documento{
            width:210mm;
            height:297mm;
            margin:0 auto;
            padding:16mm 18mm 20mm 18mm;
            box-sizing:border-box;
            background:#ffffff;
            display:block;
            page-break-before:always;
            page-break-after:always;
            page-break-inside:avoid;
            position:relative;
            overflow:hidden;
        }
        body > .exportacion_documento:first-of-type{ page-break-before:auto; }
        .exportacion_documento:last-child{ page-break-after:auto; }
        .exportacion_cabecera_seccion{
            text-align:right;
            position:absolute;
            top:10mm;
            right:18mm;
            left:18mm;
            margin:0;
        }
        .exportacion_cabecera_seccion img{ width:32mm; height:auto; }
        .exportacion_cuerpo{
            margin-top:20mm;
            padding-bottom:22mm;
            min-height:235mm;
            box-sizing:border-box;
        }
        .exportacion_logo_centro{ text-align:center; margin-top:28mm; margin-bottom:26mm; }
        .exportacion_logo_centro img{ width:62mm; height:auto; }
        .exportacion_titulo_portada{ text-align:center; font-size:15pt; font-weight:700; margin-bottom:34mm; }
        .exportacion_bloque_datos{ width:78mm; margin-left:auto; font-size:10pt; }
        .exportacion_fila_datos{ margin-bottom:7px; display:flex; gap:8px; }
        .exportacion_fila_datos strong{ min-width:32mm; font-weight:400; color:#555555; }
        .exportacion_logo_derecha{ text-align:right; margin-bottom:8mm; }
        .exportacion_logo_derecha img{ width:32mm; height:auto; }
        .exportacion_titulo_indice{ text-align:center; font-size:12pt; font-weight:700; margin:0 0 8mm 0; }
        .exportacion_indice_fila{ display:flex; align-items:flex-end; gap:6px; font-size:10pt; line-height:1.4; margin-bottom:3px; }
        .exportacion_indice_nivel_1{ padding-left:0; }
        .exportacion_indice_nivel_2{ padding-left:8mm; }
        .exportacion_indice_nivel_3{ padding-left:16mm; }
        .exportacion_indice_nivel_4{ padding-left:24mm; }
        .exportacion_indice_nivel_5{ padding-left:32mm; }
        .exportacion_indice_texto{ white-space:normal; word-break:break-word; }
        .exportacion_indice_puntos{ flex:1; border-bottom:1px dotted #666666; transform:translateY(-2px); }
        .exportacion_indice_pagina{ min-width:8mm; text-align:right; }
        .exportacion_footer{
            text-align:center;
            color:#666666;
            font-size:8pt;
            position:absolute;
            left:18mm;
            right:18mm;
            bottom:7mm;
            margin:0;
            line-height:1.25;
        }
        .exportacion_footer img{
            width:8mm !important;
            max-width:8mm !important;
            height:auto !important;
            display:block;
            margin:0 auto 2mm auto;
            object-fit:contain;
        }
        .exportacion_footer_numero{ margin-top:3mm; color:#111111; font-size:9pt; font-weight:700; }
        .exportacion_titulo_nivel_1{ margin:0 0 6mm 0; font-size:16pt; font-weight:700; text-align:left; }
        .exportacion_titulo_nivel_2{ margin:0 0 5mm 0; font-size:14pt; font-weight:700; text-align:left; }
        .exportacion_titulo_nivel_3{ margin:0 0 4mm 0; font-size:12pt; font-weight:700; text-align:left; }
        .exportacion_contenido{ white-space:pre-wrap; font-size:11pt; line-height:1.55; text-align:left; }
        .exportacion_codigo{ white-space:pre-wrap; font-size:10pt; line-height:1.45; text-align:left; font-family:"Courier New", monospace; margin:0; padding:0; border:0; background:transparent; }
        .exportacion_contenido,
        .exportacion_codigo,
        .exportacion_indice_texto,
        .exportacion_imagen_nombre{ word-wrap:break-word; overflow-wrap:anywhere; }
        .exportacion_imagen_bloque{ margin-top:8mm; text-align:center; }
        .exportacion_imagen_bloque img{ max-width:100%; max-height:150mm; width:auto; height:auto; object-fit:contain; border:1px solid #dddddd; }
        .exportacion_imagen_nombre{ margin-top:4mm; font-size:10pt; color:#444444; text-align:left; }
        .exportacion_footer_flexible{ margin-top:0; }
        h1,h2,h3,h4,h5,h6,p,table,tr,td,img{ page-break-inside:avoid; }
        @page{ size:A4; margin:0; }
    </style>
</head>
<body>

    <?php $pagina_seccion_actual = 3; ?>

    <section class="exportacion_documento">
        <div class="exportacion_logo_centro">
            <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
        </div>

        <div class="exportacion_titulo_portada">
            INFORME "<?php echo $nombre_informe; ?>"
        </div>

        <div class="exportacion_bloque_datos">
            <div class="exportacion_fila_datos"><strong>Area de Trabajo:</strong> <span><?php echo $area_trabajo; ?></span></div>
            <div class="exportacion_fila_datos"><strong>Nombre1:</strong> <span><?php echo $nombre_1; ?></span></div>
            <div class="exportacion_fila_datos"><strong>Nombre2:</strong> <span><?php echo $nombre_2; ?></span></div>
            <div class="exportacion_fila_datos"><strong>Nombre3:</strong> <span><?php echo $nombre_3; ?></span></div>
            <div class="exportacion_fila_datos"><strong>Nombre4:</strong> <span><?php echo $nombre_4; ?></span></div>
            <div class="exportacion_fila_datos"><strong>Proyecto:</strong> <span><?php echo $proyecto; ?></span></div>
            <div class="exportacion_fila_datos"><strong>Avance:</strong> <span><?php echo $avance; ?></span></div>
            <div class="exportacion_fila_datos"><strong>Solicitado por:</strong> <span><?php echo $solicitado_por; ?></span></div>
            <div class="exportacion_fila_datos"><strong>Cargo:</strong> <span><?php echo $cargo; ?></span></div>
            <div class="exportacion_fila_datos"><strong>Fecha Entrega:</strong> <span><?php echo $fecha_entrega; ?></span></div>
        </div>
    </section>

    <section class="exportacion_documento">
        <div class="exportacion_logo_derecha">
            <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
        </div>

        <div class="exportacion_cuerpo">
            <h2 class="exportacion_titulo_indice">INDICE</h2>

            <?php foreach($filas_indice as $fila_indice){ ?>
                <?php
                    $titulo_indice = isset($fila_indice['titulo']) ? trim((string)$fila_indice['titulo']) : '';
                    $pagina_indice = isset($fila_indice['pagina']) ? trim((string)$fila_indice['pagina']) : '';
                    $nivel_indice = isset($fila_indice['nivel']) ? (int)$fila_indice['nivel'] : 1;
                    if($nivel_indice < 1){ $nivel_indice = 1; }
                    if($pagina_indice === '' && isset($paginas_por_titulo[$titulo_indice])){
                        $pagina_indice = (string)$paginas_por_titulo[$titulo_indice];
                    }
                ?>
                <?php if($titulo_indice !== ''){ ?>
                    <div class="exportacion_indice_fila exportacion_indice_nivel_<?php echo $nivel_indice; ?>">
                        <span class="exportacion_indice_texto"><?php echo htmlspecialchars($titulo_indice); ?></span>
                        <span class="exportacion_indice_puntos"></span>
                        <span class="exportacion_indice_pagina"><?php echo htmlspecialchars($pagina_indice); ?></span>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="exportacion_footer exportacion_footer_flexible">
            <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
            Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
            Contacto: contacto@itred.cl - www.itred.cl
            <div class="exportacion_footer_numero">2</div>
        </div>
    </section>

    <?php if($titulo_intro !== '' || $contenido_intro !== ''){ ?>
        <section class="exportacion_documento">
            <div class="exportacion_cabecera_seccion">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
            </div>

            <div class="exportacion_cuerpo">
                <?php if($titulo_intro !== ''){ ?><h2 class="exportacion_titulo_nivel_1"><?php echo htmlspecialchars($titulo_intro); ?></h2><?php } ?>
                <?php if($contenido_intro !== ''){ ?><div class="exportacion_contenido"><?php echo nl2br(htmlspecialchars($contenido_intro)); ?></div><?php } ?>
            </div>

            <div class="exportacion_footer exportacion_footer_flexible">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
                Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                Contacto: contacto@itred.cl - www.itred.cl
                <div class="exportacion_footer_numero"><?php echo $pagina_seccion_actual; ?></div>
            </div>
        </section>
        <?php $pagina_seccion_actual++; ?>
    <?php } ?>

    <?php if($titulo_bd !== '' || $contenido_bd !== ''){ ?>
        <section class="exportacion_documento">
            <div class="exportacion_cabecera_seccion">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
            </div>

            <div class="exportacion_cuerpo">
                <?php if($titulo_bd !== ''){ ?><h2 class="exportacion_titulo_nivel_1"><?php echo htmlspecialchars($titulo_bd); ?></h2><?php } ?>
                <?php if($contenido_bd !== ''){ ?><div class="exportacion_codigo"><?php echo nl2br(htmlspecialchars($contenido_bd)); ?></div><?php } ?>
            </div>

            <div class="exportacion_footer exportacion_footer_flexible">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
                Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                Contacto: contacto@itred.cl - www.itred.cl
                <div class="exportacion_footer_numero"><?php echo $pagina_seccion_actual; ?></div>
            </div>
        </section>
        <?php $pagina_seccion_actual++; ?>
    <?php } ?>

    <?php if($titulos_doc[0] !== '' || $titulos_doc[1] !== '' || $titulos_doc[2] !== '' || $contenido_doc !== ''){ ?>
        <section class="exportacion_documento">
            <div class="exportacion_cabecera_seccion">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
            </div>

            <div class="exportacion_cuerpo">
                <?php if($titulos_doc[0] !== ''){ ?><h2 class="exportacion_titulo_nivel_1"><?php echo htmlspecialchars($titulos_doc[0]); ?></h2><?php } ?>
                <?php if($titulos_doc[1] !== ''){ ?><h3 class="exportacion_titulo_nivel_2"><?php echo htmlspecialchars($titulos_doc[1]); ?></h3><?php } ?>
                <?php if($titulos_doc[2] !== ''){ ?><h4 class="exportacion_titulo_nivel_3"><?php echo htmlspecialchars($titulos_doc[2]); ?></h4><?php } ?>
                <?php if($contenido_doc !== ''){ ?><div class="exportacion_contenido"><?php echo nl2br(htmlspecialchars($contenido_doc)); ?></div><?php } ?>
            </div>

            <div class="exportacion_footer exportacion_footer_flexible">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
                Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                Contacto: contacto@itred.cl - www.itred.cl
                <div class="exportacion_footer_numero"><?php echo $pagina_seccion_actual; ?></div>
            </div>
        </section>
        <?php $pagina_seccion_actual++; ?>
    <?php } ?>

    <?php $titulo_cu_1_anterior = ''; ?>
    <?php foreach($caso_uso_imagenes as $imagen_cu){ ?>
        <?php
            $titulo_cu_1 = exportacion_titulo_completo(isset($imagen_cu['numero_titulo_1']) ? $imagen_cu['numero_titulo_1'] : '', isset($imagen_cu['texto_titulo_1']) ? $imagen_cu['texto_titulo_1'] : '');
            $titulo_cu_2 = exportacion_titulo_completo(isset($imagen_cu['numero_titulo_2']) ? $imagen_cu['numero_titulo_2'] : '', isset($imagen_cu['texto_titulo_2']) ? $imagen_cu['texto_titulo_2'] : '');
            $nombre_cu = isset($imagen_cu['nombre_imagen']) ? trim((string)$imagen_cu['nombre_imagen']) : '';
            $src_cu = exportacion_obtener_src_imagen(isset($imagen_cu['ruta_imagen']) ? $imagen_cu['ruta_imagen'] : '');
            $mostrar_titulo_cu_1 = $titulo_cu_1 !== '' && $titulo_cu_1 !== $titulo_cu_1_anterior;
            if($titulo_cu_1 !== ''){ $titulo_cu_1_anterior = $titulo_cu_1; }
        ?>
        <section class="exportacion_documento">
            <div class="exportacion_cabecera_seccion">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
            </div>

            <div class="exportacion_cuerpo">
                <?php if($mostrar_titulo_cu_1){ ?><h2 class="exportacion_titulo_nivel_1"><?php echo htmlspecialchars($titulo_cu_1); ?></h2><?php } ?>
                <?php if($titulo_cu_2 !== ''){ ?><h3 class="exportacion_titulo_nivel_2"><?php echo htmlspecialchars($titulo_cu_2); ?></h3><?php } ?>
                <?php if($src_cu !== ''){ ?>
                    <div class="exportacion_imagen_bloque">
                        <img src="<?php echo htmlspecialchars($src_cu); ?>" alt="Imagen caso de uso">
                    </div>
                <?php } ?>
                <?php if($nombre_cu !== ''){ ?><div class="exportacion_imagen_nombre"><?php echo htmlspecialchars($nombre_cu); ?></div><?php } ?>
            </div>

            <div class="exportacion_footer exportacion_footer_flexible">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
                Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                Contacto: contacto@itred.cl - www.itred.cl
                <div class="exportacion_footer_numero"><?php echo $pagina_seccion_actual; ?></div>
            </div>
        </section>
        <?php $pagina_seccion_actual++; ?>
    <?php } ?>

    <?php $titulo_diagrama_1_anterior = ''; ?>
    <?php foreach($carpeta_diagramas as $diagrama){ ?>
        <?php
            $titulo_diagrama_1 = exportacion_titulo_completo(isset($diagrama['numero_titulo_1']) ? $diagrama['numero_titulo_1'] : '', isset($diagrama['texto_titulo_1']) ? $diagrama['texto_titulo_1'] : '');
            $titulo_diagrama_2 = exportacion_titulo_completo(isset($diagrama['numero_titulo_2']) ? $diagrama['numero_titulo_2'] : '', isset($diagrama['texto_titulo_2']) ? $diagrama['texto_titulo_2'] : '');
            $nombre_diagrama = isset($diagrama['nombre_imagen']) ? trim((string)$diagrama['nombre_imagen']) : '';
            $src_diagrama = exportacion_obtener_src_imagen(isset($diagrama['ruta_imagen']) ? $diagrama['ruta_imagen'] : '');
            $mostrar_titulo_diagrama_1 = $titulo_diagrama_1 !== '' && $titulo_diagrama_1 !== $titulo_diagrama_1_anterior;
            if($titulo_diagrama_1 !== ''){ $titulo_diagrama_1_anterior = $titulo_diagrama_1; }
        ?>
        <section class="exportacion_documento">
            <div class="exportacion_cabecera_seccion">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
            </div>

            <div class="exportacion_cuerpo">
                <?php if($mostrar_titulo_diagrama_1){ ?><h2 class="exportacion_titulo_nivel_1"><?php echo htmlspecialchars($titulo_diagrama_1); ?></h2><?php } ?>
                <?php if($titulo_diagrama_2 !== ''){ ?><h3 class="exportacion_titulo_nivel_2"><?php echo htmlspecialchars($titulo_diagrama_2); ?></h3><?php } ?>
                <?php if($src_diagrama !== ''){ ?>
                    <div class="exportacion_imagen_bloque">
                        <img src="<?php echo htmlspecialchars($src_diagrama); ?>" alt="Imagen diagrama">
                    </div>
                <?php } ?>
                <?php if($nombre_diagrama !== ''){ ?><div class="exportacion_imagen_nombre"><?php echo htmlspecialchars($nombre_diagrama); ?></div><?php } ?>
            </div>

            <div class="exportacion_footer exportacion_footer_flexible">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
                Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                Contacto: contacto@itred.cl - www.itred.cl
                <div class="exportacion_footer_numero"><?php echo $pagina_seccion_actual; ?></div>
            </div>
        </section>
        <?php $pagina_seccion_actual++; ?>
    <?php } ?>

    <?php $titulo_programa_1_anterior = ''; ?>
    <?php foreach($carpeta_informes_programas as $programa){ ?>
        <?php
            $titulo_programa_1 = exportacion_titulo_completo(isset($programa['numero_titulo_1']) ? $programa['numero_titulo_1'] : '', isset($programa['texto_titulo_1']) ? $programa['texto_titulo_1'] : '');
            $titulo_programa_2 = exportacion_titulo_completo(isset($programa['numero_titulo_2']) ? $programa['numero_titulo_2'] : '', isset($programa['texto_titulo_2']) ? $programa['texto_titulo_2'] : '');
            $ruta_principal_programa = isset($programa['ruta_principal']) ? trim((string)$programa['ruta_principal']) : '';
            $sin_manual_programa = isset($programa['sin_manual_momento']) && (int)$programa['sin_manual_momento'] === 1;
            $carpeta_programa = isset($programa['carpeta']) ? trim((string)$programa['carpeta']) : '';
            $archivo_programa = isset($programa['archivo']) ? trim((string)$programa['archivo']) : '';
            $extension_programa = isset($programa['extension']) ? trim((string)$programa['extension']) : '';
            $ruta_extra_1_programa = isset($programa['ruta_extra_1']) ? trim((string)$programa['ruta_extra_1']) : '';
            $ruta_extra_2_programa = isset($programa['ruta_extra_2']) ? trim((string)$programa['ruta_extra_2']) : '';
            $ruta_extra_3_programa = isset($programa['ruta_extra_3']) ? trim((string)$programa['ruta_extra_3']) : '';
            $ruta_extra_4_programa = isset($programa['ruta_extra_4']) ? trim((string)$programa['ruta_extra_4']) : '';
            $mostrar_titulo_programa_1 = $titulo_programa_1 !== '' && $titulo_programa_1 !== $titulo_programa_1_anterior;
            if($titulo_programa_1 !== ''){ $titulo_programa_1_anterior = $titulo_programa_1; }

            $archivo_completo_programa = '';
            if($carpeta_programa !== '' && $archivo_programa !== ''){
                $archivo_completo_programa = rtrim($carpeta_programa, '/\\') . '/' . ltrim($archivo_programa, '/\\');
            }elseif($carpeta_programa !== ''){
                $archivo_completo_programa = $carpeta_programa;
            }elseif($archivo_programa !== ''){
                $archivo_completo_programa = $archivo_programa;
            }

            if($extension_programa !== ''){
                $archivo_completo_programa .= '.' . ltrim($extension_programa, '.');
            }
        ?>
        <section class="exportacion_documento">
            <div class="exportacion_cabecera_seccion">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
            </div>

            <div class="exportacion_cuerpo">
                <?php if($mostrar_titulo_programa_1){ ?><h2 class="exportacion_titulo_nivel_1"><?php echo htmlspecialchars($titulo_programa_1); ?></h2><?php } ?>
                <?php if($titulo_programa_2 !== ''){ ?><h3 class="exportacion_titulo_nivel_2"><?php echo htmlspecialchars($titulo_programa_2); ?></h3><?php } ?>

                <?php if($ruta_principal_programa !== ''){ ?><div class="exportacion_contenido">- ruta: <?php echo htmlspecialchars($ruta_principal_programa); ?></div><?php } ?>
                <?php if($archivo_completo_programa !== ''){ ?><div class="exportacion_contenido">- archivo: <?php echo htmlspecialchars($archivo_completo_programa); ?></div><?php } ?>
                <?php if($ruta_extra_1_programa !== ''){ ?><div class="exportacion_contenido">- ruta extra: <?php echo htmlspecialchars($ruta_extra_1_programa); ?></div><?php } ?>
                <?php if($ruta_extra_2_programa !== ''){ ?><div class="exportacion_contenido">- ruta extra: <?php echo htmlspecialchars($ruta_extra_2_programa); ?></div><?php } ?>
                <?php if($ruta_extra_3_programa !== ''){ ?><div class="exportacion_contenido">- ruta extra: <?php echo htmlspecialchars($ruta_extra_3_programa); ?></div><?php } ?>
                <?php if($ruta_extra_4_programa !== ''){ ?><div class="exportacion_contenido">- ruta extra: <?php echo htmlspecialchars($ruta_extra_4_programa); ?></div><?php } ?>
                <?php if($sin_manual_programa){ ?><div class="exportacion_contenido">- SIN MANUAL POR EL MOMENTO</div><?php } ?>
            </div>

            <div class="exportacion_footer exportacion_footer_flexible">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
                Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                Contacto: contacto@itred.cl - www.itred.cl
                <div class="exportacion_footer_numero"><?php echo $pagina_seccion_actual; ?></div>
            </div>
        </section>
        <?php $pagina_seccion_actual++; ?>
    <?php } ?>

    <?php $titulo_pantallazo_1_anterior = ''; ?>
    <?php foreach($carpeta_pantallazos_programas as $pantallazo){ ?>
        <?php
            $titulo_pantallazo_1 = exportacion_titulo_completo(isset($pantallazo['numero_titulo_1']) ? $pantallazo['numero_titulo_1'] : '', isset($pantallazo['texto_titulo_1']) ? $pantallazo['texto_titulo_1'] : '');
            $titulo_pantallazo_2 = exportacion_titulo_completo(isset($pantallazo['numero_titulo_2']) ? $pantallazo['numero_titulo_2'] : '', isset($pantallazo['texto_titulo_2']) ? $pantallazo['texto_titulo_2'] : '');
            $nombre_pantallazo = isset($pantallazo['nombre_imagen']) ? trim((string)$pantallazo['nombre_imagen']) : '';
            $src_pantallazo = exportacion_obtener_src_imagen(isset($pantallazo['ruta_imagen']) ? $pantallazo['ruta_imagen'] : '');
            $mostrar_titulo_pantallazo_1 = $titulo_pantallazo_1 !== '' && $titulo_pantallazo_1 !== $titulo_pantallazo_1_anterior;
            if($titulo_pantallazo_1 !== ''){ $titulo_pantallazo_1_anterior = $titulo_pantallazo_1; }
        ?>
        <section class="exportacion_documento">
            <div class="exportacion_cabecera_seccion">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
            </div>

            <div class="exportacion_cuerpo">
                <?php if($mostrar_titulo_pantallazo_1){ ?><h2 class="exportacion_titulo_nivel_1"><?php echo htmlspecialchars($titulo_pantallazo_1); ?></h2><?php } ?>
                <?php if($titulo_pantallazo_2 !== ''){ ?><h3 class="exportacion_titulo_nivel_2"><?php echo htmlspecialchars($titulo_pantallazo_2); ?></h3><?php } ?>
                <?php if($src_pantallazo !== ''){ ?>
                    <div class="exportacion_imagen_bloque">
                        <img src="<?php echo htmlspecialchars($src_pantallazo); ?>" alt="Imagen pantallazo programa">
                    </div>
                <?php } ?>
                <?php if($nombre_pantallazo !== ''){ ?><div class="exportacion_imagen_nombre"><?php echo htmlspecialchars($nombre_pantallazo); ?></div><?php } ?>
            </div>

            <div class="exportacion_footer exportacion_footer_flexible">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
                Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                Contacto: contacto@itred.cl - www.itred.cl
                <div class="exportacion_footer_numero"><?php echo $pagina_seccion_actual; ?></div>
            </div>
        </section>
        <?php $pagina_seccion_actual++; ?>
    <?php } ?>

    <?php foreach($rutas_estructurales as $clave_ruta_exportacion => $ruta_seccion_exportacion){ ?>
        <?php if(!is_array($ruta_seccion_exportacion)){ continue; } ?>
        <?php $titulo_ruta_1_anterior = ''; ?>
        <?php foreach($ruta_seccion_exportacion as $ruta_item_exportacion){ ?>
            <?php
                $titulo_ruta_1 = exportacion_titulo_completo(isset($ruta_item_exportacion['numero_titulo_1']) ? $ruta_item_exportacion['numero_titulo_1'] : '', isset($ruta_item_exportacion['texto_titulo_1']) ? $ruta_item_exportacion['texto_titulo_1'] : '');
                $titulo_ruta_2 = exportacion_titulo_completo(isset($ruta_item_exportacion['numero_titulo_2']) ? $ruta_item_exportacion['numero_titulo_2'] : '', isset($ruta_item_exportacion['texto_titulo_2']) ? $ruta_item_exportacion['texto_titulo_2'] : '');
                $mostrar_titulo_ruta_1 = $titulo_ruta_1 !== '' && $titulo_ruta_1 !== $titulo_ruta_1_anterior;
                if($titulo_ruta_1 !== ''){ $titulo_ruta_1_anterior = $titulo_ruta_1; }

                $ruta_principal_item = isset($ruta_item_exportacion['ruta_principal']) ? trim((string)$ruta_item_exportacion['ruta_principal']) : '';
                $sin_manual_item = isset($ruta_item_exportacion['sin_manual_momento']) && (int)$ruta_item_exportacion['sin_manual_momento'] === 1;
                $carpeta_item = isset($ruta_item_exportacion['carpeta']) ? trim((string)$ruta_item_exportacion['carpeta']) : '';
                $archivo_item = isset($ruta_item_exportacion['archivo']) ? trim((string)$ruta_item_exportacion['archivo']) : '';
                $extension_item = isset($ruta_item_exportacion['extension']) ? trim((string)$ruta_item_exportacion['extension']) : '';
                $ruta_extra_1_item = isset($ruta_item_exportacion['ruta_extra_1']) ? trim((string)$ruta_item_exportacion['ruta_extra_1']) : '';
                $ruta_extra_2_item = isset($ruta_item_exportacion['ruta_extra_2']) ? trim((string)$ruta_item_exportacion['ruta_extra_2']) : '';
                $ruta_extra_3_item = isset($ruta_item_exportacion['ruta_extra_3']) ? trim((string)$ruta_item_exportacion['ruta_extra_3']) : '';
                $ruta_extra_4_item = isset($ruta_item_exportacion['ruta_extra_4']) ? trim((string)$ruta_item_exportacion['ruta_extra_4']) : '';

                $archivo_compuesto_item = '';
                if($carpeta_item !== '' && $archivo_item !== ''){
                    $archivo_compuesto_item = rtrim($carpeta_item, '/\\') . '/' . ltrim($archivo_item, '/\\');
                }elseif($carpeta_item !== ''){
                    $archivo_compuesto_item = $carpeta_item;
                }elseif($archivo_item !== ''){
                    $archivo_compuesto_item = $archivo_item;
                }
                if($extension_item !== ''){
                    $archivo_compuesto_item .= '.' . ltrim($extension_item, '.');
                }
            ?>
            <section class="exportacion_documento">
                <div class="exportacion_cabecera_seccion">
                    <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
                </div>

                <div class="exportacion_cuerpo">
                    <?php if($mostrar_titulo_ruta_1){ ?><h2 class="exportacion_titulo_nivel_1"><?php echo htmlspecialchars($titulo_ruta_1); ?></h2><?php } ?>
                    <?php if($titulo_ruta_2 !== ''){ ?><h3 class="exportacion_titulo_nivel_2"><?php echo htmlspecialchars($titulo_ruta_2); ?></h3><?php } ?>

                    <?php if($ruta_principal_item !== ''){ ?><div class="exportacion_contenido">- ruta: <?php echo htmlspecialchars($ruta_principal_item); ?></div><?php } ?>
                    <?php if($archivo_compuesto_item !== ''){ ?><div class="exportacion_contenido">- archivo: <?php echo htmlspecialchars($archivo_compuesto_item); ?></div><?php } ?>
                    <?php if($ruta_extra_1_item !== ''){ ?><div class="exportacion_contenido">- ruta extra: <?php echo htmlspecialchars($ruta_extra_1_item); ?></div><?php } ?>
                    <?php if($ruta_extra_2_item !== ''){ ?><div class="exportacion_contenido">- ruta extra: <?php echo htmlspecialchars($ruta_extra_2_item); ?></div><?php } ?>
                    <?php if($ruta_extra_3_item !== ''){ ?><div class="exportacion_contenido">- ruta extra: <?php echo htmlspecialchars($ruta_extra_3_item); ?></div><?php } ?>
                    <?php if($ruta_extra_4_item !== ''){ ?><div class="exportacion_contenido">- ruta extra: <?php echo htmlspecialchars($ruta_extra_4_item); ?></div><?php } ?>
                    <?php if($sin_manual_item){ ?><div class="exportacion_contenido">- SIN MANUAL POR EL MOMENTO</div><?php } ?>
                </div>

                <div class="exportacion_footer exportacion_footer_flexible">
                    <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
                    Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                    Contacto: contacto@itred.cl - www.itred.cl
                    <div class="exportacion_footer_numero"><?php echo $pagina_seccion_actual; ?></div>
                </div>
            </section>
            <?php $pagina_seccion_actual++; ?>
        <?php } ?>
    <?php } ?>

    <?php foreach($fuentes_detalle as $clave_fuente_exportacion => $fuente_seccion_exportacion){ ?>
        <?php if(!is_array($fuente_seccion_exportacion) || count($fuente_seccion_exportacion) === 0){ continue; } ?>
        <?php
            $fuente_base = $fuente_seccion_exportacion[0];
            $titulo_fuente_1 = exportacion_titulo_completo(isset($fuente_base['numero_titulo_1']) ? $fuente_base['numero_titulo_1'] : '', isset($fuente_base['texto_titulo_1']) ? $fuente_base['texto_titulo_1'] : '');
            $titulo_fuente_2 = exportacion_titulo_completo(isset($fuente_base['numero_titulo_2']) ? $fuente_base['numero_titulo_2'] : '', isset($fuente_base['texto_titulo_2']) ? $fuente_base['texto_titulo_2'] : '');
        ?>
        <section class="exportacion_documento">
            <div class="exportacion_cabecera_seccion">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred"><?php } ?>
            </div>

            <div class="exportacion_cuerpo">
                <?php if($titulo_fuente_1 !== ''){ ?><h2 class="exportacion_titulo_nivel_1"><?php echo htmlspecialchars($titulo_fuente_1); ?></h2><?php } ?>
                <?php if($titulo_fuente_2 !== ''){ ?><h3 class="exportacion_titulo_nivel_2"><?php echo htmlspecialchars($titulo_fuente_2); ?></h3><?php } ?>

                <table style="width:100%; border-collapse:collapse; table-layout:fixed; margin-top:8mm;">
                    <?php foreach(array_chunk($fuente_seccion_exportacion, 3) as $fila_fuente_exp){ ?>
                        <tr>
                            <?php for($i = 0; $i < 3; $i++){ ?>
                                <td style="border:1px solid #999; padding:4px; font-size:10pt; vertical-align:top; word-break:break-word;">
                                    <?php echo isset($fila_fuente_exp[$i]) ? htmlspecialchars((string)$fila_fuente_exp[$i]['nombre_fuente']) : ''; ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div class="exportacion_footer exportacion_footer_flexible">
                <?php if($logo_itred !== ''){ ?><img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" width="30" style="width:30px !important; max-width:30px !important; height:auto !important; mso-width-percent:0;"><?php } ?>
                Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                Contacto: contacto@itred.cl - www.itred.cl
                <div class="exportacion_footer_numero"><?php echo $pagina_seccion_actual; ?></div>
            </div>
        </section>
        <?php $pagina_seccion_actual++; ?>
    <?php } ?>

    <?php if($tipo_exportacion === 'pdf' || $tipo_exportacion === 'imprimir'){ ?>
    <script>
        window.onload = function(){
            window.focus();
            window.print();
        };
    </script>
    <?php } ?>

</body>
</html>
<?php
        return ob_get_clean();
    }


