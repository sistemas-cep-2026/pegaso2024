flatpickr('.input-desde', {
    dateFormat: "d/m/Y",
    locale: "es",
    maxDate: "today",
    "plugins": [new rangePlugin({ input: ".input-hasta" })],

});
fn_buscarRegistro();
function fn_buscarRegistro() {
    var str = $('#frmBuscarRegistro').serialize();
    obtenerDatos('divListarRegistro','colegiados/pre_listado_lista', str,function(){
        fn_listaDataTable('table_pre_matricula_recuado',{
            pageLength: -1,
        });
    });
}