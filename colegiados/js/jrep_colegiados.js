const table_colegiados = fn_listaDataTable("table_colegiados", {
  searching: false,
  pageLength: -1,
  ajax: {
    url: `${hostname}colegiados/rep_coleg_listar`,
    data: function () {
      return $("#frmBuscarRegistro").serialize();
    },
    type: "POST",
  },
  columns: [
    { data: "row_id" },
    { data: "cep" },
    { data: "nombre_completo" },
    { data: "cod_mun_documento_text" },
    { data: "c_local_abv" },
    { data: "fecha_col" },
    { data: "fecha_nac" },
    { data: "Email1" },
    { data: "celular1" },
    { data: "flag_activo_text", className: "text-uppercase" },
    { data: "flag_habil_text" },
    {
      data: "abono_favor",
      className: "text-end",
    },
  ],
  columnDefs: [
    {
      orderable: false,
    },
  ],
  processing: true,
  headerCallback: function (thead, data, start, end, display) {
      $(thead)
        .find("th")
        .eq(0)
        .find("span#fecha")
        .html(moment().format("D/MM/Y HH:m"));
    },

});

table_colegiados.on("preXhr.dt", function () {
  toast({
    icon: "info",
    title: "Cargando datos...",
  });
});

function fn_buscarRegistro() {
  table_colegiados.ajax.reload(null, false);
}
