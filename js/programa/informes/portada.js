/* ITred Spa - portada.js */

document.addEventListener('DOMContentLoaded', function () {
    var botonImprimir = document.getElementById('portada_boton_imprimir');

    if (botonImprimir) {
        botonImprimir.addEventListener('click', function () {
            var urlImprimir = botonImprimir.getAttribute('data-url-imprimir');

            if (!urlImprimir) {
                return;
            }

            var ventanaImpresion = window.open(urlImprimir, '_blank');

            if (!ventanaImpresion) {
                return;
            }

            ventanaImpresion.onload = function () {
                ventanaImpresion.focus();
                ventanaImpresion.print();
            };
        });
    }

    var esVistaExportacion = window.location.search.indexOf('exportar=pdf') !== -1 || window.location.search.indexOf('exportar=imprimir') !== -1;

    if (esVistaExportacion) {
        window.onload = function () {
            if (window.location.search.indexOf('exportar=pdf') !== -1) {
                window.print();
            }
        };
    }
});