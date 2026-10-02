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

function fn_subirArchivo() {
  swalProcesando();
  var str_files = new FormData($('#frmSubirArchivo')[0]);
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

function fn_eliminarArchivo(...arreglo) {
  alertaMensaje('¿Estás seguro de eliminar esta imagen?', function () {
    var str = `cc_evento=${arreglo[0]}&opc=${arreglo[1]}&img_fondo=${arreglo[2]}`;
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