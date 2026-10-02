<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recaudo.php");

$bo_doc_recaudo = new bo_tram_documentos_recaudo();
$ent_doc_recaudo = new tram_documentos_recaudo();

$desde = $_REQUEST["desde"] . ' 00:00:00';
$hasta = $_REQUEST["hasta"] . ' 23:59:59';

$ent_doc_recaudo->setDesde($desde);
$ent_doc_recaudo->setHasta($hasta);

$data_rec_tramite = $bo_doc_recaudo->listarReporteTramitesRecaudo($ent_doc_recaudo);
//print_r($data_rec_tramite);
?>
<div class="table-responsive">
    <table class="table table-hover table-sm" id="table-expedientes-recaudo">
        <thead>
            <tr class="table-active">
                <th>FECHA</th>
                <th>EXPEDIENTE</th>
                <th>(CEP) NOMBRE</th>
                <th>R_CONCEPTO</th>
                <th>R_FECHA</th>
                <th>R_MONTO</th>
                <th>R_OPE</th>
                <th>B_CTA</th>
                <th>B_CONCEPTO</th>
                <th>B_OP</th>
                <th>B_FECHA</th>
                <th>B_MONTO</th>
                <th>B_CTA_2</th>
                <th>B_OP_2</th>
                <th>B_FECHA_2</th>
                <th>B_MONTO_2</th>
                <th>OBSERVACION</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($data_rec_tramite as $row) { ?>
                <tr class="align-middle">
                    <td><?= $row['fecha_registro']; ?></td>
                    <td><?= $row['c_expediente']; ?></td>
                    <td>(<?= $row['c_cmp']; ?>) <?= $row['nombre']; ?></td>
                    <td><?= $row['referencia2']; ?></td>
                    <td><?= $row['fecha_pago_rec']; ?></td>
                    <td><?= $row['total']; ?></td>
                    <td><?= $row['num_movimiento']; ?></td>
                    <td><?= $row['banco']; ?></td>
                    <td><?= $row['cod_tram_recaudo'] . ' ' . $row['rcd_concepto']; ?></td>
                    <td><?= $row['operacion']; ?></td>
                    <td><?= $row['fecha_op']; ?></td>
                    <td><?= $row['monto']; ?></td>
                    <td><?= $row['banco2']; ?></td>
                    <td><?= $row['operacion2']; ?></td>
                    <td><?= $row['fecha_op2']; ?></td>
                    <td><?= $row['monto2']; ?></td>
                    <td><?= $row['obs']; ?></td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
</div>