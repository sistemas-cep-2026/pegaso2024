fn_buscarUsuarios();

function fn_buscarUsuarios() {
    var str = $("#frmBuscarUsuarios").serialize();
    obtenerDatos('divListarUsuarios', 'seguridad/usu_listar', str, function () {
        fn_listaDataTable('table_usuarios', {
          ordering: true,
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
    return ajax('seguridad/usu_update', str)
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
      fn_buscarUsuarios();
    }
  });
}

function fn_controlClave(usuario, opc) {
  var str = `usuario=${usuario}&opc=${opc}`;
  obtenerDatos(modalContainer, "seguridad/usu_from_clave", str, function () {
    modalRegistro.show();
  });
}

function fn_control(usuario, opc) {
  var str = `usuario=${usuario}&opc=${opc}`;
  obtenerDatos(modalContainer, "seguridad/usu_from", str, function () {
    modalRegistro.show();
  });
}

function fn_ActualizarClave() {
  var $_ = this;
  console.log($_);
  var str = $("#frmGrabarClave").serialize();
  ajax("seguridad/usu_update", str)
    .then(function (data) {
      if (data !== "0") {
        throw data;
      }
      swalOk(750);
      modalRegistro.hide();
      //recargar();
      fn_buscarUsuarios();
    })
    .catch(function (err) {
      swalError(err);
    });
}