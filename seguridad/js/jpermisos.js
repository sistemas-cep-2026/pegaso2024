fn_buscarPerfil();

function fn_buscarPerfil() {
    var str = $("#frmBuscarPerfil").serialize();
    obtenerDatos('divListarPerfil', 'seguridad/perm_listar', str, function () {
        /*fn_listaDataTable('table_perfil',{
            searching: false,
            lengthChange: false,
            buttons:''
        });*/
        fn_asignaModulo(13);
    });
}


function fn_asignaModulo(cc_perfil=13) {
    var str = `cc_perfil=${cc_perfil}`;
    obtenerDatos('div_asigPerfil', 'seguridad/perm_listar_acceso', str);
}

function fn_grabarAsigModulo() {
    var str = $("#frmAsigModuloPerfil").serialize();
    ajax('seguridad/perm_update', str)
    .then(function (data) {
        if (data !== '0') {
            throw data;
        }
        showNotification('success', 'Operación con éxito');
        // fn_buscarPerfil();
    }).catch(showNotification.bind(null, 'error', 'Error'));
}

