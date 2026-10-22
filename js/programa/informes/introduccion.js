/* ITred Spa - introduccion.js */

document.addEventListener('DOMContentLoaded', function () {
    var campoNivel = document.getElementById('nivel_titulo');
    var campoNumero = document.getElementById('numero_titulo');
    var campoTitulo = document.getElementById('texto_titulo');
    var campoContenido = document.getElementById('texto_contenido');
    var previewBloqueTitulo = document.getElementById('introduccion_preview_titulo_bloque');
    var previewNumero = document.getElementById('introduccion_preview_numero');
    var previewTitulo = document.getElementById('introduccion_preview_titulo');
    var previewContenido = document.getElementById('introduccion_preview_contenido');
    var lateralActual = document.getElementById('introduccion_indice_lateral_actual');
    var lateralTexto = document.getElementById('introduccion_indice_lateral_texto');
    var botonModificar = document.getElementById('introduccion_boton_modificar');

    function escaparHtml(texto) {
        return texto
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

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

    function actualizarPreview() {
        var nivel = campoNivel ? campoNivel.value : '1';
        var numero = campoNumero ? campoNumero.value.trim() : '';
        var titulo = campoTitulo ? campoTitulo.value.trim() : '';
        var contenido = campoContenido ? campoContenido.value.trim() : '';
        var textoTitulo = '';

        if (numero !== '' && titulo !== '') {
            textoTitulo = numero + '.- ' + titulo;
        } else if (numero !== '') {
            textoTitulo = numero;
        } else if (titulo !== '') {
            textoTitulo = titulo;
        } else {
            textoTitulo = '';
        }

        if (previewNumero) {
            previewNumero.textContent = numero !== '' ? numero + '.-' : '';
        }

        if (previewTitulo) {
            previewTitulo.textContent = titulo !== '' ? titulo : '';
        }

        if (previewContenido) {
            previewContenido.innerHTML = contenido !== ''
                ? escaparHtml(contenido).replace(/\n/g, '<br>')
                : '';
        }

        if (lateralTexto) {
            lateralTexto.textContent = textoTitulo;
        }

        aplicarNivel(previewBloqueTitulo, 'introduccion_preview_nivel_', nivel);
        aplicarNivel(lateralActual, 'portada_indice_lateral_nivel_', nivel);
    }

    if (campoNivel) {
        campoNivel.addEventListener('change', actualizarPreview);
    }

    if (campoNumero) {
        campoNumero.addEventListener('input', actualizarPreview);
    }

    if (campoTitulo) {
        campoTitulo.addEventListener('input', actualizarPreview);
    }

    if (campoContenido) {
        campoContenido.addEventListener('input', actualizarPreview);
    }

    if (botonModificar) {
        botonModificar.addEventListener('click', function () {
            if (campoTitulo) {
                campoTitulo.focus();
                campoTitulo.select();
            }
        });
    }

    actualizarPreview();
});
