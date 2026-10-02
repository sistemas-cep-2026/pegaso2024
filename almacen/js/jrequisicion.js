if (getParameterByName("opc") !== "") {
  fn_listarRegistroDocumento();

}

$("#frmRegistroVale").validate();

function fn_guardar() {
  swalProcesando();
  var str = $("#frmRegistroVale").serialize();
  ajax("almacen/requisicion_tabs_update", str)
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
  obtenerDatos("divfromDetalle", "almacen/requisicion_tabs_det_from", str);
  obtenerDatos("divListardetalle", "almacen/requisicion_tabs_det_lista", str, function () {
  });
}


function fn_guardarRegistroDetalle() {
  swalProcesando();
  var str = $("#frmFormRegistroD").serialize();
  ajax("almacen/requisicion_tabs_det_update", str)
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

function fn_eliminarDetalle(...arreglo) {
  const [cc_requisicion_det, opc] = arreglo;
  const str = `cc_requisicion_det=${cc_requisicion_det}&opc=${opc}`;

  Swal.fire({
    title: "¿Estás seguro de Eliminar?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      swalProcesando();

      ajax("almacen/requisicion_tabs_det_update", str)
        .then((data) => {
          const res = JSON.parse(data);
          if (!res.status) {
            throw new Error(res.message || "Error desconocido");
          }
          swalCerrar(750);
          recargar();
          Swal.fire("Eliminado", "El registro se ha eliminado correctamente.", "success");
        })
        .catch((err) => {
          swalError(err.responseText || err.message);
        });
    }
  });
}

function fn_procesarDocumento(...arreglo) {
  alertaMensaje("&iquest;Desea Finalizar este documento?", function () {
    var str = `cc_requisicion=${arreglo[0]}&opc=${arreglo[1]}}`;
    return ajax("almacen/requisicion_tabs_update", str)
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
  obtenerDatos("div_listar", "almacen/requisicion_tabs_busca", str, function () {
    fn_listarReporte();
  });
}

function fn_listarReporte(){
  var str = $("#frmFormRegistro").serialize();
  obtenerDatos("divReporte", "almacen/requisicion_tabs_listar", str, function () {
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
    var str = `cc_requisicion=${arreglo[0]}&opc=${arreglo[1]}`;
    return ajax("almacen/requisicion_tabs_update", str)
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

function fn_imprimir(cc_requisicion) {
  var str = `cc_requisicion=${cc_requisicion}`;
  redireccionar_ventana(`${hostname}almacen/requisicion_tabs_print?${str}`, 750, "P");
}

function contar_actividad() {
  const inputField = document.getElementById('justificacion');
  const charCountLabel = document.getElementById('charCount');
  const currentLength = inputField.value.length;
  charCountLabel.textContent = `${currentLength}/70`;
  

}