var dataSetPersonas = newBloodhound({
  url: 'comun/json_colegiado'
});

newTypeahead('varbuscarcol', dataSetPersonas).on("typeahead:selected", function (e, datum) {
  var id_pag = getParameterByName('id');
  var sec_pag = getParameterByName('sec');
  var cod = datum.c_persona;
  redireccionar(`${hostname}?id=${id_pag}&sec=${sec_pag}&cod=${cod}`, 750);
});

function fn_editperfil() {
  var str = $("#cc_persona").val();
  obtenerDatos("div_editaPerfil", "colegiados/coleg_taps_perf_from?id=" + str);
}

function fn_editGrados() {
  var cc_persona = $("#cc_persona").val();
  obtenerDatos("divEditarGrados", "colegiados/coleg_taps_grados_lista", {
    cc_persona,
  });
}
 

 

function fn_nuevoRegistroGrados(str) {
  obtenerDatos(
    modalContainerXl,
    "colegiados/coleg_taps_grados_from",
    str,
    function () {
      modalRegistroXl.show();
    }
  );
}

function fn_nuevaExoneracion(str) {
  obtenerDatos(
    modalContainerXl,
    "colegiados/coleg_taps_exo_from",
    str,
    function () {
      modalRegistroXl.show();
    }
  );
}

function fn_guardarRegistroGrados() {
  var str = $("#frmFormRegistroGrados").serializeObject();
  if (str.forma_pago === "") {
    return swalError("Debe elegir la forma de pago");
  }
  alertaMensaje("&iquest;Esta seguro de guardar los datos?", function () {
    return ajax("colegiados/coleg_taps_grados_update", str)
      .then((res) => {
        if (res !== "0") {
          Swal.showValidationMessage(res);
        }
        return res;
      })
      .catch((err) => {
        swalError(err);
      });
  }).then((result) => {
    if (result.isConfirmed) {
      swalOk(2000);
      modalRegistroXl.hide();
      fn_editGrados();
    }
  });
}

function fn_guardarRegistro() {
  alertaMensaje("&iquest;Esta seguro de guardar los datos?", function () {
    var str = $("#frmFormRegistro").serializeObject();
    return ajax("colegiados/coleg_taps_perf_update", str).then((res) => {
      if (res !== "0") {
        Swal.showValidationMessage(res);
      }
      return res;
    });
  }).then((result) => {
    if (result.value) {
      swalOk(2000);
      fn_editperfil();
    }
  });
}


function fn_guardarRegistroExoneracion() {
  var str = $("#frmFormRegistroExoneracion").serializeObject();
  alertaMensaje("&iquest;Esta seguro de guardar los datos?", function () {
    return ajax("colegiados/coleg_taps_exo_update", str)
      .then((res) => {
        if (res !== "0") {
          Swal.showValidationMessage(res);
        }
        return res;
      })
      .catch((err) => {
        swalError(err);
      });
  }).then((result) => {
    if (result.isConfirmed) {
      swalOk(2000);
      modalRegistroXl.hide();
      fn_listaExoneraciones();
    }
  });
}