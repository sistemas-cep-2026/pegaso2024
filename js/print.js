const _TOKEN = $('meta[name="csrf-token"]').attr("content");
$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": _TOKEN,
  },
  statusCode: {
    401: function (a, b) {
      console.log(a, b);
      //redireccionar(`${hostname}sistema/salir`);
    },
  },
});

const ToastBanner = Swal.mixin({
  toast: true,
  position: "bottom-end",
  showConfirmButton: false,
  allowOutsideClick: false,
  timer: 3000,
  customClass: {
    popup: "bg-dark",
    title: "text-light",
  },
  showClass: {
    popup: "animate__animated animate__fadeInDown",
  },
  hideClass: {
    popup: "animate__animated animate__fadeOutUp",
  },
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

const swal = (callback) => {
  Swal.fire(callback);
};

const toast = (callback) => {
  ToastBanner.fire(callback);
};

const hostname = `${location.protocol}//${location.hostname}:/pegaso2024/`;
//const hostname = `${location.protocol}//${location.hostname}:8080/pegasoweb/`;

if (document.getElementById("modalRegistro")) {
  var modalTemplate = document.getElementById("modalRegistro");
  var modalContainer = "modalRegistro .modal-content";
  var modalRegistro = new bootstrap.Modal(modalTemplate, {
    backdrop: "static",
    keyboard: !1,
    focus: !1,
  });
  modalTemplate.addEventListener("hidden.bs.modal", function (event) {
    $(`#${modalContainer}`).html("");
    document.body.style.paddingRight = "0px";
  });
}

if (document.getElementById("modalRegistroSm")) {
  var modalTemplateSm = document.getElementById("modalRegistroSm");
  var modalContainerSm = "modalRegistroSm .modal-content";
  var modalRegistroSm = new bootstrap.Modal(modalTemplateSm, {
    backdrop: "static",
    keyboard: !1,
    focus: !1,
  });
  modalTemplateSm.addEventListener("hidden.bs.modal", function (event) {
    $(`#${modalContainerSm}`).html("");
    document.body.style.paddingRight = "0px";
  });
}


if (document.getElementById("modalRegistroXl")) {
  var modalTemplateXl = document.getElementById("modalRegistroXl");
  var modalContainerXl = "modalRegistroXl .modal-content";
  var modalRegistroXl = new bootstrap.Modal(modalTemplateXl, {
    backdrop: "static",
    keyboard: !1,
    focus: !1,
  });
  modalTemplateXl.addEventListener("hidden.bs.modal", function (event) {
    $(`#${modalContainerXl}`).html("");
    document.body.style.paddingRight = "0px";
  });
}

if (document.getElementById("modalRegistroFull")) {
  var modalTemplateFull = document.getElementById("modalRegistroFull");
  var modalContainerFull = "modalRegistroFull .modal-content";
  var modalRegistroFull = new bootstrap.Modal(modalTemplateFull, {
    backdrop: "static",
    keyboard: !1,
    focus: !1,
  });
  modalTemplateFull.addEventListener("hidden.bs.modal", function (event) {
    $(`#${modalContainerFull}`).html("");
    document.body.style.paddingRight = "0px";
  });
}

if (document.getElementById("modalLateralRegistro")) {
  var modalLateralRegistroTemplate = document.getElementById("modalLateralRegistro");
  var modalLateralRegistroContainer = "modalLateralRegistro";
  var modalLateralRegistro = new bootstrap.Offcanvas('#modalLateralRegistro', {
    backdrop: "static",
    keyboard: !1,
  });
}

/*function obtenerDatos(contenedor, url, valores = "", callback) {
  if (!$(`#${contenedor}`).length) {
    console.error(
      `Elemento ${contenedor} a renderizar no existe dentro del documento.`
    );
    return;
  }

  var modalContainerArr = [
    modalContainer,
    modalContainerFull,
    modalContainerXl,
    modalContainerSm
  ];

  if (modalContainerArr.includes(contenedor)) {
    swalProcesando();
    modalTemplate?.addEventListener("shown.bs.modal", function () {
      Swal.close();
    });
    modalTemplateXl?.addEventListener("shown.bs.modal", function () {
      Swal.close();
    });
    modalTemplateSm?.addEventListener("shown.bs.modal", function () {
      Swal.close();
    });
    modalTemplateFull?.addEventListener("shown.bs.modal", function () {
      Swal.close();
    });
  } else {
    $(`#${contenedor}`).html(cargador());
  }
  ajax(url, valores)
    .then(function (res) {
      $(`#${contenedor}`).html(res);
    })
    .then(function () {
      if (window.initTooltips) {
        var root = document.getElementById(contenedor);
        window.initTooltips(root);
      }
    })
    .then(function () {
      if (typeof callback === "function") {
        callback();
      }

    })
    .catch(function (err) {

      $(`#${contenedor}`).html(err.responseText);
      console.error("Error en obtenerDatos:", err);

    });
}
*/

function obtenerDatos(contenedor, url, valores = "", callback) {

  const $contenedor = $(`#${contenedor}`);

  if (!$contenedor.length) {
    console.error(`Elemento ${contenedor} a renderizar no existe dentro del documento.`);
    return;
  }

  const modalContainerArr = [
    modalContainer,
    modalContainerFull,
    modalContainerXl,
    modalContainerSm
  ];

  if (modalContainerArr.includes(contenedor)) {
    swalProcesando();
    modalTemplate?.addEventListener("shown.bs.modal", () => Swal.close(), { once: true });
    modalTemplateXl?.addEventListener("shown.bs.modal", () => Swal.close(), { once: true });
    modalTemplateSm?.addEventListener("shown.bs.modal", () => Swal.close(), { once: true });
    modalTemplateFull?.addEventListener("shown.bs.modal", () => Swal.close(), { once: true });

  } else {
    $contenedor.html(cargador());
  }
  ajax(url, valores)
    .then(function (res) {

      $contenedor.html(res);
      const root = $contenedor[0];
      if (typeof window.initTooltips === "function") {
        window.initTooltips(root);
      }
      if (typeof window.initMonedaPEN === "function") {
        window.initMonedaPEN(root);
      }
      if (typeof callback === "function") {
        callback();
      }

    })
    .catch(function (err) {
      $contenedor.html(err?.responseText || "Error cargando contenido");
      console.error("Error en obtenerDatos:", err);
    });

}

/*LIMITES DE ARCHIVOS*/

const limit_file_max = 4000000;
const limit_file_min = 500000;

if (typeof Handlebars !== "undefined") {
  Handlebars.registerHelper("equalsTo", function (p, q, options) {
    return p == q ? options.fn(this) : options.inverse(this);
  });
}

function fn_periodo() {
  var str = "";
  obtenerDatos(modalContainer, "comun/periodo_from", str, function () {
    modalRegistro.show();
  });
}

function fn_periodo_comp_banco() {
  var str = "";
  obtenerDatos(
    modalContainer,
    "comun/periodo_from_comp_banco",
    str,
    function () {
      modalRegistro.show();
    }
  );
}

function fn_lista_periodo(cc_local_vinculado) {
  $.ajax({
    url: "comun/periodo_lista.php",
    data: "cc_local_vinculado=" + cc_local_vinculado,
    type: "post",
    success: function (data) {
      $("#cont_periodo").html(data);
    },
  });
}

function fn_lista_periodo_comp_banco(cc_local_vinculado) {
  $.ajax({
    url: "comun/periodo_lista_comp_banco.php",
    data: "cc_local_vinculado=" + cc_local_vinculado,
    type: "post",
    success: function (data) {
      $("#cont_periodo").html(data);
    },
  });
}

/*
encabezado para el reporte
$headerReporte = "<h2 class='text-center'>Horas Extras $periodo / $anho</h2><p>$user_nombre</p>";
echo "<script>var headerContent = `" . $headerReporte . "`;</script>";*/

if (typeof $.validator !== "undefined") {
  $.extend($.validator.messages, {
    required: "Campo obligatorio.",
    remote: "Please fix this field.",
    email: "Correo electrónico.",
    url: "Por favor ingrese una URL.",
    date: "Por favor ingrese una fecha válida.",
    dateISO: "Por favor ingrese una date (ISO).",
    number: "Por favor ingrese un número valido.",
    digits: "Ingrese sólo números.",
    creditcard: "Por favor ingrese un numero de tarjeta válido.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format(
      "Please enter no more than {0} characters."
    ),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format(
      "Ingrese sólo entre {0} y {1} caracteres."
    ),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format(
      "Please enter a value less than or equal to {0}."
    ),
    min: jQuery.validator.format(
      "Please enter a value greater than or equal to {0}."
    ),
  });

  $.validator.addMethod(
    "filesize",
    function (value, element, params) {
      var size = element.files[0].size;
      if (size < params) {
        return true;
      }
      return false;
    },
    "El archivo sobrepasa el límite permitido"
  );

  $.validator.addMethod(
    "regexp",
    function (value, element, params) {
      var expresion = new RegExp(params);
      return this.optional(element) || expresion.test(value);
    },
    "El conjunto de caracteres no coinicde con el patrón expresado."
  );

  $.validator.addMethod(
    "notEqualTo",
    function (value, element, param) {
      return this.optional(element) || value != $(`${param}`).val();
    },
    "Los datos no deben ser iguales entre sí."
  );

  $.validator.setDefaults({
    validClass: "valid-feedback",
    errorClass: "invalid-feedback",
    errorElement: "div",
    onfocusout: function (element) {
      $(element).valid();
    },
    highlight: function (element, errorClass, validClass) {
      $(element).removeClass(errorClass).addClass('is-invalid');

    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid').addClass('valid');
    },
  });
}

function imprimirDiv() {
  // Obtener el contenido del div con el id 'print-section'
  var contenido = document.getElementById("print-section").innerHTML;

  // Crear un iframe oculto para la impresión
  var iframe = document.createElement("iframe");
  iframe.style.position = "absolute";
  iframe.style.width = "0px";
  iframe.style.height = "0px";
  iframe.style.border = "none";

  document.body.appendChild(iframe);

  var doc = iframe.contentWindow.document;

  doc.open();
  doc.write("<html><head><title>COLEGIO DE ENFERMEROS DEL PERU</title>");

  doc.write(
    '<link rel="stylesheet" href="bootstrap/assets/css/bootstrap.min.css">'
  );

  var estilos = document.querySelectorAll('link[rel="stylesheet"], style');
  estilos.forEach(function (hojaEstilos) {
    if (hojaEstilos.tagName.toLowerCase() === "link") {
      // Si es un enlace de estilo, incluirlo en el iframe
      doc.write('<link rel="stylesheet" href="' + hojaEstilos.href + '">');
    } else if (hojaEstilos.tagName.toLowerCase() === "style") {
      // Si es una etiqueta <style>, incluir el contenido de la hoja de estilos en el iframe
      doc.write("<style>" + hojaEstilos.innerHTML + "</style>");
    }
  });

  doc.write("</head><body>");
  doc.write(contenido); // El contenido del div a imprimir
  doc.write("</body></html>");
  doc.close();

  // Ejecutar la impresión en el iframe
  iframe.contentWindow.focus(); // Dar foco al iframe
  iframe.contentWindow.print(); // Imprimir
  document.body.removeChild(iframe); // Eliminar el iframe después de la impresión
}


var buttonsDataTable = [
  {
    extend: "collection",
    background: false,
    autoClose: true,
    fade: 20,
    className: "btn btn-icon bg-transparent waves-effect",
    text: '<i class="fa fa-ellipsis-v"></i>',
    buttons: [
      /* {
        extend: "print",
        className: "dropdown-item waves-effect",
        footer: true,
        exportOptions: {
          stripHtml: false,
        },
        messageTop: function () {
          return $(`table thead tr.messageTOP th`).html();
        },
        title: function () {
          var description = $(`table thead tr.messageTOP th`).text();
          return `${description}`;
        },
        customize: function (win) {
          var head = win.document.head || win.document.getElementsByTagName("head")[0];
          $(head).append(
            '<link rel="stylesheet" href="' + hostname + 'bootstrap/assets/css/bootstrap.min.css">'
          );
          var css = `.text-end, td.text-end, th.text-end { text-align: right !important; }
          table.dataTable tbody td:last-child { text-align: right !important; }`;
          var style = win.document.createElement('style');
          style.type = 'text/css';
          style.appendChild(win.document.createTextNode(css));
          head.appendChild(style);

          $(win.document.body).prepend(headerContent);
          $(win.document.body).find("h1").remove();
          $(win.document.body).find("tfoot").html("").html($(`table tfoot`).html());
        }
      }, */
      {
        className: "buttons-print dropdown-item waves-effect",
        text: `<i class="fa fa-print"></i> Imprimir`,
        action: function (e, dt, node, config) {
          swalProcesando("Imprimiendo...");
          var tableElement = dt.table().node();
          var frame1 = document.createElement("iframe");
          frame1.name = "frame1";
          frame1.style.position = "absolute";
          frame1.style.top = "-1000000px";
          document.body.appendChild(frame1);
          var frameDoc = frame1.contentWindow
            ? frame1.contentWindow
            : frame1.contentDocument.document
              ? frame1.contentDocument.document
              : frame1.contentDocument;
          frameDoc.document.open();
          frameDoc.document.write("<html>");
          frameDoc.document.write("<head>");
          frameDoc.document.write(`<link rel="stylesheet" type="text/css" href="${hostname}css/print_pdf.css">`);
          frameDoc.document.write("</head>");
          frameDoc.document.write("<body>");
          /*ELIMINAR LOS POSIBLES CAPTION EN EL ELEMENTO TABLE */
          /* var tableClone = tableElement.cloneNode(true);
          $(tableClone).find("caption").remove();
          frameDoc.document.write(tableClone.outerHTML); */
          frameDoc.document.write(tableElement.outerHTML);

          frameDoc.document.write("</body></html>");
          frameDoc.document.close();
          setTimeout(function () {
            swalCerrar();
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            document.body.removeChild(frame1);
          }, 500);
          return false;
        },

      },
      {
        className: "buttons-print dropdown-item waves-effect",
        text: `<i class="fa fa-file-excel"></i> Excel`,
        action: function (e, dt, node, config) {
          swalProcesando("Creando archivo...");
          var tableElement = dt.table().node();
          var form = document.createElement('form');
          form.method = 'POST';
          form.action = hostname + 'comun/expExcel.php';
          var input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'expTabla';
          input.value = tableElement.outerHTML;
          form.appendChild(input);
          document.body.appendChild(form);
          form.submit();
          document.body.removeChild(form);
          swalCerrar();
        },
      },

    ],
  },
];

if (typeof $.fn.dataTable !== "undefined") {
  $.extend(true, $.fn.dataTable.defaults, {
    paging: true,
    searching: true,
    pageLength: 25,
    ordering: false,
    processing: true,
    info: true,
    autoWidth: false,
    responsive: true,
    lengthChange: true,
    language: {
      url: hostname + "js/locale/spanish.json",
    },
    dom: `<"d-flex"<"flex-grow-1"l><"d-flex align-items-center pe-1 btn-group dropstart"B><f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>`,
    buttons: buttonsDataTable,
  });
}

function fn_listaDataTable(table, options = {}) {
  var $_tabla = $(`#${table}`);
  var $tabla = $_tabla.DataTable(options);
  setTimeout(() => {
    $('.dataTables_filter input[type="search"]').removeClass("form-control-sm");
  }, 75);
  return $tabla;
}

function showNotification(icon, title, text = "") {
  Swal.fire({
    position: "top-end",
    icon: icon,
    title: title,
    text: text,
    showConfirmButton: false,
    timer: 3000,
    toast: true,
    customClass: {
      popup: "swal2-toast-custom",
    },
  });
}

function alertaMensaje(title, callback) {
  var _title, _html;
  if (typeof title === "string") {
    _title = title;
    _html = "";
  } else {
    _title = title[0];
    _html = title[1];
  }
  return Swal.fire({
    title: _title,
    html: _html,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "S&iacute;",
    cancelButtonText: "Cancelar",
    showLoaderOnConfirm: true,
    preConfirm: callback,
    allowOutsideClick: () => !Swal.isLoading(),
  });
}

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function swalCerrar(timer = 0) {
  setTimeout(function () {
    Swal.close();
  }, timer);
}

function swalProcesando(
  _title = "Procesando",
  _text = "Espere un momento...",
  _timer = undefined
) {
  var __timer__ = _timer;
  if (typeof _title === "number") {
    __timer__ = _title;
    _title = "Procesando";
  }
  if (typeof _text === "number") {
    __timer__ = _text;
    _text = "Espere un momento...";
  }
  swal({
    title: _title,
    text: _text,
    showConfirmButton: false,
    allowOutsideClick: false,
    imageWidth: 100,
    imageUrl: `${hostname}images/loader.svg`,
    imageHeight: 100,
    timer: __timer__,
  });
}

function swalError(error, _title = "Upss...") {
  if (error.status) {
    var $error = "";
    switch (error.status) {
      case 500:
        $error = JSON.parse(error.responseText);
        break;
    }
    Swal.fire({
      icon: "error",
      title: _title,
      text: $error.message,
      customClass: {
        confirmButton: "btn btn-primary",
      },
      buttonsStyling: false,
    });
    return Swal.showValidationMessage("Error QX3F42C2");
  }
  Swal.fire({
    icon: "error",
    title: _title,
    text: error,
    customClass: {
      confirmButton: "btn btn-primary",
    },
    buttonsStyling: false,
  });
}

function swalOk(
  _title = "Proceso exitoso",
  _text = "Espere un momento...",
  _timer = undefined
) {
  var __timer__ = _timer;
  if (typeof _title === "number") {
    __timer__ = _title;
    _title = "Proceso exitoso";
  }
  if (typeof _text === "number") {
    __timer__ = _text;
    _text = "Espere un momento...";
  }
  swal({
    title: _title,
    text: _text,
    showConfirmButton: false,
    allowOutsideClick: false,
    icon: "success",
    timer: __timer__,
  });
}

function ajax(_url, _data = "") {
  return $.ajax({
    url: `${hostname}${_url}`,
    type: "POST",
    data: _data,
  });
}

function ajaxArchivo(form, _url) {
  return $.ajax({
    url: `${hostname}${_url}`,
    type: "POST",
    data: form,
    contentType: false,
    cache: false,
    processData: false,
  });
}

function cargador() {
  return `<div class="card" aria-hidden="true">
  <div class="card-body">
    <h5 class="card-title placeholder-glow">
      <span class="placeholder col-6"></span>
    </h5>
    <p class="card-text placeholder-glow">
      <span class="placeholder col-7"></span>
      <span class="placeholder col-4"></span>
      <span class="placeholder col-4"></span>
      <span class="placeholder col-6"></span>
      <span class="placeholder col-8"></span>
    </p>
  </div>
</div>`;
}
/*************iframe***************/
function toggleButtonState(selector, state) {
  $(selector).prop("disabled", state);
}

function toggleSpinnerVisibility(hideSpinner, hideIframe) {
  $(".spinner-content").toggleClass("d-none", hideSpinner);
  $(".iframe-loader").toggleClass("d-none", hideIframe);
}

function cargadorReportes() {
  toggleButtonState(".btnBuscar", false);
  toggleSpinnerVisibility(true, false);
}

function desactivarBotonBuscar(event, form) {
  event.preventDefault(); // Previene el envío inmediato
  toggleButtonState(".btnBuscar", true);
  toggleSpinnerVisibility(false, true);

  setTimeout(() => {
    form.submit(); // Envía el formulario tras 1 segundo
  }, 1000);
}
/*************************/

function decimal(valor, digitos = 0) {
  var _valor = Number.parseFloat(valor).toFixed(digitos);
  return _valor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function recargar(time = 0, tipo = "P") {
  if (time > 0) {
    switch (tipo) {
      case "O":
        swalOk();
        break;
      case "P":
        swalProcesando();
        break;
    }
  }
  setTimeout(() => {
    window.location.reload();
  }, time);
}

function redireccionar(url, time = 0, tipo = "P") {
  if (time > 0) {
    switch (tipo) {
      case "O":
        swalOk();
        break;
      default:
        swalProcesando();
        break;
    }
  }
  setTimeout(() => {
    window.location.href = `${url}`;
  }, time);
}

function redireccionar_ventana(url, time = 0, tipo = "P") {
  if (time > 0) {
    switch (tipo) {
      case "O":
        swalOk(time);
        break;
      default:
        swalProcesando(time);
        break;
    }
  }
  setTimeout(() => {
    window.open(`${url}`, "_blank");
    Swal.close();
  }, time);
}

function retornar(time = 0, tipo = "P") {
  if (time > 0) {
    switch (tipo) {
      case "O":
        swalOk();
        break;
      default:
        swalProcesando();
        break;
    }
  }
  setTimeout(() => {
    history.go(-1);
  }, time);
}

function fn_lista_provincia(cc_dpto, div, divlim) {
  ajax("comun/ubi_provincia_lista", "cc_dpto=" + cc_dpto).then(function (data) {
    $(`#${div}`).html(data);
    $(`#${divlim}`).html('<option value="">Seleccione...</option>');
  });
}

function fn_lista_distrito(cc_prov, div, divlim) {
  var cc_dpto = $(`#${divlim}`).val();
  ajax(
    "comun/ubi_distrito_lista_col",
    "cc_dpto=" + cc_dpto + "&cc_prov=" + cc_prov
  ).then(function (data) {
    $(`#${div}`).html(data);
  });
}

function fn_imprimirContenedor(contenedor) {
  swalProcesando();
  var render_contenedor = document.querySelector(contenedor).innerHTML;
  var frame1 = document.createElement("iframe");
  frame1.name = "frame1";
  frame1.style.position = "absolute";
  frame1.style.top = "-1000000px";
  document.body.appendChild(frame1);
  var frameDoc = frame1.contentWindow
    ? frame1.contentWindow
    : frame1.contentDocument.document
      ? frame1.contentDocument.document
      : frame1.contentDocument;
  frameDoc.document.open();
  frameDoc.document.write("<html>");
  frameDoc.document.write("<head>");
  frameDoc.document.write(
    `<link rel="stylesheet" type="text/css" href="${hostname}css/style.css">`
  );
  /*frameDoc.document.write(
    `<link rel="stylesheet" type="text/css" href="${hostname}bootstrap/css/bootstrap.css">`
  );
  frameDoc.document.write(
    `<link rel="stylesheet" type="text/css" href="${hostname}css/style_pe.css">`
  );
  frameDoc.document.write(
    `<link rel="stylesheet" type="text/css" href="${hostname}bootstrap/css/bootstrap-extended.css">`
  );*/
  frameDoc.document.write("</head>");
  frameDoc.document.write("<body>");
  frameDoc.document.write(render_contenedor);
  frameDoc.document.write("</body></html>");
  frameDoc.document.close();
  setTimeout(function () {
    swalCerrar();
    window.frames["frame1"].focus();
    window.frames["frame1"].print();
    document.body.removeChild(frame1);
  }, 500);
  return false;
}

function fn_exportarXlsContenedor(contenedor, tipo = null) {
  var render_contenedor = document.querySelector(contenedor);
  var excel = XLSX.utils.table_to_book(render_contenedor, { sheet: "Reporte" });
  return XLSX.writeFile(excel, "Reporte." + (tipo || "xlsx"));
}

function fn_previsualizarImagen(
  event,
  container_img,
  extension = "jpg|jpeg|png|gif",
  limit_file = 500000
) {
  var input = event.target;
  let extension_images = extension;
  console.log(input.files[0]);
  let match_images = input.files[0].name.match(
    new RegExp(".(" + extension_images + ")$")
  );
  if (input.files[0].size > limit_file) {
    throw "El archivo a subir supera los limites permitidos.";
  }
  if (!match_images) {
    throw `Sólo se acepta archivos con extensión (${extension.replaceAll(
      "|",
      ","
    )})`;
  }
  var preview = $(`${container_img}`);
  var reader = new FileReader();
  reader.addEventListener(
    "load",
    function () {
      preview.attr("src", reader.result);
    },
    false
  );
  reader.readAsDataURL(input.files[0]);
}

$.fn.serializeObject = function () {
  const obj = {};
  const formData = this.serializeArray();

  $.each(formData, function () {
    // Elimina los corchetes del nombre si existen
    const name = this.name.replace(/\[\]$/, "");

    if (obj[name] !== undefined) {
      if (!Array.isArray(obj[name])) {
        obj[name] = [obj[name]];
      }
      obj[name].push(this.value || "");
    } else {
      obj[name] = this.value || "";
    }
  });

  // Maneja checkboxes no marcados y selects múltiples
  //this.find("input[type=radio], select[multiple]").each(function () {
  this.find("select[multiple]").each(function () {
    const nameAttr = $(this).attr("name");
    const name = nameAttr.replace(/\[\]$/, "");

    // Si no existe en el objeto, inicializa como array vacía
    if (obj[name] === undefined) {
      obj[name] = [];
    }

    // Para selects múltiples
    if ($(this).is("select")) {
      const selected = $(this)
        .find("option:selected")
        .map(function () {
          return this.value;
        })
        .get();

      obj[name] = selected;
    }

    // Para checkboxes marcados (ya manejados), los no marcados no se añaden
    if ($(this).is("input[type=radio]") && this.checked) {
      if (!Array.isArray(obj[name])) {
        obj[name] = [];
      }
      obj[name].push(this.value);
    }
  });

  return obj;
};

const typeaheadOptions = {
  hint: true,
  highlight: true,
  minLength: 3,
};

const templates = {
  empty: Handlebars.compile(
    `<div class="text-danger ms-1"><b><i class="fa fa-search"></i> No hay resultados</b></div>`
  ),
  pending: Handlebars.compile(
    `<div class="mx-2"><span class="placeholder p-1 col-12"></div><div class="mx-2"><span class="placeholder p-1 col-12"></div><div class="mx-2"><span class="placeholder p-1 col-12"></div>`
  ),
};

function newBloodhound(options = {}) {
  return new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
      url: `${hostname}${options.url}`,
      prepare: (query, settings) => {
        settings.url = `${settings.url}?query=${encodeURIComponent(query)}`;
        if (options.params) {
          settings.url = settings.url + options.params;
        }
        //console.log(query, settings);
        return settings;
      },
      rateLimitWait: 500,
    },
  });
}

