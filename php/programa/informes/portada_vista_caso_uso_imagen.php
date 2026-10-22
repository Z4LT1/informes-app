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



<form method="POST" id="caso_uso_imagen_formulario_principal" class="portada_formulario_principal caso_uso_imagen_formulario_principal" enctype="multipart/form-data">
    <input type="hidden" name="id_informe" value="<?php echo (int)$id_informe; ?>">
    <input type="hidden" name="caso_uso_primer_titulo_bloqueado" id="caso_uso_primer_titulo_bloqueado" value="<?php echo $caso_uso_primer_titulo_bloqueado ? '1' : '0'; ?>">
    <input type="hidden" name="nivel_titulo_cu_1_fijo" id="nivel_titulo_cu_1_fijo" value="<?php echo htmlspecialchars($nivel_titulo_cu_1); ?>">
    <input type="hidden" name="numero_titulo_cu_1_fijo" id="numero_titulo_cu_1_fijo" value="<?php echo htmlspecialchars($numero_titulo_cu_1); ?>">
    <input type="hidden" name="texto_titulo_cu_1_fijo" id="texto_titulo_cu_1_fijo" value="<?php echo htmlspecialchars($texto_titulo_cu_1); ?>">

    <section id="seccion_caso_uso_imagen" class="portada_fila_seccion caso_uso_imagen_fila_seccion">

        <div class="caso_uso_imagen_bloque_completo">

            <h2 class="caso_uso_imagen_titulo_documento" id="<?php echo htmlspecialchars(construir_id_ancla_indice('caso_uso_imagen', $numero_titulo_cu_1, $texto_titulo_cu_1)); ?>">CARPETA CASO DE USO</h2>

            <?php if(!empty($caso_uso_imagenes_exportacion)): ?>
                <?php
                    $anclas_cu_vistas = array();
                    foreach($caso_uso_imagenes_exportacion as $item_cu_ancla){
                        $numero_cu_1_ancla = isset($item_cu_ancla['numero_titulo_1']) ? trim((string)$item_cu_ancla['numero_titulo_1']) : '';
                        $texto_cu_1_ancla = isset($item_cu_ancla['texto_titulo_1']) ? trim((string)$item_cu_ancla['texto_titulo_1']) : '';
                        $numero_cu_2_ancla = isset($item_cu_ancla['numero_titulo_2']) ? trim((string)$item_cu_ancla['numero_titulo_2']) : '';
                        $texto_cu_2_ancla = isset($item_cu_ancla['texto_titulo_2']) ? trim((string)$item_cu_ancla['texto_titulo_2']) : '';

                        if($texto_cu_1_ancla !== ''){
                            $id_ancla_cu_1 = construir_id_ancla_indice('caso_uso_imagen', $numero_cu_1_ancla, $texto_cu_1_ancla);
                            if(!isset($anclas_cu_vistas[$id_ancla_cu_1])){
                                $anclas_cu_vistas[$id_ancla_cu_1] = true;
                                echo '<span id="' . htmlspecialchars($id_ancla_cu_1) . '"></span>';
                            }
                        }

                        if($texto_cu_2_ancla !== ''){
                            $id_ancla_cu_2 = construir_id_ancla_indice('caso_uso_imagen', $numero_cu_2_ancla, $texto_cu_2_ancla);
                            if(!isset($anclas_cu_vistas[$id_ancla_cu_2])){
                                $anclas_cu_vistas[$id_ancla_cu_2] = true;
                                echo '<span id="' . htmlspecialchars($id_ancla_cu_2) . '"></span>';
                            }
                        }
                    }
                ?>
            <?php else: ?>
                <span id="<?php echo htmlspecialchars(construir_id_ancla_indice('caso_uso_imagen', $numero_titulo_cu_2, $texto_titulo_cu_2)); ?>"></span>
            <?php endif; ?>

            <article class="portada_documento caso_uso_imagen_documento">
                <div class="caso_uso_imagen_documento_encabezado">
                    <div class="caso_uso_imagen_logo_superior">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="caso_uso_imagen_logo_imagen">
                    </div>
                </div>

                <?php if($mensaje_caso_uso_imagen !== ''){ ?>
                    <p class="portada_respuesta <?php echo htmlspecialchars($clase_mensaje_caso_uso_imagen); ?>">
                        <?php echo htmlspecialchars($mensaje_caso_uso_imagen); ?>
                    </p>
                <?php } ?>

                <section class="caso_uso_imagen_bloque_jerarquia">
                    <div class="caso_uso_imagen_jerarquia_item">
                        <div class="caso_uso_imagen_campo caso_uso_imagen_campo_tipo">
                            <label for="nivel_titulo_cu_1" class="caso_uso_imagen_etiqueta">TIPO TITULO</label>
                            <select name="nivel_titulo_cu_1" id="nivel_titulo_cu_1" class="caso_uso_imagen_select" <?php echo $caso_uso_primer_titulo_bloqueado ? 'disabled' : ''; ?>>
                                <?php for($i = 1; $i <= 20; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_cu_1 === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="caso_uso_imagen_campo caso_uso_imagen_campo_numero">
                            <label for="numero_titulo_cu_1" class="caso_uso_imagen_etiqueta">N&deg; TITULO</label>
                            <input type="text" name="numero_titulo_cu_1" id="numero_titulo_cu_1" class="caso_uso_imagen_input" value="<?php echo htmlspecialchars($numero_titulo_cu_1); ?>" <?php echo $caso_uso_primer_titulo_bloqueado ? 'readonly' : ''; ?>>
                        </div>

                        <div class="caso_uso_imagen_campo caso_uso_imagen_campo_titulo">
                            <label for="texto_titulo_cu_1" class="caso_uso_imagen_etiqueta">INGRESAR TITULO</label>
                            <input type="text" name="texto_titulo_cu_1" id="texto_titulo_cu_1" class="caso_uso_imagen_input" value="<?php echo htmlspecialchars($texto_titulo_cu_1); ?>" <?php echo $caso_uso_primer_titulo_bloqueado ? 'readonly' : ''; ?>>
                        </div>
                    </div>

                    <div class="caso_uso_imagen_jerarquia_item">
                        <div class="caso_uso_imagen_campo caso_uso_imagen_campo_tipo">
                            <label for="nivel_titulo_cu_2" class="caso_uso_imagen_etiqueta">TIPO TITULO</label>
                            <select name="nivel_titulo_cu_2" id="nivel_titulo_cu_2" class="caso_uso_imagen_select">
                                <?php for($i = 1; $i <= 20; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_cu_2 === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="caso_uso_imagen_campo caso_uso_imagen_campo_numero">
                            <label for="numero_titulo_cu_2" class="caso_uso_imagen_etiqueta">N&deg; TITULO</label>
                            <input type="text" name="numero_titulo_cu_2" id="numero_titulo_cu_2" class="caso_uso_imagen_input" value="<?php echo htmlspecialchars($numero_titulo_cu_2); ?>">
                        </div>

                        <div class="caso_uso_imagen_campo caso_uso_imagen_campo_titulo">
                            <label for="texto_titulo_cu_2" class="caso_uso_imagen_etiqueta">INGRESAR TITULO</label>
                            <input type="text" name="texto_titulo_cu_2" id="texto_titulo_cu_2" class="caso_uso_imagen_input" value="<?php echo htmlspecialchars($texto_titulo_cu_2); ?>">
                        </div>
                    </div>
                </section>

                <p class="caso_uso_imagen_subtitulo" id="caso_uso_imagen_subtitulo">IMAGEN CASO DE USO PAGINA 1</p>
                <p class="caso_uso_imagen_instruccion">
                    Aca van solo las imagenes del caso de uso. Al guardar, el primer titulo se bloquea para continuar agregando titulo de imagen e imagen. Al guardar tambien se limpia la pantalla para permitir subir una nueva imagen.
                </p>

                <section class="caso_uso_imagen_bloque_multimedia">
                    <div class="caso_uso_imagen_marco">
                        <img id="caso_uso_imagen_principal" class="caso_uso_imagen_principal" alt="" src="<?php echo htmlspecialchars($ruta_imagen_cu); ?>" style="display:<?php echo trim((string)$ruta_imagen_cu) !== '' ? 'block' : 'none'; ?>;" onerror="this.style.display='none';var ph=document.getElementById('caso_uso_imagen_placeholder');if(ph){ph.style.display='flex';}">
                        <div id="caso_uso_imagen_placeholder" class="caso_uso_imagen_placeholder" style="display:<?php echo trim((string)$ruta_imagen_cu) !== '' ? 'none' : 'flex'; ?>;">+</div>
                    </div>

                    <div class="caso_uso_imagen_controles_laterales">
                        <label for="archivo_caso_uso" class="caso_uso_imagen_label_archivo">SUBIR IMAGEN</label>
                        <input type="file" name="archivo_caso_uso" id="archivo_caso_uso" class="caso_uso_imagen_input_archivo" accept="image/*">

                        <div class="portada_bloque_botones_inferiores caso_uso_imagen_bloque_botones">
                            <button type="submit" name="guardar_caso_uso_imagen_base" value="1" class="portada_boton_guardar_inferior" id="caso_uso_imagen_boton_guardar">
                                GUARDAR
                            </button>

                            <button type="button" class="portada_boton_modificar_inferior" id="caso_uso_imagen_boton_modificar">
                                MODIFICAR
                            </button>
                        </div>
                    </div>
                </section>

                <section class="caso_uso_imagen_nombre_bloque">
                    <label for="nombre_imagen_cu" class="caso_uso_imagen_etiqueta_nombre">INGRESAR NOMBRE IMAGEN:</label>
                    <input type="text" name="nombre_imagen_cu" id="nombre_imagen_cu" class="caso_uso_imagen_input_nombre" value="<?php echo htmlspecialchars($nombre_imagen_cu); ?>">
                </section>

                <footer class="caso_uso_imagen_documento_footer">
                    <div class="caso_uso_imagen_documento_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="caso_uso_imagen_documento_footer_logo_imagen">
                    </div>

                    <div class="caso_uso_imagen_documento_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago-Chile<br>
                        Email: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl<br>
                    </div>

                    <div class="caso_uso_imagen_documento_footer_numero">6</div>
                </footer>
            </article>
        </div>

        <aside class="portada_columna_preview_individual caso_uso_imagen_columna_preview">
            <div class="portada_preview_documento caso_uso_imagen_preview_documento">
                <div class="caso_uso_imagen_preview_logo_superior">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="caso_uso_imagen_preview_logo_imagen">
                </div>

                <div class="caso_uso_imagen_preview_titulo caso_uso_imagen_preview_nivel_<?php echo htmlspecialchars($nivel_titulo_cu_1); ?>" id="caso_uso_imagen_preview_titulo_1">
                    <span class="caso_uso_imagen_preview_titulo_numero" id="caso_uso_imagen_preview_numero_1"><?php echo htmlspecialchars($numero_titulo_cu_1); ?></span>
                    <span class="caso_uso_imagen_preview_titulo_texto" id="caso_uso_imagen_preview_texto_1"><?php echo htmlspecialchars($texto_titulo_cu_1); ?></span>
                </div>

                <div class="caso_uso_imagen_preview_titulo caso_uso_imagen_preview_nivel_<?php echo htmlspecialchars($nivel_titulo_cu_2); ?>" id="caso_uso_imagen_preview_titulo_2">
                    <span class="caso_uso_imagen_preview_titulo_numero" id="caso_uso_imagen_preview_numero_2"><?php echo htmlspecialchars($numero_titulo_cu_2); ?></span>
                    <span class="caso_uso_imagen_preview_titulo_texto" id="caso_uso_imagen_preview_texto_2"><?php echo htmlspecialchars($texto_titulo_cu_2); ?></span>
                </div>

                <div class="caso_uso_imagen_preview_marco">
                    <img id="caso_uso_imagen_preview_img" class="caso_uso_imagen_preview_img" alt="" src="<?php echo htmlspecialchars($ruta_imagen_cu); ?>" style="display:<?php echo trim((string)$ruta_imagen_cu) !== '' ? 'block' : 'none'; ?>;" onerror="this.style.display='none';var ph=document.getElementById('caso_uso_imagen_preview_placeholder');if(ph){ph.style.display='block';}">
                    <div id="caso_uso_imagen_preview_placeholder" class="caso_uso_imagen_preview_placeholder" style="display:<?php echo trim((string)$ruta_imagen_cu) !== '' ? 'none' : 'block'; ?>;"></div>
                </div>

                <p class="caso_uso_imagen_preview_nombre" id="caso_uso_imagen_preview_nombre"><?php echo htmlspecialchars($nombre_imagen_cu); ?></p>

                <footer class="caso_uso_imagen_preview_footer">
                    <div class="caso_uso_imagen_preview_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="caso_uso_imagen_preview_footer_logo_imagen">
                    </div>
                    <div class="caso_uso_imagen_preview_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago - Chile<br>
                        E-Mail: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl
                    </div>
                    <div class="caso_uso_imagen_preview_footer_numero">6</div>
                </footer>
            </div>
        </aside>

    </section>
</form>

