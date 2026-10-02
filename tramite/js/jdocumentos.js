$("#frmRegistroDocumento").validate();

function fn_guardarDocumento() {
    swalProcesando();
    var str = $("#frmRegistroDocumento").serialize();
    ajax('tramite/documen_update', str)
        .then(function (data) {
            if (data.error || typeof data !== 'object') throw data?.message || data;
            redireccionar(data.url);
        })
        .catch(swalError);
}