function newTypeahead(selector, bloodhound, options = {
  name: 'nombres',
  display: 'nombres',
  limit: Infinity,
}) {
  if (!($(`#${selector}`).length)) {
    console.error(`Elemento #${selector} no existe en el DOM`);
    alert(`Elemento #${selector} no existe en el DOM`);
    return;
  }
  var selectorTypeaehad = $(`#${selector}`).typeahead(typeaheadOptions, {
    name: options.name,
    display: options.display,
    source: bloodhound.ttAdapter(),
    limit: options.limit,
    templates: templates,
  });
  return selectorTypeaehad;
  /* .on("typeahead:selected", function (e, datum) {
    $(`input[name="${hiddenInputName}"]`).val(datum.c_persona);
  }) ;*/
}

function initMonedaPEN(root = document) {

  if (typeof $.fn.inputmask === "undefined") return;

  $(root).find(".input-pen").inputmask({
    alias: "decimal",
    integerDigits: 12,
    digits: 2,
    digitsOptional: false,
    allowMinus: false,
    placeholder: "0.00",
    groupSeparator: ",",
    radixPoint: ".",
    prefix: "S/ ",
    autoGroup: true,
    rightAlign: true,
    removeMaskOnSubmit: true,
    autoUnmask: true
  });

}
function initMonedaPENPagina() {
  initMonedaPEN(document);
}
document.addEventListener("DOMContentLoaded", function () {
  initMonedaPENPagina();
});
