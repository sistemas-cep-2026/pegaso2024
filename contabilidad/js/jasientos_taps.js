var ruc = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: `${hostname}comun/json_ruc`,
    replace: (url, query) => `${url}?query=${encodeURIComponent(query)}`,
    rateLimitWait: 750,
  },
});

ruc.initialize();

  // Opciones para Typeahead
var typeaheadOptions = {
  hint: true,
  highlight: true,
  minLength: 4,
};

  // Plantillas para mensajes en Typeahead
var templates = {
  empty: Handlebars.compile(
    `<div class="text-danger ms-1"><b><i class="fa fa-search"></i> No hay resultados</b></div>`
    ),
  pending: Handlebars.compile(
    `<div class="ms-1"><b><i class="fa fa-spinner fa-spin"></i> Buscando datos</b></div>`
    ),
};

  // Opciones para la fuente de datos
var nameOptions = {
  name: "articulos",
  display: "nombres",
  source: ruc.ttAdapter(),
  limit: 15,
  templates: templates,
};

  // Inicializar Typeahead
$("#nombre")
.typeahead(typeaheadOptions, nameOptions)
.bind("typeahead:selected", function (obj, datum) {
      // Actualizar valores en los campos de entrada
  $('input[name="c_persona"]').val(datum.c_persona);

});

function fn_guardarVoucher() {
  swalProcesando();
  var str = $("#frmRegistroVoucher").serialize();
  ajax('contabilidad/asient_taps_update', str)
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

function fn_listarDetalleFrom() {
    var str = $("#frmRegistroVoucher").serialize();
    obtenerDatos('divDetalleDetallevoucher', 'contabilidad/asient_taps_det_from', str);
}




/*segunda pestana*/

function fn_BuscarVoucher() {
  var str = $("#frm").serialize();
  obtenerDatos("divlistarVoucher", "contabilidad/asient_taps_buscar", str, function () {
    fn_reporteVoucher();
  });
}

function fn_reporteVoucher() {
  var str = $("#frmListarRegistros").serialize();
  obtenerDatos("divReporCompras", "compras/rep_compras_listar", str, function () {
    /*fn_listaDataTable('table-hextras', {
      responsive: false,
      searching: false,
      pageLength: -1,
      lengthChange: false,
      buttons: ''
    });*/
  });
}