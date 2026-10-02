(function ($) {
  $("#frmBuscarRegistro").validate();
})(jQuery);

function fn_listarRegistro() {
  var str = $("#frmBuscarRegistro").serialize();
  obtenerDatos("div_listarRegistro", "capacitacion/asis_cap_listar", str, function () {
  });
}

var dataSetColegiados = newBloodhound({
  url: 'comun/json_personas_todos'
});

newTypeahead('nombre', dataSetColegiados).on("typeahead:selected", function (e, datum) {
  $('input[name="c_persona"]').val(datum.c_persona);
  setTimeout(function () {
    $('#nombre').closest('form').trigger('submit');
  }, 100);

});

function fn_control(c_persona, opc) {
  var str = `c_persona=${c_persona}&opc=${opc}`;
  obtenerDatos(modalContainer, "generales/pers_cap_from", str, function () {
    modalRegistro.show();
  });
}

function fn_guardarRegistro() {
  swalProcesando();
  var str = $("#frmFormRegistro").serialize();
  ajax("generales/pers_cap_update", str)
    .then(function (data) {
      if (data !== "0") {
        throw data;
      }
      swalOk(750);
      modalRegistro.hide();
      //fn_listarRegistro();
    })
    .catch(function (err) {
      swalError(err);
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

function fn_asistente(cc_persona, cc_evento, fecha, opc) {

  alertaMensaje("¿Desea registrar la asistencia?", function () {

    const str = `cc_persona=${encodeURIComponent(cc_persona)}`
      + `&cc_evento=${encodeURIComponent(cc_evento)}`
      + `&fecha=${encodeURIComponent(fecha)}`
      + `&opc=${encodeURIComponent(opc)}`;

    return ajax("capacitacion/asis_update", str)
      .then(data => {
        if (data !== "0") {
          throw new Error(data);
        }
        return data;
      })
      .catch(err => {
        Swal.showValidationMessage(err.message);
      });

  }).then(result => {

    if (result.value) {
      swalOk(750);
      $('input[name="c_persona"]').val('');
      $('#nombre').typeahead('val', '');
      $('#nombre').val('');
      $('#div_listarRegistro').html('');
      $('.tt-menu').hide();
      $('#nombre').focus();
    }

  });
}