modalLateralRegistroTemplate.addEventListener("shown.bs.offcanvas", (event) => {
  if (document.getElementById("modalRegistroXl")) {
    $(".offcanvas-backdrop").css({
      "z-index": 1056,
    });
    $(".offcanvas.offcanvas-end").css({
      "z-index": 1057,
    });
  }
});

fn_buscarRegistro();
$(`#${modalContainerXl}`)
  .parent(".modal-dialog")
  .addClass("modal-dialog-scrollable");

function fn_buscarRegistro() {
  var str = $("#frmBuscarRegistro").serializeObject();
  obtenerDatos("divListarRegistros", "colegiados/pre_lista", str);
}

function fn_buscarRegistroDetalle(str) {
  obtenerDatos(modalContainerXl, "colegiados/pre_lista_detalle", str, () =>
    modalRegistroXl.show(),
  );
}

function fn_procesarShow(str) {
  swalProcesando();
  obtenerDatos(
    modalLateralRegistroContainer,
    "colegiados/pre_from",
    str,
    () => {
      modalLateralRegistro.show();
      swalCerrar();
    },
  );
}

function listarEstadosTramitado(str) {
  obtenerDatos(
    "divListarEstadosTramitado",
    "colegiados/pre_lista_detalle_estados",
    str,
  );
}

function fn_procesarNuevoCol() {
  var str = $("#frmGrabarRegistroN").serialize();
  alertaMensaje("¿Desea procesar este documento?", function () {
    return ajax("colegiados/pre_update", str).then(function (res) {
      if (res !== "0") {
        Swal.showValidationMessage(res);
      }
    });
  }).then(function (res) {
    if (res.isConfirmed) {
      modalLateralRegistro.hide();
      listarEstadosTramitado(str);
    }
  });
}
