fn_listar();

function fn_listar() {
  obtenerDatos("divListarExcel", "bancos/excel_ing_listar", "");
}

function fn_nuevo() {
  obtenerDatos('modalRegistro .modal-content', 'bancos/excel_ing_from', '', function () {
    modalRegistro.show();
  });
}

function fn_cargarExcel() {
  var archivo = $("#archivo_import")[0].files[0];
  if (!archivo) {
    swalError("Selecciona un archivo .xlsx.");
    return;
  }
  var form = new FormData();
  form.append("archivo_import", archivo);
  swalProcesando("Cargando archivo", "Espere un momento...");
  ajaxArchivo(form, 'bancos/excel_ing_update?opc=I')
    .then(function (data) {
      swalOk(750);
      $("#archivo_import").val('');
      modalRegistro.hide();
      //fn_listar();
      location.reload();
    })
    .catch(function (err) {
      swalError(err.responseText || err.message || 'Error al cargar el archivo.');
    });
}


function fn_limpiar() {
  alertaMensaje(
    "¿Está seguro de eliminar todos los registros cargados?",
    function () {

      return ajax('bancos/excel_ing_update', 'opc=L')
        .then(function (data) {

          if (data.error) {
            throw data.message || "Error al limpiar registros";
          }

          return data;

        }).catch(function (err) {

          Swal.showValidationMessage(
            err.responseText || err.message || err
          );

        });

    }
  ).then(function (result) {

    if (result.value) {

      swalOk(750);
      //fn_listar();
      location.reload();

    }

  });

}

function fn_procesar() {
  alertaMensaje(
    "¿Desea procesar los registros importados?",
    function () {
      return ajax('bancos/excel_ing_update', 'opc=P')
        .then(function (data) {
          if (data.error) {
            throw data.message || "Error al procesar registros";
          }
          return data;
        }).catch(function (err) {
          Swal.showValidationMessage(
            err.responseText || err.message || err
          );

        });
    }
  ).then(function (result) {
    if (result.value) {
      swalOk(750);
      setTimeout(function () {
        location.reload();
      }, 750);
    }
  });
}

function fn_descargarPlantilla() {
  window.location.href = `${hostname}bancos/formatos/molde_importacion_bancos.xlsx`;
}
