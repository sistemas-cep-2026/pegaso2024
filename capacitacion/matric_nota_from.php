<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_modulo_nota.php");
require_once(u_src() . "bo/bo_cap_eventos_modulo.php");

$bo_modnota = new bo_cap_eventos_modulo_nota();
$bo_modulo = new bo_cap_eventos_modulo();

$ent_modnota = new cap_eventos_modulo_nota();
$ent_modulo = new cap_eventos_modulo();

$cc_evento = s_crypt($_REQUEST['cc_evento'], 'out');
$cc_evento_mat = s_crypt($_REQUEST['cc_evento_mat'], 'out');

$ent_modulo->setCc_evento($cc_evento);
$data_modulos = $bo_modulo->listar($ent_modulo);
$data_modulos = array_filter($data_modulos, function ($row) {
    return $row['flag'] == '*';
});

$cc_modnota = '';
$cc_capmod = '';
$nota = '';
$opc = 'I';
$option = "ASIGNAR MÓDULO Y NOTA";

$ent_modnota->setCc_evento_mat($cc_evento_mat);
$data = $bo_modnota->listarID($ent_modnota);
foreach ($data as $row) {
    $cc_modnota = $row["cc_modnota"];
    $cc_capmod = $row["cc_capmod"];
    $nota = $row["nota"];
    $opc = 'U';
    $option = "MODIFICAR NOTA";
}
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo $option ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form action="javascript:fn_guardarNota();" id="frmRegistroNota" novalidate>
        <div class="row">
            <div class="col-sm-12 mb-3">
                <label for="cc_capmod" class="form-label">Módulo</label>
                <select class="form-control" id="cc_capmod" name="cc_capmod" required>
                    <option value="">Selecciona...</option>
                    <?php foreach ($data_modulos as $mod) { ?>
                        <option value="<?php echo $mod['cc_capmod']; ?>" <?= ($mod['cc_capmod'] == $cc_capmod) ? 'selected' : '' ?>>
                            <?php echo $mod['ct_modulo']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-12 mb-3">
                <label for="nota" class="form-label">Nota</label>
                <input type="number" class="form-control" id="nota" name="nota" value="<?php echo $nota ?>" step="1" required>
            </div>
            <div class="col-sm-12 text-center">
                <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
                <input type="hidden" name="cc_evento_mat" value="<?php echo s_crypt($cc_evento_mat, 'in') ?>">
                <input type="hidden" name="cc_modnota" value="<?php echo s_crypt($cc_modnota, 'in') ?>">
                <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
            </div>
        </div>
    </form>
</div>
<script>
    function fn_guardarNota() {
        swalProcesando();
        var str = $("#frmRegistroNota").serialize();
        ajax('capacitacion/matric_nota_update', str)
            .then(function(res) {
                if (res != '0') {
                    throw res;
                }
                swalOk(750);
                modalRegistro.hide();
                fn_reporteParticipantes();
            }).catch(function(err) {
                swalError(err);
            });
    }
</script>
