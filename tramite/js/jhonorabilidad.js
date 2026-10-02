$("#frmGrabarRegistro").validate();

var dataSetArticulo = newBloodhound({
  url: 'comun/json_colegiado'
});

newTypeahead('nombre', dataSetArticulo)
  .on("typeahead:selected", function (e, datum) {
    $('input[name="c_persona"]').val(datum.c_persona);
    cargarRecaudoBBVA();
  });

$("#nombre").on("input", function () {
  $('input[name="c_persona"]').val('');
  $("#recaudo_id").html('<option value="">Selecciona persona válida</option>');
});

function cargarRecaudoBBVA() {
  var c_persona = $('input[name="c_persona"]').val();
  if (!c_persona) return;
  $.post('comun/lista_recuado_bbva.php', { c_persona: c_persona }, function (data) {
    var html = '<option value="">Selecciona</option>';
    $.each(data, function (_, item) {
      html += '<option value="' + item.id + '">' + item.nombre + '</option>';
    });

    $('#recaudo_id').html(html);

  }, 'json').fail(function () {
    $('#recaudo_id').html('<option value="">Error</option>');
  });
}


function fn_listarBuscar() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("div_listar", "tramite/hono_taps_busca", str, function () {
    fn_listarReporte();
  });
}

function fn_grabarRegistro() {
  swalProcesando();
  var str = $("#frmGrabarRegistro").serialize();
  ajax("tramite/hono_taps_update", str)
    .then(function (res) {
      if (res !== "0") {
        throw res;
      }
      swalOk(750);
      recargar(750);
    })
    .catch(function (err) {
      swalError(err);
    });
}

function fn_listarReporte() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divReporte", "tramite/hono_taps_listar", str, function () {
    fn_listaDataTable('table-reporte', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: ''
    });
  });
}

function fn_imprimir(...args) {
  var str = `${hostname}tramite/hono_taps_print?cod=${args[0]}`;
  redireccionar_ventana(str, 750);
}

function fc_anular(cc_honorab, opc) {
  alertaMensaje('&iquest;Desea anular este registro?', function () {
    var str = 'cc_honorab=' + cc_honorab + '&opc=' + opc;
    return ajax('tramite/hono_taps_update', str)
      .then(function (data) {
        if (data !== '0') {
          throw data;
        }
        return data;
      }).catch(function (err) {
        Swal.showValidationMessage(err);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(750);
      fn_listarReporte();
    }
  });
}
