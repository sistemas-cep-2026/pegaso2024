$("#frmRegistroIngresos").validate();

// Configuración de Bloodhound para búsqueda remota
const ruc = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: `${hostname}comun/json_personas_general`,
    replace: (url, query) => `${url}?query=${encodeURIComponent(query)}`,
    rateLimitWait: 750,
  },
});

var cccc = newBloodhound({
  url: 'comun/json_ruc'
});

newTypeahead('nombre', cccc).on("typeahead:selected", function (e, datum) {
  $('input[name="cc_persona"]').val(datum.c_persona);

});


function fn_guardarIngresos() {
  swalProcesando();
  let str = $("#frmRegistroIngresos").serialize();
  ajax('bancos/ingresos_update', str)
    .then(function (data) {
      if (!data || typeof data !== 'object') {
        throw "Respuesta inválida del servidor";
      }
      if (data.error) {
        throw data.message || "Error al guardar";
      }
      fn_listarDetalleFromIngresos();
      if (data.url) {
        redireccionar(data.url);
      }
    })
    .catch(function (err) {
      swalError(err);
    });
}

let parametro = getParameterByName('opc');

if (parametro) {
  fn_listarDetalleFromIngresos();
}

function fn_listarDetalleFromIngresos() {
  let str = $("#frmRegistroIngresos").serialize();
  obtenerDatos('divDetalleIngresos', 'bancos/ingresos_detalle_from', str);
}

function fn_procesarRegistro(str) {
  alertaMensaje('¿Desea procesar el Documento?', function () {
    return ajax('bancos/ingresos_update', str)
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
  var str = `cc_documento=${args[0]}&opc=${args[1]}`
  alertaMensaje('¿Desea abrir este registro?', function () {
    return ajax('bancos/ingresos_update', str)
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

function fn_anularRegistroFrom(...args) {
  var str = `cc_documento=${args[0]}&opc=${args[1]}`
  alertaMensaje('¿Desea anular este registro?', function () {
    return ajax('bancos/ingresos_update', str)
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
      //recargar(750);
      fn_buscarIngresos();
    }
  });

}

/****************************Segunda pestaña */
function fn_listarBuscar() {
  var str = $("#frm").serialize();
  obtenerDatos("div_listarBuscar", "bancos/ingresos_taps_buscar", str, function () {
    fn_buscarIngresos();
  });
}

function fn_buscarIngresos() {
  var str = $("#frmBuscarIngresos").serialize();
  obtenerDatos('divListarIngresos', 'bancos/ingresos_taps_buscar_listar', str, function () {
  });
}