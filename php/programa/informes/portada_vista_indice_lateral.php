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



<aside class="portada_columna_indice">

    <div class="portada_indice_scroll">

        <div class="portada_indice_panel">

            <?php $contador_filas_indice = 0; ?>

            <?php foreach($filas_indice as $fila_indice_lateral){ ?>
                <?php
                    $titulo_lateral = isset($fila_indice_lateral['titulo']) ? trim($fila_indice_lateral['titulo']) : '';
                    $pagina_lateral = isset($fila_indice_lateral['pagina']) ? trim($fila_indice_lateral['pagina']) : '';
                    $nivel_lateral = isset($fila_indice_lateral['nivel']) ? trim($fila_indice_lateral['nivel']) : '0';
                    $ancla_lateral = isset($fila_indice_lateral['ancla']) ? trim((string)$fila_indice_lateral['ancla']) : '';
                    $titulo_lateral_mayuscula = mb_strtoupper($titulo_lateral, 'UTF-8');
                    $es_ancla_indice = $titulo_lateral_mayuscula === 'INDICE';
                    $es_primera_fila_real = $titulo_lateral !== '' && $contador_filas_indice === 0;
                    $es_enlace_introduccion = $es_primera_fila_real || $titulo_lateral_mayuscula === 'INTRODUCCION.';
                    $es_enlace_caso_uso_imagen = mb_strpos($titulo_lateral_mayuscula, 'IMAGEN CASO DE USO') !== false;
                    $es_enlace_carpeta_diagramas = mb_strpos($titulo_lateral_mayuscula, 'DIAGRAMA') !== false;
                    $es_enlace_carpeta_informes_programas = mb_strpos($titulo_lateral_mayuscula, 'INFORMES PROGRAMAS') !== false;
                    $es_enlace_carpeta_medios_pago = mb_strpos($titulo_lateral_mayuscula, 'MEDIOS PAGO') !== false;
                    $es_enlace_carpeta_medios_envio = mb_strpos($titulo_lateral_mayuscula, 'MEDIOS ENVIO') !== false;
                    $es_enlace_carpeta_medios_reparto = mb_strpos($titulo_lateral_mayuscula, 'MEDIOS REPARTO') !== false;
                    $es_enlace_carpeta_manuales_clientes = mb_strpos($titulo_lateral_mayuscula, 'MANUAL CLIENTE') !== false;
                    $es_enlace_carpeta_manuales_tecnicos = mb_strpos($titulo_lateral_mayuscula, 'MANUAL TECNICO') !== false;
                    $es_enlace_fuentes_clientes = mb_strpos($titulo_lateral_mayuscula, 'FUENTES CLIENTE') !== false;
                    $es_enlace_fuentes_word = mb_strpos($titulo_lateral_mayuscula, 'FUENTES WORD') !== false;
                    $es_enlace_documentacion_caso_uso = (mb_strpos($titulo_lateral_mayuscula, 'DOCUMENTACION') !== false || mb_strpos($titulo_lateral_mayuscula, 'EXPLICACION CASO DE USO') !== false) && !$es_enlace_caso_uso_imagen;
                    $es_enlace_base_datos = mb_strpos($titulo_lateral_mayuscula, 'BASE DE DATOS') !== false || mb_strpos($titulo_lateral_mayuscula, 'BASE_DATOS') !== false || mb_strpos($titulo_lateral_mayuscula, '.SQL') !== false;
                ?>

                <?php if($titulo_lateral !== ''){ ?>
                    <?php $contador_filas_indice++; ?>
                    <div class="portada_indice_lateral_fila portada_indice_lateral_nivel_<?php echo htmlspecialchars($nivel_lateral); ?>">
                        <?php if($ancla_lateral !== ''){ ?>
                            <a href="#<?php echo htmlspecialchars($ancla_lateral); ?>" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_ancla_indice){ ?>
                            <a href="#seccion_indice" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_introduccion){ ?>
                            <a href="#seccion_introduccion" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_caso_uso_imagen){ ?>
                            <a href="#seccion_caso_uso_imagen" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_carpeta_diagramas){ ?>
                            <a href="#seccion_carpeta_diagramas" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_carpeta_informes_programas){ ?>
                            <a href="#seccion_carpeta_informes_programas" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_carpeta_medios_pago){ ?>
                            <a href="#seccion_carpeta_medios_pago" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_carpeta_medios_envio){ ?>
                            <a href="#seccion_carpeta_medios_envio" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_carpeta_medios_reparto){ ?>
                            <a href="#seccion_carpeta_medios_reparto" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_carpeta_manuales_clientes){ ?>
                            <a href="#seccion_carpeta_manuales_clientes" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_carpeta_manuales_tecnicos){ ?>
                            <a href="#seccion_carpeta_manuales_tecnicos" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_fuentes_clientes){ ?>
                            <a href="#seccion_carpeta_fuentes_clientes" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_fuentes_word){ ?>
                            <a href="#seccion_carpeta_fuentes_word" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_documentacion_caso_uso){ ?>
                            <a href="#seccion_documentacion_caso_uso" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }elseif($es_enlace_base_datos){ ?>
                            <a href="#seccion_base_datos" class="portada_indice_lateral_enlace">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </a>
                        <?php }else{ ?>
                            <div class="portada_indice_lateral_contenido">
                                <span class="portada_indice_lateral_texto"><?php echo htmlspecialchars($titulo_lateral); ?></span>
                                <span class="portada_indice_lateral_puntos"></span>
                                <span class="portada_indice_lateral_pagina"><?php echo htmlspecialchars($pagina_lateral); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>

        </div>

    </div>

</aside>

