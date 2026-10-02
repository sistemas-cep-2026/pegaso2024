<?php
require_once dirname(dirname(__DIR__)) . "/util/seguridad.php";
require_once dirname(dirname(__DIR__)) . "/util/util.php";
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once u_src() . "bo/bo_nps_respuestas.php";

$bo_nps_resp   = new bo_nps_respuestas();
$ent_nps_resp  = new nps_respuestas();

$data_respt = $bo_nps_resp->numeroClasificacion($ent_nps_resp);
$data_personas = $bo_nps_resp->Canti_particopantes($ent_nps_resp);
$personas_tal = $data_personas[0]['total_personas'];

$data_ultimo = $bo_nps_resp->ultomo_registro($ent_nps_resp);
foreach ($data_ultimo as $fec) {
    $ultima_fe = $fec['ultimo_registro'];
}

$promotores = 0;
$pasivos = 0;
$detractores = 0;

if (is_array($data_respt) && count($data_respt) > 0) {
    $row = $data_respt[0];
    $promotores = (float)($row['promotores'] ?? 0);
    $pasivos    = (float)($row['pasivos'] ?? 0);
    $detractores = (float)($row['detractores'] ?? 0);

    $promotores__pct = (float)($row['promotores_pct'] ?? 0);
    $pasivos__pct    = (float)($row['pasivos_pct'] ?? 0);
    $detractores__pct = (float)($row['detractores_pct'] ?? 0);

    $nps = (float)($row['nps'] ?? 0);
}
$data_todos = $bo_nps_resp->total_local();
?>
<div class="row">
    <div class="col-xl-4">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">NPS - CLASIFICACIÓN</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div id="charts_nps_clasificacion"
                    data-colors='["#096509", "#ffc107", "#ff0000"]'
                    data-url="<?= url('dashboard/peo/data.php') ?>"
                    class="apex-charts" dir="ltr">
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
                        <tbody class="border-0">
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-verde me-2"></i>Promotores</h4>
                                </td>
                                <td>
                                    <p class="text-muted mb-0"><i data-feather="help-circle" class="me-2 icon-sm"></i><?= $promotores ?></p>
                                </td>
                                <td class="text-end">
                                    <p class="text-success fw-medium fs-12 mb-0"><i class="ri-arrow-up-s-fill fs-5 align-middle"></i><?= decimal($promotores__pct, 1) ?>%
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-amarillo me-2"></i>Neutros</h4>
                                </td>
                                <td>
                                    <p class="text-muted mb-0"><i data-feather="help-circle" class="me-2 icon-sm"></i><?= $pasivos ?></p>
                                </td>
                                <td class="text-end">
                                    <p class="text-success fw-medium fs-12 mb-0"><i class="ri-arrow-up-s-fill fs-5 align-middle"></i><?= decimal($pasivos__pct, 1) ?>%
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-rojo me-2"></i>Detractores</h4>
                                </td>
                                <td>
                                    <p class="text-muted mb-0"><i data-feather="help-circle" class="me-2 icon-sm"></i><?= $detractores ?></p>
                                </td>
                                <td class="text-end">
                                    <p class="text-success fw-medium fs-12 mb-0"><i class="ri-arrow-up-s-fill fs-5 align-middle"></i><?= decimal($detractores__pct, 1) ?>%
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">NPS (Net Promoter Score)</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="<?= $nps ?>">0</span> </h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary rounded-circle fs-2">
                                        <i data-feather="activity"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Participantes</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="<?= $personas_tal ?>">0</span> Encuestados</h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary rounded-circle fs-2">
                                        <i data-feather="users"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Último registro</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><?= $ultima_fe  ?></h2>
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-danger rounded-circle fs-2">
                                        <i data-feather="calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->
    </div>
    <div class="col-xl-5">
        <div class="card card-height-100">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Sector laboral</h4>
            </div>
            <div class="card-body p-0">
                <div id="countries_charts"
                    data-colors='["--vz-success","--vz-primary","--vz-warning","--vz-info","--vz-danger","--vz-secondary"]'
                    data-url="<?= url('dashboard/peo/data.php?op=barras_sector') ?>"
                    class="apex-charts" dir="ltr">
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div>
</div><!-- end row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header p-0 border-0 bg-light-subtle">
                <div class="row g-0 text-center">
                    <div class="col-6 col-sm-4">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1">Participación por Consejo Regional</h5>
                        </div>
                    </div>
                </div>
            </div><!-- end card header -->
            <div class="card-body p-0 pb-2">
                <div id="audiences_metrics_charts"
                    data-colors='["--vz-success","--vz-light"]'
                    data-url="<?= url('dashboard/peo/data_regiones.php') ?>"
                    class="apex-charts" dir="ltr">
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header p-0 border-0 bg-light-subtle">
                <div class="row g-0 text-center">
                    <div class="col-12 col-sm-12">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1">Cantidad Participación por Consejo Regional</h5>
                        </div>
                    </div>
                </div>
            </div><!-- end card header -->
            <div class="card-body p-0 pb-2">
                <table class="table">
                    <tr>
                        <th>#</th>
                        <th>Consejo Regional</th>
                        <th>Cantidad</th>
                    </tr>
                    <?php
                    $i = 1;
                    $total = 0;
                    foreach ($data_todos as $to) {
                        $total += $to['cantidad'];
                    ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $to['nombre'] ?></td>
                            <td><?= $to['cantidad'] ?></td>
                        </tr>
                    <?php $i++;
                    } ?>
                    <tr>
                        <th></th>
                        <th class="text-end">Total => </th>
                        <th><?= $total ?></th>
                    </tr>
                </table>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>

<?php $include_scripts = function () {
    return importapexcharts();
} ?>