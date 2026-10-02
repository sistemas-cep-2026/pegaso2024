if (getParameterByName("opc") !== "") {
  fn_listarRegistroDocumento();

}

$("#frmRegistroVale").validate();


var dataSetArticulo = newBloodhound({
  url: 'comun/json_ruc'
});


newTypeahead('nombre', dataSetArticulo).on("typeahead:selected", function (e, datum) {
  $('input[name="cc_persona"]').val(datum.c_persona);

});


function fn_guardar() {
  swalProcesando();
  var str = $("#frmRegistroVale").serialize();
  ajax("almacen/guia_tabs_update", str)
    .then(function (data) {
      let res = JSON.parse(data);
      if (!res.status) {
        throw res;
      }
      redireccionar(res.url);
    })
    .catch(function (err) {
      swalError(err.responseText || err.message);
    });
}


function fn_listarRegistroDocumento() {
  var str = $("#frmRegistroVale").serialize();
  var valorInput = $("#flag").val();
  str += "&flag=" + encodeURIComponent(valorInput);
  obtenerDatos("divfromDetalle", "almacen/guia_tabs_det_from", str);
  obtenerDatos("divListardetalle", "almacen/guia_tabs_det_lista", str, function () {
  });
}


function fn_guardarRegistroDetalle() {
  swalProcesando();
  var str = $("#frmFormRegistroD").serialize();
  ajax("almacen/guia_tabs_det_update", str)
    .then(function (data) {
      let res = JSON.parse(data);
      if (!res.status) {
        throw res;
      }
      //fn_listarRegistroDocumento();
      swalCerrar(750);
      recargar();
      Swal.close();
    })
    .catch(function (err) {
      swalError(err.responseText || err.message);
    });
}
function fn_eliminarDetalle(cc_guia_det, opc) {
  const str = `cc_guia_det=${cc_guia_det}&opc=${opc}`;
  swalProcesando();
  ajax("almacen/guia_tabs_det_update", str)
    .then((data) => {
      const res = JSON.parse(data);
      if (!res.status) {
        throw new Error(res.message || "Error desconocido");
      }
      swalCerrar(750);
      swalProcesando();
      recargar();
    })
    .catch((err) => {
      swalError(err.responseText || err.message);
    });
}

function fn_procesarDocumento(...arreglo) {
  alertaMensaje("&iquest;Desea Finalizar este documento?", function () {
    var str = `cc_guia=${arreglo[0]}&opc=${arreglo[1]}}`;
    return ajax("almacen/guia_tabs_update", str)
      .then(function (data) {
        let res = JSON.parse(data);
        if (!res.status) {
          throw res;
        }
        return res;
      })
      .catch(function (err) {
        return swalError(err.responseText || err.message);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(750);
      recargar();
    }
  });
}

/**segunda pestaña*/
function fn_listarBuscar() {
  var str = $("#frm").serialize();
  obtenerDatos("div_listar", "almacen/guia_tabs_busca", str, function () {
    fn_listarReporte();
  });
}

function fn_listarReporte() {
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divReporte", "almacen/guia_tabs_listar", str, function () {
    fn_listaDataTable('table-reporte', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: []
    });
  });
}

function fn_anularDocumento(...arreglo) {
  alertaMensaje("&iquest;Desea anular este documento?", function () {
    var str = `cc_guia=${arreglo[0]}&opc=${arreglo[1]}`;
    return ajax("almacen/guia_tabs_update", str)
      .then(function (data) {
        let res = JSON.parse(data);
        if (!res.status) {
          throw res;
        }
        return res;
      })
      .catch(function (err) {
        Swal.showValidationMessage(err.responseText || err.message);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(750);
      //recargar();
      fn_listarBuscar();
    }
  });
}

function fn_imprimir(cc_guia) {
  var str = `cc_guia=${cc_guia}`;
  redireccionar_ventana(`${hostname}almacen/guia_tabs_print?${str}`, 750, "P");
}

function fn_busca_requisicion(cc_guia) {
  $.ajax({
    url: 'almacen/alm_busqueda_requisicion.php',
    type: 'POST',
    data: { cc_guia: cc_guia },
    success: function (response) {
      $('#modalBodyRequisicion').html(response);
      $('#modalRequisicion').modal('show');
    },
    error: function () {
      alert('Error al cargar el modal.');
    }
  });
}

function contar_actividad() {
  const inputField = document.getElementById('justificacion');
  const charCountLabel = document.getElementById('charCount');
  const currentLength = inputField.value.length;
  charCountLabel.textContent = `${currentLength}/70`;
}
