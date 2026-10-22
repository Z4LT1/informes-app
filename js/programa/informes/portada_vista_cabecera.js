/* ITred Spa - portada_vista_cabecera.js */

document.addEventListener('DOMContentLoaded', function () {
    // INICIO ACCION IMPRIMIR: abre la vista de impresión en una nueva pestaña.
    function configurarBotonImprimir() {
        var botonImprimir = document.getElementById('portada_boton_imprimir');
        if (!botonImprimir) {
            return;
        }

        botonImprimir.addEventListener('click', function () {
            var urlImprimir = botonImprimir.getAttribute('data-url-imprimir');
            if (!urlImprimir) {
                return;
            }

            window.open(urlImprimir, '_blank');
        });
    }

    // INICIO AUTOIMPRESION PDF: al abrir exportar=pdf dispara diálogo del navegador.
    function configurarAutoImpresionPdf() {
        var esPdf = window.location.search.indexOf('exportar=pdf') !== -1;
        if (!esPdf) {
            return;
        }

        window.onload = function () {
            window.print();
        };
    }

    configurarBotonImprimir();
    configurarAutoImpresionPdf();
});
