fn_BuscarCerrar();

function fn_BuscarCerrar() {
    var str = $("#frm").serialize();

    obtenerDatos(
        "divBuscarCerrar",
        "contabilidad/cerrar_buscar",
        str,
        function () {}
    );
      // Ocultar indicador de carga
        $('#cargandoCerrar').hide();

        // Habilitar nuevamente el botón Buscar
        $('#btnBuscarCerrar').prop('disabled', false);
}

function fn_CambiarCierre(boton) {

    var $boton = $(boton);

    if ($boton.prop('disabled')) return;

    var modulo = $boton.attr('data-modulo');
    var anho = $boton.attr('data-anho');
    var periodo = $boton.attr('data-periodo');

    var $doc = $(boton.ownerDocument);
    var cc_local = $doc.find('#centralizar_cc_local').val();

    var cerrado = $boton.hasClass('cerrado');

    // * = CERRADO
    // & = ABIERTO
    var nuevoEstado = cerrado ? '&' : '*';

    // Bloquear los botones durante la actualización
    var $botones = $doc.find('.btn-estado');
    $botones.prop('disabled', true);

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

            // Refrescar únicamente cerrar_lista.php
            var formulario = document.getElementById(
                'formlibroCerrar'
            );

            formulario.elements['anho'].value = anho;
            formulario.elements['cc_local'].value = cc_local;

            formulario.submit();

        } else {

            $botones.prop('disabled', false);

            alertaMensaje(
                respuesta.mensaje || 
                'No se pudo actualizar el período.'
            );
        }

    }).fail(function () {

        $botones.prop('disabled', false);

        alertaMensaje(
            'Error al actualizar el cierre del período.'
        );

    });
}
function fn_AjustarIframeCerrar(iframe) {

    try {

        var doc = iframe.contentDocument ||
                  iframe.contentWindow.document;

        // Ajustar automáticamente la altura
        iframe.style.height = '0px';

        var altura = Math.max(
            doc.body.scrollHeight,
            doc.documentElement.scrollHeight
        );

        iframe.style.height = (altura + 20) + 'px';

    } catch (error) {

        console.error('Error al ajustar iframe:', error);

    } finally {

        // Ocultar indicador de carga
        $('#cargandoCerrar').hide();

        // Habilitar nuevamente el botón Buscar
        $('#btnBuscarCerrar').prop('disabled', false);

    }
}