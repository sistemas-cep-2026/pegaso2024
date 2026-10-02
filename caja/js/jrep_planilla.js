

$("#frmFormRegistroMinsa").validate();

function fn_listar_entidad(c_local) {
    $.post('comun/listar_entidad_pagadora.php', { c_local }, function (html) {
        $('#c_entidad_pagadora').html(html);
    });
}

function fn_listarMinsa() {
    var str = $("#frmFormRegistroMinsa").serialize();
    obtenerDatos("divReporteMinsa", "caja/rep_planilla_minsa", str, function () {
        fn_listaDataTable('table-minsa', {
            responsive: false,
            searching: false,
            pageLength: -1,
            lengthChange: false,
            buttons: ''
        });
    });
}


function fn_listarEssalud() {
    var str = $("#frmRegistroEssalud").serialize();
    obtenerDatos("divReporteEssalud", "caja/rep_planilla_essalud", str, function () {
        fn_listaDataTable('table-minsa', {
            responsive: false,
            searching: false,
            pageLength: -1,
            lengthChange: false,
            buttons: ''
        });
    });
}


function fn_verPlanillaEssalud(periodo, cc_local) {
    var str = `periodo=${periodo}&cc_local=${cc_local}`;
    obtenerDatos(modalContainerXl, "caja/rep_planilla_essalud_detalle", str, function () {
        modalRegistroXl.show();
    });
}