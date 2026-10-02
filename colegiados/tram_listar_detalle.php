<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recaudo.php");

$bo_doc_recaudo = new bo_tram_documentos_recaudo();
$ent_doc_recaudo = new tram_documentos_recaudo();

$c_expediente = $_REQUEST["c_expediente"] ?? '';
$asunto = $_REQUEST["asunto"] ?? '';

$ent_doc_recaudo->setC_expediente($c_expediente);
$data_doc_pagos = $bo_doc_recaudo->listarXExpediente($ent_doc_recaudo);

?>
<div class="modal-header">
    <h5 class="modal-title">Lista de pagos del expediente N° <?= $c_expediente ?><br><span class="fs-6">ASUNTO: <span class="text-muted"><?= $asunto; ?></span></span></h5>
    
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="table-responsive">
        <table class="table table-hover table-sm" id="table-expedientes">
            <thead>
                <tr class="table-active">
                    <th>#</th>
                    <th>FECHA INGRESO</th>
                    <th>NOMBRE</th>
                    <th>BANCO</th>
                    <th>CONCEPTO</th>
                    <th>MONTO</th>
                    <th>FECHA PROCESADO</th>
                    <th><button class="btn btn-sm btn-icon btn-info" title="Agregar pago" onclick="fn_agregarPago({c_expediente:'<?= $c_expediente ?>'})"><i class="fa fa-plus"></i></button></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if (empty($data_doc_pagos)) {
                ?>
                    <!-- Danger Alert -->
                    <tr class="align-middle">
                        <td colspan="8">
                            <?= errors() ?>
                        </td>
                    </tr>
                    <?php
                } else {
                    foreach ($data_doc_pagos as $row) {
                    ?>
                        <tr class="align-middle">
                            <td><?= $i ?></td>
                            <td><?= $row['fecha_ingreso'] ?></td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="link-secondary link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover"><?= $row['nombre'] ?></div>
                                    <div class="text-muted">CEP: <?= $row['c_cmp'] ?></div>
                                </div>
                            </td>
                            <td><?= empty($row['banco']) ? 'RECAUDO (BBVA)' : $row['banco'] ?></td>
                            <td>
                                <div class="d-flex flex-column">
                                    <div class="link-info link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover"><?= empty($row['referencia2']) ? $row['cod_tram_recaudo']. ' ' .$row['rcd_concepto'] : $row['referencia2'] ?></div>
                                    <div class="text-muted">Fecha: <?= empty($row['fecha_op']) ? $row['fecha_pago_rec'] : $row['fecha_op'] ?> - OP: <?= empty($row['num_movimiento']) ? $row['operacion'] : $row['num_movimiento'] ?></div>
                                </div>
                            </td>
                            <td><?= empty($row['monto']) ? $row['total'] : $row['monto'] ?></td>
                            <td><?= empty($row['fecha_salida']) ? '------' : $row['fecha_salida'] ?></td>
                            <td>&nbsp;</td>
                        </tr>
                <?php $i++;
                    }
                } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <?= bt_cerrar(); ?>
</div>