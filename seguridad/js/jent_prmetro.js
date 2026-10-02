function fn_ejecutar(tipo) {
  alertaMensaje("&iquest;Desea procesar?", function () {
    return ajax("seguridad/ent_prm_update", `tipo=${tipo}`)
      .then((data) => {
        if (data !== "0") {
          throw new Error(data);
        }
      })
      .catch((error) => {
        Swal.showValidationMessage(error);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(1000);
    }
  });
}

function fn_ejecutarXTabla(tabla, tipo) {
  alertaMensaje(`&iquest;Desea procesar la tabla ${tabla} (${tipo})?`, function () {
    return ajax("seguridad/ent_prm_tabla_update", { tabla: tabla, tipo: tipo })
      .then((data) => {
        if (data !== "0") {
          throw new Error(data);
        }
      })
      .catch((error) => {
        Swal.showValidationMessage(error);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(1000);
    }
  });
}
