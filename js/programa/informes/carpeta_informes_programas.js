document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('carpeta_informes_programas_formulario');
    if (!form) {
        return;
    }

    var hiddenBloqueado = document.getElementById('carpeta_informes_programas_primer_titulo_bloqueado');
    var nivel1 = document.getElementById('nivel_titulo_cip_1');
    var numero1 = document.getElementById('numero_titulo_cip_1');
    var texto1 = document.getElementById('texto_titulo_cip_1');
    var numero2 = document.getElementById('numero_titulo_cip_2');
    var texto2 = document.getElementById('texto_titulo_cip_2');

    var rutaPrincipal = document.getElementById('ruta_principal_cip');
    var sinManual = document.getElementById('sin_manual_momento_cip');
    var carpeta = document.getElementById('carpeta_cip');
    var archivo = document.getElementById('archivo_cip');
    var extension = document.getElementById('extension_cip');

    var activarExtras = document.getElementById('activar_rutas_extra_cip');
    var extra1 = document.getElementById('ruta_extra_1_cip');
    var extra2 = document.getElementById('ruta_extra_2_cip');
    var extra3 = document.getElementById('ruta_extra_3_cip');
    var extra4 = document.getElementById('ruta_extra_4_cip');
    var botonMas = document.getElementById('boton_habilitar_rutas_extra_cip');

    var botonModificar = document.getElementById('boton_modificar_titulo_cip_1');
    var botonModificarFooter = document.getElementById('boton_modificar_footer_cip');

    var previewNumero1 = document.getElementById('preview_numero_titulo_cip_1');
    var previewTexto1 = document.getElementById('preview_texto_titulo_cip_1');
    var previewNumero2 = document.getElementById('preview_numero_titulo_cip_2');
    var previewTexto2 = document.getElementById('preview_texto_titulo_cip_2');
    var previewContenido = document.getElementById('preview_contenido_cip');

    function textoO(valor, fallback) {
        var limpio = (valor || '').trim();
        return limpio !== '' ? limpio : fallback;
    }

    function setExtrasReadonly(readonly) {
        [extra1, extra2, extra3, extra4].forEach(function (campo) {
            if (campo) {
                campo.readOnly = readonly;
            }
        });
    }

    function hayValorEnExtras() {
        return [extra1, extra2, extra3, extra4].some(function (campo) {
            return campo && campo.value && campo.value.trim() !== '';
        });
    }

    function construirNombreArchivo() {
        var ruta = (carpeta && carpeta.value ? carpeta.value.trim() : '');
        var nombre = (archivo && archivo.value ? archivo.value.trim() : '');
        var ext = (extension && extension.value ? extension.value.trim() : '');

        var base = '';
        if (ruta !== '' && nombre !== '') {
            base = ruta.replace(/\/+$/g, '') + '/' + nombre.replace(/^\/+/, '');
        } else if (ruta !== '') {
            base = ruta;
        } else {
            base = nombre;
        }

        if (ext !== '') {
            base += '.' + ext.replace(/^\./, '');
        }

        return base;
    }

    function actualizarPreview() {
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

        if (previewContenido) {
            var lineas = [];
            var ruta = rutaPrincipal && rutaPrincipal.value ? rutaPrincipal.value.trim() : '';
            var archivoCompuesto = construirNombreArchivo();

            if (ruta !== '') {
                lineas.push('- ruta: ' + ruta);
            }

            if (archivoCompuesto !== '') {
                lineas.push('- archivo: ' + archivoCompuesto);
            }

            [extra1, extra2, extra3, extra4].forEach(function (campo) {
                if (campo && campo.value && campo.value.trim() !== '') {
                    lineas.push('- ruta extra: ' + campo.value.trim());
                }
            });

            if (sinManual && sinManual.checked) {
                lineas.push('- SIN MANUAL POR EL MOMENTO');
            }

            if (lineas.length === 0) {
                previewContenido.innerHTML = '';
                return;
            }

            previewContenido.innerHTML = '';
            lineas.forEach(function (linea) {
                var p = document.createElement('p');
                p.textContent = linea;
                previewContenido.appendChild(p);
            });
        }
    }

    function desbloquearPrimerTitulo() {
        if (hiddenBloqueado) {
            hiddenBloqueado.value = '0';
        }

        [nivel1, numero1, texto1].forEach(function (campo) {
            if (campo) {
                campo.readOnly = false;
                campo.disabled = false;
            }
        });

        if (texto1) {
            texto1.focus();
            texto1.select();
        }
    }

    if (activarExtras) {
        activarExtras.checked = hayValorEnExtras();
        setExtrasReadonly(!activarExtras.checked);

        activarExtras.addEventListener('change', function () {
            setExtrasReadonly(!activarExtras.checked);
            if (activarExtras.checked && extra1) {
                extra1.focus();
            }
        });
    }

    if (botonMas) {
        botonMas.addEventListener('click', function () {
            if (activarExtras) {
                activarExtras.checked = true;
            }
            setExtrasReadonly(false);
            if (extra1) {
                extra1.focus();
            }
        });
    }

    [botonModificar, botonModificarFooter].forEach(function (boton) {
        if (boton) {
            boton.addEventListener('click', desbloquearPrimerTitulo);
        }
    });

    [numero1, texto1, numero2, texto2, rutaPrincipal, carpeta, archivo, extension, extra1, extra2, extra3, extra4].forEach(function (campo) {
        if (campo) {
            campo.addEventListener('input', actualizarPreview);
        }
    });

    if (sinManual) {
        sinManual.addEventListener('change', actualizarPreview);
    }

    form.addEventListener('submit', function () {
        if (hiddenBloqueado) {
            hiddenBloqueado.value = '1';
        }
    });

    actualizarPreview();
});