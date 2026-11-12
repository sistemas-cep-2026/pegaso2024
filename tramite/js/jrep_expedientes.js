var CAMPOS_FILTRO_EXP = ['#fecha_desde', '#fecha_hasta', '#nombre_remitente', '#c_expediente', '#c_area_adm', '#c_region', '#asunto', '#nro_doc'];

var REGLAS_FILTRO_EXP = {
    '01': ['#c_expediente'],                                                   // EXPEDIENTE
    '02': ['#fecha_desde', '#fecha_hasta'],                                    // FECHA
    '03': ['#fecha_desde', '#fecha_hasta', '#nombre_remitente'],               // FECHA Y PERSONA
    '04': ['#fecha_desde', '#fecha_hasta', '#c_area_adm'],                     // FECHA Y AREA
    '05': ['#fecha_desde', '#fecha_hasta', '#nombre_remitente', '#c_area_adm'], // FECHA Y (PERSONA-AREA)
    '06': ['#fecha_desde', '#fecha_hasta', '#c_region'], // FECHA Y cr
    '07': ['#fecha_desde', '#fecha_hasta', '#asunto'], // FECHA Y asunto
    '08': ['#fecha_desde', '#fecha_hasta', '#nro_doc'] // FECHA Y nro_doc
};

function fn_aplicarFiltroExp() {
    var activos = REGLAS_FILTRO_EXP[$('#tipo_filtro').val()] || [];

    $.each(CAMPOS_FILTRO_EXP, function (i, sel) {
        var $campo = $(sel);
        var habilitar = $.inArray(sel, activos) !== -1;
        $campo.prop('disabled', !habilitar);

        if (!habilitar) {
            $campo.val('');
        } else if ((sel === '#fecha_desde' || sel === '#fecha_hasta') && !$campo.val()) {
            $campo.val($campo.prop('defaultValue'));
        }
    });
}

$(document).on('change', '#tipo_filtro', fn_aplicarFiltroExp);

$(document).on('reset', '#frmBuscarExp', function () {
    setTimeout(fn_aplicarFiltroExp, 0);
});

fn_aplicarFiltroExp();

if ($('#tipo_filtro').val() !== '01') {
    fn_buscarExp();
}

function fn_buscarExp() {
    var filtro = $('#tipo_filtro').val();
    var campo = null;
    var minimo = 0;
    var nombre = '';

    if (filtro === '07') {
        campo = $('#asunto');
        minimo = 4;
        nombre = 'La Referencia';
    } else if (filtro === '08') {
        campo = $('#nro_doc');
        minimo = 2;
        nombre = 'El número de documento';
    }

    if (campo && campo.val().trim().length < minimo) {
        alertaMensaje(nombre + ' debe tener como mínimo ' + minimo + ' caracteres.');
        campo.focus();
        return false;
    }
    var str = $("#frmBuscarExp").serialize();
    obtenerDatos('divReporExp', 'tramite/rep_expe_lista', str, function () {
        if (!document.getElementById('table-reporte')) {
            return;
        }
        fn_listaDataTable('table-reporte', {
            searching: true,
            lengthChange: false,
            paging: true,
            pageLength: 45,
            buttons: buttonsDataTable
        });
    });
}

function fn_verSeguimientoExp(cc_docrecibidos_enc) {
    obtenerDatos(modalContainerXl, 'tramite/exp_rep_show', 'cod=' + encodeURIComponent(cc_docrecibidos_enc), function () {
        modalRegistroXl.show();
    });
}