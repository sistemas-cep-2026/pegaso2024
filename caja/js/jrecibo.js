$("#frmRegistroRecibo").validate();

function urlFuente() {
  var v = (($('#tipo_persona').val() || '').toString().trim().toUpperCase());
  var map = { 'C': 'comun/json_colegiado', 'E': 'comun/json_ruc' };
  return map[v] || 'comun/json_colegiado';
}

function montarTypeahead() {
  if ($('#nombre').data('ttTypeahead')) {
    $('#nombre').typeahead('destroy');
  }
  var inicializarTypeahead = newBloodhound({ url: urlFuente() });
  newTypeahead('nombre', inicializarTypeahead)
    .off('typeahead:selected')
    .on('typeahead:selected', function (e, datum) {
      $('input[name="c_persona"]').val(datum.c_persona);
    });
}

$(function () {
  montarTypeahead();
  $('#tipo_persona').on('change', function () {
    $('#nombre').val('');
    $('input[name="c_persona"]').val('');
    montarTypeahead();
  });
});

function getRCValue() {
  var $opts = $('#cod_documento option');
  var byValue = $opts.filter(function () { return $(this).val() === 'RC'; });
  if (byValue.length) return byValue.val();
  var byText = $opts.filter(function () { return $(this).text().trim().toUpperCase() === 'RC'; });
  return byText.length ? byText.val() : 'RC';
}

function toggleCodDocumento() {
  var pv = ($('#c_punto_de_venta').val() || '').toString();
  var is137 = (pv === '000137');
  var $sel = $('#cod_documento');
  var rcVal = getRCValue();

  if (is137) {
    $sel.prop('disabled', false);
    $('#cod_documento_hidden').remove();
  } else {
    $sel.val(rcVal).prop('disabled', true);
    if (!$('#cod_documento_hidden').length) {
      $('<input>', {
        type: 'hidden',
        id: 'cod_documento_hidden',
        name: 'cod_documento',
        value: rcVal
      }).appendTo('#frmRegistroRecibo');
    } else {
      $('#cod_documento_hidden').val(rcVal);
    }
  }
}

$(function () {
  $('#c_punto_de_venta').on('change', toggleCodDocumento);
  toggleCodDocumento();
});

var parametro = getParameterByName('opc');
if (parametro !== '') {
  fn_listarDetalleRecibo();
}

function fn_guardarRecibo() {
  swalProcesando();

  var $sel = $('#cod_documento');
  if ($sel.is(':disabled')) {
    var val = $sel.val() || getRCValue();
    if (!$('#cod_documento_hidden').length) {
      $('<input>', { type: 'hidden', id: 'cod_documento_hidden', name: 'cod_documento', value: val })
        .appendTo('#frmRegistroRecibo');
    } else {
      $('#cod_documento_hidden').val(val);
    }
  } else {
    $('#cod_documento_hidden').remove();
  }

  var str = $("#frmRegistroRecibo").serialize();
  ajax('caja/recib_update', str)
    .then(function (data) {
      if (data.error || typeof data !== 'object') throw (data?.message || data);
      redireccionar(data.url);
    })
    .catch(function (err) { swalError(err); });
}

/* ====== Detalle: crear/actualizar ====== */
function fn_guardarRegistroDetalle() {
  swalProcesando();
  var str = $("#frmFormRegistroD").serialize();
  ajax("caja/recib_det_update", str)
    .then(function (data) {
      let res = JSON.parse(data);
      if (!res.status) throw res;
      swalCerrar(750);
      fn_listarDetalleRecibo();
      Swal.close();
    })
    .catch(function (err) { swalError(err.responseText || err.message); });
}

function fn_EliminarDetalle(cc_ventadetall, opc) {
  alertaMensaje('¿Desea Eliminar este registro?', () => {
    var params = `cc_ventadetall=${cc_ventadetall}&opc=${opc}`;
    ajax("caja/recib_det_update", params)
      .then((data) => {
        if (data === '0') {
          swalAdvertencia('No se pudo completar el proceso.');
        } else {
          swalCerrar(750);
          fn_listarDetalleRecibo();
        }
      })
      .catch((error) => {
        var mensaje = error?.responseText || error?.message || 'Ocurrió un error inesperado.';
        swalError(mensaje);
      });
  });
}

/* ====== Pagos: crear/actualizar ====== */
function fn_guardarRegistroPagos() {
  swalProcesando();
  var str = $("#frmFormRegistroPagos").serialize();
  ajax("caja/recib_pagos_update", str)
    .then(function (data) {
      let res = JSON.parse(data);
      if (!res.status) throw res;
      swalCerrar(750);
      fn_listarDetalleRecibo();
      Swal.close();
    })
    .catch(function (err) { swalError(err.responseText || err.message); });
}

