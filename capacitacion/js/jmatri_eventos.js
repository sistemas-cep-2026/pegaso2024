
cargarEventos();
$('#cc_evento').select2({
  theme: 'default', // o 'bootstrap-5' si quieres integrarlo más
  placeholder: "Selecciona evento",
  width: '100%' // asegúrate que llene el espacio
});

function fn_reporteParticipantes() {
  var str = $("#frmBuscarParticipantes").serialize();
  obtenerDatos("divReporParticipantes", "capacitacion/matric_lista", str, function () {
    fn_listaDataTable('table_listaParticipantes', {
      ordering: true,
      responsive: false,
      searching: true,
      pageLength: 30,
      lengthChange: false,
      buttons: []
    });
  });
}

function cargarEventos() {
  var anho = $("#anho").val();
  var c_local = $("#c_local").val();
  if (anho && c_local) {
    $.ajax({
      url: 'capacitacion/eve_combo_evento.php',
      data: {
        c_local: c_local,
        anho: anho
      },
      type: 'post',
      success: function (data) {
        $("#cc_evento").html(data);
      }
    });
  } else {
    $("#cc_evento").html('<option value="">Selecciona...</option>');
  }
}

function fn_nuevoMatriculado(cc_evento) {
  var str = "cc_evento=" + cc_evento;
  obtenerDatos(modalContainer, "capacitacion/matric_buscar_from", str, function () {
    modalRegistro.show();
  });
}

function fn_nota(cc_evento_mat, cc_evento) {
  var str = `cc_evento_mat=${cc_evento_mat}&cc_evento=${cc_evento}`;
  obtenerDatos(modalContainer, "capacitacion/matric_nota_from", str, function () {
    modalRegistro.show();
  });
}


function fn_BuscarEventos() {
  var str = $("#frmEvento").serialize();
  obtenerDatos("div_buscar", "capacitacion/eve_taps_buscar", str, function () {
    cargarEventos();
  });
}

function fn_Eliminar(cc_evento_mat, opc) {
  alertaMensaje("¿Desea eliminar?", function () {
    const str = `cc_evento_mat=${cc_evento_mat}&opc=${opc}`;
    return ajax("capacitacion/matric_buscar_update", str)
      .then(data => {
        if (data !== "0") throw new Error(data);
        return data;
      })
      .catch(err => {
        Swal.showValidationMessage(err);
      });
  }).then(result => {
    if (result.value) {
      swalOk(750);
      fn_reporteParticipantes();
    }
  });
}
