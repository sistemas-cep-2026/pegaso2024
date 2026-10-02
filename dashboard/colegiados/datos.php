<?php
require_once dirname(dirname(__DIR__)) . "/util/seguridad.php";
require_once dirname(dirname(__DIR__)) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_personas     = new bo_gen_personas();

$c_local = $_REQUEST['c_local'] == '28' ? '' : $_REQUEST['c_local'];
$anho = $_REQUEST['anho'] == '9999' ? '' : $_REQUEST['anho'];
$anho_anual = $_REQUEST['anho'] == '9999' ? date('Y') : $_REQUEST['anho'];

$data_per = $bo_personas->listaResumenColegiadosDashboard($c_local, $anho);
$data_per_grados = $bo_personas->listaResumenGradosColegiadosDashboard($c_local, $anho);
$data_col_anual = $bo_personas->listaResumenAnualColegiadosDashboard($c_local, $anho_anual);
$data_col_etareo_sexo = $bo_personas->listaResumenSexoEtareoColegiadosDashboard($c_local, $anho);

foreach ($data_per as $personas) {
    $colegiados = $personas["colegiados"];
    $activos = $personas["activos"];
    $cesante = $personas["cesante"];
    $fallecido = $personas["fallecido"];
    $exo_70 = $personas["exo_70"];
    $exo_viaje = $personas["exo_viaje"];
}

/*************************/
foreach ($data_per_grados as $grados) {
    $especialidad = $grados["especialidad"];
    $maestria = $grados["maestria"];
    $doctorado = $grados["doctorado"];
    $auditoria = $grados["auditoria"];
    $lactancia = $grados["lactancia"];
    $posdoctorado = $grados["posdoctorado"];
    $conciliador = $grados["conciliador"];
}

/*************************/
$data_meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
$data_col_anual_valores = [];
foreach ($data_col_anual[0] as $value) {
    $data_col_anual_valores[] = $value;
}

/*************************/
$valores_masculino = [];
$valores_femenino = [];

$valores_masculino = array_values(array_filter($data_col_etareo_sexo, function ($item) {
    return $item['cod_sexo'] == 'M';
}));

$valores_rango_edad = array_values(array_column($valores_masculino, 'rango_edad'));

$valores_femenino = array_values(array_filter($data_col_etareo_sexo, function ($item) {
    return $item['cod_sexo'] == 'F';
}));

$valores_femenino_cantidad = array_values(array_column($valores_femenino, 'cantidad'));
$valores_masculino_cantidad = array_values(array_column($valores_masculino, 'cantidad'));

$suma_valores_femenino_cantidad = array_sum($valores_femenino_cantidad);
$suma_valores_masculino_cantidad = array_sum($valores_masculino_cantidad);

$porcentaje_femenino = ($suma_valores_femenino_cantidad / $colegiados) * 100;
$porcentaje_masculino = ($suma_valores_masculino_cantidad / $colegiados) * 100;
?>

