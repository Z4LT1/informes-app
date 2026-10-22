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

if(!isset($ruta_estado) || !is_array($ruta_estado)){
    return;
}

$clave_ruta = isset($ruta_estado['clave']) ? (string)$ruta_estado['clave'] : '';
$id_html_ruta = isset($ruta_estado['id_html']) ? (string)$ruta_estado['id_html'] : '';
$documento_titulo_ruta = isset($ruta_estado['documento_titulo']) ? (string)$ruta_estado['documento_titulo'] : '';
$texto_apoyo_ruta = isset($ruta_estado['texto_apoyo']) ? (string)$ruta_estado['texto_apoyo'] : '';
$footer_numero_ruta = isset($ruta_estado['footer_numero']) ? (string)$ruta_estado['footer_numero'] : '';

$mensaje_ruta = isset($ruta_estado['mensaje']) ? (string)$ruta_estado['mensaje'] : '';
$clase_mensaje_ruta = isset($ruta_estado['clase_mensaje']) ? (string)$ruta_estado['clase_mensaje'] : '';
$primer_titulo_bloqueado_ruta = isset($ruta_estado['primer_titulo_bloqueado']) && $ruta_estado['primer_titulo_bloqueado'];

$nivel_titulo_1_ruta = isset($ruta_estado['nivel_titulo_1']) ? (string)$ruta_estado['nivel_titulo_1'] : '2';
$numero_titulo_1_ruta = isset($ruta_estado['numero_titulo_1']) ? (string)$ruta_estado['numero_titulo_1'] : '';
$texto_titulo_1_ruta = isset($ruta_estado['texto_titulo_1']) ? (string)$ruta_estado['texto_titulo_1'] : '';
$nivel_titulo_2_ruta = isset($ruta_estado['nivel_titulo_2']) ? (string)$ruta_estado['nivel_titulo_2'] : '3';
$numero_titulo_2_ruta = isset($ruta_estado['numero_titulo_2']) ? (string)$ruta_estado['numero_titulo_2'] : '';
$texto_titulo_2_ruta = isset($ruta_estado['texto_titulo_2']) ? (string)$ruta_estado['texto_titulo_2'] : '';

$ruta_principal_ruta = isset($ruta_estado['ruta_principal']) ? (string)$ruta_estado['ruta_principal'] : '';
$sin_manual_momento_ruta = isset($ruta_estado['sin_manual_momento']) && $ruta_estado['sin_manual_momento'];
$carpeta_ruta = isset($ruta_estado['carpeta']) ? (string)$ruta_estado['carpeta'] : '';
$archivo_ruta = isset($ruta_estado['archivo']) ? (string)$ruta_estado['archivo'] : '';
$extension_ruta = isset($ruta_estado['extension']) ? (string)$ruta_estado['extension'] : '';
$ruta_extra_1_ruta = isset($ruta_estado['ruta_extra_1']) ? (string)$ruta_estado['ruta_extra_1'] : '';
$ruta_extra_2_ruta = isset($ruta_estado['ruta_extra_2']) ? (string)$ruta_estado['ruta_extra_2'] : '';
$ruta_extra_3_ruta = isset($ruta_estado['ruta_extra_3']) ? (string)$ruta_estado['ruta_extra_3'] : '';
$ruta_extra_4_ruta = isset($ruta_estado['ruta_extra_4']) ? (string)$ruta_estado['ruta_extra_4'] : '';

$registros_ruta = isset($ruta_estado['registros']) && is_array($ruta_estado['registros']) ? $ruta_estado['registros'] : array();

$preview_html_id = 'preview_contenido_ruta_' . $clave_ruta;
$activar_extras_id = 'activar_rutas_extra_' . $clave_ruta;
$boton_extras_id = 'boton_habilitar_rutas_extra_' . $clave_ruta;
$boton_modificar_id = 'boton_modificar_titulo_ruta_' . $clave_ruta;
$boton_modificar_footer_id = 'boton_modificar_footer_ruta_' . $clave_ruta;

