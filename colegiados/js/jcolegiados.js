fn_buscarRegistro();

function fn_buscarRegistro() {
  var str = $("#frmBuscarRegistro").serialize();
  obtenerDatos(
    "divListarRegistros",
    "colegiados/coleg_listar",
    str,
    function () {
      
    }
  );
}
let timer;
$("#varbuscar").on("input", function () {
  clearTimeout(timer);
  timer = setTimeout(() => {
    
    fn_buscarRegistro();
  }, 1000);
});
