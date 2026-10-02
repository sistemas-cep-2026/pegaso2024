fn_buscarRegistro();
fn_buscarAsientos();
function fn_buscarRegistro() {
  $('#divConciliaciondetalle').empty();
  var str = $("#frmBuscarRegistro").serialize();
  obtenerDatos('divConciliacion', 'caja/concilia_tranf_lista', str, function () {
    fn_buscarRegistroDetalle('01', cod_anho, cod_mes);
  });
}

function fn_buscarRegistroDetalle(cc_local, cod_anho, cod_mes) {
  var str = `cc_local=${cc_local}&cod_anho=${cod_anho}&cod_mes=${cod_mes}`;
  obtenerDatos('divConciliaciondetalle', 'caja/concilia_tranf_lista_detalle', str, function () {
  });
}

function fn_GuardarRegistroDetalle() {
  swalProcesando();
  var str = $("#frmGuardarRegistroDetalle").serialize();
  var cc_local = $('#cc_locald').val();
  var cod_anho = $('#cod_anhod').val();
  var cod_mes = $('#cod_mesd').val();

  ajax("caja/concilia_tranf_lista_update", str)
    .then(function (data) {
      if (data == '0') {
        fn_buscarRegistroDetalle(cc_local, cod_anho, cod_mes);
        fn_buscarRegistro();
        swalCerrar(750);
      } else {
        throw new Error(data);
      }
    })
    .catch(function (err) {
      swalError(err.message);
    });
}


function fn_imprimir(cod_anho, cod_mes) {
  var str = `cod_anho=${cod_anho}&cod_mes=${cod_mes}`;
  redireccionar_ventana(`${hostname}caja/concilia_tranf_lista_print?${str}`, 750, "P");
}

function fn_eliminarDeta(cc_transferencia, opc) {
  alertaMensaje('¿Desea Eliminar este registro?', () => {
    const params = `cc_transferencia=${cc_transferencia}&opc=${opc}`;
    var cc_local = $('#cc_locald').val();
    var cod_anho = $('#cod_anhod').val();
    var cod_mes = $('#cod_mesd').val();
    ajax("caja/concilia_tranf_lista_update", params)
      .then((data) => {
        if (data == '0') {
          fn_buscarRegistroDetalle(cc_local, cod_anho, cod_mes);
          fn_buscarRegistro();
          swalCerrar(750);
        } else {
          swalAdvertencia(data);
        }
      })
      .catch((error) => {
        const mensaje = error?.responseText || error?.message || 'Ocurrió un error inesperado.';
        swalError(mensaje);
      });
  });
}
/***********************Segunda pestana */

function fn_buscarAsientos() {
  var str = $("#frmBuscarAsientos").serialize();
  obtenerDatos('divAsientosContables', 'caja/concilia_tranf_asientos', str, function () {
  });
}
 
function fn_agregarAsiento(...arreglo) {
  alertaMensaje('¿Estás seguro de procesar/Anular?', function () {
    var str = `cc_local=${arreglo[0]}&cod_anho=${arreglo[1]}&cod_mes=${arreglo[2]}&c_usuario=${arreglo[3]}`;
    return ajax("caja/concilia_tranf_asientos_update", str)
      .then(function (data) {
        if (data !== "0") {
         // throw data;
        }
      // recargar(750, 'O');
        fn_buscarAsientos() ;
      })
      .catch(function (err) {
        Swal.showValidationMessage(err);
      });
  });
}


 
function fn_imprimirAsientos(asiento) {
  var str = `asiento=${asiento}`;
  redireccionar_ventana(`${hostname}contabilidad/asiento_print?${str}`, 750, "P");
}