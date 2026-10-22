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
?>

<form method="POST" id="carpeta_pantallazos_programas_formulario_principal" class="portada_formulario_principal carpeta_diagramas_formulario_principal" enctype="multipart/form-data">
    <input type="hidden" name="id_informe" value="<?php echo (int)$id_informe; ?>">
    <input type="hidden" name="carpeta_pantallazos_primer_titulo_bloqueado" id="carpeta_pantallazos_primer_titulo_bloqueado" value="<?php echo $carpeta_pantallazos_primer_titulo_bloqueado ? '1' : '0'; ?>">
    <input type="hidden" name="nivel_titulo_cp_1_fijo" id="nivel_titulo_cp_1_fijo" value="<?php echo htmlspecialchars($nivel_titulo_cp_1); ?>">
    <input type="hidden" name="numero_titulo_cp_1_fijo" id="numero_titulo_cp_1_fijo" value="<?php echo htmlspecialchars($numero_titulo_cp_1); ?>">
    <input type="hidden" name="texto_titulo_cp_1_fijo" id="texto_titulo_cp_1_fijo" value="<?php echo htmlspecialchars($texto_titulo_cp_1); ?>">

    <section id="seccion_carpeta_pantallazos_programas" class="portada_fila_seccion carpeta_diagramas_fila_seccion">

        <div class="carpeta_diagramas_bloque_completo">

            <h2 class="carpeta_diagramas_titulo_documento" id="<?php echo htmlspecialchars(construir_id_ancla_indice('carpeta_pantallazos_programas', $numero_titulo_cp_1, $texto_titulo_cp_1)); ?>">CARPETA PANTALLAZOS PROGRAMAS</h2>

            <?php if(!empty($carpeta_pantallazos_programas_exportacion)): ?>
                <?php
                    $anclas_cp_vistas = array();
                    foreach($carpeta_pantallazos_programas_exportacion as $item_cp_ancla){
                        $numero_cp_1_ancla = isset($item_cp_ancla['numero_titulo_1']) ? trim((string)$item_cp_ancla['numero_titulo_1']) : '';
                        $texto_cp_1_ancla = isset($item_cp_ancla['texto_titulo_1']) ? trim((string)$item_cp_ancla['texto_titulo_1']) : '';
                        $numero_cp_2_ancla = isset($item_cp_ancla['numero_titulo_2']) ? trim((string)$item_cp_ancla['numero_titulo_2']) : '';
                        $texto_cp_2_ancla = isset($item_cp_ancla['texto_titulo_2']) ? trim((string)$item_cp_ancla['texto_titulo_2']) : '';

                        if($texto_cp_1_ancla !== ''){
                            $id_ancla_cp_1 = construir_id_ancla_indice('carpeta_pantallazos_programas', $numero_cp_1_ancla, $texto_cp_1_ancla);
                            if(!isset($anclas_cp_vistas[$id_ancla_cp_1])){
                                $anclas_cp_vistas[$id_ancla_cp_1] = true;
                                echo '<span id="' . htmlspecialchars($id_ancla_cp_1) . '"></span>';
                            }
                        }

                        if($texto_cp_2_ancla !== ''){
                            $id_ancla_cp_2 = construir_id_ancla_indice('carpeta_pantallazos_programas', $numero_cp_2_ancla, $texto_cp_2_ancla);
                            if(!isset($anclas_cp_vistas[$id_ancla_cp_2])){
                                $anclas_cp_vistas[$id_ancla_cp_2] = true;
                                echo '<span id="' . htmlspecialchars($id_ancla_cp_2) . '"></span>';
                            }
                        }
                    }
                ?>
            <?php else: ?>
                <span id="<?php echo htmlspecialchars(construir_id_ancla_indice('carpeta_pantallazos_programas', $numero_titulo_cp_2, $texto_titulo_cp_2)); ?>"></span>
            <?php endif; ?>

            <article class="portada_documento carpeta_diagramas_documento">
                <div class="carpeta_diagramas_documento_encabezado">
                    <div class="carpeta_diagramas_logo_superior">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="carpeta_diagramas_logo_imagen">
                    </div>
                </div>

                <?php if($mensaje_carpeta_pantallazos_programas !== ''){ ?>
                    <p class="portada_respuesta <?php echo htmlspecialchars($clase_mensaje_carpeta_pantallazos_programas); ?>">
                        <?php echo htmlspecialchars($mensaje_carpeta_pantallazos_programas); ?>
                    </p>
                <?php } ?>

                <section class="carpeta_diagramas_bloque_jerarquia">
                    <div class="carpeta_diagramas_jerarquia_item">
                        <div class="carpeta_diagramas_campo carpeta_diagramas_campo_tipo">
                            <label for="nivel_titulo_cp_1" class="carpeta_diagramas_etiqueta">TIPO TITULO</label>
                            <select name="nivel_titulo_cp_1" id="nivel_titulo_cp_1" class="carpeta_diagramas_select" <?php echo $carpeta_pantallazos_primer_titulo_bloqueado ? 'disabled' : ''; ?>>
                                <?php for($i = 1; $i <= 20; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_cp_1 === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="carpeta_diagramas_campo carpeta_diagramas_campo_numero">
                            <label for="numero_titulo_cp_1" class="carpeta_diagramas_etiqueta">N&deg; TITULO</label>
                            <input type="text" name="numero_titulo_cp_1" id="numero_titulo_cp_1" class="carpeta_diagramas_input" value="<?php echo htmlspecialchars($numero_titulo_cp_1); ?>" <?php echo $carpeta_pantallazos_primer_titulo_bloqueado ? 'readonly' : ''; ?>>
                        </div>

                        <div class="carpeta_diagramas_campo carpeta_diagramas_campo_titulo">
                            <label for="texto_titulo_cp_1" class="carpeta_diagramas_etiqueta">INGRESAR TITULO</label>
                            <input type="text" name="texto_titulo_cp_1" id="texto_titulo_cp_1" class="carpeta_diagramas_input" value="<?php echo htmlspecialchars($texto_titulo_cp_1); ?>" <?php echo $carpeta_pantallazos_primer_titulo_bloqueado ? 'readonly' : ''; ?>>
                        </div>
                    </div>

                    <div class="carpeta_diagramas_jerarquia_item">
                        <div class="carpeta_diagramas_campo carpeta_diagramas_campo_tipo">
                            <label for="nivel_titulo_cp_2" class="carpeta_diagramas_etiqueta">TIPO TITULO</label>
                            <select name="nivel_titulo_cp_2" id="nivel_titulo_cp_2" class="carpeta_diagramas_select">
                                <?php for($i = 1; $i <= 20; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_cp_2 === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="carpeta_diagramas_campo carpeta_diagramas_campo_numero">
                            <label for="numero_titulo_cp_2" class="carpeta_diagramas_etiqueta">N&deg; TITULO</label>
                            <input type="text" name="numero_titulo_cp_2" id="numero_titulo_cp_2" class="carpeta_diagramas_input" value="<?php echo htmlspecialchars($numero_titulo_cp_2); ?>">
                        </div>

                        <div class="carpeta_diagramas_campo carpeta_diagramas_campo_titulo">
                            <label for="texto_titulo_cp_2" class="carpeta_diagramas_etiqueta">INGRESAR TITULO</label>
                            <input type="text" name="texto_titulo_cp_2" id="texto_titulo_cp_2" class="carpeta_diagramas_input" value="<?php echo htmlspecialchars($texto_titulo_cp_2); ?>">
                        </div>
                    </div>
                </section>

                <p class="carpeta_diagramas_subtitulo" id="carpeta_pantallazos_subtitulo">IMAGEN PANTALLAZO PROGRAMA</p>

                <section class="carpeta_diagramas_bloque_multimedia">
                    <div class="carpeta_diagramas_marco">
                        <img id="carpeta_pantallazos_imagen_principal" class="carpeta_diagramas_imagen_principal" alt="" src="<?php echo htmlspecialchars($ruta_imagen_cp); ?>" style="display:<?php echo trim((string)$ruta_imagen_cp) !== '' ? 'block' : 'none'; ?>;" onerror="this.style.display='none';var ph=document.getElementById('carpeta_pantallazos_imagen_placeholder');if(ph){ph.style.display='flex';}">
                        <div id="carpeta_pantallazos_imagen_placeholder" class="carpeta_diagramas_imagen_placeholder" style="display:<?php echo trim((string)$ruta_imagen_cp) !== '' ? 'none' : 'flex'; ?>;">+</div>
                    </div>

                    <div class="carpeta_diagramas_controles_laterales">
                        <label for="archivo_carpeta_pantallazos" class="carpeta_diagramas_label_archivo">SUBIR IMAGEN</label>
                        <input type="file" name="archivo_carpeta_pantallazos" id="archivo_carpeta_pantallazos" class="carpeta_diagramas_input_archivo" accept="image/*">

                        <div class="portada_bloque_botones_inferiores carpeta_diagramas_bloque_botones">
                            <button type="submit" name="guardar_carpeta_pantallazos_programas_base" value="1" class="portada_boton_guardar_inferior" id="carpeta_pantallazos_boton_guardar">
                                GUARDAR
                            </button>

                            <button type="button" class="portada_boton_modificar_inferior" id="carpeta_pantallazos_boton_modificar">
                                MODIFICAR
                            </button>
                        </div>
                    </div>
                </section>

                <section class="carpeta_diagramas_nombre_bloque">
                    <label for="nombre_imagen_cp" class="carpeta_diagramas_etiqueta_nombre">INGRESAR NOMBRE IMAGEN:</label>
                    <input type="text" name="nombre_imagen_cp" id="nombre_imagen_cp" class="carpeta_diagramas_input_nombre" value="<?php echo htmlspecialchars($nombre_imagen_cp); ?>">
                </section>

                <footer class="carpeta_diagramas_documento_footer">
                    <div class="carpeta_diagramas_documento_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="carpeta_diagramas_documento_footer_logo_imagen">
                    </div>

                    <div class="carpeta_diagramas_documento_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago-Chile<br>
                        Email: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl<br>
                    </div>

                    <div class="carpeta_diagramas_documento_footer_numero">14</div>
                </footer>
            </article>
        </div>

        <aside class="portada_columna_preview_individual carpeta_diagramas_columna_preview">
            <div class="portada_preview_documento carpeta_diagramas_preview_documento">
                <div class="carpeta_diagramas_preview_logo_superior">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="carpeta_diagramas_preview_logo_imagen">
                </div>

                <div class="carpeta_diagramas_preview_titulo carpeta_diagramas_preview_nivel_<?php echo htmlspecialchars($nivel_titulo_cp_1); ?>" id="carpeta_pantallazos_preview_titulo_1">
                    <span class="carpeta_diagramas_preview_titulo_numero" id="carpeta_pantallazos_preview_numero_1"><?php echo htmlspecialchars($numero_titulo_cp_1); ?></span>
                    <span class="carpeta_diagramas_preview_titulo_texto" id="carpeta_pantallazos_preview_texto_1"><?php echo htmlspecialchars($texto_titulo_cp_1); ?></span>
                </div>

                <div class="carpeta_diagramas_preview_titulo carpeta_diagramas_preview_nivel_<?php echo htmlspecialchars($nivel_titulo_cp_2); ?>" id="carpeta_pantallazos_preview_titulo_2">
                    <span class="carpeta_diagramas_preview_titulo_numero" id="carpeta_pantallazos_preview_numero_2"><?php echo htmlspecialchars($numero_titulo_cp_2); ?></span>
                    <span class="carpeta_diagramas_preview_titulo_texto" id="carpeta_pantallazos_preview_texto_2"><?php echo htmlspecialchars($texto_titulo_cp_2); ?></span>
                </div>

                <div class="carpeta_diagramas_preview_marco">
                    <img id="carpeta_pantallazos_preview_img" class="carpeta_diagramas_preview_img" alt="" src="<?php echo htmlspecialchars($ruta_imagen_cp); ?>" style="display:<?php echo trim((string)$ruta_imagen_cp) !== '' ? 'block' : 'none'; ?>;" onerror="this.style.display='none';var ph=document.getElementById('carpeta_pantallazos_preview_placeholder');if(ph){ph.style.display='block';}">
                    <div id="carpeta_pantallazos_preview_placeholder" class="carpeta_diagramas_preview_placeholder" style="display:<?php echo trim((string)$ruta_imagen_cp) !== '' ? 'none' : 'block'; ?>;"></div>
                </div>

                <p class="carpeta_diagramas_preview_nombre" id="carpeta_pantallazos_preview_nombre"><?php echo htmlspecialchars($nombre_imagen_cp); ?></p>

                <footer class="carpeta_diagramas_preview_footer">
                    <div class="carpeta_diagramas_preview_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="carpeta_diagramas_preview_footer_logo_imagen">
                    </div>
                    <div class="carpeta_diagramas_preview_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago - Chile<br>
                        E-Mail: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl
                    </div>
                    <div class="carpeta_diagramas_preview_footer_numero">14</div>
                </footer>
            </div>
        </aside>

    </section>
</form>
