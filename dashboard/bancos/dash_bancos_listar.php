<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina(true);
require_once(u_src() . "bo/bo_banc_comprobantes_de_caja.php");
require_once(u_src() . "bo/bo_banc_saldos_bancos_cuentas.php");
require_once(u_src() . "bo/bo_banc_dietas.php");
require_once(u_src() . "bo/bo_banc_beneficiofam.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_comprobantes = new bo_banc_comprobantes_de_caja();
$bo_saldos = new bo_banc_saldos_bancos_cuentas();
$bo_dietas = new bo_banc_dietas();
$bo_fam = new bo_banc_beneficiofam();
$bo_parametro_detalle = new bo_gen_parametro_det();
$ent_fam = new banc_beneficiofam();

$anho = $_REQUEST['anho'] ?? date('Y');
$mes = $_REQUEST['mes'] ?? '';

$cc_local_sesion = s_local();
$es_admin_general = ($cc_local_sesion === '28');

// un consejo regional (no admin) SIEMPRE ve su propio consejo, sin importar
// qué venga en la petición — se fuerza aquí en el servidor. Para el admin
// general, '' (vacío) significa "todos los consejos" (consolidado).
$c_local_pedido = trim((string)($_REQUEST['c_local'] ?? ''));
$c_local = $es_admin_general ? $c_local_pedido : $cc_local_sesion;

$meses_nombre = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

// --- tarjetas KPI ---------------------------------------------------------
$data_ing = $bo_comprobantes->totalTipo($anho, $mes, $c_local, 'I');
$total_ingresos = round((float)($data_ing[0]['monto'] ?? 0), 2);

$data_egr = $bo_comprobantes->totalTipo($anho, $mes, $c_local, 'E');
$total_egresos = round((float)($data_egr[0]['monto'] ?? 0), 2);

$data_saldo = $bo_saldos->totalSaldo($anho, $mes, $c_local);
$total_saldo = round((float)($data_saldo[0]['total'] ?? 0), 2);

$data_dietas = $bo_dietas->totalDietas($anho, $mes, $c_local);
$total_dietas_cant = (int)($data_dietas[0]['cantidad'] ?? 0);
$total_dietas_monto = round((float)($data_dietas[0]['monto'] ?? 0), 2);

$ent_fam->setCod_anho($anho);
$ent_fam->setCod_mes($mes);
$ent_fam->setCc_local($c_local);
$data_fam = $bo_fam->resumen_total($ent_fam);
$total_fam_monto = 0;
$total_fam_cant = 0;
if (!empty($data_fam)) {
    $row = $data_fam[0];
    for ($t = 0; $t <= 5; $t++) {
        $total_fam_cant += (int)($row["cantidad_tipo_{$t}"] ?? 0);
        $total_fam_monto += (float)($row["monto_tipo_{$t}"] ?? 0);
    }
}

// --- ingresos vs egresos por mes ------------------------------------------
$data_ing_mes = $bo_comprobantes->montoPorMesTipo($anho, $c_local, 'I');
$mapa_ing = array_fill(1, 12, 0);
foreach ($data_ing_mes as $row) {
    $m = (int)$row['mes'];
    if ($m >= 1 && $m <= 12) $mapa_ing[$m] = round((float)$row['monto'], 2);
}

$data_egr_mes = $bo_comprobantes->montoPorMesTipo($anho, $c_local, 'E');
$mapa_egr = array_fill(1, 12, 0);
foreach ($data_egr_mes as $row) {
    $m = (int)$row['mes'];
    if ($m >= 1 && $m <= 12) $mapa_egr[$m] = round((float)$row['monto'], 2);
}

$mes_categorias = [];
$ingresos_series = [];
$egresos_series = [];
for ($m = 1; $m <= 12; $m++) {
    $mes_categorias[] = $meses_nombre[$m];
    $ingresos_series[] = $mapa_ing[$m];
    $egresos_series[] = $mapa_egr[$m];
}

// --- dietas por mes --------------------------------------------------------
$data_dietas_mes = $bo_dietas->montoPorMes($anho, $c_local);
$mapa_dietas_cant = array_fill(1, 12, 0);
$mapa_dietas_monto = array_fill(1, 12, 0);
foreach ($data_dietas_mes as $row) {
    $m = (int)$row['mes'];
    if ($m >= 1 && $m <= 12) {
        $mapa_dietas_cant[$m] = (int)$row['cantidad'];
        $mapa_dietas_monto[$m] = round((float)$row['monto'], 2);
    }
}
$dietas_cant_series = [];
$dietas_monto_series = [];
for ($m = 1; $m <= 12; $m++) {
    $dietas_cant_series[] = $mapa_dietas_cant[$m];
    $dietas_monto_series[] = $mapa_dietas_monto[$m];
}

// --- FAM por tipo (donut) ---------------------------------------------------
$data_tipo_fam = $bo_parametro_detalle->listarParametroDet('banc_beneficiofam', 'cod_tipo');
$fam_tipo_labels_base = [];
foreach ($data_tipo_fam as $t) {
    $fam_tipo_labels_base[(int)$t['cc_codigo']] = $t['detalle'];
}
$fam_tipo_labels = [];
$fam_tipo_series = [];
if (!empty($data_fam)) {
    $row = $data_fam[0];
    for ($t = 0; $t <= 5; $t++) {
        $monto_t = round((float)($row["monto_tipo_{$t}"] ?? 0), 2);
        if ($monto_t > 0) {
            $fam_tipo_labels[] = $fam_tipo_labels_base[$t] ?? "Tipo {$t}";
            $fam_tipo_series[] = $monto_t;
        }
    }
}
?>
<div class="row">
    <div class="col-md">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Ingresos</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($total_ingresos, 2) ?></h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                            <i class="ri-arrow-down-circle-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Egresos</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($total_egresos, 2) ?></h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-4">
                            <i class="ri-arrow-up-circle-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Saldo en bancos</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($total_saldo, 2) ?></h4>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                            <i class="ri-bank-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Dietas</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($total_dietas_monto, 2) ?></h4>
                        <p class="text-muted mb-0 fs-13"><?= $total_dietas_cant ?> registros</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                            <i class="ri-user-received-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">FAM</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($total_fam_monto, 2) ?></h4>
                        <p class="text-muted mb-0 fs-13"><?= $total_fam_cant ?> registros</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                            <i class="ri-hand-heart-line"></i>
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
                <h5 class="mb-1">Ingresos vs Egresos por mes</h5>
                <p class="text-muted mb-0 fs-13"><?= $anho ?> — comprobantes procesados</p>
            </div>
            <div class="card-body">
                <?php if (array_sum($ingresos_series) == 0 && array_sum($egresos_series) == 0): ?>
                    <div class="text-center p-4 text-muted">Sin movimientos registrados para este filtro.</div>
                <?php else: ?>
                    <div id="ing_egr_chart"
                        data-colors='["--vz-success", "--vz-danger"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-series-ingresos="<?= htmlspecialchars(json_encode($ingresos_series), ENT_QUOTES) ?>"
                        data-series-egresos="<?= htmlspecialchars(json_encode($egresos_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-7">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Dietas por mes</h5>
                <p class="text-muted mb-0 fs-13"><?= $anho ?></p>
            </div>
            <div class="card-body">
                <?php if (array_sum($dietas_cant_series) == 0): ?>
                    <div class="text-center p-4 text-muted">Sin dietas registradas para este filtro.</div>
                <?php else: ?>
                    <div id="dietas_mes_chart"
                        data-colors='["--vz-primary", "--vz-success"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($dietas_cant_series), ENT_QUOTES) ?>"
                        data-series-monto="<?= htmlspecialchars(json_encode($dietas_monto_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">FAM por tipo</h5>
                <p class="text-muted mb-0 fs-13">Monto — <?= $anho ?></p>
            </div>
            <div class="card-body">
                <?php if (empty($fam_tipo_series)): ?>
                    <div class="text-center p-4 text-muted">Sin beneficios FAM registrados para este filtro.</div>
                <?php else: ?>
                    <div id="fam_tipo_chart"
                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-info", "--vz-danger", "--vz-secondary"]'
                        data-labels="<?= htmlspecialchars(json_encode($fam_tipo_labels), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($fam_tipo_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
