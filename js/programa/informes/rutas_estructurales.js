document.addEventListener('DOMContentLoaded', function () {
    var formularios = document.querySelectorAll('[data-ruta-formulario="1"]');
    if (!formularios || formularios.length === 0) {
        return;
    }

    function valorTexto(input) {
        return input && input.value ? input.value.trim() : '';
    }

    function construirArchivo(carpeta, archivo, extension) {
        var parteCarpeta = valorTexto(carpeta);
        var parteArchivo = valorTexto(archivo);
        var parteExtension = valorTexto(extension);

        var base = '';
        if (parteCarpeta !== '' && parteArchivo !== '') {
            base = parteCarpeta.replace(/\/+$/g, '') + '/' + parteArchivo.replace(/^\/+/, '');
        } else if (parteCarpeta !== '') {
            base = parteCarpeta;
        } else {
            base = parteArchivo;
        }

        if (parteExtension !== '') {
            base += '.' + parteExtension.replace(/^\./, '');
        }

        return base;
    }

    formularios.forEach(function (form) {
        var contenedor = form.closest('[data-ruta-seccion]');
        if (!contenedor) {
            return;
        }

        var seccion = contenedor.getAttribute('data-ruta-seccion') || '';
        if (seccion === '') {
            return;
        }

        var hiddenBloqueado = document.getElementById('primer_titulo_bloqueado_ruta_' + seccion);
        var botonModificar = document.getElementById('boton_modificar_titulo_ruta_' + seccion);
        var botonModificarFooter = document.getElementById('boton_modificar_footer_ruta_' + seccion);

        var activarExtras = document.getElementById('activar_rutas_extra_' + seccion);
        var botonExtras = document.getElementById('boton_habilitar_rutas_extra_' + seccion);
        var extra1 = document.getElementById('ruta_extra_1_ruta_' + seccion);
        var extra2 = document.getElementById('ruta_extra_2_ruta_' + seccion);
        var extra3 = document.getElementById('ruta_extra_3_ruta_' + seccion);
        var extra4 = document.getElementById('ruta_extra_4_ruta_' + seccion);

        var numero1 = document.getElementById('numero_titulo_1_ruta_' + seccion);
        var texto1 = document.getElementById('texto_titulo_1_ruta_' + seccion);
        var numero2 = document.getElementById('numero_titulo_2_ruta_' + seccion);
        var texto2 = document.getElementById('texto_titulo_2_ruta_' + seccion);

        var rutaPrincipal = document.getElementById('ruta_principal_ruta_' + seccion);
        var sinManual = document.getElementById('sin_manual_momento_ruta_' + seccion);
        var carpeta = document.getElementById('carpeta_ruta_' + seccion);
        var archivo = document.getElementById('archivo_ruta_' + seccion);
        var extension = document.getElementById('extension_ruta_' + seccion);

        var preview = document.getElementById('preview_contenido_ruta_' + seccion);

        function extrasConValor() {
            return [extra1, extra2, extra3, extra4].some(function (x) {
                return valorTexto(x) !== '';
            });
        }

        function setExtrasReadonly(readonly) {
            [extra1, extra2, extra3, extra4].forEach(function (campo) {
                if (campo) {
                    campo.readOnly = readonly;
                }
            });
        }

        function actualizarPreviewTemporal() {
            if (!preview) {
                return;
            }

            var lineas = [];
            var ruta = valorTexto(rutaPrincipal);
            var archivoCompuesto = construirArchivo(carpeta, archivo, extension);

            if (ruta !== '') {
                lineas.push('- ruta: ' + ruta);
            }
            if (archivoCompuesto !== '') {
                lineas.push('- archivo: ' + archivoCompuesto);
            }

            [extra1, extra2, extra3, extra4].forEach(function (extra) {
                var valor = valorTexto(extra);
                if (valor !== '') {
                    lineas.push('- ruta extra: ' + valor);
                }
            });

            if (sinManual && sinManual.checked) {
                lineas.push('- SIN MANUAL POR EL MOMENTO');
            }

            if (lineas.length === 0) {
                return;
            }

            var contenedorTemporal = preview.querySelector('[data-temporal="1"]');
            if (!contenedorTemporal) {
                contenedorTemporal = document.createElement('div');
                contenedorTemporal.setAttribute('data-temporal', '1');
                preview.appendChild(contenedorTemporal);
            }

            contenedorTemporal.innerHTML = '';
            lineas.forEach(function (linea) {
                var p = document.createElement('p');
                p.textContent = linea;
                contenedorTemporal.appendChild(p);
            });
        }

        function desbloquearPrimerTitulo() {
            if (hiddenBloqueado) {
                hiddenBloqueado.value = '0';
            }

            ['nivel_titulo_1_ruta_', 'numero_titulo_1_ruta_', 'texto_titulo_1_ruta_'].forEach(function (prefijo) {
                var campo = document.getElementById(prefijo + seccion);
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

        [botonModificar, botonModificarFooter].forEach(function (boton) {
            if (boton) {
                boton.addEventListener('click', desbloquearPrimerTitulo);
            }
        });

        if (activarExtras) {
            activarExtras.checked = extrasConValor();
            setExtrasReadonly(!activarExtras.checked);
            activarExtras.addEventListener('change', function () {
                setExtrasReadonly(!activarExtras.checked);
                if (activarExtras.checked && extra1) {
                    extra1.focus();
                }
            });
        }

        if (botonExtras) {
            botonExtras.addEventListener('click', function () {
                if (activarExtras) {
                    activarExtras.checked = true;
                }
                setExtrasReadonly(false);
                if (extra1) {
                    extra1.focus();
                }
            });
        }

        [numero1, texto1, numero2, texto2, rutaPrincipal, carpeta, archivo, extension, extra1, extra2, extra3, extra4].forEach(function (campo) {
            if (campo) {
                campo.addEventListener('input', actualizarPreviewTemporal);
            }
        });

        if (sinManual) {
            sinManual.addEventListener('change', actualizarPreviewTemporal);
        }

        form.addEventListener('submit', function () {
            if (hiddenBloqueado) {
                hiddenBloqueado.value = '1';
            }
        });

        actualizarPreviewTemporal();
    });
});