$("#frmGrabarRegistro").validate();

fn_fromActividadDetalle();

function fn_fromActividadDetalle() {
  var str = $('#cc_sustento').val();
  obtenerDatos('divFromDetalle', 'rrhh/hextras_taps_sust_from?cc_sustento=' + str);
}

function fn_grabarRegistro() {
  try {
    swalProcesando();
    var str = $("#frmGrabarRegistro").serialize();
    return ajax("rrhh/hextras_taps_update", str)
      .then(function (res) {
        var mensaje = res.split("|");
        if (mensaje[0] !== "0") {
          throw res;
        }
        redireccionar(mensaje[1]);
        //fn_fromActividadDetalle();
      })
      .catch(function (err) {
        swalError(err);
      });
  } catch (err) {
    swalError(err);
  }
}


/**********Detalle*************/

function fn_grabarDetalleD() {
  swalProcesando();
  var str = $("#frmFormRegistroD").serialize();
  ajax("rrhh/hextras_taps_sust_update", str)
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

function fn_Eliminar(cc_sustento_det) {
  alertaMensaje("&iquest;Desea eliminar?", function () {
    var str = "cc_sustento_det=" + cc_sustento_det + "&opcd=E";
    return ajax("rrhh/hextras_taps_sust_update", str)
      .then(function (data) {
        if (data !== "0") {
          throw new Error(data);
        }
        return data;
      })
      .catch(function (err) {
        Swal.showValidationMessage(err);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(750);
      recargar(750);
    }
  });
}

/*segunda pestana*/

function fn_listarReporte() {
  var str = $("#frm").serialize();
  obtenerDatos("divlistarHoras", "rrhh/hextras_taps_buscar", str, function () {
    fn_reporteMensual();
  });
}

function fn_reporteMensual() {
  var str = $("#frmFormRegistroMensual").serialize();
  obtenerDatos("divReportemensual", "rrhh/hextras_taps_listar", str, function () {
    /*fn_listaDataTable('table-hextras', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: ''
    });*/
  });
}



/*consolidad*/
function fn_listarConsolidado() {
  var str = $("#frm").serialize();
  obtenerDatos("divlistarConsolidad", "rrhh/hextras_taps_consoli", str, function () {
    fn_reporteConsolidado();
  });
}

function fn_reporteConsolidado() {
  var str = $("#frmFormRegistroConsol").serialize();
  obtenerDatos("divReporteConsolidado", "rrhh/hextras_taps_consoli_lita", str, function () {
    /*fn_listaDataTable('table-hextras', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: ''
    });*/
  });
}


function updateCharacterCount() {
  const inputField = document.getElementById('obs');
  const charCountLabel = document.getElementById('charCount');
  const currentLength = inputField.value.length;
  charCountLabel.textContent = `${currentLength}/70`;
}

