fn_buscarRegistro();

function fn_buscarRegistro() {
	var str = $("#frmRegistro").serialize();
	obtenerDatos("divRegistros", "colegiados/obs_control_listar", str, function () {
		fn_listaDataTable('table-reporte', {
			responsive: false,
			searching: false,
			pageLength: 50,
			lengthChange: false,
			buttons: ''
		});
	});
}

function fn_controlObs(cc_personaobs, cc_persona) {
  var str = `cc_personaobs=${cc_personaobs}&cc_persona=${cc_persona}`;
  obtenerDatos(modalContainer, "colegiados/obs_control_from", str, function () {
    modalRegistro.show();
  });
}

function fn_grabarRegistro() {
    var $_ = this;
    console.log($_);
    var str = $("#frmGrabarRegistro").serialize();
    ajax('colegiados/obs_control_update', str)
    .then(function (data) {
        if (data !== "0") {
            throw data;
        }
        swalOk(750);
        modalRegistro.hide();
        fn_buscarRegistro();
    }).catch(function (err) {
        swalError(err);
    });
}

function contarRespuesta() {
  const inputField = document.getElementById('respuesta');
  const charCountLabel = document.getElementById('charCount');
  const currentLength = inputField.value.length;
  charCountLabel.textContent = `${currentLength}250`;
}