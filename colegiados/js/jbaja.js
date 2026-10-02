//typeaheadOptions.minLength = 8;
var form = $("#frmBuscarRegistro").validate();

var dataSetPersonas = newBloodhound({
  url: 'comun/json_colegiado'
});

var $str;

newTypeahead('nombres', dataSetPersonas).on("typeahead:selected", function (e, datum) {
  $str = datum;
  //fn_buscarRegistro();
});

function fn_buscarRegistro() {
  obtenerDatos("divListarRegistros", "colegiados/baja_lista", $str);
}

function fn_agregarRegistro(str) {
  swalProcesando();
  obtenerDatos(
    modalLateralRegistroContainer,
    "colegiados/baja_from",
    str,
    () => {
      modalLateralRegistro.show();
      swalCerrar();
    }
  );
}

function fn_procesarEstados() {
  var str = $("#frmGrabarRegistroN").serialize();
  alertaMensaje('¿Desea procesar este documento?', function () {
    return ajax('colegiados/baja_update', str)
      .then(function (res) {
        if (res !== '0') {
          Swal.showValidationMessage(res);
        }
      })
  }).then(function (res) {
    if (res.isConfirmed) {
      modalLateralRegistro.hide();
      fn_buscarRegistro();
    }
  });
}

function fn_abrirProcesoBaja(str) {
  swalProcesando();
  obtenerDatos(
    modalLateralRegistroContainer,
    "colegiados/baja_from_proceso",
    str,
    () => {
      modalLateralRegistro.show();
      swalCerrar();
    }
  );
}

function fn_inicioBajaCEP(str) {
  alertaMensaje([`La baja de colegiatura voluntaria se basa en la resolucion N° 038-26-CDN-CEP. Esto es solo el inicio del proceso para su posterior evaluación y aceptación`, '¿Deseas continuar con el registro?'], function () {
    return ajax('colegiados/baja_update', str)
      .then(function (res) {
        if (res !== '0') {
          Swal.showValidationMessage(res);
        }
      })
  }).then(function (result) {
    if (result.isConfirmed) {
      swalOk(1500);
      $str = str;
      fn_buscarRegistro();
    }
  });
}

function fn_procesoBaja() {
  var str = $("#frmGrabaProcesoBaja").serialize();
  alertaMensaje([`ESTE PROCESO ES EL PASO FINAL PARA EL PROCESO DE BAJA DEFINITIVA. ESTO ES UNA ACCIÓN IRREVERSIBLE, POR LO CUAL TIENE QUE SER RESPALDADA POR LAS AUTORIDADES DEL CEP CON RESOLUCIÓN EMITIDA.`, '¿Deseas procesar el registro?'], function () {
    return ajax('colegiados/baja_update', str)
      .then(function (res) {
        if (res !== '0') {
          Swal.showValidationMessage(res);
        }
      })
  }).then(function (result) {
    if (result.isConfirmed) {
      swalOk(1500);
      $str = str;
      fn_buscarRegistro();
      modalLateralRegistro.hide();
    }
  });
}
