(function ($) {
  $("#frmRegistroEvento").validate();
})(jQuery);

function fn_guardarEvento() {
  swalProcesando();
  var str = $("#frmRegistroEvento").serialize();

  ajax('capacitacion/eve_update', str)
    .then(function (data) {
      if (data.error || typeof data !== 'object') {
        throw data?.message || data;
      }
      recargar(750, 'O');
      setTimeout(function () {
        redireccionar(data.url);
      }, 750);

    }).catch(function (err) {
      swalError(err);
    });
}

function fn_subirArchivo(campo) {
  swalProcesando();
  var str_files = new FormData(document.getElementById('frmSubirArchivo_' + campo));
  ajaxArchivo(str_files, "capacitacion/eve_update_file")
    .then(function (data) {
      if (data !== "0") {
        throw data;
      }
      recargar(750, 'O');
    }).catch(function (err) {
      Swal.showValidationMessage(err);
    });
}

function fn_eliminarArchivo(cc_evento, opc, nombreArchivo, campo) {
  alertaMensaje('¿Estás seguro de eliminar esta imagen?', function () {
    var str = `cc_evento=${cc_evento}&opc=${opc}&campo=${campo}&${campo}=${encodeURIComponent(nombreArchivo)}`;
    return ajax("capacitacion/eve_update_file", str)
      .then(function (data) {
        if (data !== "0") {
          throw data;
        }
        recargar(750, 'O');
      })
      .catch(function (err) {
        Swal.showValidationMessage(err);
      });
  });
}
/****************************** */
$(document).ready(function () {
  fn_inicializarEditores();
});
window.editores = {};

function fn_inicializarEditores() {
  window.editores = window.editores || {};
  document.querySelectorAll('.ckeditor-classic').forEach(function (el) {
    if (el.ckeditorInstance) return;
    ClassicEditor.create(el, {
      toolbar: {
        items: ['undo', 'redo', '|', 'heading', '|', 'bold', 'italic'],
        shouldNotGroupWhenFull: true
      }
    })
      .then(function (editor) {
        el.ckeditorInstance = editor;
        window.editores[el.id] = editor;
      })
      .catch(function (error) {
        console.error('Error CKEditor:', error);
      });

  });
}
function fn_destruirEditores() {
  var ids = Object.keys(window.editores);
  var promesas = ids.map(function (id) {
    return window.editores[id].destroy().catch(function (error) {
      console.error(error);
    });
  });
  return Promise.all(promesas).then(function () {
    window.editores = {};
  });
}