<style>
    .s0 {
        opacity: .05;
        fill: var(--vz-info)
    }
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="d-flex flex-column h-100">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-4 col-md-6">
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Total Colegiados</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value" data-target="<?= $colegiados ?>">0</span></h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="total_colegiados" data-porcentaje="<?= '100' ?>" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Colegiados Activos</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value" data-target="<?= $activos ?>">0</span></h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="total_activos" data-porcentaje="<?= decimal(($activos / $colegiados) * 100, '1') ?>" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Colegiados Cesantes</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value" data-target="<?= $cesante ?>">0</span></h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="total_cesante" data-porcentaje="<?= decimal(($cesante / $colegiados) * 100, '1') ?>" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Colegiados fallecidos</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value" data-target="<?= $fallecido ?>">0</span></h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="total_fallecido" data-porcentaje="<?= decimal(($fallecido / $colegiados) * 100, '1') ?>" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Colegiados exonerados (+70 años)</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value" data-target="<?= $exo_70 ?>">0</span></h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="total_exo_70" data-porcentaje="<?= decimal(($exo_70 / $colegiados) * 100, '1') ?>" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card card-animate overflow-hidden">
                        <div class="position-absolute start-0" style="z-index: 0;">
                            <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z" />
                            </svg>
                        </div>
                        <div class="card-body" style="z-index:1 ;">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Colegiados exonerados (viaje)</p>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-0"><span class="counter-value" data-target="<?= $exo_viaje ?>">0</span></h4>
                                </div>
                                <div class="flex-shrink-0">
                                    <div id="total_exo_viaje" data-porcentaje="<?= decimal(($exo_viaje / $colegiados) * 100, '1') ?>" data-colors='["--vz-success"]' class="apex-charts" dir="ltr"></div>
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
    <div class="col-lg-8">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Colegiados por año y mes</h4>
                    </div>
                    <div class="card-body">
                        <div id="total_colegiados_anual_mes"
                            data-colors='["--vz-primary"]'
                            data-categories="<?= htmlspecialchars(json_encode($data_meses), ENT_QUOTES) ?>"
                            data-series="<?= htmlspecialchars(json_encode($data_col_anual_valores), ENT_QUOTES) ?>"
                            class="apex-charts">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Grupo etareo por sexo</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-inline main-chart text-center mb-0">
                            <li class="list-inline-item chart-border-left me-0 border-start-0">
                                <h4 class="mb-1"><?= $suma_valores_femenino_cantidad ?><span class="text-muted d-inline-block fs-13 align-middle ms-2">Femenino</span></h4>
                                <span class="text-muted d-inline-block fs-12 align-middle"><?= decimal($porcentaje_femenino, '2') ?>%</span>
                            </li>
                            <li class="list-inline-item chart-border-left me-0">
                                <h4 class="mb-1"><?= $suma_valores_masculino_cantidad ?> <span class="text-muted d-inline-block fs-13 align-middle ms-2">Masculino</span></h4>
                                <span class="text-muted d-inline-block fs-12 align-middle"><?= decimal($porcentaje_masculino, '2') ?>%</span>
                            </li>
                        </ul>
                        <div id="data_total_etareo_sexo" data-rango_edad="<?= htmlspecialchars(json_encode($valores_rango_edad), ENT_QUOTES) ?>"
                            data-masculino="<?= htmlspecialchars(json_encode($valores_masculino_cantidad), ENT_QUOTES) ?>"
                            data-femenino="<?= htmlspecialchars(json_encode($valores_femenino_cantidad), ENT_QUOTES) ?>"
                            class="apex-charts" dir="ltr"></div>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="col-lg-4">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-12">
                <div class="card card-animate overflow-hidden">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div class="avatar-title border bg-info-subtle border-info border-opacity-25 rounded-2 fs-17">
                                <i class="fa fa-lg fa-user-tag icon-dual-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15 counter-value" data-target="<?= $especialidad; ?>">0</h5>
                            <p class="mb-0 text-muted">Especialistas</p>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
            <div class="col-xl-12">
                <div class="card card-animate overflow-hidden">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                                <i class="fa fa-lg fa-user-graduate icon-dual-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15 counter-value" data-target="<?= $maestria; ?>">0</h5>
                            <p class="mb-0 text-muted">Maestrías</p>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
            <div class="col-xl-12">
                <div class="card card-animate overflow-hidden">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                                <i class="fa fa-lg fa-user-graduate icon-dual-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15 counter-value" data-target="<?= $doctorado; ?>">0</h5>
                            <p class="mb-0 text-muted">Doctorados</p>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
            <div class="col-xl-12">
                <div class="card card-animate overflow-hidden">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div class="avatar-title border bg-primary-subtle border-primary border-opacity-25 rounded-2 fs-17">
                                <i class="fa fa-lg fa-address-card icon-dual-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15 counter-value" data-target="<?= $auditoria; ?>">0</h5>
                            <p class="mb-0 text-muted">Auditorías</p>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
            <div class="col-xl-12">
                <div class="card card-animate overflow-hidden">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div class="avatar-title border bg-primary-subtle border-primary border-opacity-25 rounded-2 fs-17">
                                <i class="fa fa-lg fa-person-breastfeeding icon-dual-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15 counter-value" data-target="<?= $lactancia; ?>">0</h5>
                            <p class="mb-0 text-muted">Consejeras en lactancia materna</p>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
            <div class="col-xl-12">
                <div class="card card-animate overflow-hidden">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div class="avatar-title border bg-secondary-subtle border-secondary border-opacity-25 rounded-2 fs-17">
                                <i class="fa fa-lg fa-address-card icon-dual-secondary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15 counter-value" data-target="<?= $posdoctorado; ?>">0</h5>
                            <p class="mb-0 text-muted">Posdoctorado</p>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
            <div class="col-xl-12">
                <div class="card card-animate overflow-hidden">
                    <div class="card-body d-flex gap-3 align-items-center">
                        <div class="avatar-sm">
                            <div class="avatar-title border bg-warning-subtle border-warning border-opacity-25 rounded-2 fs-17">
                                <i class="fa fa-lg fa-scale-balanced icon-dual-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15 counter-value" data-target="<?= $conciliador; ?>">0</h5>
                            <p class="mb-0 text-muted">Conciliadores extrajudiciales</p>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div>
    </div>
