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

if(!isset($fuente_estado) || !is_array($fuente_estado)){
    return;
}

$clave_fuente = isset($fuente_estado['clave']) ? (string)$fuente_estado['clave'] : '';
$id_html_fuente = isset($fuente_estado['id_html']) ? (string)$fuente_estado['id_html'] : '';
$documento_titulo_fuente = isset($fuente_estado['documento_titulo']) ? (string)$fuente_estado['documento_titulo'] : '';
$descripcion_preview_fuente = isset($fuente_estado['descripcion_preview']) ? (string)$fuente_estado['descripcion_preview'] : '';
$footer_numero_fuente = isset($fuente_estado['footer_numero']) ? (string)$fuente_estado['footer_numero'] : '';

$mensaje_fuente = isset($fuente_estado['mensaje']) ? (string)$fuente_estado['mensaje'] : '';
$clase_mensaje_fuente = isset($fuente_estado['clase_mensaje']) ? (string)$fuente_estado['clase_mensaje'] : '';

$nivel_titulo_1_fuente = isset($fuente_estado['nivel_titulo_1']) ? (string)$fuente_estado['nivel_titulo_1'] : '3';
$numero_titulo_1_fuente = isset($fuente_estado['numero_titulo_1']) ? (string)$fuente_estado['numero_titulo_1'] : '';
$texto_titulo_1_fuente = isset($fuente_estado['texto_titulo_1']) ? (string)$fuente_estado['texto_titulo_1'] : '';
$nivel_titulo_2_fuente = isset($fuente_estado['nivel_titulo_2']) ? (string)$fuente_estado['nivel_titulo_2'] : '4';
$numero_titulo_2_fuente = isset($fuente_estado['numero_titulo_2']) ? (string)$fuente_estado['numero_titulo_2'] : '';
$texto_titulo_2_fuente = isset($fuente_estado['texto_titulo_2']) ? (string)$fuente_estado['texto_titulo_2'] : '';

$registros_fuente = isset($fuente_estado['registros']) && is_array($fuente_estado['registros']) ? $fuente_estado['registros'] : array();
$titulos_h2_fuente = explode("\n", $documento_titulo_fuente);
?>

