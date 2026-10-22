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



<form method="POST" id="base_datos_formulario_principal" class="portada_formulario_principal base_datos_formulario_principal">
    <input type="hidden" name="id_informe" value="<?php echo (int)$id_informe; ?>">

    <section id="seccion_base_datos" class="portada_fila_seccion base_datos_fila_seccion">

        
        
        <div class="base_datos_bloque_completo">

            <h2 class="base_datos_titulo_documento" id="<?php echo htmlspecialchars(construir_id_ancla_indice('base_datos', $numero_titulo_bd, $texto_titulo_bd)); ?>">CARPETA BASE DE DATOS</h2>

            <article class="portada_documento base_datos_documento">
                <div class="base_datos_documento_encabezado">
                    <div class="base_datos_logo_superior">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="base_datos_logo_imagen">
                    </div>
                </div>

                <?php if($mensaje_base_datos !== ''){ ?>
                    <p class="portada_respuesta <?php echo htmlspecialchars($clase_mensaje_base_datos); ?>">
                        <?php echo htmlspecialchars($mensaje_base_datos); ?>
                    </p>
                <?php } ?>

                
                <section class="base_datos_bloque_jerarquia">
                    <div class="base_datos_campo base_datos_campo_tipo">
                        <label for="nivel_titulo_bd" class="base_datos_etiqueta">TIPO TITULO</label>
                        <select name="nivel_titulo_bd" id="nivel_titulo_bd" class="base_datos_select">
                            <?php for($i = 1; $i <= 20; $i++){ ?>
                                <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_bd === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="base_datos_campo base_datos_campo_numero">
                        <label for="numero_titulo_bd" class="base_datos_etiqueta">N&deg; TITULO</label>
                        <input type="text" name="numero_titulo_bd" id="numero_titulo_bd" class="base_datos_input" value="<?php echo htmlspecialchars($numero_titulo_bd); ?>">
                    </div>

                    <div class="base_datos_campo base_datos_campo_titulo">
                        <label for="texto_titulo_bd" class="base_datos_etiqueta">INGRESAR NOMBRE BASE DE DATOS</label>
                        <input type="text" name="texto_titulo_bd" id="texto_titulo_bd" class="base_datos_input" value="<?php echo htmlspecialchars($texto_titulo_bd); ?>">
                    </div>
                </section>

                
                <section class="base_datos_bloque_texto">
                    <label for="texto_contenido_bd" class="base_datos_etiqueta_area">INGRESAR TEXTO BASE DE DATOS COMPLETA ACTUALIZADA</label>
                    <textarea name="texto_contenido_bd" id="texto_contenido_bd" class="base_datos_textarea"><?php echo htmlspecialchars($texto_contenido_bd); ?></textarea>
                </section>

                <div class="portada_bloque_botones_inferiores base_datos_bloque_botones">
                    <button type="submit" name="guardar_base_datos_base" value="1" class="portada_boton_guardar_inferior">
                        GUARDAR
                    </button>

                    <button type="button" class="portada_boton_modificar_inferior" id="base_datos_boton_modificar">
                        MODIFICAR
                    </button>
                </div>

                <footer class="base_datos_documento_footer">
                    <div class="base_datos_documento_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="base_datos_documento_footer_logo_imagen">
                    </div>

                    <div class="base_datos_documento_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago-Chile<br>
                        Email: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl<br>
                    </div>

                    <div class="base_datos_documento_footer_numero">4</div>
                </footer>

            </article>

        </div>

        
        <aside class="portada_columna_preview_individual base_datos_columna_preview">
            <div class="portada_preview_documento base_datos_preview_documento">
                <div class="base_datos_preview_logo_superior">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="base_datos_preview_logo_imagen">
                </div>

                <div class="base_datos_preview_titulo base_datos_preview_nivel_<?php echo htmlspecialchars($nivel_titulo_bd); ?>" id="base_datos_preview_titulo_bloque">
                    <span class="base_datos_preview_titulo_numero" id="base_datos_preview_numero"><?php echo htmlspecialchars($numero_titulo_bd); ?></span>
                    <span class="base_datos_preview_titulo_texto" id="base_datos_preview_titulo"><?php echo htmlspecialchars($texto_titulo_bd); ?></span>
                </div>

                <div class="base_datos_preview_contenido" id="base_datos_preview_contenido"><?php echo nl2br(htmlspecialchars($texto_contenido_bd)); ?></div>

                <footer class="base_datos_preview_footer">
                    <div class="base_datos_preview_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="base_datos_preview_footer_logo_imagen">
                    </div>
                    <div class="base_datos_preview_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago - Chile<br>
                        E-Mail: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl
                    </div>
                    <div class="base_datos_preview_footer_numero">4</div>
                </footer>
            </div>
        </aside>

    </section>
</form>

