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



<section id="seccion_indice" class="portada_fila_seccion portada_fila_seccion_indice">

    <div class="portada_bloque_indice_completo">

        <h2 class="portada_titulo_indice_documento">INDICE</h2>

        <article class="portada_documento_indice">

            <div class="portada_documento_indice_logo">
                <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="portada_documento_indice_logo_imagen">
            </div>

            <h3 class="portada_documento_indice_titulo">INDICE</h3>

            <div class="portada_documento_indice_listado">
                <?php foreach($filas_indice as $fila_indice_documento){ ?>
                    <?php
                        $titulo_documento = isset($fila_indice_documento['titulo']) ? trim($fila_indice_documento['titulo']) : '';
                        $pagina_documento = isset($fila_indice_documento['pagina']) ? trim($fila_indice_documento['pagina']) : '';
                        $nivel_documento = isset($fila_indice_documento['nivel']) ? trim($fila_indice_documento['nivel']) : '0';
                    ?>

                    <?php if($titulo_documento !== ''){ ?>
                        <div class="portada_documento_indice_fila portada_documento_indice_nivel_<?php echo htmlspecialchars($nivel_documento); ?>">
                            <span class="portada_documento_indice_texto"><?php echo htmlspecialchars($titulo_documento); ?></span>
                            <span class="portada_documento_indice_puntos"></span>
                            <span class="portada_documento_indice_pagina"><?php echo htmlspecialchars($pagina_documento); ?></span>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="portada_documento_indice_footer">
                <div class="portada_documento_indice_footer_logo">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="portada_documento_indice_footer_logo_imagen">
                </div>

                <div class="portada_documento_indice_footer_texto">
                    Tecnolog&iacute;a y Construcci&oacute;n<br>
                    Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                    Santiago-Chile<br>
                    Email: contacto@itred.cl / itred.spa@gmail.com<br>
                    Sitio Web: https://www.itred.cl<br>
                </div>

                <div class="portada_documento_indice_footer_numero">2</div>
            </div>

        </article>

    </div>

    
    
    <aside class="portada_columna_preview_individual portada_columna_preview_indice">

        <div class="portada_preview_documento portada_preview_documento_indice">

            <div class="portada_preview_logo_derecha_indice">
                <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="portada_preview_logo_imagen">
            </div>

            <h3 class="portada_preview_indice_titulo">INDICE</h3>

            <div class="portada_preview_indice_listado">
                <?php foreach($filas_indice as $fila_indice_preview){ ?>
                    <?php
                        $titulo_preview = isset($fila_indice_preview['titulo']) ? trim($fila_indice_preview['titulo']) : '';
                        $pagina_preview = isset($fila_indice_preview['pagina']) ? trim($fila_indice_preview['pagina']) : '';
                        $nivel_preview = isset($fila_indice_preview['nivel']) ? trim($fila_indice_preview['nivel']) : '0';
                    ?>

                    <?php if($titulo_preview !== ''){ ?>
                        <div class="portada_preview_indice_fila portada_preview_indice_nivel_<?php echo htmlspecialchars($nivel_preview); ?>">
                            <span class="portada_preview_indice_texto"><?php echo htmlspecialchars($titulo_preview); ?></span>
                            <span class="portada_preview_indice_puntos"></span>
                            <span class="portada_preview_indice_pagina"><?php echo htmlspecialchars($pagina_preview); ?></span>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="portada_preview_indice_footer">
                <div class="portada_preview_indice_footer_logo">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="portada_preview_indice_footer_logo_imagen">
                </div>

                <div class="portada_preview_indice_footer_texto">
                    Tecnolog&iacute;a y Construcci&oacute;n<br>
                    Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                    Santiago - Chile<br>
                    E-Mail: contacto@itred.cl / itred.spa@gmail.com<br>
                    Sitio Web: https://www.itred.cl
                </div>

                <div class="portada_preview_indice_footer_numero">2</div>
            </div>

        </div>

    </aside>

</section>

