$("#frmBuscarRegistro").validate();
function fn_buscarRegistro(){
    var str = $("#frmBuscarRegistro").serialize();
    obtenerDatos("divListarRegistro",'colegiados/diploma_lista', str, function(){
        //fn_listaDataTable("tabla-diplomas");
    });
}