
fn_buscarFam();

function fn_buscarFam() {
    var str = $("#frmBuscarFam").serialize();
    obtenerDatos('divListarFamRepor', 'bancos/fam_buscar_listar', str, function () {
        // el modo "Consolidado" no genera la tabla #table-fam (usa otra
        // estructura), así que solo se inicializa DataTables si existe.
        if (document.getElementById('table-fam')) {
            fn_listaDataTable('table-fam', {
            responsive: false,
            searching: false,
            pageLength: 30,
            lengthChange: false,
            buttons: []
            });
        }
    });
}