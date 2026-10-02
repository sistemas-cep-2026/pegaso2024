//fn_buscar();

function fn_buscar() {
    var str = $("#frmBuscar").serialize();
    obtenerDatos('divListar', 'generales/perso_listar', str, function () {
        fn_listaDataTable('table_personas', {
          responsive: false,
          searching: false,
          pageLength: 30,
          lengthChange: false,
          buttons: []
      });
    });
}
 
function fn_Anular(usuario, opc) {
  alertaMensaje('&iquest;Desea Bloquear este Usuario?', function () {
    var str = 'usuario=' + usuario + '&opc=' + opc;
    return ajax('generales/perso_update', str)
      .then(function (data) {
        if (data !== '0') {
          throw data;
        }
        return data;
      }).catch(function (err) {
        Swal.showValidationMessage(err);
      });
  }).then(function (result) {
    if (result.value) {
      swalOk(750);
      fn_buscar();
    }
  });
}

function fn_control(c_persona, opc) {
  var str = `c_persona=${c_persona}&opc=${opc}`;
  obtenerDatos(modalContainer, "generales/perso_from", str, function () {
    modalRegistro.show();
  });
}

function fn_Actualizar() {
  var $_ = this;
  console.log($_);
  var str = $("#frmGrabar").serialize();
  ajax("generales/perso_update", str)
    .then(function (data) {
      if (data.error) {
        throw data;
      }
      swalOk(750);
      modalRegistro.hide();
      //recargar();
      fn_buscar();
    })
    .catch(function (err) {
      swalError(err.message);
    });
}