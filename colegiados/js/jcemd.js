$('select.form-select.select2').select2({
    width: 'resolve',
    dropdownAutoWidth: true,
    placeholder: $(this).data('placeholder'),
    language: {
        noResults: function () {
            return "No hay resultados";
        }
    }
});


function fn_buscarRegistro(){
    var str = $('#frmBuscarRegistro').serialize();
    obtenerDatos('divListarRegistro','colegiados/cemd_lista',str,function(){
        fn_listaDataTable('table_cedm', {
            pageLength: -1,
        });
    })
}