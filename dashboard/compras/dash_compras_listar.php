<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina(true);
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");
require_once(u_src() . "bo/bo_comp_liquidaciones_caja_chica.php");

$bo_compras = new bo_comp_documentos_de_compras();
$bo_caja_chica = new bo_comp_liquidaciones_caja_chica();

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
$data_total = $bo_compras->totalCompras($anho, $mes, $c_local);
$total_cantidad = (int)($data_total[0]['cantidad'] ?? 0);
$total_monto = round((float)($data_total[0]['monto'] ?? 0), 2);

$data_estado = $bo_compras->estadoCompras($anho, $mes, $c_local);
$pendientes_cant = 0;
$pendientes_monto = 0;
$canceladas_cant = 0;
$canceladas_monto = 0;
foreach ($data_estado as $row) {
    if ($row['estado'] === 'P') {
        $pendientes_cant = (int)($row['cantidad'] ?? 0);
        $pendientes_monto = round((float)($row['monto'] ?? 0), 2);
    } else {
        $canceladas_cant = (int)($row['cantidad'] ?? 0);
        $canceladas_monto = round((float)($row['monto'] ?? 0), 2);
    }
}

// caja chica: fondo pendiente de rendir es un saldo actual (no depende del período elegido)
$data_cc_pendiente = $bo_caja_chica->totalPendientes($c_local);
$cc_pendiente_cant = (int)($data_cc_pendiente[0]['cantidad'] ?? 0);
$cc_pendiente_monto = round((float)($data_cc_pendiente[0]['monto'] ?? 0), 2);

// caja chica: monto ya rendido con documentos de compra dentro del período elegido
$data_cc_rendido = $bo_compras->totalRendidoCajaChica($anho, $mes, $c_local);
$cc_rendido_cant = (int)($data_cc_rendido[0]['cantidad'] ?? 0);
$cc_rendido_monto = round((float)($data_cc_rendido[0]['monto'] ?? 0), 2);

// --- compras por mes -------------------------------------------------------
$data_compras_mes = $bo_compras->montoPorMes($anho, $c_local);
$mapa_cant = array_fill(1, 12, 0);
$mapa_monto = array_fill(1, 12, 0);
foreach ($data_compras_mes as $row) {
    $m = (int)$row['mes'];
    if ($m >= 1 && $m <= 12) {
        $mapa_cant[$m] = (int)$row['cantidad'];
        $mapa_monto[$m] = round((float)$row['monto'], 2);
    }
}
$mes_categorias = [];
$compras_cant_series = [];
$compras_monto_series = [];
for ($m = 1; $m <= 12; $m++) {
    $mes_categorias[] = $meses_nombre[$m];
    $compras_cant_series[] = $mapa_cant[$m];
    $compras_monto_series[] = $mapa_monto[$m];
}

// --- estado de compras (donut) ---------------------------------------------
$estado_labels = [];
$estado_series = [];
if ($pendientes_monto > 0) {
    $estado_labels[] = 'Pendiente';
    $estado_series[] = $pendientes_monto;
}
if ($canceladas_monto > 0) {
    $estado_labels[] = 'Pagado';
    $estado_series[] = $canceladas_monto;
}

// --- top 5 proveedores -------------------------------------------------------
$data_prov = $bo_compras->topProveedores($anho, $mes, $c_local, 5);
$prov_labels = [];
$prov_series = [];
foreach ($data_prov as $row) {
    $prov_labels[] = $row['nombre'];
    $prov_series[] = round((float)$row['monto'], 2);
}

