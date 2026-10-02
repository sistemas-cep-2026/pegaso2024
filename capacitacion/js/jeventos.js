fn_listarEventos();

function fn_listarEventos(pagina) {
  var str = $("#frmBuscarFiltro").serialize();
  if (pagina) {
    str += "&pagina=" + pagina;
  }
  obtenerDatos("div_listarEventosFiltro", "capacitacion/eve_listar.php", str, function () {
  });
}

function fn_verCurso(cod) {
  $("#div_listadoCursos").addClass("d-none");
  $("#div_detalleCurso").removeClass("d-none");
  obtenerDatos("div_detalleCurso", "capacitacion/eve_detalle.php", "cod=" + encodeURIComponent(cod), function () { });
}

function fn_volverCursos() {
  $("#div_detalleCurso").addClass("d-none").empty();
  $("#div_listadoCursos").removeClass("d-none");
}

function fn_verdiploma(url) {
  document.getElementById('imgModalimg').src = url;
  var modal = new bootstrap.Modal(document.getElementById('modalRegistroimg'));
  modal.show();
}

function publicar_evento(cc_evento, opc) {
  alertaMensaje("¿Desea publicar este evento?", function () {
    const str = `cc_evento=${cc_evento}&opc=${opc}`;
    return ajax("capacitacion/eve_update", str)
      .then(data => {
        data = String(data).trim();
        if (data !== "0") {
          Swal.showValidationMessage(data);
          return false;
        }
        return true;
      })
      .catch(() => {
        Swal.showValidationMessage("Error al publicar el evento");
        return false;
      });
  }).then(result => {
    if (result.value) {
      swalOk(750);
      fn_listarEventos();
    }
  });
}