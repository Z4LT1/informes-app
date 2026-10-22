document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('carpeta_pantallazos_programas_formulario_principal');
    var hiddenBloqueado = document.getElementById('carpeta_pantallazos_primer_titulo_bloqueado');

    var nivel1 = document.getElementById('nivel_titulo_cp_1');
    var numero1 = document.getElementById('numero_titulo_cp_1');
    var texto1 = document.getElementById('texto_titulo_cp_1');
    var nivel2 = document.getElementById('nivel_titulo_cp_2');
    var numero2 = document.getElementById('numero_titulo_cp_2');
    var texto2 = document.getElementById('texto_titulo_cp_2');
    var nombreImagen = document.getElementById('nombre_imagen_cp');
    var archivo = document.getElementById('archivo_carpeta_pantallazos');

    var fijoNivel1 = document.getElementById('nivel_titulo_cp_1_fijo');
    var fijoNumero1 = document.getElementById('numero_titulo_cp_1_fijo');
    var fijoTexto1 = document.getElementById('texto_titulo_cp_1_fijo');

    var previewNumero1 = document.getElementById('carpeta_pantallazos_preview_numero_1');
    var previewTexto1 = document.getElementById('carpeta_pantallazos_preview_texto_1');
    var previewNumero2 = document.getElementById('carpeta_pantallazos_preview_numero_2');
    var previewTexto2 = document.getElementById('carpeta_pantallazos_preview_texto_2');
    var previewBloque1 = document.getElementById('carpeta_pantallazos_preview_titulo_1');
    var previewBloque2 = document.getElementById('carpeta_pantallazos_preview_titulo_2');
    var previewNombre = document.getElementById('carpeta_pantallazos_preview_nombre');

    var imagenPrincipal = document.getElementById('carpeta_pantallazos_imagen_principal');
    var placeholderPrincipal = document.getElementById('carpeta_pantallazos_imagen_placeholder');
    var imagenPreview = document.getElementById('carpeta_pantallazos_preview_img');
    var placeholderPreview = document.getElementById('carpeta_pantallazos_preview_placeholder');

    var botonGuardar = document.getElementById('carpeta_pantallazos_boton_guardar');
    var botonModificar = document.getElementById('carpeta_pantallazos_boton_modificar');

    function aplicarNivel(elemento, prefijoClase, nivel) {
        if (!elemento) {
            return;
        }

        for (var i = elemento.classList.length - 1; i >= 0; i--) {
            if (elemento.classList[i].indexOf(prefijoClase) === 0) {
                elemento.classList.remove(elemento.classList[i]);
            }
        }

        elemento.classList.add(prefijoClase + nivel);
    }

    function textoO(valor, fallback) {
        var limpio = (valor || '').trim();
        return limpio !== '' ? limpio : fallback;
    }

    function actualizarPreviewTitulos() {
        if (previewNumero1) {
            previewNumero1.textContent = textoO(numero1 ? numero1.value : '', '');
        }

        if (previewTexto1) {
            previewTexto1.textContent = textoO(texto1 ? texto1.value : '', '');
        }

        if (previewNumero2) {
            previewNumero2.textContent = textoO(numero2 ? numero2.value : '', '');
        }

        if (previewTexto2) {
            previewTexto2.textContent = textoO(texto2 ? texto2.value : '', '');
        }

        if (previewNombre) {
            previewNombre.textContent = textoO(nombreImagen ? nombreImagen.value : '', '');
        }

        aplicarNivel(previewBloque1, 'carpeta_diagramas_preview_nivel_', nivel1 ? nivel1.value : '2');
        aplicarNivel(previewBloque2, 'carpeta_diagramas_preview_nivel_', nivel2 ? nivel2.value : '3');

        if (fijoNivel1 && nivel1) {
            fijoNivel1.value = nivel1.value;
        }

        if (fijoNumero1 && numero1) {
            fijoNumero1.value = numero1.value;
        }

        if (fijoTexto1 && texto1) {
            fijoTexto1.value = texto1.value;
        }
    }

    function actualizarPreviewImagen(file) {
        if (!file || !file.type || file.type.indexOf('image/') !== 0) {
            if (imagenPrincipal) {
                imagenPrincipal.style.display = 'none';
                imagenPrincipal.removeAttribute('src');
            }
            if (imagenPreview) {
                imagenPreview.style.display = 'none';
                imagenPreview.removeAttribute('src');
            }
            if (placeholderPrincipal) {
                placeholderPrincipal.style.display = 'flex';
            }
            if (placeholderPreview) {
                placeholderPreview.style.display = 'block';
            }
            return;
        }

        var lector = new FileReader();
        lector.onload = function (evento) {
            var dataUrl = evento.target.result;

            if (imagenPrincipal) {
                imagenPrincipal.src = dataUrl;
                imagenPrincipal.style.display = 'block';
            }

            if (imagenPreview) {
                imagenPreview.src = dataUrl;
                imagenPreview.style.display = 'block';
            }

            if (placeholderPrincipal) {
                placeholderPrincipal.style.display = 'none';
            }

            if (placeholderPreview) {
                placeholderPreview.style.display = 'none';
            }
        };

        lector.readAsDataURL(file);
    }

    function desbloquearPrimerTitulo() {
        if (hiddenBloqueado) {
            hiddenBloqueado.value = '0';
        }

        if (nivel1) {
            nivel1.disabled = false;
        }

        if (numero1) {
            numero1.readOnly = false;
        }

        if (texto1) {
            texto1.readOnly = false;
            texto1.focus();
            texto1.select();
        }
    }

    if (archivo) {
        archivo.addEventListener('change', function () {
            var file = archivo.files && archivo.files.length > 0 ? archivo.files[0] : null;
            actualizarPreviewImagen(file);
        });
    }

    [nivel1, nivel2].forEach(function (campoNivel) {
        if (campoNivel) {
            campoNivel.addEventListener('change', actualizarPreviewTitulos);
        }
    });

    [numero1, texto1, numero2, texto2, nombreImagen].forEach(function (campoTexto) {
        if (campoTexto) {
            campoTexto.addEventListener('input', actualizarPreviewTitulos);
        }
    });

    if (botonGuardar) {
        botonGuardar.addEventListener('click', function () {
            if (hiddenBloqueado) {
                hiddenBloqueado.value = '1';
            }
        });
    }

    if (botonModificar) {
        botonModificar.addEventListener('click', function () {
            desbloquearPrimerTitulo();
        });
    }

    if (form) {
        form.addEventListener('submit', function () {
            actualizarPreviewTitulos();
        });
    }

    actualizarPreviewTitulos();

    var imagenInicial = (imagenPrincipal && imagenPrincipal.getAttribute('src')) ? imagenPrincipal.getAttribute('src').trim() : '';
    if (imagenInicial !== '') {
        if (imagenPrincipal) {
            imagenPrincipal.style.display = 'block';
        }
        if (imagenPreview) {
            imagenPreview.src = imagenInicial;
            imagenPreview.style.display = 'block';
        }
        if (placeholderPrincipal) {
            placeholderPrincipal.style.display = 'none';
        }
        if (placeholderPreview) {
            placeholderPreview.style.display = 'none';
        }
    } else {
        actualizarPreviewImagen(null);
    }
});