// --- caja chica: aperturas por mes ------------------------------------------
$data_cc_mes = $bo_caja_chica->montoPorMesApertura($anho, $c_local);
$mapa_cc_cant = array_fill(1, 12, 0);
$mapa_cc_monto = array_fill(1, 12, 0);
foreach ($data_cc_mes as $row) {
    $m = (int)$row['mes'];
    if ($m >= 1 && $m <= 12) {
        $mapa_cc_cant[$m] = (int)$row['cantidad'];
        $mapa_cc_monto[$m] = round((float)$row['monto'], 2);
    }
}
$cc_cant_series = [];
$cc_monto_series = [];
for ($m = 1; $m <= 12; $m++) {
    $cc_cant_series[] = $mapa_cc_cant[$m];
    $cc_monto_series[] = $mapa_cc_monto[$m];
}
?>
<div class="row">
    <div class="col-md">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Total Compras</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($total_monto, 2) ?></h4>
                        <p class="text-muted mb-0 fs-13"><?= $total_cantidad ?> documentos</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                            <i class="ri-shopping-cart-line"></i>
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
                        <p class="fw-medium text-muted mb-0">Pendientes de pago</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($pendientes_monto, 2) ?></h4>
                        <p class="text-muted mb-0 fs-13"><?= $pendientes_cant ?> documentos</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                            <i class="ri-hourglass-2-line"></i>
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
                        <p class="fw-medium text-muted mb-0">Pagadas</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($canceladas_monto, 2) ?></h4>
                        <p class="text-muted mb-0 fs-13"><?= $canceladas_cant ?> documentos</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                            <i class="ri-check-double-line"></i>
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
                        <p class="fw-medium text-muted mb-0">Caja chica pendiente</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($cc_pendiente_monto, 2) ?></h4>
                        <p class="text-muted mb-0 fs-13"><?= $cc_pendiente_cant ?> caja(s) abierta(s)</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                            <i class="ri-wallet-3-line"></i>
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
                        <p class="fw-medium text-muted mb-0">Caja chica rendida</p>
                        <h4 class="mt-3 ff-secondary fw-semibold">S/ <?= number_format($cc_rendido_monto, 2) ?></h4>
                        <p class="text-muted mb-0 fs-13"><?= $cc_rendido_cant ?> documentos — <?= $anho ?></p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                            <i class="ri-file-list-3-line"></i>
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
                <h5 class="mb-1">Compras por mes</h5>
                <p class="text-muted mb-0 fs-13"><?= $anho ?> — documentos procesados</p>
            </div>
            <div class="card-body">
                <?php if (array_sum($compras_cant_series) == 0): ?>
                    <div class="text-center p-4 text-muted">Sin compras registradas para este filtro.</div>
                <?php else: ?>
                    <div id="compras_mes_chart"
                        data-colors='["--vz-primary", "--vz-success"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($compras_cant_series), ENT_QUOTES) ?>"
                        data-series-monto="<?= htmlspecialchars(json_encode($compras_monto_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-5">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Estado de compras</h5>
                <p class="text-muted mb-0 fs-13">Monto — Pendiente vs Pagado</p>
            </div>
            <div class="card-body">
                <?php if (empty($estado_series)): ?>
                    <div class="text-center p-4 text-muted">Sin documentos para este filtro.</div>
                <?php else: ?>
                    <div id="compras_estado_chart"
                        data-colors='["--vz-warning", "--vz-success"]'
                        data-labels="<?= htmlspecialchars(json_encode($estado_labels), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($estado_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Top 5 proveedores</h5>
                <p class="text-muted mb-0 fs-13">Por monto — <?= $anho ?></p>
            </div>
            <div class="card-body">
                <?php if (empty($prov_series)): ?>
                    <div class="text-center p-4 text-muted">Sin proveedores para este filtro.</div>
                <?php else: ?>
                    <div id="compras_prov_chart"
                        data-colors='["--vz-primary"]'
                        data-labels="<?= htmlspecialchars(json_encode($prov_labels), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($prov_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card card-height-100">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Caja chica — aperturas por mes</h5>
                <p class="text-muted mb-0 fs-13"><?= $anho ?> — cantidad y monto de apertura (según fecha de apertura)</p>
            </div>
            <div class="card-body">
                <?php if (array_sum($cc_cant_series) == 0): ?>
                    <div class="text-center p-4 text-muted">Sin cajas chicas aperturadas para este filtro.</div>
                <?php else: ?>
                    <div id="cc_mes_chart"
                        data-colors='["--vz-info", "--vz-primary"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($cc_cant_series), ENT_QUOTES) ?>"
                        data-series-monto="<?= htmlspecialchars(json_encode($cc_monto_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
