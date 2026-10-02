$("#frmRegistroEgresos").validate();

// Configuración de Bloodhound para búsqueda remota
const colegiado = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: `${hostname}comun/json_colegiado.php`,
    replace: (url, query) => `${url}?query=${encodeURIComponent(query)}`,
    rateLimitWait: 750,
  },
});

newTypeahead('nombre', colegiado).on("typeahead:selected", function (e, datum) {
  $('input[name="cc_persona"]').val(datum.c_persona);
});


function fn_guardarDietas() {
  swalProcesando();
  var str = $("#frmRegistroDietas").serialize();
  ajax('bancos/dietas_update', str)
    .then(function (data) {
      if (data.error || typeof data !== 'object') {
        throw data?.message || data;
      }
      redireccionar(data.url);
      fn_listarDetalleFromDietas();
    }).catch(function (err) {
      swalError(err);
    });
}

var parametro = getParameterByName('opc');
if (parametro !== '') {
  fn_listarDetalleFromDietas();
}

function fn_listarDetalleFromDietas() {
  var str = $("#frmRegistroDietas").serialize();
  obtenerDatos('divDetalleIngresos', 'bancos/dietas_detalle_from', str);
}



function fn_procesarRegistro(str) {
  alertaMensaje('¿Desea procesar la Dieta?', function () {
    return ajax('bancos/dietas_update', str)
      .then(function (data) {
        //var data = JSON.parse(res);
        if (data.error || typeof data !== 'object') {
          throw data?.message;
        }
        return data;
      }).catch(function (err) {
        Swal.showValidationMessage(err);
      });
  }).then(function (result) {
    if (result.value) {
      recargar(750);
    }
  });

}
function fn_AbrirRegistroFrom(...args) {
  var str = `cc_dietas=${args[0]}&opc=${args[1]}`
  alertaMensaje('¿Desea ABRIR la Dieta?', function () {
    return ajax('bancos/dietas_update', str)
      .then(function (data) {
        if (data.error || typeof data !== 'object') {
          throw data?.message;
        }
        return data;
      }).catch(function (err) {
        Swal.showValidationMessage(err);
      });
  }).then(function (result) {
    if (result.value) {
      recargar(750);
    }
  });

}

/****************************Segunda pestaña */
/*function fn_listarBuscar() {
  var str = $("#frm").serialize();
  obtenerDatos("div_listarBuscar", "bancos/dietas_taps_buscar", str, function () {
    fn_buscarIngresos();
  });
}*/

function fn_buscarDietas() {
  var str = $("#frmBuscarDietas").serialize();
  obtenerDatos('div_listarBuscar', 'bancos/dietas_taps_buscar_listar', str, function () {
  });
}