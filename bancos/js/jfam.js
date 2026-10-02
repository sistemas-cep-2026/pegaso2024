$("#frmRegistroFam").validate();

const colegiado = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: {
    url: `${hostname}comun/json_colegiado.php`,
    replace: (url, query) => `${url}?query=${encodeURIComponent(query)}`,
    rateLimitWait: 750,
  },
});

newTypeahead('nombre', colegiado).on("typeahead:selected", function (e, datum) {
  $('input[name="cc_persona"]').val(datum.c_persona);
});
/*
$('.input-pen').inputmask({
  alias: "decimal",
  integerDigits: 10,
  digits: 2,
  allowMinus: false,
  digitsOptional: false,
  placeholder: "0.00",
  groupSeparator: ',',
  prefix: 'S/ ',
  autoGroup: true,
});*/

function fn_guardarFam() {
  alertaMensaje('¿Desea procesar este registro?', function () {
    var str = $("#frmRegistroFam").serialize();

    ajax("bancos/fam_update", str)
      .then(function (res) {
        if (res !== "0") {
          throw res;
        }
        swalOk(750);
        recargar(750);
      })
      .catch(function (err) {
        swalError(err);
      });
  });
}

function contar_actividad() {
  const inputField = document.getElementById('referencia');
  const charCountLabel = document.getElementById('charCount');
  const currentLength = inputField.value.length;
  charCountLabel.textContent = `${currentLength}/90`;
}

/****************************Segunda pestaña */
function fn_listarBuscar() {
  var str = $("#frm").serialize();
  obtenerDatos("div_listarBuscar", "bancos/fam_buscar", str, function () {
    fn_buscarFam();
  });
}

function fn_buscarFam() {
  var str = $("#frmBuscarFam").serialize();
  obtenerDatos('divListarFam', 'bancos/fam_taps_listar', str, function () {
    fn_listaDataTable('table-fam', {
      responsive: false,
      searching: false,
      pageLength: 30,
      lengthChange: false,
      buttons: []
    });
  });
}