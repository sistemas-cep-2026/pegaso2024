var dataSetColegiados = newBloodhound({
  url: 'comun/json_colegiado'
});

newTypeahead('nombre', dataSetColegiados).on("typeahead:selected", function (e, datum) {
  $('input[name="cc_persona"]').val(datum.c_persona)
});

function fn_buscarRegistro() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("div_index", "caja/exo_listar", str, function () {
  //  fn_EstadodeCuenta();
  });
}

function fn_nuevaExoneracion(cc_persona,opc) {
  var str = `cc_persona=${cc_persona}&opc=${opc}`;
  obtenerDatos(modalContainer, "caja/exo_from", str, function () {
    modalRegistro.show();
  });
}

function fn_Eliminar(cc_exo,opc) {
  alertaMensaje('¿Desea anular Exoneración?', () => {
    var params = `cc_exo=${cc_exo}&opc=${opc}`;
    ajax("caja/fracc_update", params)
      .then((data) => {
        if (data === '0') {
          swalAdvertencia('No se pudo completar el proceso.');
        } else {
          swalCerrar(750);
          fn_buscarRegistro();
        }
      })
      .catch((error) => {
        var mensaje = error?.responseText || error?.message || 'Ocurrió un error inesperado.';
        swalError(mensaje);
      });
  });
}

function fn_imprimir(cc_fraccionacc_exomiento) {
  var str =`cc_exo=${cc_exo}`;
  redireccionar_ventana(`${hostname}caja/exo_print?${str}`, 750, "P");
}

 