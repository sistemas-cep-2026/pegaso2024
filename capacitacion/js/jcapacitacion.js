cargarEventos();
$('#cc_evento').select2({
  theme: 'default', // o 'bootstrap-5' si quieres integrarlo más
  placeholder: "Selecciona evento",
  width: '100%' // asegúrate que llene el espacio
});

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

function fn_reporteParticipantes() {
  var str = $("#frmBuscarParticipantes").serialize();
  obtenerDatos("divReporParticipantes", "capacitacion/rep_cap_listar", str, function () {
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