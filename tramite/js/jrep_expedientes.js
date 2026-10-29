var CAMPOS_FILTRO_EXP = ['#fecha_desde', '#fecha_hasta', '#nombre_remitente', '#c_expediente', '#c_area_adm'];

var REGLAS_FILTRO_EXP = {
    '01': ['#c_expediente'],                                                   // EXPEDIENTE
    '02': ['#fecha_desde', '#fecha_hasta'],                                    // FECHA
    '03': ['#fecha_desde', '#fecha_hasta', '#nombre_remitente'],               // FECHA Y PERSONA
    '04': ['#fecha_desde', '#fecha_hasta', '#c_area_adm'],                     // FECHA Y AREA
    '05': ['#fecha_desde', '#fecha_hasta', '#nombre_remitente', '#c_area_adm'] // FECHA Y (PERSONA-AREA)
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
    var str = $("#frmBuscarExp").serialize();
    obtenerDatos('divReporExp', 'tramite/rep_expe_lista', str, function () {
        if (!document.getElementById('table-reporte')) {
            return;
        }
        fn_listaDataTable('table-reporte', {
            searching: false,
            lengthChange: false,
            paging: false,
            buttons: []
        });
    });
}

function fn_verSeguimientoExp(cc_docrecibidos_enc) {
    obtenerDatos(modalContainerXl, 'tramite/exp_rep_show', 'cod=' + encodeURIComponent(cc_docrecibidos_enc), function () {
        modalRegistroXl.show();
    });
}