$("#frmListarLibros").validate();

function fn_buscarLibros() {
  var str = $("#frmListarLibros").serialize();
  obtenerDatos(
    "divListarLibro",
    "colegiados/libros_lista",
    str,
    function () {}
  );
}
