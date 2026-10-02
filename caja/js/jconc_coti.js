$("#frmBuscarRegistro").validate();

function fn_buscarRegistro() {
    var str = $("#frmBuscarRegistro").serialize();
    obtenerDatos('divConciliacion', 'caja/concilia_coti_listar', str, function () {
        /*fn_listaDataTable('table-reporte',{
            searching: false,
            lengthChange: false,
            paging: false,
            buttons:[]
        });*/
    });
} 

function fn_concil_from(cod_anho, cod_mes) {
  var str = `cod_anho=${cod_anho}&cod_mes=${cod_mes}`;
  obtenerDatos(modalContainerSm, "caja/concilia_coti_from", str, function () {
    modalRegistroSm.show();
  });
}
function fn_imprimir(cod_anho, cod_mes, cc_local) {
  var str =`cod_anho=${cod_anho}&cod_mes=${cod_mes}&cc_local=${cc_local}`;
  redireccionar_ventana(`${hostname}caja/concilia_print?${str}`, 750, "P");
}


function fn_segundaFirma(cod_anho, cod_mes, cc_local, opc) {
  alertaMensaje('¿Desea Ratificar esta Conciliación?', () => {
    const params = `cod_anho=${cod_anho}&cod_mes=${cod_mes}&cc_local=${cc_local}&opc=${opc}`;
    
    ajax("caja/concilia_coti_update", params)
      .then((data) => {
        if (data === '0') {
          swalAdvertencia('No se pudo completar el proceso.');
        } else {
          swalCerrar(750);
          fn_buscarRegistro();
        }
      })
      .catch((error) => {
        const mensaje = error?.responseText || error?.message || 'Ocurrió un error inesperado.';
        swalError(mensaje);
      });
  });
}
