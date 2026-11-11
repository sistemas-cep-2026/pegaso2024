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

  if (!window.confirm('¿Desea centralizar las compras de ' + anho + '-' + periodo + '?')) return;
  $boton.prop('disabled', true);
  $mensaje.text('Procesando, espere por favor...');

  $.ajax({
    url: 'contabilidad/centralizar_compras_procesar.php',
    type: 'POST',
    dataType: 'json',
    data: { cc_local: cc_local, anho: anho, periodo: periodo }
  }).done(function (respuesta) {
    $mensaje.text(respuesta.mensaje || 'Proceso finalizado.');
    if (respuesta.ok) {
      var formulario = document.getElementById('formlibroCompras');
      if (formulario) formulario.submit();
    }
  }).fail(function (xhr) {
    var mensaje = (xhr.responseJSON && xhr.responseJSON.mensaje) || 'No se pudo ejecutar el proceso.';
    $mensaje.text(mensaje);
  }).always(function () {
    $boton.prop('disabled', false);
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

  if (!window.confirm('¿Desea centralizar las BANCOS de ' + anho + '-' + periodo + '?')) return;
  $boton.prop('disabled', true);
  $mensaje.text('Procesando, espere por favor...');

  $.ajax({
    url: 'contabilidad/centralizar_bancos_procesar.php',
    type: 'POST',
    dataType: 'json',
    data: { cc_local: cc_local, anho: anho, periodo: periodo }
  }).done(function (respuesta) {
    $mensaje.text(respuesta.mensaje || 'Proceso finalizado.');
    if (respuesta.ok) {
      var formulario = document.getElementById('formlibroBancos');
      if (formulario) formulario.submit();
    }
  }).fail(function (xhr) {
    var mensaje = (xhr.responseJSON && xhr.responseJSON.mensaje) || 'No se pudo ejecutar el proceso.';
    $mensaje.text(mensaje);
  }).always(function () {
    $boton.prop('disabled', false);
  });
}