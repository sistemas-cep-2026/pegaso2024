$("#frmRegistroEgresos").validate();

var dataSetColegiados = newBloodhound({
  url: 'comun/json_colegiado'
});

var dataSetEmpresas = newBloodhound({
  url: 'comun/json_ruc'
});

$(`#nombre`).typeahead(typeaheadOptions, {
  name: 'nombres',
  display: 'nombres',
  limit: 15,
  templates: templates,
  source: function (query, sync, async) {
    let tipo = $('#tipo_persona').val();
    let m = $.trim(query).match(/^(\d{6,11})\s*-/);
    let q = m ? m[1] : query;
    if (tipo === "C") {
      dataSetColegiados.search(q, sync, async);
    } else {
      dataSetEmpresas.search(q, sync, async);
    }
  }
}).bind("typeahead:selected", function (_, datum) {
  $("#c_persona").val(datum.c_persona);
});


/*******************/


function fn_guardarEgresos() {
  swalProcesando();
  var str = $("#frmRegistroEgresos").serialize();
  ajax('bancos/egresos_update', str)
    .then(function (data) {
      if (data.error || typeof data !== 'object') {
        throw data?.message || data;
      }
      redireccionar(data.url);

    }).catch(function (err) {
      swalError(err);
    });
}

var parametro = getParameterByName('opc');
if (parametro !== '') {
  fn_listarDetalleFromEgresos();
}

function fn_listarDetalleFromEgresos() {
  var str = $("#frmRegistroEgresos").serialize();
  obtenerDatos('divDetalleEgresos', 'bancos/egresos_detalle_from', str);
}

function fn_procesarRegistro(str) {
  alertaMensaje('¿Desea procesar el Documento?', function () {
    return ajax('bancos/egresos_update', str)
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
      fn_buscarEgresos();
    }
  });

}

function fn_AbrirRegistroFrom(...args) {
  var str = `cc_documento=${args[0]}&opc=${args[1]}`
  alertaMensaje('¿Desea abrir este registro?', function () {
    return ajax('bancos/egresos_update', str)
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

function mostrarCajaChica() {
  var activo = $('#cajachica').is(':checked');
  if (activo) {
    $('#c_liquidacion_caja_chica').prop('disabled', false);
  } else {
    $('#c_liquidacion_caja_chica').prop('disabled', true).val('');
  }
}

$('#cajachica').on('change', function () {
  mostrarCajaChica();
});

mostrarCajaChica();

/******************************* *
  procesar el detalle de la caja chica
 /*********************** */

function fn_recibosCaja(cc_documento, opc) {
  alertaMensaje('¿Desea procesar los registros de caja?', function () {
    var str = 'cc_documento=' + cc_documento + '&opc=' + opc;
    return ajax('bancos/egresos_update', str);
  }).then(function (result) {
    if (result.value) {
      swalOk(750);
      setTimeout(function () {
        location.reload();
      }, 750);
    }
  });
}
/******************************* *
  Modal para cargar cuentas detalle
 /*********************** */
function fn_showCompras(el) {
  var $row = el.closest('tr');
  var str = $row.find(':input').serialize();
  obtenerDatos(modalContainerXl, "bancos/egresos_detalle_show", str, function () {
    modalRegistroXl.show();
  });
}


/****************************Segunda pestaña */
function fn_listarBuscar() {
  var str = $("#frm").serialize();
  obtenerDatos("div_listarBuscar", "bancos/egresos_taps_buscar", str, function () {
    fn_buscarEgresos();
  });
}

function fn_buscarEgresos() {
  var str = $("#frmBuscarEgresos").serialize();
  obtenerDatos('divListarEgresos', 'bancos/egresos_taps_buscar_listar', str, function () {
    fn_listaDataTable('table-egreso', {
      responsive: false,
      searching: false,
      pageLength: 25,
      lengthChange: false,
      buttons: []
    });
  });
}