function fn_EliminarPago(cc_itemplanilla, opcp) {
  alertaMensaje('¿Desea Eliminar este registro?', () => {
    var params = `cc_itemplanilla=${cc_itemplanilla}&opcp=${opcp}`;
    ajax("caja/recib_pagos_update", params)
      .then((data) => {
        if (data === '0') {
          swalAdvertencia('No se pudo completar el proceso.');
        } else {
          swalCerrar(750);
          fn_listarDetalleRecibo();
        }
      })
      .catch((error) => {
        var mensaje = error?.responseText || error?.message || 'Ocurrió un error inesperado.';
        swalError(mensaje);
      });
  });
}

/**************** Lectura y comparación de totales ====== */
function readNum($el) {
  if (!$el.length) return 0;
  var raw = $el.is('input') ? $el.val() : ($el.data('val') ?? $el.text());
  if (!raw) return 0;
  raw = String(raw).replace(/\./g, '').replace(',', '.');
  raw = raw.replace(/[^\d.-]/g, '');
  var n = parseFloat(raw);
  return isNaN(n) ? 0 : n;
}

function validarTotales() {
  var td = readNum($('#total_detalle'));
  var tp = readNum($('#total_pagos'));
  var iguales = Math.abs(td - tp) < 0.005;
  var positivos = td > 0 && tp > 0;
  $('#btnProcesar').prop('disabled', !(iguales && positivos));
}

$(document).on('input change keyup', '#total_detalle, #total_pagos', validarTotales);
$(document).ready(validarTotales);

function fn_listarDetalleRecibo() {
  var cPersona = $("#c_persona").val();
  let formData = $("#frmRegistroRecibo").serialize();
  var ccVentas = $("#cc_ventas").val();
  var queryString = formData + '&cc_ventas=' + encodeURIComponent(ccVentas) + '&c_persona=' + encodeURIComponent(cPersona);

  obtenerDatos("divPagosRecibo", "caja/recib_pagos_from", queryString, validarTotales);
  obtenerDatos("divDetalleRecibo", "caja/recib_det_from", queryString, validarTotales);
}

/******************   otros     **** */
function fn_procesarRegistro(...arreglo) {
  alertaMensaje("¿Desea procesar este recibo?", function () {
    var str = `cc_ventas=${arreglo[0]}&opc=${arreglo[1]}`;
    return ajax("caja/recib_update", str)
      .then(function (data) {
        var res = (typeof data === "string") ? JSON.parse(data) : data;
        if (res && res.error === false) {
          if (res.url) { window.location.href = res.url; }
          return res;
        }
        throw (res && res.message) || "Error en la operación";
      })
      .catch(function (err) { return swalError(err.responseText || err.message || String(err)); });
  }).then(function (result) {
    if (result && result.value) {
      swalOk(750);
      recargar();
    }
  });
}

function fn_anularRegistroFrom(...arreglo) {
  alertaMensaje("¿Desea anular este recibo?", function () {
    var str = `cc_ventas=${arreglo[0]}&opc=${arreglo[1]}`;
    return ajax("caja/recib_update", str)
      .then(function (data) {
        var res = (typeof data === "string") ? JSON.parse(data) : data;
        if (res && res.error === false) {
          if (res.url) { window.location.href = res.url; }
          return res;
        }
        throw (res && res.message) || "Error en la operación";
      })
      .catch(function (err) { return swalError(err.responseText || err.message || String(err)); });
  }).then(function (result) {
    if (result && result.value) {
      swalOk(750);
      recargar();
    }
  });
}

function fn_anularRegistro(cc_ventas, opc) {
  alertaMensaje('¿Desea Anular este registro?', () => {
    var params = `cc_ventas=${cc_ventas}&opc=${opc}`;
    ajax("caja/recib_update", params)
      .then((data) => {
        if (data === '0') {
          swalAdvertencia('No se pudo completar el proceso.');
        } else {
          swalCerrar(750);
          fn_buscarRecibos()
        }
      })
      .catch((error) => {
        var mensaje = error?.responseText || error?.message || 'Ocurrió un error inesperado.';
        swalError(mensaje);
      });
  });
}

/**************************** Segunda pestaña */
function fn_listarBuscar() {
  var str = $("#frm").serialize();
  obtenerDatos("divlistarVentas", "caja/recib_taps_buscar", str, function () { });
  fn_buscarRecibos();
}

function fn_buscarRecibos() {
  var str = $("#frmBuscarRecibos").serialize();
  obtenerDatos('divListarRecibos', 'caja/recib_taps_buscar_listar', str, function () { });
}
