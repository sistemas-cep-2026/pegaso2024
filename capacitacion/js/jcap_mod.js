cargarEventos();
$('#cc_evento').select2({
  theme: 'default',
  placeholder: "Selecciona evento",
  width: '100%'
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

function fn_reporteModulos() {
  var str = $("#frmBuscarCapMod").serialize();
  obtenerDatos("divReporCapMod", "capacitacion/cap_mod_listar", str, function () {
    fn_listaDataTable('table-cap-mod', {
      responsive: false,
      searching: false,
      pageLength: 25,
      lengthChange: false,
      buttons: []
    });
  });
}

function fn_control(cc_capmod, opc, cc_evento) {
  var str = `cc_capmod=${cc_capmod}&opc=${opc}&cc_evento=${cc_evento}`;
  obtenerDatos(modalContainer, "capacitacion/cap_mod_from", str, function () {
    modalRegistro.show();
  });
}
