<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina(true);
require_once(u_src() . "bo/bo_alm_dashboard.php");

$bo = new bo_alm_dashboard();

$anho = (int) ($_REQUEST['anho'] ?? date('Y'));
if ($anho < 2000 || $anho > 2100) {
    $anho = (int) date('Y');
}
$mes = (string) ($_REQUEST['mes'] ?? '');
$mes = (ctype_digit($mes) && (int) $mes >= 1 && (int) $mes <= 12) ? (int) $mes : 0;

$cc_local_sesion = s_local();
$es_admin_general = ($cc_local_sesion === '28');
// Un consejo regional SIEMPRE ve su propio consejo, venga lo que venga en la petición.
$c_local_pedido = trim((string) ($_REQUEST['c_local'] ?? ''));
$c_local = $es_admin_general ? $c_local_pedido : $cc_local_sesion;
if ($c_local !== '' && !preg_match('/^[0-9A-Za-z]{1,2}$/', $c_local)) {
    $c_local = $cc_local_sesion;
}

$meses_nombre = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
$meses_largo = u_meses();
$periodo_text = $mes > 0 ? $meses_largo[sprintf('%02d', $mes)] . ' ' . $anho : 'Año ' . $anho;

function dash_alm_h($t)
{
    return htmlspecialchars(trim((string) $t), ENT_QUOTES, 'UTF-8');
}

function dash_alm_num($v)
{
    $v = (float) $v;
    return number_format($v, (floor($v) == $v) ? 0 : 2, '.', ',');
}

function dash_alm_codigo($c)
{
    $s = ltrim(trim((string) $c), '0');
    return str_pad($s === '' ? '0' : $s, 6, '0', STR_PAD_LEFT);
}

// --- tarjetas ---------------------------------------------------------------
$r = $bo->kpiRequisiciones($anho, $mes, $c_local);
$req_total = (int) ($r[0]['total'] ?? 0);
$req_pend = (int) ($r[0]['pendientes'] ?? 0);

$r = $bo->kpiGuias('E', $anho, $mes, $c_local);
$ent_total = (int) ($r[0]['total'] ?? 0);
$ent_pend = (int) ($r[0]['pendientes'] ?? 0);

$r = $bo->kpiGuias('S', $anho, $mes, $c_local);
$sal_total = (int) ($r[0]['total'] ?? 0);
$sal_pend = (int) ($r[0]['pendientes'] ?? 0);

$sin_stock = null;
if ($c_local !== '') {
    $r = $bo->totalSinStock($c_local, 6);
    $sin_stock = (int) ($r[0]['total'] ?? 0);
}

// --- entradas y salidas por mes ---------------------------------------------
$ent_doc = array_fill(1, 12, 0);
$ent_uni = array_fill(1, 12, 0);
$sal_doc = array_fill(1, 12, 0);
$sal_uni = array_fill(1, 12, 0);
foreach ($bo->movimientosPorMes('E', $anho, $c_local) as $row) {
    $m = (int) $row['mes'];
    if ($m >= 1 && $m <= 12) {
        $ent_doc[$m] = (int) $row['documentos'];
        $ent_uni[$m] = round((float) $row['unidades'], 2);
    }
}
foreach ($bo->movimientosPorMes('S', $anho, $c_local) as $row) {
    $m = (int) $row['mes'];
    if ($m >= 1 && $m <= 12) {
        $sal_doc[$m] = (int) $row['documentos'];
        $sal_uni[$m] = round((float) $row['unidades'], 2);
    }
}
$mes_categorias = array_slice($meses_nombre, 1);
$ent_doc = array_values($ent_doc);
$sal_doc = array_values($sal_doc);
$ent_uni = array_values($ent_uni);
$sal_uni = array_values($sal_uni);

// --- top artículos y familias ----------------------------------------------

$data_top = $bo->topArticulos($anho, $mes, $c_local, 10);

$fam_labels = [];
$fam_series = [];
foreach ($bo->consumoPorFamilia($anho, $mes, $c_local) as $row) {
    $fam_labels[] = trim((string) $row['familia']);
    $fam_series[] = round((float) $row['unidades'], 2);
}

// --- tablas -------------------------------------------------------------------
$data_stock = ($c_local !== '') ? $bo->stockBajo($c_local, 6, 15) : [];

$tarjetas = [
    ['Requisiciones', $req_total, $req_pend . ' pendiente(s) de atender', 'ri-file-list-3-line', 'primary'],
    ['Guías de entrada', $ent_total, $ent_pend . ' pendiente(s) de kardex', 'ri-inbox-archive-line', 'success'],
    ['Vales de salida', $sal_total, $sal_pend . ' pendiente(s) de kardex', 'ri-inbox-unarchive-line', 'info'],
    ['Artículos sin stock', ($sin_stock === null ? '—' : $sin_stock), ($sin_stock === null ? 'Elija un consejo' : 'con consumo en los últimos 6 meses'), 'ri-error-warning-line', 'danger'],
];
?>
<div class="row">
    <?php foreach ($tarjetas as $t): ?>
        <div class="col-md-6 col-xl-3">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="fw-medium text-muted mb-0"><?= dash_alm_h($t[0]) ?></p>
                            <h4 class="mt-3 ff-secondary fw-semibold"><?= dash_alm_h($t[1]) ?></h4>
                            <p class="text-muted mb-0 fs-13"><?= dash_alm_h($t[2]) ?></p>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-<?= $t[4] ?>-subtle text-<?= $t[4] ?> rounded-circle fs-4">
                                <i class="<?= $t[3] ?>"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<p class="text-muted fs-12 mt-n2 mb-3">Período: <?= dash_alm_h($periodo_text) ?>. No se cuentan documentos anulados ni en registro.</p>

