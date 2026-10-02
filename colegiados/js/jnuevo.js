typeaheadOptions.minLength = 8;
var form = $("#frmBuscarRegistro").validate();

var dataSetPersonas = newBloodhound({
  url: 'comun/json_personas_pre_matricula'
});

var $str;

newTypeahead('nombres', dataSetPersonas).on("typeahead:selected", function (e, datum) {
  $str = datum;
  fn_buscarRegistro();
});

function fn_buscarRegistro() {
  obtenerDatos("divListarRegistros", "colegiados/nvo_lista", $str);
}


function fn_procesarNuevoCEP() {
  var str = $('#frmRegistroNuevoCEP').serializeObject();
  alertaMensaje([`Se asignará el CEP: <b>${str.cep}</b> a <br><b>${str.nombre}</b>`, '¿Deseas procesar el registro?'], function () {
    return ajax('colegiados/nvo_update', str)
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
      $("#nombre").val("");
      $("#nombre").trigger('propertychange.typeahead');
    }
  });
}

function fn_procesarShow(str) {
  swalProcesando();
  obtenerDatos(
    modalLateralRegistroContainer,
    "colegiados/pre_from_cn",
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
    return ajax('colegiados/pre_update', str)
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