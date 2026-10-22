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



<form method="POST" id="portada_formulario_principal" class="portada_formulario_principal">
    <input type="hidden" name="id_informe" value="<?php echo (int)$id_informe; ?>">

    
    
    <section class="portada_fila_seccion">

        <article class="portada_documento">

            <div class="portada_documento_encabezado">
                <div class="portada_logo_superior">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="portada_logo_imagen">
                </div>
            </div>

            <?php if($mensaje_portada !== ''){ ?>
                <p class="portada_respuesta <?php echo htmlspecialchars($clase_mensaje_portada); ?>">
                    <?php echo htmlspecialchars($mensaje_portada); ?>
                </p>
            <?php } ?>

            <div class="portada_bloque_superior_nombre">
                <span class="portada_etiqueta_titulo">INFORME "</span>

                <?php if($modo_edicion){ ?>
                    <input
                        type="text"
                        name="nombre_informe"
                        id="nombre_informe"
                        class="portada_input_nombre"
                        value="<?php echo htmlspecialchars($nombre_informe); ?>"
                        placeholder="Nombre del informe"
                        required
                    >
                <?php }else{ ?>
                    <span class="portada_texto_nombre_visual"><?php echo htmlspecialchars($texto_nombre_informe); ?></span>
                <?php } ?>

                <span class="portada_comilla_final">"</span>
            </div>

            <div class="portada_bloque_contenido">

                <div class="portada_bloque_izquierdo"></div>

                <div class="portada_bloque_derecho">

                    <div class="portada_bloque_campo">
                        <label for="area_trabajo" class="portada_etiqueta">Area de Trabajo:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="text" name="area_trabajo" id="area_trabajo" class="portada_input" value="<?php echo htmlspecialchars($area_trabajo); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($area_trabajo); ?></span>
                        <?php } ?>
                    </div>

                    <div class="portada_bloque_campo">
                        <label for="nombre_1" class="portada_etiqueta">Nombre1:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="text" name="nombre_1" id="nombre_1" class="portada_input" value="<?php echo htmlspecialchars($nombre_1); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($nombre_1); ?></span>
                        <?php } ?>
                    </div>

                    <div class="portada_bloque_campo">
                        <label for="nombre_2" class="portada_etiqueta">Nombre2:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="text" name="nombre_2" id="nombre_2" class="portada_input" value="<?php echo htmlspecialchars($nombre_2); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($nombre_2); ?></span>
                        <?php } ?>
                    </div>

                    <div class="portada_bloque_campo">
                        <label for="nombre_3" class="portada_etiqueta">Nombre3:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="text" name="nombre_3" id="nombre_3" class="portada_input" value="<?php echo htmlspecialchars($nombre_3); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($nombre_3); ?></span>
                        <?php } ?>
                    </div>

                    <div class="portada_bloque_campo">
                        <label for="nombre_4" class="portada_etiqueta">Nombre4:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="text" name="nombre_4" id="nombre_4" class="portada_input" value="<?php echo htmlspecialchars($nombre_4); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($nombre_4); ?></span>
                        <?php } ?>
                    </div>

                    <div class="portada_bloque_campo">
                        <label for="proyecto" class="portada_etiqueta">Proyecto:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="text" name="proyecto" id="proyecto" class="portada_input" value="<?php echo htmlspecialchars($proyecto); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($proyecto); ?></span>
                        <?php } ?>
                    </div>

                    <div class="portada_bloque_campo">
                        <label for="avance" class="portada_etiqueta">Avance:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="text" name="avance" id="avance" class="portada_input" value="<?php echo htmlspecialchars($avance); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($avance); ?></span>
                        <?php } ?>
                    </div>

                    <div class="portada_bloque_campo">
                        <label for="solicitado_por" class="portada_etiqueta">Solicitado por:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="text" name="solicitado_por" id="solicitado_por" class="portada_input" value="<?php echo htmlspecialchars($solicitado_por); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($solicitado_por); ?></span>
                        <?php } ?>
                    </div>

                    <div class="portada_bloque_campo">
                        <label for="cargo" class="portada_etiqueta">Cargo:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="text" name="cargo" id="cargo" class="portada_input" value="<?php echo htmlspecialchars($cargo); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($cargo); ?></span>
                        <?php } ?>
                    </div>

                    <div class="portada_bloque_campo">
                        <label for="fecha_entrega" class="portada_etiqueta">Fecha Entrega:</label>
                        <?php if($modo_edicion){ ?>
                            <input type="date" name="fecha_entrega" id="fecha_entrega" class="portada_input" value="<?php echo htmlspecialchars($fecha_entrega); ?>">
                        <?php }else{ ?>
                            <span class="portada_texto_visual"><?php echo htmlspecialchars($texto_fecha_entrega); ?></span>
                        <?php } ?>
                    </div>

                </div>

            </div>

            <div class="portada_bloque_botones_inferiores">

                <button
                    type="submit"
                    name="guardar_portada"
                    value="1"
                    class="portada_boton_guardar_inferior<?php echo !$guardar_habilitado ? ' portada_boton_deshabilitado' : ''; ?>"
                    <?php echo !$guardar_habilitado ? 'disabled' : ''; ?>
                >
                    GUARDAR INFORME
                </button>

                <?php if($mostrar_boton_modificar){ ?>
                    <a href="portada.php?id_informe=<?php echo (int)$id_informe; ?>&editar=1" class="portada_boton_modificar_inferior">
                        MODIFICAR INFORME
                    </a>
                <?php } ?>

            </div>

        </article>

        
        
        <aside class="portada_columna_preview_individual">

            <div class="portada_preview_documento">

                <div class="portada_preview_logo_derecha">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="portada_preview_logo_imagen">
                </div>

                <div class="portada_preview_bloque_superior_nombre">
                    <span class="portada_preview_etiqueta_titulo">INFORME "</span>
                    <span class="portada_preview_texto_nombre"><?php echo htmlspecialchars($texto_nombre_informe); ?></span>
                    <span class="portada_preview_comilla_final">"</span>
                </div>

                <div class="portada_preview_bloque_contenido_textual">
                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Area de Trabajo:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($area_trabajo); ?></span>
                    </div>

                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Nombre1:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($nombre_1); ?></span>
                    </div>

                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Nombre2:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($nombre_2); ?></span>
                    </div>

                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Nombre3:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($nombre_3); ?></span>
                    </div>

                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Nombre4:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($nombre_4); ?></span>
                    </div>

                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Proyecto:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($proyecto); ?></span>
                    </div>

                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Avance:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($avance); ?></span>
                    </div>

                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Solicitado por:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($solicitado_por); ?></span>
                    </div>

                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Cargo:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($cargo); ?></span>
                    </div>

                    <div class="portada_preview_fila_textual">
                        <span class="portada_preview_label">Fecha Entrega:</span>
                        <span class="portada_preview_valor_textual"><?php echo htmlspecialchars($texto_fecha_entrega); ?></span>
                    </div>
                </div>

            </div>

        </aside>

    </section>

</form>