<section id="<?php echo htmlspecialchars($id_html_fuente); ?>" class="portada_fila_seccion fuentes_fila_seccion" data-fuente-seccion="<?php echo htmlspecialchars($clave_fuente); ?>">

    <div class="fuentes_bloque_completo">

        <h2 class="fuentes_titulo_documento" id="<?php echo htmlspecialchars(construir_id_ancla_indice('fuentes_' . $clave_fuente, $numero_titulo_1_fuente, $texto_titulo_1_fuente)); ?>">
            <?php foreach($titulos_h2_fuente as $indice_h2_fuente => $linea_h2_fuente){ ?>
                <?php if($indice_h2_fuente > 0){ ?><br><?php } ?><?php echo htmlspecialchars($linea_h2_fuente); ?>
            <?php } ?>
        </h2>

        <?php if(!empty($registros_fuente)): ?>
            <?php
                $anclas_fuente_vistas = array();
                foreach($registros_fuente as $item_fuente_ancla){
                    $numero_f1_ancla = isset($item_fuente_ancla['numero_titulo_1']) ? trim((string)$item_fuente_ancla['numero_titulo_1']) : '';
                    $texto_f1_ancla = isset($item_fuente_ancla['texto_titulo_1']) ? trim((string)$item_fuente_ancla['texto_titulo_1']) : '';
                    $numero_f2_ancla = isset($item_fuente_ancla['numero_titulo_2']) ? trim((string)$item_fuente_ancla['numero_titulo_2']) : '';
                    $texto_f2_ancla = isset($item_fuente_ancla['texto_titulo_2']) ? trim((string)$item_fuente_ancla['texto_titulo_2']) : '';

                    if($texto_f1_ancla !== ''){
                        $id_ancla_f1 = construir_id_ancla_indice('fuentes_' . $clave_fuente, $numero_f1_ancla, $texto_f1_ancla);
                        if(!isset($anclas_fuente_vistas[$id_ancla_f1])){
                            $anclas_fuente_vistas[$id_ancla_f1] = true;
                            echo '<span id="' . htmlspecialchars($id_ancla_f1) . '"></span>';
                        }
                    }

                    if($texto_f2_ancla !== ''){
                        $id_ancla_f2 = construir_id_ancla_indice('fuentes_' . $clave_fuente, $numero_f2_ancla, $texto_f2_ancla);
                        if(!isset($anclas_fuente_vistas[$id_ancla_f2])){
                            $anclas_fuente_vistas[$id_ancla_f2] = true;
                            echo '<span id="' . htmlspecialchars($id_ancla_f2) . '"></span>';
                        }
                    }
                }
            ?>
        <?php else: ?>
            <span id="<?php echo htmlspecialchars(construir_id_ancla_indice('fuentes_' . $clave_fuente, $numero_titulo_2_fuente, $texto_titulo_2_fuente)); ?>"></span>
        <?php endif; ?>

        <article class="portada_documento fuentes_documento">
            <form action="portada.php?id_informe=<?php echo (int)$id_informe; ?>#<?php echo htmlspecialchars($id_html_fuente); ?>" method="POST" id="fuentes_formulario_<?php echo htmlspecialchars($clave_fuente); ?>" data-fuente-formulario="1" class="seccion_ruta_formulario">
                <input type="hidden" name="id_informe" value="<?php echo (int)$id_informe; ?>">
                <input type="hidden" name="guardar_fuente_base" value="1">
                <input type="hidden" name="seccion_fuente" value="<?php echo htmlspecialchars($clave_fuente); ?>">
                <input type="hidden" name="nombre_fuente" id="nombre_fuente_input_<?php echo htmlspecialchars($clave_fuente); ?>" value="">

                <?php if($mensaje_fuente !== ''): ?>
                    <div class="portada_respuesta <?php echo htmlspecialchars($clase_mensaje_fuente); ?>">
                        <?php echo htmlspecialchars($mensaje_fuente); ?>
                    </div>
                <?php endif; ?>

                <div class="fuentes_documento_encabezado">
                    <div class="fuentes_logo_superior">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="fuentes_logo_imagen">
                    </div>
                    <p class="fuentes_nota_superior">Puedes editar manualmente los titulos de esta seccion antes de guardar cada fuente.</p>
                </div>

                <section class="fuentes_bloque_jerarquia">
                    <div class="fuentes_jerarquia_item">
                        <div class="fuentes_campo">
                            <label class="fuentes_etiqueta">TIPO TITULO</label>
                            <select name="nivel_titulo_1_fuente" class="fuentes_input">
                                <?php for($i = 1; $i <= 20; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_1_fuente === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="fuentes_campo">
                            <label class="fuentes_etiqueta">N&deg; TITULO</label>
                            <input type="text" name="numero_titulo_1_fuente" class="fuentes_input" value="<?php echo htmlspecialchars($numero_titulo_1_fuente); ?>">
                        </div>
                        <div class="fuentes_campo">
                            <label class="fuentes_etiqueta">INGRESAR TITULO</label>
                            <input type="text" name="texto_titulo_1_fuente" class="fuentes_input" value="<?php echo htmlspecialchars($texto_titulo_1_fuente); ?>">
                        </div>
                    </div>

                    <div class="fuentes_jerarquia_item">
                        <div class="fuentes_campo">
                            <label class="fuentes_etiqueta">TIPO TITULO</label>
                            <select name="nivel_titulo_2_fuente" class="fuentes_input">
                                <?php for($i = 1; $i <= 20; $i++){ ?>
                                    <option value="<?php echo $i; ?>" <?php echo $nivel_titulo_2_fuente === (string)$i ? 'selected' : ''; ?>>TITULO <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="fuentes_campo">
                            <label class="fuentes_etiqueta">N&deg; TITULO</label>
                            <input type="text" name="numero_titulo_2_fuente" class="fuentes_input" value="<?php echo htmlspecialchars($numero_titulo_2_fuente); ?>">
                        </div>
                        <div class="fuentes_campo">
                            <label class="fuentes_etiqueta">INGRESAR TITULO</label>
                            <input type="text" name="texto_titulo_2_fuente" class="fuentes_input" value="<?php echo htmlspecialchars($texto_titulo_2_fuente); ?>">
                        </div>
                    </div>
                </section>

                <section class="fuentes_tarjetas">
                    <article class="fuentes_tarjeta">
                        <div class="fuentes_tarjeta_icono">X</div>
                        <p class="fuentes_tarjeta_texto">DESCARGAR PLANILLA EXCEL, PARA CARGAR LISTADO DE FUENTES</p>
                    </article>
                    <button type="button" class="fuentes_tarjeta" id="fuentes_btn_guardar_<?php echo htmlspecialchars($clave_fuente); ?>">
                        <div class="fuentes_tarjeta_icono">X</div>
                        <p class="fuentes_tarjeta_texto">SUBIR PLANILLA EXCEL, PARA CARGAR LISTADO DE FUENTES</p>
                    </button>
                </section>

                <footer class="fuentes_documento_footer">
                    <div class="fuentes_documento_footer_logo">
                        <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="fuentes_documento_footer_logo_imagen">
                    </div>
                    <div class="fuentes_documento_footer_texto">
                        Tecnolog&iacute;a y Construcci&oacute;n<br>
                        Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                        Santiago-Chile<br>
                        Email: contacto@itred.cl / itred.spa@gmail.com<br>
                        Sitio Web: https://www.itred.cl<br>
                    </div>
                    <div class="fuentes_documento_footer_numero"><?php echo htmlspecialchars($footer_numero_fuente); ?></div>
                </footer>
            </form>
        </article>
    </div>

    <aside class="portada_columna_preview_individual seccion_ruta_columna_preview">
        <div class="portada_preview_documento fuentes_preview_documento">
            <div class="fuentes_preview_logo_superior">
                <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="fuentes_preview_logo_imagen">
            </div>

            <p class="fuentes_preview_titulo" id="fuentes_preview_titulo_1_<?php echo htmlspecialchars($clave_fuente); ?>"><?php echo htmlspecialchars($numero_titulo_1_fuente . ' ' . $texto_titulo_1_fuente); ?></p>
            <p class="fuentes_preview_titulo" id="fuentes_preview_titulo_2_<?php echo htmlspecialchars($clave_fuente); ?>"><?php echo htmlspecialchars($numero_titulo_2_fuente . ' ' . $texto_titulo_2_fuente); ?></p>
            <p class="fuentes_preview_texto"><?php echo htmlspecialchars($descripcion_preview_fuente); ?></p>

            <table class="fuentes_preview_tabla" id="fuentes_preview_tabla_<?php echo htmlspecialchars($clave_fuente); ?>">
                <?php if(!empty($registros_fuente)): ?>
                    <?php $chunk_fuentes = array_chunk($registros_fuente, 3); ?>
                    <?php foreach($chunk_fuentes as $fila_fuentes): ?>
                        <tr>
                            <?php for($i = 0; $i < 3; $i++): ?>
                                <td><?php echo isset($fila_fuentes[$i]) ? htmlspecialchars((string)$fila_fuentes[$i]['nombre_fuente']) : '&nbsp;'; ?></td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                <?php endif; ?>
            </table>

            <footer class="fuentes_preview_footer">
                <div class="fuentes_preview_footer_logo">
                    <img src="<?php echo htmlspecialchars($logo_itred); ?>" alt="Logo Itred" class="fuentes_preview_footer_logo_imagen">
                </div>
                <div class="fuentes_preview_footer_texto">
                    Direcci&oacute;n: Guido Reni #4190, Pedro Aguirre Cerda<br>
                    E-Mail: contacto@itred.cl / itred.spa@gmail.com<br>
                    Sitio Web: https://www.itred.cl
                </div>
                <div class="fuentes_preview_footer_numero">2</div>
            </footer>
        </div>
    </aside>

</section>