<div class="row">
    <div class="col-xl-6">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Documentos por mes</h5>
                <p class="text-muted mb-0 fs-13"><?= $anho ?> — guías de entrada y vales de salida</p>
            </div>
            <div class="card-body">
                <?php if (array_sum($ent_doc) + array_sum($sal_doc) == 0): ?>
                    <div class="text-center p-4 text-muted">Sin movimientos registrados en <?= $anho ?>.</div>
                <?php else: ?>
                    <div id="alm_mes_chart" class="apex-charts"
                        data-colors='["--vz-success", "--vz-info"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-ent-doc="<?= htmlspecialchars(json_encode($ent_doc), ENT_QUOTES) ?>"
                        data-sal-doc="<?= htmlspecialchars(json_encode($sal_doc), ENT_QUOTES) ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Unidades por mes</h5>
                <p class="text-muted mb-0 fs-13"><?= $anho ?> — unidades ingresadas y entregadas</p>
            </div>
            <div class="card-body">
                <?php if (array_sum($ent_uni) + array_sum($sal_uni) == 0): ?>
                    <div class="text-center p-4 text-muted">Sin movimientos registrados en <?= $anho ?>.</div>
                <?php else: ?>
                    <div id="alm_mes_uni_chart" class="apex-charts"
                        data-colors='["--vz-success", "--vz-info"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-ent-uni="<?= htmlspecialchars(json_encode($ent_uni), ENT_QUOTES) ?>"
                        data-sal-uni="<?= htmlspecialchars(json_encode($sal_uni), ENT_QUOTES) ?>">
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
                <h5 class="mb-1">Artículos más consumidos</h5>
                <p class="text-muted mb-0 fs-13"><?= dash_alm_h($periodo_text) ?> — top 10</p>
            </div>
            <div class="card-body p-0">
                <?php if (empty($data_top)): ?>
                    <div class="text-center p-4 text-muted">Sin vales de salida para este filtro.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Código</th>
                                    <th>Artículo</th>
                                    <th>Unidad</th>
                                    <th class="text-end">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($data_top as $row): ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><?= dash_alm_h(dash_alm_codigo($row['c_articulo'])) ?></td>
                                        <td><?= dash_alm_h($row['nombre']) ?></td>
                                        <td><?= dash_alm_h($row['unidad']) ?></td>
                                        <td class="text-end fw-semibold"><?= dash_alm_num($row['unidades']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Consumo por familia</h5>
                <p class="text-muted mb-0 fs-13"><?= dash_alm_h($periodo_text) ?> — unidades entregadas</p>
            </div>
            <div class="card-body">
                <?php if (empty($fam_series)): ?>
                    <div class="text-center p-4 text-muted">Sin vales de salida para este filtro.</div>
                <?php else: ?>
                    <div id="alm_familia_chart" class="apex-charts"
                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-info", "--vz-danger", "--vz-secondary"]'
                        data-labels="<?= htmlspecialchars(json_encode($fam_labels), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($fam_series), ENT_QUOTES) ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Artículos por reponer</h5>
                <p class="text-muted mb-0 fs-13">Consumidos en los últimos 6 meses cuyo stock actual no cubre un mes de consumo promedio</p>
            </div>
            <div class="card-body p-0">
                <?php if ($c_local === ''): ?>
                    <div class="text-center p-4 text-muted">Elija un consejo para ver el stock.</div>
                <?php elseif (empty($data_stock)): ?>
                    <div class="text-center p-4 text-muted">Ningún artículo por debajo de un mes de consumo.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Artículo</th>
                                    <th>Unidad</th>
                                    <th class="text-end">Stock actual</th>
                                    <th class="text-end">Consumo prom./mes</th>
                                    <th class="text-end">Cobertura</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_stock as $row):
                                    $stock = (float) $row['stock'];
                                    $prom = (float) $row['promedio_mes'];
                                    $dias_cob = ($prom > 0 && $stock > 0) ? (int) floor($stock / $prom * 30) : 0;
                                    $color = $stock <= 0 ? 'danger' : 'warning'; ?>
                                    <tr>
                                        <td><?= dash_alm_h(dash_alm_codigo($row['c_articulo'])) ?></td>
                                        <td><?= dash_alm_h($row['nombre']) ?></td>
                                        <td><?= dash_alm_h($row['unidad']) ?></td>
                                        <td class="text-end"><?= dash_alm_num($stock) ?></td>
                                        <td class="text-end"><?= number_format($prom, 1) ?></td>
                                        <td class="text-end"><span class="badge bg-<?= $color ?>-subtle text-<?= $color ?>"><?= $stock <= 0 ? 'Sin stock' : ('~' . $dias_cob . ' días') ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
