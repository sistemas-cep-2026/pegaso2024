$("#frmFormRegistro").validate();

 var cccc = newBloodhound({
  url: 'comun/json_ruc'
});


newTypeahead('nombre', cccc).on("typeahead:selected", function (e, datum) {
  $('input[name="cc_persona"]').val(datum.c_persona);

});

function fn_buscarRegistro() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("div_documentos", "compras/comp_seguimiento_lista.php", str, function () {
     
  });
}
 