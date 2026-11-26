<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");
require_once(u_src() . "bo/bo_cont_asistencia.php");

// Editar marcaciones es solo para nivel A (igual que el interruptor Recuadre)
if (s_nivel() !== 'A') {
    echo errors('No tiene permiso para modificar asistencias.');
    exit;
}

$id         = s_crypt($_REQUEST["id"] ?? '', 'out');
$opc        = s_crypt($_REQUEST["opc"] ?? '', 'out');
$cc_persona = s_crypt($_REQUEST["cc_persona"] ?? '', 'out');

$bo_asistencia  = new bo_cont_asistencia();

// Valores por defecto para una marcación nueva
$fecha = date('Y-m-d');
$hora = '';
$flag = 'A';
$horario = '';

if ($opc === 'U') {
    $data_asistencia = $bo_asistencia->listarId($id);
    foreach ($data_asistencia as $row) {
        $id = $row['id'];
        $cc_persona = $row['cc_persona'];
        $fecha = $row['punch_time'];
        $hora = $row['hora'];
        $flag = $row['flag'];
        $horario = $row['horario'];
    }
}
$h = function ($t) {
    return htmlspecialchars(trim((string) $t), ENT_QUOTES, 'UTF-8');
};
?>
<div class="modal-header">
    <h4 class="modal-title">Control de asistencia</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <form method="post" action="javascript:fn_grabarRegistro();" role="form" id="frmGrabarRegistro" novalidate>
        <div class="row pb-1">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">Fecha : </span>
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $h($fecha); ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">Hora : </span>
                    <input type="time" class="form-control" id="hora" name="hora" value="<?php echo $h($hora); ?>" required>
                </div>
            </div>
        </div>
        <div class="row pb-1">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text">Horario : </span>
                    <input type="number" min="0" max="24" class="form-control" id="horario" name="horario" value="<?php echo $h($horario); ?>" required>
                    <span class="input-group-text">hrs.</span>
                </div>
            </div>
            <div class="col-lg-6">
                <?php
                $cheked = ($flag == "A") ? 'checked' : '';
                input_checkbox('Estado', 'flag', 'A', $cheked, 'flag');
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <?php echo bt_guardar(); ?>
                <?php echo bt_cerrar(); ?>
                <input type="hidden" name="id" id="id" value="<?php echo s_crypt($id, 'in') ?>">
                <input type="hidden" name="cc_persona" id="cc_persona" value="<?php echo s_crypt($cc_persona, 'in') ?>">
                <input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in'); ?>">
            </div>
        </div>
    </form>
</div>