</div>
<script>
    var $_chartRadialBar = {
        type: "radialBar",
        width: 105,
        sparkline: {
            enabled: true,
        },
    };

    var $_plotOptionsRadialBar = {
        radialBar: {
            hollow: {
                margin: 0,
                size: "70%",
            },
            track: {
                margin: 1,
            },
            dataLabels: {
                show: true,
                name: {
                    show: false,
                },
                value: {
                    show: true,
                    fontSize: "16px",
                    fontWeight: 600,
                    offsetY: 8,
                },
            },
        },
    };

    var $_condicionColegiados = [
        "colegiados",
        "activos",
        "cesante",
        "fallecido",
        "exo_70",
        "exo_viaje",
    ];

    $_condicionColegiados.forEach((condicion) => {
        var option = {
            series: [
                document
                .querySelector(`#total_${condicion}`)
                .getAttribute("data-porcentaje"),
            ],
            chart: $_chartRadialBar,
            dataLabels: {
                enabled: false,
            },
            plotOptions: $_plotOptionsRadialBar,
            colors: ["#0ab39c"],
        };

        new ApexCharts(
            document.querySelector(`#total_${condicion}`),
            option,
        ).render();
    });

    var $_colegiadoAnualOptions = {
        series: [{
            name: "Total",
            data: JSON.parse(
                document
                .querySelector(`#total_colegiados_anual_mes`)
                .getAttribute("data-series"),
            ),
        }, ],
        chart: {
            type: "bar",
            height: 350,
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "45%",
                borderRadius: 4
            },
        },
        colors: ["#1e81bb"],
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false
        },
        stroke: {
            show: false
        },
        xaxis: {
            categories: JSON.parse(
                document
                .querySelector(`#total_colegiados_anual_mes`)
                .getAttribute("data-categories"),
            ),
            axisTicks: {
                show: false
            },
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return decimal(val,0) + " colegiados";
                },
            },
        },
    };

    new ApexCharts(
        document.querySelector(`#total_colegiados_anual_mes`),
        $_colegiadoAnualOptions,
    ).render();

    /* var $_optionsDonutSexo = {
        series:JSON.parse(document.querySelector(`#data_total_sexo`).getAttribute("data-series")),
        labels: ["Femenino", "Masculino"],
        chart: {
            height: 333,
            type: "donut"
        },
        legend: {
            position: "bottom"
        },
        stroke: {
            show: !1
        },
        dataLabels: {
            dropShadow: {
                enabled: !1
            }
        },
        colors: ["#e963e9", "#100ab3"],
    };

    new ApexCharts(document.querySelector(`#data_total_sexo`),$_optionsDonutSexo).render() */

    var $_optionsEtareoSexo = {
        series: [{
                name: "Femenino",
                data: JSON.parse(
                    document
                    .querySelector(`#data_total_etareo_sexo`)
                    .getAttribute("data-femenino"),
                ),
            },
            {
                name: "Masculino",
                data: JSON.parse(
                    document
                    .querySelector(`#data_total_etareo_sexo`)
                    .getAttribute("data-masculino"),
                ),
            },
        ],
        chart: {
            height: 350,
            type: "area",
            toolbar: "false",
        },
        dataLabels: {
            enabled: !1,
        },
        stroke: {
            curve: "smooth",
            width: 2,
        },
        xaxis: {
            categories: JSON.parse(
                document
                .querySelector(`#data_total_etareo_sexo`)
                .getAttribute("data-rango_edad"),
            ),
        },
        /* yaxis: {
              labels: {
                  formatter: function(e) {
                      return "$" + e + "k"
                  }
              },
              tickAmount: 5,
              min: 0,
              max: 260
          }, */
        colors: ["#e963e9", "#100ab3"],
        fill: {
            opacity: 0.06,
            colors: ["#e963e9", "#100ab3"],
            type: "solid",
        },
    };
    new ApexCharts(
        document.querySelector("#data_total_etareo_sexo"),
        $_optionsEtareoSexo,
    ).render();

    function D() {
        var e = document.querySelectorAll(".counter-value");

        function s(e) {
            return e.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }
        e && Array.from(e).forEach(function(o) {
            ! function e() {
                var t = +o.getAttribute("data-target"),
                    a = +o.innerText,
                    n = t / 250;
                n < 1 && (n = 1),
                    a < t ? (o.innerText = (a + n).toFixed(0),
                        setTimeout(e, 1)) : o.innerText = s(t),
                    s(o.innerText)
            }()
        })
    }
    D();
</script>