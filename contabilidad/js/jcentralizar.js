fn_BuscarCompras();
function fn_BuscarCompras() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarCompras", "contabilidad/centralizar_compras_buscar", str, function () {
    //fn_listarReporte();
  });
}

function fn_BuscarBancos(cc_local) {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarBancos", "contabilidad/centralizar_bancos_buscar.php", str, function () {
    //fn_listarReporte();
   // fn_listar_banco(cc_local);
  });
}

function fn_BuscarVentas() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarVentas", "contabilidad/centralizar_ventas_buscar.php", str, function () {
    //fn_listarReporte();
  
  });
}



 function fn_BuscarPlanilla728() {
  var str = $("#frm").serialize();
  obtenerDatos("divBuscarPlanilla728", "contabilidad/centralizar_planilla728_buscar.php", str, function () {
    //fn_listarReporte();
  });
}
 
 

function fn_ProcesarCompras(boton) {
  var $boton = $(boton);
  if ($boton.prop('disabled')) return;

  var $doc = $(boton.ownerDocument);
  var cc_local = $doc.find('#centralizar_cc_local').val();
  var anho = $doc.find('#centralizar_anho').val();
  var periodo = $doc.find('#centralizar_periodo').val();
  var $mensaje = $doc.find('#mensajeProcesarCompras');

  Swal.fire({
    title: '¿Desea centralizar las compras?',
    text: 'Se procesarán las compras del período ' + anho + '-' + periodo + '.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, procesar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33'
  }).then(function (result) {

    if (!result.isConfirmed) return;

    $boton.prop('disabled', true);
    $mensaje.text('Procesando, espere por favor...');

    $.ajax({
      url: 'contabilidad/centralizar_compras_procesar.php',
      type: 'POST',
      dataType: 'json',
      data: {
        cc_local: cc_local,
        anho: anho,
        periodo: periodo
      }
    }).done(function (respuesta) {

      $mensaje.text(respuesta.mensaje || 'Proceso finalizado.');

      if (respuesta.ok) {

        Swal.fire({
          title: 'Proceso completado',
          text: respuesta.mensaje || 'Las compras fueron centralizadas correctamente.',
          icon: 'success',
          confirmButtonText: 'Aceptar'
        });

        var formulario = document.getElementById('formlibroCompras');
        if (formulario) formulario.submit();

      } else {
        alertaMensaje(respuesta.mensaje || 'No se pudo centralizar las compras.');
      }

    }).fail(function (xhr) {

      var mensaje = (xhr.responseJSON && xhr.responseJSON.mensaje)
        || 'No se pudo ejecutar el proceso.';

      $mensaje.text(mensaje);
      alertaMensaje(mensaje);

    }).always(function () {
      $boton.prop('disabled', false);
    });

  });
}

function fn_ProcesarBancos(boton) {
  var $boton = $(boton);
  if ($boton.prop('disabled')) return;

  var $doc = $(boton.ownerDocument);
  var cc_local = $doc.find('#centralizar_cc_local').val();
  var anho = $doc.find('#centralizar_anho').val();
  var periodo = $doc.find('#centralizar_periodo').val();
  var $mensaje = $doc.find('#mensajeProcesarBancos');

  Swal.fire({
    title: '¿Desea centralizar los bancos?',
    text: 'Se procesarán los movimientos bancarios del período ' + anho + '-' + periodo + '.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, procesar',
    cancelButtonText: 'Cancelar',
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33'
  }).then(function (result) {

    if (!result.isConfirmed) return;

    $boton.prop('disabled', true);
    $mensaje.text('Procesando, espere por favor...');

    $.ajax({
      url: 'contabilidad/centralizar_bancos_procesar.php',
      type: 'POST',
      dataType: 'json',
      data: {
        cc_local: cc_local,
        anho: anho,
        periodo: periodo
      }
    }).done(function (respuesta) {

      $mensaje.text(respuesta.mensaje || 'Proceso finalizado.');

      if (respuesta.ok) {

        Swal.fire({
          title: 'Proceso completado',
          text: respuesta.mensaje || 'Los movimientos bancarios fueron centralizados correctamente.',
          icon: 'success',
          confirmButtonText: 'Aceptar'
        }).then(function () {

          var formulario = $doc.find('#formlibroBancos')[0];
          if (formulario) formulario.submit();

        });

      } else {
        alertaMensaje(
          respuesta.mensaje || 'No se pudo centralizar los bancos.'
        );
      }

    }).fail(function (xhr) {

      var mensaje = (xhr.responseJSON && xhr.responseJSON.mensaje)
        || 'No se pudo ejecutar el proceso de centralización de bancos.';

      $mensaje.text(mensaje);
      alertaMensaje(mensaje);

    }).always(function () {
      $boton.prop('disabled', false);
    });

  });
}