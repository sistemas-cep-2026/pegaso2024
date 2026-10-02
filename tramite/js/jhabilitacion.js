var validateForm = $('#frmGrabarRegistro').validate();

$('select.form-select.select2').select2({
    width: 'resolve',
    placeholder: $(this).data('placeholder'),
    language: {
        noResults: function () {
            return "No hay resultados";
        }
    }
});

$('select.form-select.select2').on('select2:select', function (e) {
    validateForm.form();
});

const colegiadosData = newBloodhound({ url: 'comun/json_colegiado' });
const personasData = newBloodhound({ url: 'comun/json_personasotros' });

// Inicializa el typeahead pero sin fuente fija
$('#nombres').typeahead(
    {
        hint: true,
        highlight: true,
        minLength: 3,
    },
    {
        name: 'nombres',
        display: 'nombres',
        limit: Infinity,
        templates: templates,
        source: function (query, sync, async) {
            let tipo = $('#c_tipo').val();
            if (tipo === "03") {
                colegiadosData.search(query, sync, async);
            } else {
                personasData.search(query, sync, async);
            }
        }
    }
).on("typeahead:selected", function (e, data) {
    $('#c_persona').val(data.c_persona);
});

const expedienteData = newBloodhound({ url: 'comun/json_exp_hab' });
const listaExpedienteData = newTypeahead('expediente', expedienteData);
listaExpedienteData.on("typeahead:selected", function (e, data) {
    $('#c_persona_institucion').val(data.c_persona_institucion);
    $('#nombre_institucion').val(data.nombre_institucion);
});


function fn_listarRegistroHabilitaciones() {
    var str = $('#frmListarRegistroHabilitaciones').serializeObject();
    obtenerDatos('divListarHabilitaciones', 'tramite/rep_hab_lista', str);
}


function fn_grabarRegistro() {
    var str = $('#frmGrabarRegistro').serializeObject();
    if (str.c_persona === '') {
        return swalError("Ingrese el CEP o apellidos y nombres");
    }
    alertaMensaje('¿Desea procesar la Habilitación?', function () {
        return ajax('tramite/hab_update', str).then(function (res) {
            if (!res.status) {
                console.log(res);
                throw res;
            }
            return res;
        });
    }).then((result) => {
        if (result.isConfirmed) {
            redireccionar(result.value.url, 2000, 'O');
        }
    }).catch(function (err) {
        Swal.showValidationMessage(err.message);

    });
}


function fn_anularDocumento(str) {
    alertaMensaje('¿Desea anular la Habilitación?', function () {
        return ajax('tramite/hab_update', str).then(function (res) {
            if (res !== '0') {
                Swal.showValidationMessage(res)
            }
        });
    }).then((result) => {
        if (result.isConfirmed) {
            swalOk(2000);
            fn_listarRegistroHabilitaciones();
        }
    });
}

function fn_cambioTipoDoc(value) {
    $('.temporal').toggleClass('d-none', value === '03');
}