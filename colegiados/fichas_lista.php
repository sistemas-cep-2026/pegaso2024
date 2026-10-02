<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_personas = new bo_gen_personas();
$ent_personas = new gen_personas();

$variable = $_REQUEST['varbuscar'];
$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];

$ent_personas->setNombre($variable);
$ent_personas->setDesde($desde);
$ent_personas->setHasta($hasta);

$data_personas = $bo_personas->listarColegiadosFicha($ent_personas);
?>
<div class="table-responsive">
    <table class="table align-middle mb-0 table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">NOMBRE</th>
                <th scope="col">FEC. NAC.</th>
                <th scope="col">FEC. COL.</th>
                <th scope="col">CR</th>
                <th scope="col">ESTADO</th>
                <th scope="col">HABIL</th>
                <th scope="col" class="text-end"></th>
            </tr>
        </thead>
        <tbody>
            <?php

            $i = 1;
            foreach ($data_personas as $row) {
                //$image_path = buscarFoto($row["num_documento"]);
            ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar text-white bg-primary rounded-2 d-flex justify-content-center align-items-center" style="width: 35px; height: 35px;">
                                <?= obtener_iniciales($row["nombre_completo"]); ?>
                            </div>
                            <div class="ms-3">
                                <a href="?id=<?= s_crypt('300002', 'in') ?>&sec=<?= s_crypt('1', 'in') ?>&cod=<?= s_crypt($row["c_persona"], 'in') ?>">
                                    <h5 class="mb-0">[<?= $row["cep"] ?>] <?= $row["nombre_completo"] ?></h5>
                                </a>
                                <small class="text-muted">DNI: <?= trim($row["num_documento"]) ?>/ Correo: <?= $row["Email1"] ?> / Celular: <?= $row["celular1"] ?></small>
                            </div>
                        </div>

                    </td>
                    <td><?= $row["fecha_nac"] ?></td>
                    <td><?= $row["fecha_col"] ?></td>
                    <td><?= $row["c_local_abv"] ?></td>
                    <td>
                        <span class="badge rounded-pill <?= $color_flag_estado[$row["flag_activo"]]; ?>">
                            <?= $row["flag_activo_text"]; ?></span>
                    </td>
                    <td>
                        <span class="badge badge-label <?= $color_flag_habil[$row["flag_habil"]] ?>">
                            <i class="mdi mdi-circle-medium"></i> <?= $row["flag_habil_text"] ?>
                        </span>
                    </td>
                    <td class="text-end">
                        <a role="button" target="_blank" class="btn btn-icon btn-outline-primary" href="<?= url("colegiados/print_documentofichas?c_persona=".trim($row["num_documento"])."&cep=".$row["cep"].""); ?>" title="DESCARGA LOCAL"><i class="fa fa-lg fa-print"></i> </a></h5>
                        <a role="button" target="_blank" class="btn btn-icon btn-info" href="<?= url("colegiados/print_documentocol?c_persona=".trim($row["num_documento"])."&cep=".$row["cep"].""); ?>" title="DESCARGA NUBE"><i class="fa fa-lg fa-print"></i> </a></h5>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
    <!-- end table -->
</div>
<!-- end table responsive -->