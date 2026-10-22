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



<form method="POST" id="introduccion_formulario_principal" class="portada_formulario_principal introduccion_formulario_principal">
    <input type="hidden" name="id_informe" value="<?php echo (int)$id_informe; ?>">

    <section id="seccion_introduccion" class="portada_fila_seccion introduccion_fila_seccion">

        
        
        <div class="introduccion_bloque_completo">

            <h2 class="introduccion_titulo_documento" id="<?php echo htmlspecialchars(construir_id_ancla_indice('introduccion', $numero_titulo, $texto_titulo)); ?>">INTRODUCCION</h2>

            <article class="portada_documento introduccion_documento">
            <div class="introduccion_documento_encabezado">
                <div class="introduccion_logo_superior">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="introduccion_logo_imagen">
                </div>
            </div>

            <?php if($mensaje_introduccion !== ''){ ?>
                <p class="portada_respuesta <?php echo htmlspecialchars($clase_mensaje_introduccion); ?>">
                    <?php echo htmlspecialchars($mensaje_introduccion); ?>
                </p>
            <?php } ?>

            
            
            <section class="introduccion_bloque_jerarquia">
                <div class="introduccion_campo introduccion_campo_tipo">
                    <label for="nivel_titulo" class="introduccion_etiqueta">TIPO TITULO</label>
                    <select name="nivel_titulo" id="nivel_titulo" class="introduccion_select">
                        <?php for($i = 1; $i <= 20; $i++){ ?>
                            <option value="<?php echo $i; ?>" <?php echo $nivel_titulo === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="introduccion_campo introduccion_campo_numero">
                    <label for="numero_titulo" class="introduccion_etiqueta">N&deg; TITULO</label>
                    <input type="text" name="numero_titulo" id="numero_titulo" class="introduccion_input" value="<?php echo htmlspecialchars($numero_titulo); ?>">
                </div>

                <div class="introduccion_campo introduccion_campo_titulo">
                    <label for="texto_titulo" class="introduccion_etiqueta">INGRESAR TITULO</label>
                    <input type="text" name="texto_titulo" id="texto_titulo" class="introduccion_input" value="<?php echo htmlspecialchars($texto_titulo); ?>">
                </div>
            </section>

            
            
            <section class="introduccion_bloque_texto">
                <label for="texto_contenido" class="introduccion_etiqueta_area">INGRESAR INTRODUCCION</label>

                <textarea name="texto_contenido" id="texto_contenido" class="introduccion_textarea"><?php echo htmlspecialchars($texto_contenido); ?></textarea>
            </section>

            

            

            <div class="portada_bloque_botones_inferiores introduccion_bloque_botones">
                <button type="submit" name="guardar_introduccion_base" value="1" class="portada_boton_guardar_inferior">
                    GUARDAR
                </button>

                <button type="button" class="portada_boton_modificar_inferior" id="introduccion_boton_modificar">
                    MODIFICAR
                </button>
            </div>

            <footer class="introduccion_documento_footer">
                <div class="introduccion_documento_footer_logo">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="introduccion_documento_footer_logo_imagen">
                </div>

                <div class="introduccion_documento_footer_texto">
                    Tecnolog&iacute;a y Construcci&oacute;n<br>
                    Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                    Santiago-Chile<br>
                    Email: contacto@itred.cl / itred.spa@gmail.com<br>
                    Sitio Web: https://www.itred.cl<br>
                </div>

                <div class="introduccion_documento_footer_numero">3</div>
            </footer>

            </article>

        </div>

        
        
        <aside class="portada_columna_preview_individual introduccion_columna_preview">
            <div class="portada_preview_documento introduccion_preview_documento">
                <div class="introduccion_preview_logo_superior">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="introduccion_preview_logo_imagen">
                </div>

                <div class="introduccion_preview_titulo introduccion_preview_nivel_<?php echo htmlspecialchars($nivel_titulo); ?>" id="introduccion_preview_titulo_bloque">
                    <span class="introduccion_preview_titulo_numero" id="introduccion_preview_numero"><?php echo htmlspecialchars($numero_titulo); ?></span>
                    <span class="introduccion_preview_titulo_texto" id="introduccion_preview_titulo"><?php echo htmlspecialchars($texto_titulo); ?></span>
                </div>

                <div class="introduccion_preview_contenido" id="introduccion_preview_contenido"><?php echo nl2br(htmlspecialchars($texto_contenido)); ?></div>

                <footer class="introduccion_preview_footer">
                    <div class="introduccion_preview_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="introduccion_preview_footer_logo_imagen">
                    </div>
                    <div class="introduccion_preview_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago - Chile<br>
                        E-Mail: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl
                    </div>
                    <div class="introduccion_preview_footer_numero">3</div>
                </footer>
            </div>
        </aside>

    </section>
</form>

