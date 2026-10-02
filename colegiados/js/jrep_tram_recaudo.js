$('#fn_buscarReporteRecaudoGradosTramites').validate();

flatpickr('.input-desde', {
    dateFormat: "d/m/Y",
    locale: "es",
    maxDate: "today",
    "plugins": [new rangePlugin({ input: ".input-hasta" })],
    onChange: (selectedDates, dateStr, instance) => {
        //fn_buscarReporteRecaudoGradosTramites();
    },
});

//fn_buscarTramites();
function fn_buscarReporteRecaudoGradosTramites() {
    var str = $('#fn_buscarReporteRecaudoGradosTramites').serializeObject();
    var url = (str.tipo == 'T') ? 'colegiados/rep_tram_listar_tramites' : 'colegiados/rep_tram_listar_grados';
    obtenerDatos('divListarReporteRecaudoGradosTramites', url, str, function(){
        fn_listaDataTable('table-expedientes-recaudo',{
            pageLength: -1,
            ordering: !1,
            responsive:!1
        } )
    });
}
