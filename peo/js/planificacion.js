$(function () {
    //fn_buscarRegistro();
});
function fn_objetivosIndex() {
  var str ='';// 'cc_banco=' + cc_banco;
  obtenerDatos('divlistarIndex', 'peo/objvo_index', str);
}

function fn_listarObjetivos() {
    var str = $("#frmBuscarRegistro").serialize();
    obtenerDatos('divListaObjetivos', 'peo/objvo_lista', str);
}

/**Inciativas****/
function fn_listarIniciativas() {
  var str ='';
  obtenerDatos('divlistarIniIndex', 'peo/iniciativa_index', str);
}

function fn_fromobjetivos(cc_objetivos, anho) {
  var str = 'cc_objetivos=' + cc_objetivos+'&anho='+anho;
  obtenerDatos('divlistarbjetivosFrom', 'peo/iniciativa_listar', str, function(){
  });
}

function fn_control(cc_iniciativas, opc) {
    var str = 'cc_iniciativas=' + cc_iniciativas + '&opc=' + opc;
    obtenerDatos(modalContainer, 'peo/activid_form', str, function () {
        modalRegistro.show();
    });
}