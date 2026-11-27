<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_contabilidad_centralizar.php");
$bo_centralizar = new bo_contabilidad_centralizar();

// El consejo sale de la sesión (no del formulario): nadie puede ver ni cambiar otro consejo.
$cc_local = s_local_vinculado();
$anho = isset($_REQUEST['anho']) ? trim((string) $_REQUEST['anho']) : '';

if (preg_match('/^[0-9A-Za-z]{1,3}$/', $cc_local) !== 1 || preg_match('/^[0-9]{4}$/', $anho) !== 1) {
    echo errors('Seleccione un consejo y un año válidos.', 'warning');
    return;
}

$data_periodos = $bo_centralizar->ListarPeriodosCerrar($cc_local, $anho);
$data_periodos = is_array($data_periodos) ? $data_periodos : array();
usort($data_periodos, function ($a, $b) {
    return strcmp(trim((string) $a['c_mes']), trim((string) $b['c_mes']));
});

if (empty($data_periodos)) {
    echo errors('No hay períodos registrados para ' . htmlspecialchars($anho, ENT_QUOTES, 'UTF-8') . '.', 'info');
    return;
}

$meses = u_meses_contable();
// Columna => [letra que recibe sp_v1_periodos_local_actualizar, campo de periodos_local]
$modulos = array(
    'COMPRAS'      => array('C', 'flag_cierre_compras'),
    'BANCOS'       => array('B', 'flag_cierre_bancos'),
    'CONTABILIDAD' => array('P', 'flag_cierre_contabilidad'),
);
?>
<div class="table-responsive">
    <table class="table table-bordered table-nowrap align-middle mb-0">
        <thead class="table-light">
            <tr class="text-center">
                <th scope="col">Año</th>
                <th scope="col">Período</th>
                <th scope="col">Planilla</th>
                <?php foreach ($modulos as $titulo => $m) { ?>
                    <th scope="col"><?php echo $titulo; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_periodos as $row) {
                $ano = htmlspecialchars(trim((string) $row['c_ano']), ENT_QUOTES, 'UTF-8');
                $mes = str_pad(trim((string) $row['c_mes']), 2, '0', STR_PAD_LEFT);
                $mes_txt = isset($meses[$mes]) ? $meses[$mes] : $mes;
            ?>
                <tr class="text-center">
                    <td><?php echo $ano; ?></td>
                    <td class="text-start"><span class="fw-medium"><?php echo htmlspecialchars($mes, ENT_QUOTES, 'UTF-8'); ?></span> <span class="text-muted">- <?php echo htmlspecialchars($mes_txt, ENT_QUOTES, 'UTF-8'); ?></span></td>
                    <td class="text-muted">—</td>
                    <?php foreach ($modulos as $titulo => $m) {
                        // '*' = CERRADO, '&' = ABIERTO
                        $cerrado = trim((string) $row[$m[1]]) === '*';
                    ?>
                        <td>
                            <button type="button"
                                class="btn btn-label waves-effect waves-light btn-estado-cierre <?php echo $cerrado ? 'btn-success' : 'btn-warning'; ?>"
                                data-modulo="<?php echo $m[0]; ?>"
                                data-titulo="<?php echo $titulo; ?>"
                                data-anho="<?php echo $ano; ?>"
                                data-periodo="<?php echo htmlspecialchars(trim((string) $row['c_mes']), ENT_QUOTES, 'UTF-8'); ?>"
                                data-cerrado="<?php echo $cerrado ? '1' : '0'; ?>"
                                onclick="fn_CambiarCierre(this);">
                                <i class="<?php echo $cerrado ? 'ri-check-double-line' : 'ri-error-warning-line'; ?> label-icon align-middle fs-16 me-2"></i>
                                <?php echo $cerrado ? 'Cerrado' : 'Abierto'; ?>
                            </button>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<input type="hidden" id="cerrar_cc_local" value="<?php echo htmlspecialchars($cc_local, ENT_QUOTES, 'UTF-8'); ?>">