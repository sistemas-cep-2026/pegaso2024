$("#frmGrabarRegistro").validate();

var dataSetArticulo = newBloodhound({
  url: 'comun/json_colegiado'
});

newTypeahead('nombre', dataSetArticulo).on("typeahead:selected", function (e, datum) {
  $('input[name="c_persona"]').val(datum.c_persona)
});


function fn_listarBuscar() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("div_listar", "tramite/discapacidad_taps_busca", str, function () {
    fn_listarReporte();
  });
}

function fn_listarReporte() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divReporte", "tramite/discapacidad_taps_listar", str, function () {
    fn_listaDataTable('table-reporte', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: ''
    });
  });
}

function fn_grabarRegistro() {
  swalProcesando();
  var str = $("#frmGrabarRegistro").serialize();
  ajax('tramite/discapacidad_taps_update', str)
    .then(function (data) {
      if (typeof data === 'string') data = JSON.parse(data);
      if (!data || data.error) {
        throw data?.message || 'Error al procesar la operación';
      }
      data.url
        ? redireccionar(data.url)
        : swalExito('Operación realizada correctamente');

    })
    .catch(function (err) {
      swalError(err);
    });
}




function fn_imprimir(...args) {
  var str = `${hostname}tramite/discapacidad_taps_print?cod=${args[0]}`;
  redireccionar_ventana(str, 750);
}

function fc_anular(id, opc) {
  alertaMensaje('&iquest;Desea anular este registro?', function () {
    var str = 'id=' + id + '&opc=' + opc;
    return ajax('tramite/discapacidad_taps_update', str)
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