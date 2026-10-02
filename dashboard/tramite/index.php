<?php
require_once(dirname(dirname(__DIR__)) . "/util/seguridad.php");
require_once(dirname(dirname(__DIR__)) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
require_once(u_src() . "bo/bo_tram_permisos.php");
require_once(u_src() . "bo/bo_tram_honorabilidad.php");
require_once(u_src() . "bo/bo_gen_personas_discapacidad.php");
require_once(u_src() . "bo/bo_tram_actividad_sustento.php");

$bo_general = new bo_general();
$bo_docs_recibidos = new bo_tram_documentos_recibidos();
$bo_permisos = new bo_tram_permisos();
$bo_honorabilidad = new bo_tram_honorabilidad();
$bo_discapacidad = new bo_gen_personas_discapacidad();
$bo_horas_extras = new bo_tram_actividad_sustento();

$cc_local = s_local();
// c_local='28' es el administrador general (Consejo Nacional): debe ver el consolidado
// de TODOS los consejos regionales, no solo sus propios registros. Se convierte a
// cadena vacía para que los filtros condicionales de los BO lo omitan.
$c_local_filtro = ($cc_local === '28') ? '' : $cc_local;
$anho = date('Y');

// nombre del consejo (local) de la sesión, para dejar explícito en pantalla qué se está mostrando
$data_local = $bo_general->RegionID($cc_local);
$cc_local_text = '';
foreach ($data_local as $loc) {
    $cc_local_text = $loc['nombre'];
}
$ambito_text = ($cc_local === '28') ? 'Todos los consejos regionales' : $cc_local_text;

// --- tarjetas ------------------------------------------------------------
$data_recibidos = $bo_docs_recibidos->cantidadPorLocal($c_local_filtro, $anho);
$total_recibidos = $data_recibidos[0]['cantidad'] ?? 0;

$data_permisos_vig = $bo_permisos->cantidadVigentes($c_local_filtro);
$total_permisos_vig = $data_permisos_vig[0]['cantidad'] ?? 0;

$data_hono = $bo_honorabilidad->cantidadPorLocal($c_local_filtro, $anho);
$total_hono = $data_hono[0]['cantidad'] ?? 0;

$data_discapacidad = $bo_discapacidad->cantidadPorLocal($c_local_filtro, $anho);
$total_discapacidad = $data_discapacidad[0]['cantidad'] ?? 0;

$data_horas_extras = $bo_horas_extras->cantidadPorLocal($c_local_filtro, $anho);
$total_horas_extras = $data_horas_extras[0]['cantidad'] ?? 0;

// --- gráfico: documentos recibidos por estado -----------------------------
$data_estado = $bo_docs_recibidos->porEstado($c_local_filtro, $anho);
$estado_labels = array_map(fn($r) => $r['estado'] ?: 'Sin estado', $data_estado);
$estado_series = array_map(fn($r) => (int)$r['cantidad'], $data_estado);

// --- gráfico: documentos recibidos por mes ---------------------------------
$meses_nombre = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
$data_mes = $bo_docs_recibidos->porMes($c_local_filtro, $anho);
$mapa_mes = array_fill(1, 12, 0);
foreach ($data_mes as $row) {
    $mapa_mes[(int)$row['mes']] = (int)$row['cantidad'];
}
$mes_categorias = [];
$mes_series = [];
foreach ($mapa_mes as $num => $cant) {
    $mes_categorias[] = $meses_nombre[$num];
    $mes_series[] = $cant;
}
?>
<div class="row">
    <div class="col-12">
        <p class="text-muted mb-3">
            <?php if ($cc_local === '28'): ?>
                Mostrando el <strong>consolidado de todos los consejos regionales</strong> — año <?= $anho ?>
            <?php else: ?>
                Mostrando información de <strong><?= htmlspecialchars($cc_local_text) ?></strong> — año <?= $anho ?>
            <?php endif; ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Documentos recibidos</p>
                        <h2 class="mt-3 ff-secondary fw-semibold">
                            <span class="counter-value" data-target="<?= $total_recibidos ?>">0</span>
                        </h2>
                        <p class="text-muted mb-0">en <?= $anho ?></p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                            <i class="ri-inbox-archive-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Permisos vigentes</p>
                        <h2 class="mt-3 ff-secondary fw-semibold">
                            <span class="counter-value" data-target="<?= $total_permisos_vig ?>">0</span>
                        </h2>
                        <p class="text-muted mb-0">no anulados</p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                            <i class="ri-file-user-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Honorabilidad</p>
                        <h2 class="mt-3 ff-secondary fw-semibold">
                            <span class="counter-value" data-target="<?= $total_hono ?>">0</span>
                        </h2>
                        <p class="text-muted mb-0">emitidas en <?= $anho ?></p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                            <i class="ri-award-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Discapacidad</p>
                        <h2 class="mt-3 ff-secondary fw-semibold">
                            <span class="counter-value" data-target="<?= $total_discapacidad ?>">0</span>
                        </h2>
                        <p class="text-muted mb-0">registros en <?= $anho ?></p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                            <i class="ri-wheelchair-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="fw-medium text-muted mb-0">Horas extras</p>
                        <h2 class="mt-3 ff-secondary fw-semibold">
                            <span class="counter-value" data-target="<?= $total_horas_extras ?>">0</span>
                        </h2>
                        <p class="text-muted mb-0">actividades en <?= $anho ?></p>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-4">
                            <i class="ri-time-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Documentos recibidos por mes</h5>
                <p class="text-muted mb-0 fs-13"><?= htmlspecialchars($ambito_text) ?>, <?= $anho ?></p>
            </div>
            <div class="card-body">
                <?php if (array_sum($mes_series) === 0): ?>
                    <div class="text-center p-4 text-muted">Sin documentos recibidos registrados en <?= $anho ?>.</div>
                <?php else: ?>
                    <div id="docs_recibidos_mes_chart"
                        data-colors='["--vz-primary"]'
                        data-categories="<?= htmlspecialchars(json_encode($mes_categorias), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($mes_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Documentos recibidos por estado</h5>
                <p class="text-muted mb-0 fs-13"><?= htmlspecialchars($ambito_text) ?>, <?= $anho ?></p>
            </div>
            <div class="card-body">
                <?php if (empty($estado_series)): ?>
                    <div class="text-center p-4 text-muted">Sin datos para el periodo.</div>
                <?php else: ?>
                    <div id="docs_recibidos_estado_chart"
                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                        data-labels="<?= htmlspecialchars(json_encode($estado_labels), ENT_QUOTES) ?>"
                        data-series="<?= htmlspecialchars(json_encode($estado_series), ENT_QUOTES) ?>"
                        class="apex-charts">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$include_scripts = function () {
    return importapexcharts();
};
?>
