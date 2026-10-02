<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_personas = new bo_gen_personas();
$ent_personas = new gen_personas();

$variable = $_REQUEST['varbuscar'];
if (is_numeric($variable)) {
    $ent_personas->setC_cmp(digitos($variable, 6));
} else {
    $ent_personas->setNombre($variable);
}
$data_personas = $bo_personas->listarColegiados($ent_personas);
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
                <th scope="col" class="text-end">S/D</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $i = 1;
            foreach ($data_personas as $row) {
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
                                <small class="text-muted">DNI: <?= $row["num_documento"] ?>/ Correo: <?= $row["Email1"] ?> / Celular: <?= $row["celular1"] ?></small>
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
                        <?php
                        $abono_color = ($row["abono_favor"] > 0) ? "text-danger" : "text-success";
                        ?>
                        <h5 class="<?= $abono_color; ?>"><strong>S/ <?= decimal($row["abono_favor"],2) ?></strong></h5>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
    <!-- end table -->
</div>
<!-- end table responsive -->