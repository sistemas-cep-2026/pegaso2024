<?php
require_once dirname(dirname(__DIR__)) . "/util/seguridad.php";
require_once dirname(dirname(__DIR__)) . "/util/util.php";
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cap_eventos.php");

$bo_general = new bo_general();
$bo_eventos = new bo_cap_eventos();

$ent_eventos = new cap_eventos();

$cc_local = s_local();

$cod_ano = isset($_GET['anho']) && is_numeric($_GET['anho'])
    ? (int) $_GET['anho']
    : s_anho();

$ent_eventos->setCc_local($cc_local);
$ent_eventos->setFecha($cod_ano);

$data_totalev = $bo_eventos->canti_eventos_anho($ent_eventos);
$data_even_total = $data_totalev[0]['total_eventos'] ?? 0;

$data_nevento = $bo_eventos->canti_eventos_local($ent_eventos);
$data_even_local = $data_nevento[0]['cant_eventos'] ?? 0;

$porcentaje = $data_even_total > 0
    ? round(($data_even_local / $data_even_total) * 100, 2)
    : 0;
$data_part_total = $bo_eventos->asistentes_anho($ent_eventos);
$total_asi  = $data_part_total[0]['n_asistentes'] ?? 0;
$total_pone = $data_part_total[0]['n_ponentes'] ?? 0;
$total_orga = $data_part_total[0]['n_organizadores'] ?? 0;

$data_local_total = $bo_eventos->asistentes_local($ent_eventos);
$total_local_asi  = $data_local_total[0]['n_asistentes'] ?? 0;
$total_local_pone = $data_local_total[0]['n_ponentes'] ?? 0;
$total_local_orga = $data_local_total[0]['n_organizadores'] ?? 0;

$porcentaje_asis   = $total_asi  > 0 ? round(($total_local_asi  / $total_asi)  * 100, 2) : 0;
$porcentaje_ponent = $total_pone > 0 ? round(($total_local_pone / $total_pone) * 100, 2) : 0;
$porcentaje_organ  = $total_orga > 0 ? round(($total_local_orga / $total_orga) * 100, 2) : 0;

// colegiados (enfermeros) vs no colegiados, entre los asistentes del local/año seleccionado
$data_coleg_otros = $bo_eventos->coleg_otros($ent_eventos);
$total_colegiados = $data_coleg_otros[0]['colegiados'] ?? 0;
$total_no_colegiados = $data_coleg_otros[0]['no_colegiados'] ?? 0;
$total_coleg_base = $total_colegiados + $total_no_colegiados;
$porcentaje_colegiados = $total_coleg_base > 0 ? round(($total_colegiados / $total_coleg_base) * 100, 2) : 0;
$porcentaje_no_colegiados = $total_coleg_base > 0 ? round(($total_no_colegiados / $total_coleg_base) * 100, 2) : 0;

$data_regional = $bo_general->RegionID($cc_local);
$cc_local_text = '';
foreach ($data_regional as $row) {
    $cc_local_text = $row['nombre'];
}

// top 10 colegiadas con más cursos en el año/local seleccionado
$data_top_coleg = $bo_eventos->topColegiadosCursos($ent_eventos);

// grupo etario de los asistentes del año/local seleccionado
$data_grupo_etario = $bo_eventos->grupoEtario($ent_eventos);
$orden_etario = ['< 25', '25-34', '35-44', '45-54', '55-64', '65+', 'S/D'];
$mapa_etario = array_fill_keys($orden_etario, 0);
foreach ($data_grupo_etario as $row) {
    if (isset($mapa_etario[$row['grupo_etario']])) {
        $mapa_etario[$row['grupo_etario']] = (int)$row['total'];
    }
}
// oculta el bucket S/D si no tiene datos, para no ensuciar el gráfico
if ($mapa_etario['S/D'] == 0) {
    unset($mapa_etario['S/D']);
}
$etario_categorias = array_keys($mapa_etario);
$etario_totales = array_values($mapa_etario);

$data_ano = $bo_eventos->listarAnhos();
?>

