 fn_BuscarCerrar();
function fn_BuscarCerrar() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarCerrar", "contabilidad/cerrar_buscar", str, function () {
    
  });
}

function fn_CambiarCierre(boton) {
    var $boton = $(boton);
    if ($boton.prop('disabled')) return;

    var modulo = $boton.data('modulo');
    var anho = String($boton.data('anho'));
    var periodo = String($boton.data('periodo'));

    var $doc = $(boton.ownerDocument);
    var cc_local = $doc.find('#centralizar_cc_local').val();

    var cerrado = $boton.hasClass('cerrado');
    var nuevoEstado = cerrado ? 0 : 1;

    Swal.fire({
        title: cerrado ? '¿Abrir período?' : '¿Cerrar período?',
        text: 'Módulo: ' + modulo.toUpperCase() +
              ' | Período: ' + anho + '-' + periodo,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, confirmar',
        cancelButtonText: 'Cancelar'
    }).then(function (result) {

        if (!result.isConfirmed) return;

        $boton.prop('disabled', true);

        $.ajax({
            url: 'contabilidad/cerrar_update.php',
            type: 'POST',
            dataType: 'json',
            data: {
                cc_local: cc_local,
                anho: anho,
                periodo: periodo,
                modulo: modulo,
                estado: nuevoEstado
            }
        }).done(function (respuesta) {

            if (respuesta.ok) {
                $boton
                    .removeClass('cerrado abierto')
                    .addClass(nuevoEstado === 1 ? 'cerrado' : 'abierto')
                    .text(nuevoEstado === 1 ? '🔒 CERRADO' : '🔓 ABIERTO');

                Swal.fire({
                    title: 'Actualizado',
                    text: respuesta.mensaje || 'Estado actualizado correctamente.',
                    icon: 'success'
                });
            } else {
                alertaMensaje(respuesta.mensaje || 'No se pudo actualizar.');
            }

        }).fail(function () {
            alertaMensaje('Error al actualizar el cierre del período.');
        }).always(function () {
            $boton.prop('disabled', false);
        });
    });
}