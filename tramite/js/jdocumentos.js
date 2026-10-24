$("#frmRegistroDocumento").validate();

 fn_listarDetalleFrom()

function fn_guardarDocumento() {
    swalProcesando();
    var str = $("#frmRegistroDocumento").serialize();
    ajax('tramite/documen_update', str)
        .then(function (data) {
            if (data.error || typeof data !== 'object') throw data?.message || data;
            redireccionar(data.url);
        })
        .catch(swalError);
   fn_listarDetalleFrom()
}

 function fn_procesar(str) {
    alertaMensaje('¿Desea procesar el Documento?', function () {
        return ajax('tramite/documen_update', str)
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

function fn_listarDetalleFrom() {
  var str = $("#frmRegistroDocumento").serialize();
  obtenerDatos('divDetalleDetalleDoc', 'tramite/documentos_taps_det_from', str);
}

 function actualizarAreaDocumento() {

            var tipo = ($('#c_tipo_de_documento').val() || '')
                .trim()
                .toUpperCase();

            var area = $('#c_area_adm_doc');
            var areaOculta = $('#c_area_adm_doc_hidden');

            var tiposBloqueados = ['OF', 'OR', 'R', 'RR'];

            if (tiposBloqueados.includes(tipo)) {

                // Seleccionar el área 000006
                area.val('000006');

                // Actualizar Select2 y bloquear el campo
                area.trigger('change');
                area.prop('disabled', true);

                // Enviar el valor al servidor
                areaOculta.val('000006').prop('disabled', false);

            } else {

                // Habilitar el área para otros tipos
                area.prop('disabled', false);
                areaOculta.val('').prop('disabled', true);

            }
        }

        // Detectar el cambio de tipo de documento
        $('#c_tipo_de_documento').on('change', actualizarAreaDocumento);

        // Ejecutar al cargar el formulario
        actualizarAreaDocumento();
