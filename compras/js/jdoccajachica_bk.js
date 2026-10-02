$("#frmRegistroCchica").validate();
var cleaveNumeral=new Cleave("#total",{numeral:!0,numeralThousandsGroupStyle:"thousand"})

 
var cccc = newBloodhound({
  url: 'comun/json_ruc'
});

 
newTypeahead('nombre', cccc).on("typeahead:selected", function (e, datum) {
  $('input[name="cc_persona"]').val(datum.c_persona);

});

function fn_guardarCchica() {
    swalProcesando();
    var str = $("#frmRegistroCchica").serialize();
    ajax('compras/doccajachica_taps_update', str)
    .then(function (data) {
            // var data = JSON.parse(res);
        if (data.error || typeof data !== 'object') {
            throw data?.message || data;
        }
        redireccionar(data.url);
        
    }).catch(function (err) {
        swalError(err);
    });
}

var parametro = getParameterByName('opc');
if (parametro !== '') {
    fn_listarDetalleFrom();
} 

/********************************/ 
function fn_listarDetalleFrom() {
    var str = $("#frmRegistroCchica").serialize();
    obtenerDatos('divDetalleDetalleCH', 'compras/rep_compras_det_from', str);
}
 
function fn_procesarRegistro(str) {
    alertaMensaje('¿Desea procesar el Documento?', function () {
        return ajax('compras/comp_taps_update', str)
        .then(function (data) {
                
            if (data.error || typeof data !== 'object') {
                throw data?.message;
            }
            return data;
        }).catch(function (err) {
            Swal.showValidationMessage(err);
        });
    }).then(function (result) {
        if (result.value) {
            recargar(750);
        }
    });

}

function fn_anularRegistroFrom(...args) {
    var str = `cc_compra=${args[0]}&opc=${args[1]}`
    alertaMensaje('¿Desea anular el Documento?', function () {
        return ajax('compras/comp_taps_update', str)
        .then(function (data) {
                //var data = JSON.parse(res);
            if (data.error || typeof data !== 'object') {
                throw data?.message;
            }
            return data;
        }).catch(function (err) {
            Swal.showValidationMessage(err);
        });
    }).then(function (result) {
        if (result.value) {
            recargar(750);
        }
    });

}
function fn_AbrirRegistroFrom(...args) {
  var str = `cc_compra=${args[0]}&opc=${args[1]}`
  alertaMensaje('¿Desea ABRIR el Documento?', function () {
      return ajax('compras/comp_taps_update', str)
      .then(function (data) {
              //var data = JSON.parse(res);
          if (data.error || typeof data !== 'object') {
              throw data?.message;
          }
          return data;
      }).catch(function (err) {
          Swal.showValidationMessage(err);
      });
  }).then(function (result) {
      if (result.value) {
          recargar(750);
      }
  });

}
 

function fn_reporteComprasCH() {
  var str = $("#frm").serialize();
  obtenerDatos("divReporComprasCH", "compras/doccajachica_taps_listar", str, function () {
    fn_listaDataTable('table-cjachoca', {
      responsive: false,
      searching: true,
      pageLength: -1,
      lengthChange: false,
      buttons: []
  });
});
}



/***********************/
