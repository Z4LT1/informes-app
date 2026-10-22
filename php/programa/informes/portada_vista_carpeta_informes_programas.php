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

<section id="seccion_carpeta_informes_programas" class="portada_fila_seccion seccion_ruta_fila_seccion">

    <div class="seccion_ruta_bloque_completo">

        <h2 class="seccion_ruta_titulo_documento" id="<?php echo htmlspecialchars(construir_id_ancla_indice('carpeta_informes_programas', $numero_titulo_cip_1, $texto_titulo_cip_1)); ?>">CARPETA DOCUMENTACION<br>CARPETA INFORMES<br>CARPETA INFORMES PROGRAMAS</h2>

        <?php if(!empty($carpeta_informes_programas_exportacion)): ?>
            <?php
                $anclas_cip_vistas = array();
                foreach($carpeta_informes_programas_exportacion as $item_cip_ancla){
                    $numero_cip_1_ancla = isset($item_cip_ancla['numero_titulo_1']) ? trim((string)$item_cip_ancla['numero_titulo_1']) : '';
                    $texto_cip_1_ancla = isset($item_cip_ancla['texto_titulo_1']) ? trim((string)$item_cip_ancla['texto_titulo_1']) : '';
                    $numero_cip_2_ancla = isset($item_cip_ancla['numero_titulo_2']) ? trim((string)$item_cip_ancla['numero_titulo_2']) : '';
                    $texto_cip_2_ancla = isset($item_cip_ancla['texto_titulo_2']) ? trim((string)$item_cip_ancla['texto_titulo_2']) : '';

                    if($texto_cip_1_ancla !== ''){
                        $id_ancla_cip_1 = construir_id_ancla_indice('carpeta_informes_programas', $numero_cip_1_ancla, $texto_cip_1_ancla);
                        if(!isset($anclas_cip_vistas[$id_ancla_cip_1])){
                            $anclas_cip_vistas[$id_ancla_cip_1] = true;
                            echo '<span id="' . htmlspecialchars($id_ancla_cip_1) . '"></span>';
                        }
                    }

                    if($texto_cip_2_ancla !== ''){
                        $id_ancla_cip_2 = construir_id_ancla_indice('carpeta_informes_programas', $numero_cip_2_ancla, $texto_cip_2_ancla);
                        if(!isset($anclas_cip_vistas[$id_ancla_cip_2])){
                            $anclas_cip_vistas[$id_ancla_cip_2] = true;
                            echo '<span id="' . htmlspecialchars($id_ancla_cip_2) . '"></span>';
                        }
                    }
                }
            ?>
        <?php else: ?>
            <span id="<?php echo htmlspecialchars(construir_id_ancla_indice('carpeta_informes_programas', $numero_titulo_cip_2, $texto_titulo_cip_2)); ?>"></span>
        <?php endif; ?>

        <article class="portada_documento seccion_ruta_documento">
            <form action="portada.php?id_informe=<?php echo (int)$id_informe; ?>#seccion_carpeta_informes_programas" method="POST" class="seccion_ruta_formulario" id="carpeta_informes_programas_formulario">
                <input type="hidden" name="id_informe" value="<?php echo (int)$id_informe; ?>">
                <input type="hidden" name="guardar_carpeta_informes_programas_base" value="1">
                <input type="hidden" name="carpeta_informes_programas_primer_titulo_bloqueado" value="<?php echo $carpeta_informes_programas_primer_titulo_bloqueado ? '1' : '0'; ?>" id="carpeta_informes_programas_primer_titulo_bloqueado">

                <?php if($mensaje_carpeta_informes_programas !== ''): ?>
                    <div class="portada_respuesta <?php echo htmlspecialchars($clase_mensaje_carpeta_informes_programas); ?>">
                        <?php echo htmlspecialchars($mensaje_carpeta_informes_programas); ?>
                    </div>
                <?php endif; ?>

            <div class="seccion_ruta_documento_encabezado">
                <div class="seccion_ruta_logo_superior">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="seccion_ruta_logo_imagen">
                </div>
            </div>

            <section class="seccion_ruta_bloque_jerarquia">
                <div class="seccion_ruta_jerarquia_item">
                    <div class="seccion_ruta_campo seccion_ruta_campo_tipo">
                        <label class="seccion_ruta_etiqueta">TIPO TITULO</label>
                        <?php if($carpeta_informes_programas_primer_titulo_bloqueado): ?>
                            <input type="hidden" name="nivel_titulo_cip_1_fijo" value="<?php echo htmlspecialchars($nivel_titulo_cip_1); ?>">
                            <input type="text" class="seccion_ruta_input" value="<?php echo htmlspecialchars($nivel_titulo_cip_1); ?>" readonly>
                        <?php else: ?>
                            <input type="text" class="seccion_ruta_input" name="nivel_titulo_cip_1" value="<?php echo htmlspecialchars($nivel_titulo_cip_1); ?>" id="nivel_titulo_cip_1">
                        <?php endif; ?>
                    </div>

                    <div class="seccion_ruta_campo seccion_ruta_campo_numero">
                        <label class="seccion_ruta_etiqueta">N&deg; TITULO</label>
                        <?php if($carpeta_informes_programas_primer_titulo_bloqueado): ?>
                            <input type="hidden" name="numero_titulo_cip_1_fijo" value="<?php echo htmlspecialchars($numero_titulo_cip_1); ?>">
                            <input type="text" class="seccion_ruta_input" value="<?php echo htmlspecialchars($numero_titulo_cip_1); ?>" readonly>
                        <?php else: ?>
                            <input type="text" class="seccion_ruta_input" name="numero_titulo_cip_1" value="<?php echo htmlspecialchars($numero_titulo_cip_1); ?>" id="numero_titulo_cip_1">
                        <?php endif; ?>
                    </div>

                    <div class="seccion_ruta_campo seccion_ruta_campo_titulo">
                        <label class="seccion_ruta_etiqueta">INGRESAR TITULO</label>
                        <?php if($carpeta_informes_programas_primer_titulo_bloqueado): ?>
                            <input type="hidden" name="texto_titulo_cip_1_fijo" value="<?php echo htmlspecialchars($texto_titulo_cip_1); ?>">
                            <input type="text" class="seccion_ruta_input" value="<?php echo htmlspecialchars($texto_titulo_cip_1); ?>" readonly>
                        <?php else: ?>
                            <input type="text" class="seccion_ruta_input" name="texto_titulo_cip_1" value="<?php echo htmlspecialchars($texto_titulo_cip_1); ?>" id="texto_titulo_cip_1">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="seccion_ruta_jerarquia_item">
                    <div class="seccion_ruta_campo seccion_ruta_campo_tipo">
                        <label class="seccion_ruta_etiqueta">TIPO TITULO</label>
                        <input type="text" class="seccion_ruta_input" name="nivel_titulo_cip_2" value="<?php echo htmlspecialchars($nivel_titulo_cip_2); ?>" id="nivel_titulo_cip_2">
                    </div>

                    <div class="seccion_ruta_campo seccion_ruta_campo_numero">
                        <label class="seccion_ruta_etiqueta">N&deg; TITULO</label>
                        <input type="text" class="seccion_ruta_input" name="numero_titulo_cip_2" value="<?php echo htmlspecialchars($numero_titulo_cip_2); ?>" id="numero_titulo_cip_2">
                    </div>

                    <div class="seccion_ruta_campo seccion_ruta_campo_titulo">
                        <label class="seccion_ruta_etiqueta">INGRESAR TITULO</label>
                        <input type="text" class="seccion_ruta_input" name="texto_titulo_cip_2" value="<?php echo htmlspecialchars($texto_titulo_cip_2); ?>" id="texto_titulo_cip_2">
                    </div>
                </div>
            </section>

            <section class="seccion_ruta_bloque_campo_principal">
                <label class="seccion_ruta_etiqueta">INGRESAR RUTA</label>
                <input type="text" class="seccion_ruta_input" name="ruta_principal_cip" value="<?php echo htmlspecialchars($ruta_principal_cip); ?>" id="ruta_principal_cip" placeholder="Ejemplo: documentacion/informes/informe_programa/index.php">
            </section>

            <p class="seccion_ruta_texto_apoyo">Ruta informe programa (agregar la ruta donde se guarda el informe)</p>

            <label class="seccion_ruta_checkbox_linea">
                <input type="checkbox" name="sin_manual_momento_cip" value="1" <?php echo $sin_manual_momento_cip ? 'checked' : ''; ?> id="sin_manual_momento_cip">
                Agregar mensaje "SIN MANUAL POR EL MOMENTO"
            </label>

            <div class="seccion_ruta_botonera_principal">
                <button type="submit" class="seccion_ruta_boton">Guardar</button>
                <button type="button" class="seccion_ruta_boton secundario" id="boton_modificar_titulo_cip_1">Modificar</button>
            </div>

            <section class="seccion_ruta_fila_bloques">
                <article class="seccion_ruta_bloque_simple">
                    <div>
                        <label class="seccion_ruta_etiqueta">INGRESAR CARPETAS</label>
                        <input type="text" class="seccion_ruta_input" name="carpeta_cip" value="<?php echo htmlspecialchars($carpeta_cip); ?>" id="carpeta_cip">
                    </div>
                    <div class="seccion_ruta_botones_stack">
                        <button type="submit" class="seccion_ruta_boton">Guardar</button>
                        <button type="button" class="seccion_ruta_boton secundario">Modificar</button>
                    </div>
                </article>

                <article class="seccion_ruta_bloque_simple">
                    <div>
                        <label class="seccion_ruta_etiqueta">INGRESAR ARCHIVOS</label>
                        <input type="text" class="seccion_ruta_input" name="archivo_cip" value="<?php echo htmlspecialchars($archivo_cip); ?>" id="archivo_cip">
                    </div>
                    <div class="seccion_ruta_botones_stack">
                        <button type="submit" class="seccion_ruta_boton">Guardar</button>
                        <button type="button" class="seccion_ruta_boton secundario">Modificar</button>
                    </div>
                </article>

                <article class="seccion_ruta_bloque_simple">
                    <div>
                        <label class="seccion_ruta_etiqueta">INGRESAR EXTENSION</label>
                        <input type="text" class="seccion_ruta_input" name="extension_cip" value="<?php echo htmlspecialchars($extension_cip); ?>" id="extension_cip" placeholder="php, css, js, html, sql, mp4...">
                    </div>
                    <div class="seccion_ruta_botones_stack">
                        <button type="submit" class="seccion_ruta_boton">Guardar</button>
                        <button type="button" class="seccion_ruta_boton secundario">Modificar</button>
                    </div>
                </article>
            </section>

            <section class="seccion_ruta_fila_ruta_extra">
                <label class="seccion_ruta_checkbox_linea">
                    <input type="checkbox" id="activar_rutas_extra_cip">
                    AGREGAR RUTA
                </label>

                <div class="seccion_ruta_campos_ruta_extra">
                    <input type="text" class="seccion_ruta_input" name="ruta_extra_1_cip" value="<?php echo htmlspecialchars($ruta_extra_1_cip); ?>" id="ruta_extra_1_cip" readonly>
                    <input type="text" class="seccion_ruta_input" name="ruta_extra_2_cip" value="<?php echo htmlspecialchars($ruta_extra_2_cip); ?>" id="ruta_extra_2_cip" readonly>
                    <input type="text" class="seccion_ruta_input" name="ruta_extra_3_cip" value="<?php echo htmlspecialchars($ruta_extra_3_cip); ?>" id="ruta_extra_3_cip" readonly>
                    <input type="text" class="seccion_ruta_input" name="ruta_extra_4_cip" value="<?php echo htmlspecialchars($ruta_extra_4_cip); ?>" id="ruta_extra_4_cip" readonly>
                </div>

                <button type="button" class="seccion_ruta_boton_add" id="boton_habilitar_rutas_extra_cip">+</button>
            </section>

            <div class="seccion_ruta_botones_footer">
                <button type="submit" class="seccion_ruta_boton">Guardar</button>
                <button type="button" class="seccion_ruta_boton secundario" id="boton_modificar_footer_cip">Modificar</button>
            </div>

            <footer class="seccion_ruta_documento_footer">
                <div class="seccion_ruta_documento_footer_logo">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="seccion_ruta_documento_footer_logo_imagen">
                </div>

                <div class="seccion_ruta_documento_footer_texto">
                    Tecnolog&iacute;a y Construcci&oacute;n<br>
                    Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                    Santiago-Chile<br>
                    Email: contacto@itred.cl / itred.spa@gmail.com<br>
                    Sitio Web: https://www.itred.cl<br>
                </div>

                <div class="seccion_ruta_documento_footer_numero">8</div>
            </footer>
            </form>
        </article>
    </div>

    <aside class="portada_columna_preview_individual seccion_ruta_columna_preview">
        <div class="portada_preview_documento seccion_ruta_preview_documento">
            <div class="seccion_ruta_preview_logo_superior">
                <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="seccion_ruta_preview_logo_imagen">
            </div>

            <div class="seccion_ruta_preview_titulo seccion_ruta_preview_nivel_2">
                <span class="seccion_ruta_preview_titulo_numero" id="preview_numero_titulo_cip_1"><?php echo htmlspecialchars($numero_titulo_cip_1); ?></span>
                <span class="seccion_ruta_preview_titulo_texto" id="preview_texto_titulo_cip_1"><?php echo htmlspecialchars($texto_titulo_cip_1); ?></span>
            </div>

            <div class="seccion_ruta_preview_titulo seccion_ruta_preview_nivel_3">
                <span class="seccion_ruta_preview_titulo_numero" id="preview_numero_titulo_cip_2"><?php echo htmlspecialchars($numero_titulo_cip_2); ?></span>
                <span class="seccion_ruta_preview_titulo_texto" id="preview_texto_titulo_cip_2"><?php echo htmlspecialchars($texto_titulo_cip_2); ?></span>
            </div>

            <div class="seccion_ruta_preview_contenido" id="preview_contenido_cip">
                <?php if(!empty($carpeta_informes_programas_exportacion)): ?>
                    <ol>
                        <?php foreach($carpeta_informes_programas_exportacion as $registro_cip): ?>
                            <?php
                                $ruta_registro_cip = isset($registro_cip['ruta_principal']) ? trim((string)$registro_cip['ruta_principal']) : '';
                                $carpeta_registro_cip = isset($registro_cip['carpeta']) ? trim((string)$registro_cip['carpeta']) : '';
                                $archivo_registro_cip = isset($registro_cip['archivo']) ? trim((string)$registro_cip['archivo']) : '';
                                $extension_registro_cip = isset($registro_cip['extension']) ? trim((string)$registro_cip['extension']) : '';
                                $ruta_extra_1_registro_cip = isset($registro_cip['ruta_extra_1']) ? trim((string)$registro_cip['ruta_extra_1']) : '';
                                $ruta_extra_2_registro_cip = isset($registro_cip['ruta_extra_2']) ? trim((string)$registro_cip['ruta_extra_2']) : '';
                                $ruta_extra_3_registro_cip = isset($registro_cip['ruta_extra_3']) ? trim((string)$registro_cip['ruta_extra_3']) : '';
                                $ruta_extra_4_registro_cip = isset($registro_cip['ruta_extra_4']) ? trim((string)$registro_cip['ruta_extra_4']) : '';
                                $sin_manual_registro_cip = isset($registro_cip['sin_manual_momento']) && (int)$registro_cip['sin_manual_momento'] === 1;

                                $archivo_compuesto_cip = '';
                                if($carpeta_registro_cip !== '' && $archivo_registro_cip !== ''){
                                    $archivo_compuesto_cip = rtrim($carpeta_registro_cip, '/\\') . '/' . ltrim($archivo_registro_cip, '/\\');
                                }elseif($carpeta_registro_cip !== ''){
                                    $archivo_compuesto_cip = $carpeta_registro_cip;
                                }elseif($archivo_registro_cip !== ''){
                                    $archivo_compuesto_cip = $archivo_registro_cip;
                                }

                                if($extension_registro_cip !== ''){
                                    $archivo_compuesto_cip .= '.' . ltrim($extension_registro_cip, '.');
                                }
                            ?>
                            <li>
                                <?php if($ruta_registro_cip !== ''): ?><p>- ruta: <?php echo htmlspecialchars($ruta_registro_cip); ?></p><?php endif; ?>
                                <?php if($archivo_compuesto_cip !== ''): ?><p>- archivo: <?php echo htmlspecialchars($archivo_compuesto_cip); ?></p><?php endif; ?>
                                <?php if($ruta_extra_1_registro_cip !== ''): ?><p>- ruta extra: <?php echo htmlspecialchars($ruta_extra_1_registro_cip); ?></p><?php endif; ?>
                                <?php if($ruta_extra_2_registro_cip !== ''): ?><p>- ruta extra: <?php echo htmlspecialchars($ruta_extra_2_registro_cip); ?></p><?php endif; ?>
                                <?php if($ruta_extra_3_registro_cip !== ''): ?><p>- ruta extra: <?php echo htmlspecialchars($ruta_extra_3_registro_cip); ?></p><?php endif; ?>
                                <?php if($ruta_extra_4_registro_cip !== ''): ?><p>- ruta extra: <?php echo htmlspecialchars($ruta_extra_4_registro_cip); ?></p><?php endif; ?>
                                <?php if($sin_manual_registro_cip): ?><p>- SIN MANUAL POR EL MOMENTO</p><?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php elseif($sin_manual_momento_cip): ?>
                    <p>- SIN MANUAL POR EL MOMENTO</p>
                    <?php else: ?>
                    <?php endif; ?>
            </div>

            <footer class="seccion_ruta_preview_footer">
                <div class="seccion_ruta_preview_footer_logo">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="seccion_ruta_preview_footer_logo_imagen">
                </div>
                <div class="seccion_ruta_preview_footer_texto">
                    Tecnolog&iacute;a y Construcci&oacute;n<br>
                    Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                    Santiago - Chile<br>
                    E-Mail: contacto@itred.cl / itred.spa@gmail.com<br>
                    Sitio Web: https://www.itred.cl
                </div>
                <div class="seccion_ruta_preview_footer_numero">8</div>
            </footer>
        </div>
    </aside>

</section>
