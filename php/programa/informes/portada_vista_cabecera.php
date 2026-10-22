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



<section class="portada_cabecera_superior">

    
    
    <div class="portada_cabecera_izquierda">
        <button
            type="submit"
            name="guardar_portada"
            value="1"
            form="portada_formulario_principal"
            class="portada_boton_guardar_superior<?php echo !$guardar_habilitado ? ' portada_boton_deshabilitado' : ''; ?>"
            <?php echo !$guardar_habilitado ? 'disabled' : ''; ?>
        >
            GUARDAR
        </button>

        <a href="panel.php?vista=nuevo" class="portada_boton_cabecera_panel">
            VOLVER AL PANEL
        </a>

    </div>

    <?php if($id_informe > 0){ ?>
        <div class="portada_cabecera_exportacion">
            <a href="portada.php?id_informe=<?php echo (int)$id_informe; ?>&exportar=word" class="portada_boton_cabecera_secundario">
                WORD
            </a>

            <a href="portada.php?id_informe=<?php echo (int)$id_informe; ?>&exportar=pdf" target="_blank" class="portada_boton_cabecera_secundario">
                PDF
            </a>

            <button type="button" class="portada_boton_cabecera_secundario" id="portada_boton_imprimir" data-url-imprimir="portada.php?id_informe=<?php echo (int)$id_informe; ?>&exportar=imprimir">
                IMPRIMIR
            </button>
        </div>
    <?php } ?>

    
    
    <div class="portada_cabecera_derecha">

        <p class="portada_usuario">
            USUARIO:
            <span class="portada_usuario_nombre">
                <?php echo htmlspecialchars($nombre_usuario_sesion); ?>
            </span>
        </p>

        <form method="POST" action="../login/cerrar_sesion.php" class="portada_formulario_superior">
            <button type="submit" class="portada_boton_cabecera">
                CERRAR SESI&Oacute;N
            </button>
        </form>

    </div>

</section>

