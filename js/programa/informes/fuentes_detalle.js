document.addEventListener('DOMContentLoaded', function () {
    var formularios = document.querySelectorAll('[data-fuente-formulario="1"]');
    if (!formularios || formularios.length === 0) {
        return;
    }

    formularios.forEach(function (form) {
        var seccionContenedor = form.closest('[data-fuente-seccion]');
        if (!seccionContenedor) {
            return;
        }

        var clave = seccionContenedor.getAttribute('data-fuente-seccion') || '';
        if (clave === '') {
            return;
        }

        var botonGuardar = document.getElementById('fuentes_btn_guardar_' + clave);
        var inputNombreFuente = document.getElementById('nombre_fuente_input_' + clave);
        var inputNumeroTitulo1 = form.querySelector('[name="numero_titulo_1_fuente"]');
        var inputTextoTitulo1 = form.querySelector('[name="texto_titulo_1_fuente"]');
        var inputNumeroTitulo2 = form.querySelector('[name="numero_titulo_2_fuente"]');
        var inputTextoTitulo2 = form.querySelector('[name="texto_titulo_2_fuente"]');
        var previewTitulo1 = document.getElementById('fuentes_preview_titulo_1_' + clave);
        var previewTitulo2 = document.getElementById('fuentes_preview_titulo_2_' + clave);

        if (!botonGuardar || !inputNombreFuente) {
            return;
        }

        function construirTitulo(numero, texto, fallback) {
            var numeroLimpio = (numero || '').trim();
            var textoLimpio = (texto || '').trim();
            var combinado = (numeroLimpio + ' ' + textoLimpio).trim();
            return combinado !== '' ? combinado : fallback;
        }

        function actualizarPreviewTitulos() {
            if (previewTitulo1) {
                previewTitulo1.textContent = construirTitulo(
                    inputNumeroTitulo1 ? inputNumeroTitulo1.value : '',
                    inputTextoTitulo1 ? inputTextoTitulo1.value : '',
                    ''
                );
            }

            if (previewTitulo2) {
                previewTitulo2.textContent = construirTitulo(
                    inputNumeroTitulo2 ? inputNumeroTitulo2.value : '',
                    inputTextoTitulo2 ? inputTextoTitulo2.value : '',
                    ''
                );
            }
        }

        [inputNumeroTitulo1, inputTextoTitulo1, inputNumeroTitulo2, inputTextoTitulo2].forEach(function (campo) {
            if (campo) {
                campo.addEventListener('input', actualizarPreviewTitulos);
                campo.addEventListener('change', actualizarPreviewTitulos);
            }
        });

        actualizarPreviewTitulos();

        botonGuardar.addEventListener('click', function () {
            var valor = window.prompt('Ingrese el nombre de la fuente (ej: Roboto-Regular.ttf):', '');
            if (valor === null) {
                return;
            }

            var limpio = valor.trim();
            if (limpio === '') {
                window.alert('Debe ingresar un nombre de fuente para guardar.');
                return;
            }

            inputNombreFuente.value = limpio;
            form.submit();
        });
    });
});