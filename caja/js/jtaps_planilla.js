fn_habilesInhabiles();
function fn_habilesInhabiles(){
  var str = $("#frm_habilesInhabiles").serialize();
  obtenerDatos("divReporHabilesIn", "caja/plani_taps_aih_listar", str, function () {
    /*fn_listaDataTable('table-reporteMensual', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: []
    });*/
  });
}