$titulos_h2_ruta = explode("\n", $documento_titulo_ruta);
?>

<section id="<?php echo htmlspecialchars($id_html_ruta); ?>" class="portada_fila_seccion seccion_ruta_fila_seccion" data-ruta-seccion="<?php echo htmlspecialchars($clave_ruta); ?>">

    <div class="seccion_ruta_bloque_completo">

        <h2 class="seccion_ruta_titulo_documento" id="<?php echo htmlspecialchars(construir_id_ancla_indice('ruta_estructural_' . $clave_ruta, $numero_titulo_1_ruta, $texto_titulo_1_ruta)); ?>">
            <?php foreach($titulos_h2_ruta as $indice_h2_ruta => $linea_h2_ruta){ ?>
                <?php if($indice_h2_ruta > 0){ ?><br><?php } ?><?php echo htmlspecialchars($linea_h2_ruta); ?>
            <?php } ?>
        </h2>

        <?php if(!empty($registros_ruta)): ?>
            <?php
                $anclas_ruta_vistas = array();
                foreach($registros_ruta as $item_ruta_ancla){
                    $numero_r1_ancla = isset($item_ruta_ancla['numero_titulo_1']) ? trim((string)$item_ruta_ancla['numero_titulo_1']) : '';
                    $texto_r1_ancla = isset($item_ruta_ancla['texto_titulo_1']) ? trim((string)$item_ruta_ancla['texto_titulo_1']) : '';
                    $numero_r2_ancla = isset($item_ruta_ancla['numero_titulo_2']) ? trim((string)$item_ruta_ancla['numero_titulo_2']) : '';
                    $texto_r2_ancla = isset($item_ruta_ancla['texto_titulo_2']) ? trim((string)$item_ruta_ancla['texto_titulo_2']) : '';

                    if($texto_r1_ancla !== ''){
                        $id_ancla_r1 = construir_id_ancla_indice('ruta_estructural_' . $clave_ruta, $numero_r1_ancla, $texto_r1_ancla);
                        if(!isset($anclas_ruta_vistas[$id_ancla_r1])){
                            $anclas_ruta_vistas[$id_ancla_r1] = true;
                            echo '<span id="' . htmlspecialchars($id_ancla_r1) . '"></span>';
                        }
                    }

                    if($texto_r2_ancla !== ''){
                        $id_ancla_r2 = construir_id_ancla_indice('ruta_estructural_' . $clave_ruta, $numero_r2_ancla, $texto_r2_ancla);
                        if(!isset($anclas_ruta_vistas[$id_ancla_r2])){
                            $anclas_ruta_vistas[$id_ancla_r2] = true;
                            echo '<span id="' . htmlspecialchars($id_ancla_r2) . '"></span>';
                        }
                    }
                }
            ?>
        <?php else: ?>
            <span id="<?php echo htmlspecialchars(construir_id_ancla_indice('ruta_estructural_' . $clave_ruta, $numero_titulo_2_ruta, $texto_titulo_2_ruta)); ?>"></span>
        <?php endif; ?>

        <article class="portada_documento seccion_ruta_documento">
            <form action="portada.php?id_informe=<?php echo (int)$id_informe; ?>#<?php echo htmlspecialchars($id_html_ruta); ?>" method="POST" class="seccion_ruta_formulario" id="ruta_estructural_formulario_<?php echo htmlspecialchars($clave_ruta); ?>" data-ruta-formulario="1">
                <input type="hidden" name="id_informe" value="<?php echo (int)$id_informe; ?>">
                <input type="hidden" name="guardar_ruta_estructural_base" value="1">
                <input type="hidden" name="seccion_ruta_estructural" value="<?php echo htmlspecialchars($clave_ruta); ?>">
                <input type="hidden" name="primer_titulo_bloqueado_ruta" value="<?php echo $primer_titulo_bloqueado_ruta ? '1' : '0'; ?>" id="primer_titulo_bloqueado_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">

                <?php if($mensaje_ruta !== ''): ?>
                    <div class="portada_respuesta <?php echo htmlspecialchars($clase_mensaje_ruta); ?>">
                        <?php echo htmlspecialchars($mensaje_ruta); ?>
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
                            <?php if($primer_titulo_bloqueado_ruta): ?>
                                <input type="hidden" name="nivel_titulo_1_ruta_fijo" value="<?php echo htmlspecialchars($nivel_titulo_1_ruta); ?>">
                                <input type="text" class="seccion_ruta_input" value="<?php echo htmlspecialchars($nivel_titulo_1_ruta); ?>" readonly>
                            <?php else: ?>
                                <input type="text" class="seccion_ruta_input" name="nivel_titulo_1_ruta" value="<?php echo htmlspecialchars($nivel_titulo_1_ruta); ?>" id="nivel_titulo_1_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                            <?php endif; ?>
                        </div>

                        <div class="seccion_ruta_campo seccion_ruta_campo_numero">
                            <label class="seccion_ruta_etiqueta">N&deg; TITULO</label>
                            <?php if($primer_titulo_bloqueado_ruta): ?>
                                <input type="hidden" name="numero_titulo_1_ruta_fijo" value="<?php echo htmlspecialchars($numero_titulo_1_ruta); ?>">
                                <input type="text" class="seccion_ruta_input" value="<?php echo htmlspecialchars($numero_titulo_1_ruta); ?>" readonly>
                            <?php else: ?>
                                <input type="text" class="seccion_ruta_input" name="numero_titulo_1_ruta" value="<?php echo htmlspecialchars($numero_titulo_1_ruta); ?>" id="numero_titulo_1_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                            <?php endif; ?>
                        </div>

                        <div class="seccion_ruta_campo seccion_ruta_campo_titulo">
                            <label class="seccion_ruta_etiqueta">INGRESAR TITULO</label>
                            <?php if($primer_titulo_bloqueado_ruta): ?>
                                <input type="hidden" name="texto_titulo_1_ruta_fijo" value="<?php echo htmlspecialchars($texto_titulo_1_ruta); ?>">
                                <input type="text" class="seccion_ruta_input" value="<?php echo htmlspecialchars($texto_titulo_1_ruta); ?>" readonly>
                            <?php else: ?>
                                <input type="text" class="seccion_ruta_input" name="texto_titulo_1_ruta" value="<?php echo htmlspecialchars($texto_titulo_1_ruta); ?>" id="texto_titulo_1_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="seccion_ruta_jerarquia_item">
                        <div class="seccion_ruta_campo seccion_ruta_campo_tipo">
                            <label class="seccion_ruta_etiqueta">TIPO TITULO</label>
                            <input type="text" class="seccion_ruta_input" name="nivel_titulo_2_ruta" value="<?php echo htmlspecialchars($nivel_titulo_2_ruta); ?>" id="nivel_titulo_2_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                        </div>

                        <div class="seccion_ruta_campo seccion_ruta_campo_numero">
                            <label class="seccion_ruta_etiqueta">N&deg; TITULO</label>
                            <input type="text" class="seccion_ruta_input" name="numero_titulo_2_ruta" value="<?php echo htmlspecialchars($numero_titulo_2_ruta); ?>" id="numero_titulo_2_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                        </div>

                        <div class="seccion_ruta_campo seccion_ruta_campo_titulo">
                            <label class="seccion_ruta_etiqueta">INGRESAR TITULO</label>
                            <input type="text" class="seccion_ruta_input" name="texto_titulo_2_ruta" value="<?php echo htmlspecialchars($texto_titulo_2_ruta); ?>" id="texto_titulo_2_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                        </div>
                    </div>
                </section>

                <section class="seccion_ruta_bloque_campo_principal">
                    <label class="seccion_ruta_etiqueta">INGRESAR RUTA</label>
                    <input type="text" class="seccion_ruta_input" name="ruta_principal_ruta" value="<?php echo htmlspecialchars($ruta_principal_ruta); ?>" id="ruta_principal_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                </section>

                <p class="seccion_ruta_texto_apoyo"><?php echo htmlspecialchars($texto_apoyo_ruta); ?></p>

                <label class="seccion_ruta_checkbox_linea">
                    <input type="checkbox" name="sin_manual_momento_ruta" value="1" <?php echo $sin_manual_momento_ruta ? 'checked' : ''; ?> id="sin_manual_momento_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                    Agregar mensaje "SIN MANUAL POR EL MOMENTO"
                </label>

                <div class="seccion_ruta_botonera_principal">
                    <button type="submit" class="seccion_ruta_boton">Guardar</button>
                    <button type="button" class="seccion_ruta_boton secundario" id="<?php echo htmlspecialchars($boton_modificar_id); ?>">Modificar</button>
                </div>

                <section class="seccion_ruta_fila_bloques">
                    <article class="seccion_ruta_bloque_simple">
                        <div>
                            <label class="seccion_ruta_etiqueta">INGRESAR CARPETAS</label>
                            <input type="text" class="seccion_ruta_input" name="carpeta_ruta" value="<?php echo htmlspecialchars($carpeta_ruta); ?>" id="carpeta_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                        </div>
                        <div class="seccion_ruta_botones_stack">
                            <button type="submit" class="seccion_ruta_boton">Guardar</button>
                            <button type="button" class="seccion_ruta_boton secundario">Modificar</button>
                        </div>
                    </article>

                    <article class="seccion_ruta_bloque_simple">
                        <div>
                            <label class="seccion_ruta_etiqueta">INGRESAR ARCHIVOS</label>
                            <input type="text" class="seccion_ruta_input" name="archivo_ruta" value="<?php echo htmlspecialchars($archivo_ruta); ?>" id="archivo_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                        </div>
                        <div class="seccion_ruta_botones_stack">
                            <button type="submit" class="seccion_ruta_boton">Guardar</button>
                            <button type="button" class="seccion_ruta_boton secundario">Modificar</button>
                        </div>
                    </article>

                    <article class="seccion_ruta_bloque_simple">
                        <div>
                            <label class="seccion_ruta_etiqueta">INGRESAR EXTENSION</label>
                            <input type="text" class="seccion_ruta_input" name="extension_ruta" value="<?php echo htmlspecialchars($extension_ruta); ?>" id="extension_ruta_<?php echo htmlspecialchars($clave_ruta); ?>">
                        </div>
                        <div class="seccion_ruta_botones_stack">
                            <button type="submit" class="seccion_ruta_boton">Guardar</button>
                            <button type="button" class="seccion_ruta_boton secundario">Modificar</button>
                        </div>
                    </article>
                </section>

                <section class="seccion_ruta_fila_ruta_extra">
                    <label class="seccion_ruta_checkbox_linea">
                        <input type="checkbox" id="<?php echo htmlspecialchars($activar_extras_id); ?>">
                        AGREGAR RUTA
                    </label>

                    <div class="seccion_ruta_campos_ruta_extra">
                        <input type="text" class="seccion_ruta_input" name="ruta_extra_1_ruta" value="<?php echo htmlspecialchars($ruta_extra_1_ruta); ?>" id="ruta_extra_1_ruta_<?php echo htmlspecialchars($clave_ruta); ?>" readonly>
                        <input type="text" class="seccion_ruta_input" name="ruta_extra_2_ruta" value="<?php echo htmlspecialchars($ruta_extra_2_ruta); ?>" id="ruta_extra_2_ruta_<?php echo htmlspecialchars($clave_ruta); ?>" readonly>
                        <input type="text" class="seccion_ruta_input" name="ruta_extra_3_ruta" value="<?php echo htmlspecialchars($ruta_extra_3_ruta); ?>" id="ruta_extra_3_ruta_<?php echo htmlspecialchars($clave_ruta); ?>" readonly>
                        <input type="text" class="seccion_ruta_input" name="ruta_extra_4_ruta" value="<?php echo htmlspecialchars($ruta_extra_4_ruta); ?>" id="ruta_extra_4_ruta_<?php echo htmlspecialchars($clave_ruta); ?>" readonly>
                    </div>

                    <button type="button" class="seccion_ruta_boton_add" id="<?php echo htmlspecialchars($boton_extras_id); ?>">+</button>
                </section>

                <div class="seccion_ruta_botones_footer">
                    <button type="submit" class="seccion_ruta_boton">Guardar</button>
                    <button type="button" class="seccion_ruta_boton secundario" id="<?php echo htmlspecialchars($boton_modificar_footer_id); ?>">Modificar</button>
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

                    <div class="seccion_ruta_documento_footer_numero"><?php echo htmlspecialchars($footer_numero_ruta); ?></div>
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
                <span class="seccion_ruta_preview_titulo_numero"><?php echo htmlspecialchars($numero_titulo_1_ruta); ?></span>
                <span class="seccion_ruta_preview_titulo_texto"><?php echo htmlspecialchars($texto_titulo_1_ruta); ?></span>
            </div>

            <div class="seccion_ruta_preview_titulo seccion_ruta_preview_nivel_3">
                <span class="seccion_ruta_preview_titulo_numero"><?php echo htmlspecialchars($numero_titulo_2_ruta); ?></span>
                <span class="seccion_ruta_preview_titulo_texto"><?php echo htmlspecialchars($texto_titulo_2_ruta); ?></span>
            </div>

            <div class="seccion_ruta_preview_contenido" id="<?php echo htmlspecialchars($preview_html_id); ?>">
                <?php if(!empty($registros_ruta)): ?>
                    <ol>
                        <?php foreach($registros_ruta as $registro_ruta): ?>
                            <?php
                                $ruta_principal_item = isset($registro_ruta['ruta_principal']) ? trim((string)$registro_ruta['ruta_principal']) : '';
                                $carpeta_item = isset($registro_ruta['carpeta']) ? trim((string)$registro_ruta['carpeta']) : '';
                                $archivo_item = isset($registro_ruta['archivo']) ? trim((string)$registro_ruta['archivo']) : '';
                                $extension_item = isset($registro_ruta['extension']) ? trim((string)$registro_ruta['extension']) : '';
                                $sin_manual_item = isset($registro_ruta['sin_manual_momento']) && (int)$registro_ruta['sin_manual_momento'] === 1;
                                $ruta_extras_item = array(
                                    isset($registro_ruta['ruta_extra_1']) ? trim((string)$registro_ruta['ruta_extra_1']) : '',
                                    isset($registro_ruta['ruta_extra_2']) ? trim((string)$registro_ruta['ruta_extra_2']) : '',
                                    isset($registro_ruta['ruta_extra_3']) ? trim((string)$registro_ruta['ruta_extra_3']) : '',
                                    isset($registro_ruta['ruta_extra_4']) ? trim((string)$registro_ruta['ruta_extra_4']) : ''
                                );

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
                            <li>
                                <?php if($ruta_principal_item !== ''): ?><p>- ruta: <?php echo htmlspecialchars($ruta_principal_item); ?></p><?php endif; ?>
                                <?php if($archivo_compuesto_item !== ''): ?><p>- archivo: <?php echo htmlspecialchars($archivo_compuesto_item); ?></p><?php endif; ?>
                                <?php foreach($ruta_extras_item as $extra_item): ?>
                                    <?php if($extra_item !== ''): ?><p>- ruta extra: <?php echo htmlspecialchars($extra_item); ?></p><?php endif; ?>
                                <?php endforeach; ?>
                                <?php if($sin_manual_item): ?><p>- SIN MANUAL POR EL MOMENTO</p><?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php elseif($ruta_principal_ruta !== '' || $carpeta_ruta !== '' || $archivo_ruta !== '' || $extension_ruta !== ''): ?>
                    <p>- ruta: <?php echo htmlspecialchars($ruta_principal_ruta); ?></p>
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
-                <div class="seccion_ruta_preview_footer_numero">2</div>
+                <div class="seccion_ruta_preview_footer_numero"><?php echo htmlspecialchars($footer_numero_ruta); ?></div>
             </footer>
         </div>
     </aside>

 </section>
