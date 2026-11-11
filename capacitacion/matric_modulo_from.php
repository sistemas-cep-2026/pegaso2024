<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_matricula.php");
require_once(u_src() . "bo/bo_cap_eventos_modulo.php");
require_once(u_src() . "bo/bo_cap_eventos_modulo_nota.php");

$bo_matricula = new bo_cap_eventos_matricula();
$bo_modulo = new bo_cap_eventos_modulo();
$bo_modnota = new bo_cap_eventos_modulo_nota();

$ent_matricula = new cap_eventos_matricula();
$ent_modulo = new cap_eventos_modulo();
$ent_modnota = new cap_eventos_modulo_nota();

$cc_evento_mat = s_crypt($_REQUEST['cc_evento_mat'] ?? '', 'out');

$mat = null;
if (ctype_digit((string)$cc_evento_mat)) {
    $ent_matricula->setCc_evento_mat($cc_evento_mat);
    $data_mat = $bo_matricula->listarID($ent_matricula);
    $mat = $data_mat[0] ?? null;
}
$es_ponente = ($mat !== null && trim((string)$mat['ponente']) === '1');

$modulos = [];
$asignados = [];
$seleccionado = 0;
if ($es_ponente) {
    // Módulos del evento: se muestran los activos y los ya asignados (aunque luego se hayan anulado, para poder quitarlos)
    $ent_modulo->setCc_evento($mat['cc_evento']);
    $data_modulos = $bo_modulo->listar($ent_modulo);

    $ent_modnota->setCc_evento_mat($mat['cc_evento_mat']);
    foreach ($bo_modnota->listarID($ent_modnota) as $a) {
        $asignados[(int)$a['cc_capmod']] = true;
    }

    foreach ($data_modulos as $m) {
        $activo = (trim((string)$m['flag']) === '*');
        $id = (int)$m['cc_capmod'];
        if ($activo || isset($asignados[$id])) {
            $modulos[] = ['id' => $id, 'nombre' => trim((string)$m['ct_modulo']), 'activo' => $activo];
        }
    }
    // módulo preseleccionado: el primero asignado (un ponente debe tener uno solo)
    $ids_asignados = array_keys($asignados);
    $seleccionado = !empty($ids_asignados) ? (int)$ids_asignados[0] : 0;
}
?>
<div class="modal-header">
    <h4 class="modal-title">ASIGNAR MÓDULO</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <?php if (!$es_ponente) { ?>
        <div class="alert alert-warning border-0 mb-3">
            <i class="ri-error-warning-line me-1"></i>
            La matrícula no existe o la persona no está marcada como ponente.
        </div>
        <div class="text-center"><?php echo bt_cerrar(); ?></div>
    <?php } elseif (empty($modulos)) { ?>
        <div class="alert alert-info border-0 mb-3">
            <i class="ri-information-line me-1"></i>
            Este evento no tiene módulos activos. Regístralos primero en el mantenimiento de módulos del evento.
        </div>
        <div class="text-center"><?php echo bt_cerrar(); ?></div>
    <?php } else { ?>
        <form action="javascript:fn_guardarModulo();" id="frmRegistroModulo" novalidate>
            <p class="text-muted fs-13 mb-2">Selecciona el módulo que dicta el ponente.</p>
            <?php if (count($asignados) > 1) { ?>
                <div class="alert alert-warning border-0 fs-13 mb-2">
                    <i class="ri-error-warning-line me-1"></i>
                    Este ponente tiene <?php echo count($asignados) ?> módulos registrados. Al guardar quedará solo el seleccionado.
                </div>
            <?php } ?>
            <div class="list-group mb-3">
                <label class="list-group-item d-flex align-items-start gap-2">
                    <input class="form-check-input mt-1 flex-shrink-0" type="radio" name="modulo" value="" <?php echo ($seleccionado === 0) ? 'checked' : '' ?>>
                    <span class="text-muted">Sin módulo</span>
                </label>
                <?php foreach ($modulos as $m) { ?>
                    <label class="list-group-item d-flex align-items-start gap-2">
                        <input class="form-check-input mt-1 flex-shrink-0" type="radio" name="modulo"
                            value="<?php echo s_crypt($m['id'], 'in') ?>" <?php echo ($seleccionado === $m['id']) ? 'checked' : '' ?>>
                        <span>
                            <?php echo htmlspecialchars($m['nombre'], ENT_QUOTES, 'UTF-8') ?>
                            <?php if (!$m['activo']) { ?>
                                <span class="badge bg-danger-subtle text-danger ms-1">ANULADO</span>
                            <?php } ?>
                        </span>
                    </label>
                <?php } ?>
            </div>
            <div class="text-center">
                <?php echo bt_guardar(); ?> <?php echo bt_cerrar(); ?>
                <input type="hidden" name="cc_evento_mat" value="<?php echo s_crypt($cc_evento_mat, 'in') ?>">
            </div>
        </form>
    <?php } ?>
</div>
<script>
    function fn_guardarModulo() {
        swalProcesando();
        var str = $("#frmRegistroModulo").serialize();
        ajax('capacitacion/matric_modulo_update', str)
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