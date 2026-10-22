/* ITred Spa - documentacion_caso_uso.js */

document.addEventListener('DOMContentLoaded', function () {
    var campos = {
        nivel1: document.getElementById('nivel_titulo_doc_1'),
        nivel2: document.getElementById('nivel_titulo_doc_2'),
        nivel3: document.getElementById('nivel_titulo_doc_3'),
        numero1: document.getElementById('numero_titulo_doc_1'),
        numero2: document.getElementById('numero_titulo_doc_2'),
        numero3: document.getElementById('numero_titulo_doc_3'),
        texto1: document.getElementById('texto_titulo_doc_1'),
        texto2: document.getElementById('texto_titulo_doc_2'),
        texto3: document.getElementById('texto_titulo_doc_3'),
        contenido: document.getElementById('texto_contenido_doc')
    };

    var preview = {
        bloque1: document.getElementById('documentacion_caso_uso_preview_titulo_1'),
        bloque2: document.getElementById('documentacion_caso_uso_preview_titulo_2'),
        bloque3: document.getElementById('documentacion_caso_uso_preview_titulo_3'),
        numero1: document.getElementById('documentacion_caso_uso_preview_numero_1'),
        numero2: document.getElementById('documentacion_caso_uso_preview_numero_2'),
        numero3: document.getElementById('documentacion_caso_uso_preview_numero_3'),
        texto1: document.getElementById('documentacion_caso_uso_preview_texto_1'),
        texto2: document.getElementById('documentacion_caso_uso_preview_texto_2'),
        texto3: document.getElementById('documentacion_caso_uso_preview_texto_3'),
        contenido: document.getElementById('documentacion_caso_uso_preview_contenido'),
        subtitulo: document.getElementById('documentacion_caso_uso_subtitulo')
    };

    var botonModificar = document.getElementById('documentacion_caso_uso_boton_modificar');

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

    function valorO(valor, fallback) {
        var limpio = (valor || '').trim();
        return limpio !== '' ? limpio : fallback;
    }

    function actualizarPreview() {
        var numero1 = valorO(campos.numero1 ? campos.numero1.value : '', '');
        var numero2 = valorO(campos.numero2 ? campos.numero2.value : '', '');
        var numero3 = valorO(campos.numero3 ? campos.numero3.value : '', '');
        var texto1 = valorO(campos.texto1 ? campos.texto1.value : '', '');
        var texto2 = valorO(campos.texto2 ? campos.texto2.value : '', '');
        var texto3 = valorO(campos.texto3 ? campos.texto3.value : '', '');
        var contenido = (campos.contenido ? campos.contenido.value : '').trim();

        if (preview.numero1) { preview.numero1.textContent = numero1; }
        if (preview.numero2) { preview.numero2.textContent = numero2; }
        if (preview.numero3) { preview.numero3.textContent = numero3; }
        if (preview.texto1) { preview.texto1.textContent = texto1; }
        if (preview.texto2) { preview.texto2.textContent = texto2; }
        if (preview.texto3) { preview.texto3.textContent = texto3; }
        if (preview.subtitulo) { preview.subtitulo.textContent = texto3; }

        if (preview.contenido) {
            preview.contenido.innerHTML = contenido !== ''
                ? escaparHtml(contenido).replace(/\n/g, '<br>')
                : '';
        }

        aplicarNivel(preview.bloque1, 'documentacion_caso_uso_preview_nivel_', campos.nivel1 ? campos.nivel1.value : '1');
        aplicarNivel(preview.bloque2, 'documentacion_caso_uso_preview_nivel_', campos.nivel2 ? campos.nivel2.value : '2');
        aplicarNivel(preview.bloque3, 'documentacion_caso_uso_preview_nivel_', campos.nivel3 ? campos.nivel3.value : '3');
    }

    Object.keys(campos).forEach(function (key) {
        if (!campos[key]) {
            return;
        }

        var evento = key.indexOf('nivel') === 0 ? 'change' : 'input';
        campos[key].addEventListener(evento, actualizarPreview);
    });

    if (botonModificar) {
        botonModificar.addEventListener('click', function () {
            if (campos.texto1) {
                campos.texto1.focus();
                campos.texto1.select();
            }
        });
    }

    actualizarPreview();
});
