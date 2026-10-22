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



<form method="POST" id="documentacion_caso_uso_formulario_principal" class="portada_formulario_principal documentacion_caso_uso_formulario_principal">
    <input type="hidden" name="id_informe" value="<?php echo (int)$id_informe; ?>">

    <section id="seccion_documentacion_caso_uso" class="portada_fila_seccion documentacion_caso_uso_fila_seccion">

        
        <div class="documentacion_caso_uso_bloque_completo">

            <h2 class="documentacion_caso_uso_titulo_documento" id="<?php echo htmlspecialchars(construir_id_ancla_indice('documentacion_caso_uso', $numero_titulo_doc_1, $texto_titulo_doc_1)); ?>">CARPETA DOCUMENTACION<br>CARPETA CASO DE USO</h2>

            <article class="portada_documento documentacion_caso_uso_documento">
                <div class="documentacion_caso_uso_documento_encabezado">
                    <div class="documentacion_caso_uso_logo_superior">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="documentacion_caso_uso_logo_imagen">
                    </div>
                </div>

                <?php if($mensaje_documentacion_caso_uso !== ''){ ?>
                    <p class="portada_respuesta <?php echo htmlspecialchars($clase_mensaje_documentacion_caso_uso); ?>">
                        <?php echo htmlspecialchars($mensaje_documentacion_caso_uso); ?>
                    </p>
                <?php } ?>

                <section class="documentacion_caso_uso_bloque_jerarquia">
                    <div class="documentacion_caso_uso_jerarquia_item">
                        <div class="documentacion_caso_uso_campo documentacion_caso_uso_campo_tipo">
                            <label for="nivel_titulo_doc_1" class="documentacion_caso_uso_etiqueta">TIPO TITULO</label>
                            <select name="nivel_titulo_doc_1" id="nivel_titulo_doc_1" class="documentacion_caso_uso_select">
                                <?php for($i = 1; $i <= 20; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_doc_1 === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="documentacion_caso_uso_campo documentacion_caso_uso_campo_numero">
                            <label for="numero_titulo_doc_1" class="documentacion_caso_uso_etiqueta">N&deg; TITULO</label>
                            <input type="text" name="numero_titulo_doc_1" id="numero_titulo_doc_1" class="documentacion_caso_uso_input" value="<?php echo htmlspecialchars($numero_titulo_doc_1); ?>">
                        </div>

                        <div class="documentacion_caso_uso_campo documentacion_caso_uso_campo_titulo">
                            <label for="texto_titulo_doc_1" class="documentacion_caso_uso_etiqueta">INGRESAR TITULO</label>
                            <input type="text" name="texto_titulo_doc_1" id="texto_titulo_doc_1" class="documentacion_caso_uso_input" value="<?php echo htmlspecialchars($texto_titulo_doc_1); ?>">
                        </div>
                    </div>

                    <div class="documentacion_caso_uso_jerarquia_item">
                        <div class="documentacion_caso_uso_campo documentacion_caso_uso_campo_tipo">
                            <label for="nivel_titulo_doc_2" class="documentacion_caso_uso_etiqueta">TIPO TITULO</label>
                            <select name="nivel_titulo_doc_2" id="nivel_titulo_doc_2" class="documentacion_caso_uso_select">
                                <?php for($i = 1; $i <= 20; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_doc_2 === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="documentacion_caso_uso_campo documentacion_caso_uso_campo_numero">
                            <label for="numero_titulo_doc_2" class="documentacion_caso_uso_etiqueta">N&deg; TITULO</label>
                            <input type="text" name="numero_titulo_doc_2" id="numero_titulo_doc_2" class="documentacion_caso_uso_input" value="<?php echo htmlspecialchars($numero_titulo_doc_2); ?>">
                        </div>

                        <div class="documentacion_caso_uso_campo documentacion_caso_uso_campo_titulo">
                            <label for="texto_titulo_doc_2" class="documentacion_caso_uso_etiqueta">INGRESAR TITULO</label>
                            <input type="text" name="texto_titulo_doc_2" id="texto_titulo_doc_2" class="documentacion_caso_uso_input" value="<?php echo htmlspecialchars($texto_titulo_doc_2); ?>">
                        </div>
                    </div>

                    <div class="documentacion_caso_uso_jerarquia_item">
                        <div class="documentacion_caso_uso_campo documentacion_caso_uso_campo_tipo">
                            <label for="nivel_titulo_doc_3" class="documentacion_caso_uso_etiqueta">TIPO TITULO</label>
                            <select name="nivel_titulo_doc_3" id="nivel_titulo_doc_3" class="documentacion_caso_uso_select">
                                <?php for($i = 1; $i <= 20; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_doc_3 === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="documentacion_caso_uso_campo documentacion_caso_uso_campo_numero">
                            <label for="numero_titulo_doc_3" class="documentacion_caso_uso_etiqueta">N&deg; TITULO</label>
                            <input type="text" name="numero_titulo_doc_3" id="numero_titulo_doc_3" class="documentacion_caso_uso_input" value="<?php echo htmlspecialchars($numero_titulo_doc_3); ?>">
                        </div>

                        <div class="documentacion_caso_uso_campo documentacion_caso_uso_campo_titulo">
                            <label for="texto_titulo_doc_3" class="documentacion_caso_uso_etiqueta">INGRESAR TITULO</label>
                            <input type="text" name="texto_titulo_doc_3" id="texto_titulo_doc_3" class="documentacion_caso_uso_input" value="<?php echo htmlspecialchars($texto_titulo_doc_3); ?>">
                        </div>
                    </div>
                </section>

                <span id="<?php echo htmlspecialchars(construir_id_ancla_indice('documentacion_caso_uso', $numero_titulo_doc_2, $texto_titulo_doc_2)); ?>"></span>
                <p class="documentacion_caso_uso_subtitulo" id="documentacion_caso_uso_subtitulo"><?php echo htmlspecialchars($texto_titulo_doc_3); ?></p>
                <span id="<?php echo htmlspecialchars(construir_id_ancla_indice('documentacion_caso_uso', $numero_titulo_doc_3, $texto_titulo_doc_3)); ?>"></span>

                <section class="documentacion_caso_uso_bloque_texto">
                    <label for="texto_contenido_doc" class="documentacion_caso_uso_etiqueta_area">INGRESAR TEXTO CASO DE USO</label>
                    <textarea name="texto_contenido_doc" id="texto_contenido_doc" class="documentacion_caso_uso_textarea"><?php echo htmlspecialchars($texto_contenido_doc); ?></textarea>
                </section>

                <div class="portada_bloque_botones_inferiores documentacion_caso_uso_bloque_botones">
                    <button type="submit" name="guardar_documentacion_caso_uso_base" value="1" class="portada_boton_guardar_inferior">
                        GUARDAR
                    </button>

                    <button type="button" class="portada_boton_modificar_inferior" id="documentacion_caso_uso_boton_modificar">
                        MODIFICAR
                    </button>
                </div>

                <footer class="documentacion_caso_uso_documento_footer">
                    <div class="documentacion_caso_uso_documento_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="documentacion_caso_uso_documento_footer_logo_imagen">
                    </div>

                    <div class="documentacion_caso_uso_documento_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago-Chile<br>
                        Email: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl<br>
                    </div>

                    <div class="documentacion_caso_uso_documento_footer_numero">5</div>
                </footer>

            </article>

        </div>

        
        <aside class="portada_columna_preview_individual documentacion_caso_uso_columna_preview">
            <div class="portada_preview_documento documentacion_caso_uso_preview_documento">
                <div class="documentacion_caso_uso_preview_logo_superior">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="documentacion_caso_uso_preview_logo_imagen">
                </div>

                <div class="documentacion_caso_uso_preview_titulo documentacion_caso_uso_preview_nivel_1" id="documentacion_caso_uso_preview_titulo_1">
                    <span class="documentacion_caso_uso_preview_titulo_numero" id="documentacion_caso_uso_preview_numero_1"><?php echo htmlspecialchars($numero_titulo_doc_1); ?></span>
                    <span class="documentacion_caso_uso_preview_titulo_texto" id="documentacion_caso_uso_preview_texto_1"><?php echo htmlspecialchars($texto_titulo_doc_1); ?></span>
                </div>

                <div class="documentacion_caso_uso_preview_titulo documentacion_caso_uso_preview_nivel_2" id="documentacion_caso_uso_preview_titulo_2">
                    <span class="documentacion_caso_uso_preview_titulo_numero" id="documentacion_caso_uso_preview_numero_2"><?php echo htmlspecialchars($numero_titulo_doc_2); ?></span>
                    <span class="documentacion_caso_uso_preview_titulo_texto" id="documentacion_caso_uso_preview_texto_2"><?php echo htmlspecialchars($texto_titulo_doc_2); ?></span>
                </div>

                <div class="documentacion_caso_uso_preview_titulo documentacion_caso_uso_preview_nivel_3" id="documentacion_caso_uso_preview_titulo_3">
                    <span class="documentacion_caso_uso_preview_titulo_numero" id="documentacion_caso_uso_preview_numero_3"><?php echo htmlspecialchars($numero_titulo_doc_3); ?></span>
                    <span class="documentacion_caso_uso_preview_titulo_texto" id="documentacion_caso_uso_preview_texto_3"><?php echo htmlspecialchars($texto_titulo_doc_3); ?></span>
                </div>

                <div class="documentacion_caso_uso_preview_contenido" id="documentacion_caso_uso_preview_contenido"><?php echo nl2br(htmlspecialchars($texto_contenido_doc)); ?></div>

                <footer class="documentacion_caso_uso_preview_footer">
                    <div class="documentacion_caso_uso_preview_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="documentacion_caso_uso_preview_footer_logo_imagen">
                    </div>
                    <div class="documentacion_caso_uso_preview_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago - Chile<br>
                        E-Mail: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl
                    </div>
                    <div class="documentacion_caso_uso_preview_footer_numero">5</div>
                </footer>
            </div>
        </aside>

    </section>
</form>

