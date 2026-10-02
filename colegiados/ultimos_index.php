<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_det = new bo_gen_parametro_det();
$bo_personas = new bo_gen_personas();

$data_tipos_grados = $bo_det->listarParametroDet('personas', 'tipo_grado');
$arr_tipos_grados = array_values(array_filter($data_tipos_grados, function ($item) {
    return !in_array($item['cc_codigo'], ['H', 'T']);
}));
$c_local_colegiacion = s_local() == '28' ? '' : s_local();
?>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ultimos registros</h4>
    </div>
    <div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
        <div id="cargador">
            <?= cargador(); ?>
        </div>
        <div id="contentedor_ultimos" class="d-none">
            <ul class="nav nav-tabs nav-border-top nav-border-top-primary mb-3" id="ultimos" role="tablist">
                <?php
                $i = 1;
                foreach ($arr_tipos_grados as $tipo_grado) {
                ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $i == 1 ? 'active' : '' ?>" id="<?= $tipo_grado['cc_codigo'] ?>-tab" data-bs-toggle="tab" data-bs-target="#<?= $tipo_grado['cc_codigo'] ?>-tab-pane" type="button" role="tab" aria-controls="<?= $tipo_grado['cc_codigo'] ?>-tab-pane" aria-selected="false"><?= $tipo_grado['detalle'] ?></button>
                    </li>
                <?php
                    $i++;
                };
                ?>
            </ul>
            <div class="tab-content" id="ultimosContent">
                <?php
                $i = 1;
                foreach ($arr_tipos_grados as $tipo_grado) {
                ?>
                    <div class="tab-pane fade <?= $i == 1 ? 'show active' : '' ?>" id="<?= $tipo_grado['cc_codigo'] ?>-tab-pane" role="tabpanel" aria-labelledby="<?= $tipo_grado['cc_codigo'] ?>-tab" tabindex="0">
                        <table class="table table-sm table-hover">
                            <caption class="caption-top">
                                <div class="row">
                                    <div class="col-12">
                                        <h5><?= $tipo_grado['detalle'] ?></h5>
                                    </div>
                                </div>
                            </caption>
                            <thead>
                                <tr class="table-active">
                                    <th>#</th>
                                    <th>NRO REGISTRO</th>
                                    <th>NOMBRE</th>
                                    <th>CR</th>
                                    <th>FECHA</th>
                                    <?= $tipo_grado['cc_codigo'] !== 'C' ? '<th>LITERAL</th>' : '' ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $data_ultimos = $bo_personas->ultimos($tipo_grado['cc_codigo'], $c_local_colegiacion);
                                foreach ($data_ultimos as $row) {
                                ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $row["c_cmp"]; ?></td>
                                        <td><?= $row["nombre"]; ?></td>
                                        <td><?= $row["c_local_colegiacion"]; ?></td>
                                        <td><?= $row["fecha_de_inicio"] ?></td>
                                        <?= $tipo_grado['cc_codigo'] !== 'C' ? '<td>' . $row["literal"] . '</td>' : '' ?>
                                    </tr>
                                <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                    $i++;
                };
                ?>
            </div>
        </div>
    </div>
</div>