<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");
require_once(u_src() . "bo/bo_bbva_proceso_detalle.php");
require_once(u_src() . "bo/bo_bcp_proceso_detalle.php");

$bo_documentos_venta = new bo_fin_documentos_de_venta();
$bo_bbva = new bo_bbva_proceso_detalle();
$bo_bcp = new bo_bcp_proceso_detalle();

$anho = $_REQUEST['anho'] ?? date('Y');
$mes = $_REQUEST['mes'] ?? '';

$cc_local_sesion = s_local();
$es_admin_general = ($cc_local_sesion === '28');


$c_local_pedido = trim((string)($_REQUEST['c_local'] ?? ''));
$c_local = ($es_admin_general && $c_local_pedido !== '') ? $c_local_pedido : $cc_local_sesion;

$meses_nombre = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];


$data_bbva = $bo_bbva->ultimaActualizacion();
$ultimo_bbva = $data_bbva[0]['ultimo'] ?? 'Sin registros';

$data_bcp = $bo_bcp->ultimaActualizacion();
$ultimo_bcp = $data_bcp[0]['ultimo'] ?? 'Sin registros';


$data_recibos = $bo_documentos_venta->cantidadRecibos($anho, $mes, $c_local);
$total_recibos = $data_recibos[0]['cantidad'] ?? 0;
$total_recibos_monto = $data_recibos[0]['monto'] ?? 0;

$data_mes = $bo_documentos_venta->recibosPorMes($anho, $c_local);
$mapa_mes = array_fill(1, 12, 0);
$mapa_mes_monto = array_fill(1, 12, 0);
foreach ($data_mes as $row) {
    $mes_num = (int)$row['mes'];
    if ($mes_num >= 1 && $mes_num <= 12) {
        $mapa_mes[$mes_num] = (int)$row['cantidad'];
        $mapa_mes_monto[$mes_num] = round((float)$row['monto'], 2);
    }
}
$mes_categorias = [];
$mes_series = [];
$mes_series_monto = [];
foreach ($mapa_mes as $num => $cant) {
    $mes_categorias[] = $meses_nombre[$num];
    $mes_series[] = $cant;
    $mes_series_monto[] = $mapa_mes_monto[$num];
}


$data_bbva_mes = $bo_bbva->montoPorMes($anho, $c_local);
$mapa_bbva_mes = array_fill(1, 12, 0);
foreach ($data_bbva_mes as $row) {
    $mes_num = (int)$row['mes'];
    if ($mes_num >= 1 && $mes_num <= 12) {
        $mapa_bbva_mes[$mes_num] = round((float)$row['monto'], 2);
    }
}
$bbva_mes_series = array_values($mapa_bbva_mes);


$data_bcp_mes = $bo_bcp->montoPorMes($anho, $c_local);
$mapa_bcp_mes = array_fill(1, 12, 0);
foreach ($data_bcp_mes as $row) {
    $mes_num = (int)$row['mes'];
    if ($mes_num >= 1 && $mes_num <= 12) {
        $mapa_bcp_mes[$mes_num] = round((float)$row['monto'], 2);
    }
}
$bcp_mes_series = array_values($mapa_bcp_mes);
?>
<div class="row">
    <div class="col-md-4">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Recaudadora BCP</p>
                        <h5 class="mt-3 fw-semibold"><?= htmlspecialchars($ultimo_bcp) ?></h5>
                        <p class="text-muted mb-0">última actualización</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                            <i class="ri-bank-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Recaudadora BBVA</p>
                        <h5 class="mt-3 fw-semibold"><?= htmlspecialchars($ultimo_bbva) ?></h5>
                        <p class="text-muted mb-0">última actualización</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                            <i class="ri-bank-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Número de recibos</p>
                        <h2 class="mt-3 ff-secondary fw-semibold">
                            <h5 class="mt-3 fw-semibold"><?= (int)$total_recibos ?></h5>
                        </h2>
                        <p class="text-muted mb-0">
                            S/ <?= number_format((float)$total_recibos_monto, 2) ?> — según filtro
                        </p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                            <i class="ri-wallet-3-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Recibos internos por mes</h5>
                <p class="text-muted mb-0 fs-13">Año: <?= $anho ?></p>
            </div>
            <div class="card-body">
                <?php if (array_sum($mes_series) === 0): ?>
                    <div class="text-center p-4 text-muted">Sin recibos registrados para este filtro.</div>
                <?php else: ?>
                    <div id="recibos_mes_chart"
                        data-colors='["--vz-primary", "--vz-success"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($mes_series), ENT_QUOTES) ?>"
                        data-series-monto="<?= htmlspecialchars(json_encode($mes_series_monto), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Monto recaudado BBVA por mes</h5>
                <p class="text-muted mb-0 fs-13">Año: <?= $anho ?></p>
            </div>
            <div class="card-body">
                <?php if (array_sum($bbva_mes_series) == 0): ?>
                    <div class="text-center p-4 text-muted">Sin recaudo BBVA procesado para este filtro.</div>
                <?php else: ?>
                    <div id="bbva_mes_chart"
                        data-colors='["--vz-warning"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($bbva_mes_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Monto recaudado BCP por mes</h5>
                <p class="text-muted mb-0 fs-13">Año: <?= $anho ?></p>
            </div>
            <div class="card-body">
                <?php if (array_sum($bcp_mes_series) == 0): ?>
                    <div class="text-center p-4 text-muted">Sin recaudo BCP procesado para este filtro.</div>
                <?php else: ?>
                    <div id="bcp_mes_chart"
                        data-colors='["--vz-info"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($bcp_mes_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>