<div class="row">
    <div class="col-xxl-12">
        <div class="col-12">
            <div class="d-flex align-items-lg-center flex-lg-row flex-column">

                <div class="flex-grow-1">
                    <h4 class="fs-16 mb-1">Informes de eventos</h4>
                    <p class="text-muted mb-3">
                        Datos anuales de eventos del <?= htmlspecialchars($cc_local_text) ?>
                    </p>
                </div>
                <div class="mt-3 mt-lg-0">
                    <div class="dropdown card-header-dropdown">

                        <a class="text-reset dropdown-btn" href="#"
                            data-bs-toggle="dropdown">
                            <span class="fw-semibold text-uppercase fs-12">
                                <?= $cod_ano ?>
                                <i class="mdi mdi-chevron-down ms-1"></i>
                            </span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <?php foreach ($data_ano as $cod): ?>
                                <a class="dropdown-item <?= ($cod_ano == (int)$cod['anho']) ? 'active' : '' ?>"
                                    href="?<?= http_build_query(array_merge($_GET, ['anho' => $cod['anho']])) ?>">
                                    <?= htmlspecialchars($cod['anho']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="d-flex flex-column h-100">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Eventos</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value" data-target="<?= $data_even_local ?>">0</span> Eventos
                                    </h2>
                                    <p class="mb-0 text-muted">
                                        <span class="badge bg-light text-success mb-0">
                                            <i class="ri-arrow-up-line"></i> <?= $porcentaje ?> %
                                        </span> de eventos
                                    </p>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                        <i class="ri-calendar-event-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Asistentes</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value" data-target="<?= $total_local_asi ?>">0</span>
                                    </h2>
                                    <span class="badge bg-light text-success">
                                        <?= $porcentaje_asis ?> %
                                    </span>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-4">
                                        <i class="ri-user-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Ponentes</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value" data-target="<?= $total_local_pone ?>">0</span>
                                    </h2>
                                    <span class="badge bg-light text-success">
                                        <?= $porcentaje_ponent ?> %
                                    </span>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                                        <i class="ri-mic-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="fw-medium text-muted mb-0">Organizadores</p>
                                    <h2 class="mt-4 ff-secondary fw-semibold">
                                        <span class="counter-value" data-target="<?= $total_local_orga ?>">0</span>
                                    </h2>
                                    <span class="badge bg-light text-success">
                                        <?= $porcentaje_organ ?> %
                                    </span>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                                        <i class="ri-team-line"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Asistencia por Consejo Regional</h5>
            </div>

            <div class="card-body p-0 pb-2">
                <div id="audiences_metrics_charts"
                    data-colors='["--vz-success","--vz-light"]'
                    data-url="<?= url('dashboard/capacitacion/data.php') . '?anho=' . $cod_ano ?>"
                    class="apex-charts">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Colegiados vs No colegiados</h5>
                <p class="text-muted mb-0 fs-13">Asistentes del <?= htmlspecialchars($cc_local_text) ?>, <?= $cod_ano ?></p>
            </div>
            <div class="card-body">
                <div id="colegiados_donut_chart"
                    data-colors='["--vz-success", "--vz-warning"]'
                    data-series="<?= htmlspecialchars(json_encode([(int)$total_colegiados, (int)$total_no_colegiados]), ENT_QUOTES) ?>"
                    class="apex-charts">
                </div>
                <div class="d-flex justify-content-center gap-4 mt-2">
                    <div class="text-center">
                        <h5 class="mb-0"><?= $total_colegiados ?></h5>
                        <p class="text-muted mb-0 fs-13">Colegiados (<?= $porcentaje_colegiados ?>%)</p>
                    </div>
                    <div class="text-center">
                        <h5 class="mb-0"><?= $total_no_colegiados ?></h5>
                        <p class="text-muted mb-0 fs-13">No colegiados (<?= $porcentaje_no_colegiados ?>%)</p>
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
                <h5 class="mb-1">Top 10 colegiadas con más cursos</h5>
                <p class="text-muted mb-0 fs-13">Asistentes del <?= htmlspecialchars($cc_local_text) ?>, <?= $cod_ano ?></p>
            </div>
            <div class="card-body">
                <?php if (empty($data_top_coleg)): ?>
                    <div class="text-center p-3 text-muted">Sin datos para el periodo seleccionado.</div>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php $rank = 1;
                        foreach ($data_top_coleg as $row): ?>
                            <li class="list-group-item d-flex align-items-center px-0">
                                <div class="avatar-xs flex-shrink-0 me-3">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fw-semibold">
                                        <?= $rank ?>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0"><?= htmlspecialchars($row['nombre']) ?></h6>
                                    <p class="text-muted mb-0 fs-13">CEP : <?= htmlspecialchars($row['c_cmp']) ?></p>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-primary-subtle text-primary fs-12 p-2">
                                        <i class="ri-graduation-cap-line align-middle me-1"></i><?= (int)$row['total_cursos'] ?> curso<?= $row['total_cursos'] != 1 ? 's' : '' ?>
                                    </span>
                                </div>
                            </li>
                        <?php $rank++;
                        endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header bg-light-subtle">
                <h5 class="mb-1">Grupo etario</h5>
                <p class="text-muted mb-0 fs-13">Asistentes del <?= htmlspecialchars($cc_local_text) ?>, <?= $cod_ano ?></p>
            </div>
            <div class="card-body">
                <div id="grupo_etario_chart"
                    data-colors='["--vz-info"]'
                    data-categories="<?= htmlspecialchars(json_encode($etario_categorias), ENT_QUOTES) ?>"
                    data-series="<?= htmlspecialchars(json_encode($etario_totales), ENT_QUOTES) ?>"
                    class="apex-charts">
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$include_scripts = function () {
    return importapexcharts();
};
?>