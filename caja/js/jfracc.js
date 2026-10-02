var dataSetColegiados = newBloodhound({
  url: 'comun/json_colegiado'
});

newTypeahead('nombre', dataSetColegiados).on("typeahead:selected", function (e, datum) {
  $('input[name="c_persona"]').val(datum.c_persona)
});





function fn_buscarRegistro() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("div_fracc_index", "caja/fracc_listar", str, function () {
  //  fn_EstadodeCuenta();
  });
}


function fn_Eliminar(cc_fraccionamiento,opc) {
  alertaMensaje('¿Desea Eliminar este Fraccionamiento?', () => {
    var params = `cc_fraccionamiento=${cc_fraccionamiento}&opc=${opc}`;
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


function fn_fracc_from(cc_persona,deuda) {
  var str = `cc_persona=${cc_persona}&deuda=${deuda}`;
  obtenerDatos(modalContainerSm, "caja/fracc_from", str, function () {
    modalRegistroSm.show();
  });
}

function fn_imprimir(cc_fraccionamiento) {
  var str =`cc_fraccionamiento=${cc_fraccionamiento}`;
  redireccionar_ventana(`${hostname}caja/fracc_print?${str}`, 750, "P");
}

 