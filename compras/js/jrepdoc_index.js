$("#frmFormRegistro").validate();

var cccc = newBloodhound({
  url: 'comun/json_ruc'
});


newTypeahead('nombre', cccc).on("typeahead:selected", function (e, datum) {
  $('input[name="cc_persona"]').val(datum.c_persona);

});



function fn_buscarRegistro() {
    var str = $("#frmFormRegistro").serialize();
    var flag_todos = $("#flag_todos").val();
    var url = "";
    if (flag_todos === "1") {
        // Todos los Consejos y todos los años
        url = "compras/comp_repdoc_lista_todos.php";
    } else {
        // Consulta normal por Consejo y Año
        url = "compras/comp_repdoc_lista.php";
    }
    obtenerDatos(
        "div_documentos",
        url,
        str,
        function () {
        }
    );
}
 