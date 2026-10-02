<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_modulo.php");

$bo_capmod = new bo_cap_eventos_modulo();
$ent_capmod = new cap_eventos_modulo();

$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_evento = s_crypt($_REQUEST['cc_evento'], 'out');
$cc_capmod = isset($_REQUEST['cc_capmod']) ? s_crypt($_REQUEST['cc_capmod'], 'out') : '';
$ct_modulo = '';
$flag = '*';
$option = "NUEVO MÓDULO";

if ($opc == 'U') {
    $ent_capmod->setCc_capmod($cc_capmod);
    $data = $bo_capmod->listarID($ent_capmod);
    foreach ($data as $row) {
        $ct_modulo = $row["ct_modulo"];
        $cc_evento = $row["cc_evento"];
        $flag = $row["flag"];
    }
    $option = "MODIFICAR MÓDULO";
}
$checked = ($flag == '*') ? 'checked' : '';
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo $option ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form action="javascript:fn_guardar();" id="frmRegistroCapMod" novalidate>
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-3">
                    <label for="ct_modulo" class="form-label">Módulo</label>
                    <textarea class="form-control" id="ct_modulo" name="ct_modulo" rows="3" required><?php echo $ct_modulo ?></textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="flag" name="flag" value="*" <?php echo $checked ?>>
                    <label class="form-check-label" for="flag">Activo</label>
                </div>
            </div>
            <div class="col-sm-12 text-center">
                <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
                <input type="hidden" name="cc_evento" value="<?php echo s_crypt($cc_evento, 'in') ?>">
                <input type="hidden" name="cc_capmod" value="<?php echo s_crypt($cc_capmod, 'in') ?>">
                <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
            </div>
        </div>
    </form>
</div>
<script>
    function fn_guardar() {
        swalProcesando();
        var str = $("#frmRegistroCapMod").serialize();
        ajax('capacitacion/cap_mod_update', str)
            .then(function(res) {
                if (res != '0') {
                    throw res;
                }
                swalOk(750);
                modalRegistro.hide();
                fn_reporteModulos();
            }).catch(function(err) {
                swalError(err);
            });
    }
</script>
