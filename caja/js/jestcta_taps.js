var dataSetColegiados = newBloodhound({
  url: 'comun/json_colegiado'
});

newTypeahead('nombre', dataSetColegiados).on("typeahead:selected", function (e, datum) {
  $('input[name="c_persona"]').val(datum.c_persona)
});


function fn_buscarRegistro() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("div_estadocta_index", "caja/estcta_taps_buscar", str, function () {
    fn_EstadodeCuenta();
  });
}

/******************/

function fn_EstadodeCuenta() {
  var str = $('#cc_persona').val();
  obtenerDatos('div_estadocuenta', 'caja/estcta_taps_estcta?cc_persona=' + str);
}
 
function fn_pagoshistoricos() {
  var str = $('#cc_persona').val();
  obtenerDatos('div_pagoshistorico', 'caja/estcta_taps_hist_pagos?cc_persona=' + str);
}
 
function fn_BeneficoFam() {
  var str = $('#cc_persona').val();
  obtenerDatos('div_beneficiofam', 'caja/rep_tabs_beneficiofam?cc_persona=' + str);
}
 
function fn_ListarExoneraciones() {
  var str = $('#cc_persona').val();
  obtenerDatos('div_listarExoneraciones', 'caja/rep_exonerac_lista?cc_persona=' + str);
}

function fn_habilitaciones() {
  var str = $('#cc_persona').val();
  obtenerDatos('div_listarHabilitaciones', 'caja/rep_habilitaciones_lista?cc_persona=' + str);
}
function fn_ListarFraccionamientos() {
  var str = $('#cc_persona').val();
  obtenerDatos('div_listarFraccionamientos', 'caja/rep_fracc_lista?cc_persona=' + str);
}
 