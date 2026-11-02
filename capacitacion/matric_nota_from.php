<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_matricula.php");

$bo_eventos_matricula = new bo_cap_eventos_matricula();

$ent_eventos_matricula = new cap_eventos_matricula();

$cc_evento_mat = s_crypt($_REQUEST['cc_evento_mat'] ?? '', 'out');

$nota = '';
$opc = 'N';
$option = "ASIGNAR NOTA";

$ent_eventos_matricula->setCc_evento_mat($cc_evento_mat);
$data = $bo_eventos_matricula->listarID($ent_eventos_matricula);
foreach ($data as $row) {
    $existe = true;
    $cc_evento_mat = $row["cc_evento_mat"];
    $nota = trim((string)($row["nota"] ?? ''));
    $opc = 'N';
    $option = "MODIFICAR NOTA";
}
?>
<div class="modal-header">
    <h4 class="modal-title"><?php echo $option ?></h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form action="javascript:fn_guardarNota();" id="frmRegistroNota" class="was-validated">
        <div class="row">
            <div class="col-sm-12 mb-3">
                <label for="nota" class="form-label">Nota</label>
                <input type="number" class="form-control" id="nota" name="nota"
                    value="<?php echo htmlspecialchars($nota, ENT_QUOTES, 'UTF-8') ?>" step="1" min="11" max="20" placeholder="11 a 20" required>
                <div class="invalid-feedback">Ingrese una nota entera mayor a 10 y menor o igual a 20.</div>
            </div>
            <div class="col-sm-12 text-center">
                <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
                <input type="hidden" name="cc_evento_mat" value="<?php echo s_crypt($cc_evento_mat, 'in') ?>">
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
                modalRegistroSm.hide();
                fn_reporteParticipantes();
            }).catch(function(err) {
                swalError(err);
            });
    }
</script>