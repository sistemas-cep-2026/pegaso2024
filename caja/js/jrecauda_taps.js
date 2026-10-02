
/************************************************* BCP ***** */
function fn_BuscarBCP() {
  const str = $("#frm").serialize();
  obtenerDatos("div_fromBCP", "caja/recau_bcp_from", str, () => { });
}


function fn_grabarImportar() {
  let form = document.getElementById('formImportar');
  if (!form) return console.error('Formulario no encontrado.');
  swalProcesando();
  $.ajax({
    url: 'caja/recau_bcp_update',
    type: 'POST',
    data: new FormData(form),
    contentType: false,
    processData: false,
    cache: false
  })
    .done(response => {
      Swal.close();
      try {
        let { estado, mensaje, datos } = JSON.parse(response);
        if (estado !== '0') return swalError(mensaje || 'Error desconocido.');
        fn_BuscarBCP();
        fn_procesarImportacion();
      } catch {
        swalError('Error al procesar la respuesta del servidor.');
      }
    })
    .fail(err => {
      Swal.close();
      swalError('Error en la solicitud AJAX1.');
    });
}

function fn_procesarImportacion() {
  let intentos = 0;
  let maxIntentos = 20;
  let intervalo = 10000;

  function ejecutarProceso() {
    if (intentos >= maxIntentos) {
      swalError('El proceso tardó demasiado en completarse.');
      return;
    }
    $.ajax({
      url: 'caja/recau_bcp_update',
      type: 'POST',
      data: { opc: 'P' },
      dataType: 'json',
      timeout: 600000,
    })
      .done(response => {
        if (response.estado === '0') {
          swalOk(750);
          fn_BuscarBCP();
        } else {
          intentos++;
          setTimeout(ejecutarProceso, intervalo);
        }
      })
      .fail(err => {
        swalError('Error en la solicitud AJAX2.');
      });
  }
  ejecutarProceso();
}

/************************************************* BBVA ***** */

function fn_BuscarBBVA() {
  const str = $("#frm").serialize();
  obtenerDatos("div_fromBBVA", "caja/recau_bbva_from", str, () => { });
}

function fn_grabarImportarBBVA() {
  let form = document.getElementById('formImportarBBVA');
  if (!form) return console.error('Formulario no encontrado.');
  swalProcesando();
  $.ajax({
    url: 'caja/recau_bbva_update',
    type: 'POST',
    data: new FormData(form),
    contentType: false,
    processData: false,
    cache: false
  })
    .done(response => {
      Swal.close();
      try {
        let { estado, mensaje, datos } = JSON.parse(response);
        if (estado !== '0') return swalError(mensaje || 'Error desconocido.');
        fn_BuscarBBVA();
         fn_procesarImportacionBBVA();
      } catch {
        swalError('Error al procesar la respuesta del servidor.');
      }
    })
    .fail(err => { 
      Swal.close();
      swalError('Error en la solicitud AJAX1.');
    });
}

 function fn_procesarImportacionBBVA() {
  let intentos = 0;
  let maxIntentos = 20;
  let intervalo = 10000;

  function ejecutarProcesoBBVA() {
    if (intentos >= maxIntentos) {
      swalError('El proceso tardó demasiado en completarse.');
      return;
    }
    $.ajax({
      url: 'caja/recau_bbva_update',
      type: 'POST',
      data: { opc: 'P' },
      dataType: 'json',
      timeout: 600000,
    })
      .done(response => {
        if (response.estado === '0') {
          swalOk(750);
          fn_BuscarBBVA();
        } else {
          intentos++;
          setTimeout(ejecutarProcesoBBVA, intervalo);
        }
      })
      .fail(err => {
        swalError('Error en la solicitud AJAX2.');
      });
  }
  ejecutarProcesoBBVA();
}
  

 


/**********************Descargas */
function descargarBBVA(...args) {
  var str = `${hostname}caja/recau_taps_donwload?cod=${args[0]}`;
  redireccionar_ventana(str, 750);
}