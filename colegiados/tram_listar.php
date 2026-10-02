<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

$bo_doc_recibidos = new bo_tram_documentos_recibidos();
$ent_doc_recibidos = new tram_documentos_recibidos();

$c_local = s_local();
$c_local_origen = $_REQUEST["c_local_origen"];
$desde = $_REQUEST["desde"] . ' 00:00:00';
$hasta = $_REQUEST["hasta"] . ' 23:59:59';
$c_local_origen = $_REQUEST["c_local_origen"] ?? '';
$nombre_remitente = $_REQUEST["nombre_remitente"] ?? '';
$num_documento = $_REQUEST["num_documento"] ?? '';
$c_expediente = $_REQUEST["c_expediente"] ?? '';

$ent_doc_recibidos->setC_local($c_local);
$ent_doc_recibidos->setDesde($desde);
$ent_doc_recibidos->setHasta($hasta);
$ent_doc_recibidos->setC_local_origen($c_local_origen);
$ent_doc_recibidos->setNombre_remitente($nombre_remitente);
$ent_doc_recibidos->setNum_documento($num_documento);
$ent_doc_recibidos->setC_expediente($c_expediente);

$data_doc = $bo_doc_recibidos->listarTramitesColegiacion($ent_doc_recibidos);
?>
<div class="table-responsive">
    <table class="table table-hover table-sm" id="table-expedientes-recaudo">
        <thead>
            <tr class="table-active">
                <th>#</th>
                <th>FECHA</th>
                <th>NOMBRE</th>
                <th>EXPEDIENTE - ASUNTO</th>
                <!-- <th>(C)</th> -->
                <th>ACCIÓN</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($data_doc as $row) { ?>
                <tr class="align-middle">
                    <td><?= $i ?></td>
                    <td><?= $row['fecha_ingreso'] ?></td>
                    <td>
                        <div class="d-flex flex-column">
                            <div class="link-secondary link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover"> <?= $row['nombre'] ?></div>
                            <div class="text-muted">
                                CEP: <?= $row['c_cmp'] ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <div class="link-info link-offset-2 text-decoration-underline link-underline-opacity-25 link-underline-opacity-100-hover"><?= $row['c_expediente'] ?> (<?= $row['num_documento'] ?>)</div>
                            <div class="text-muted">
                                <?= $row['asunto'] ?>
                            </div>
                        </div>
                    </td>
                    <!-- <td><?= '';//$row['cantidad_pagos'] ?></td> -->
                    <td>
                        <button class="btn btn-primary btn-sm btn-icon" onclick="fn_listarTramitesPago({c_expediente:'<?= $row['c_expediente'] ?>', asunto:'<?= $row['asunto'] ?>'})"><i class="fa-lg fa-solid fa-file-invoice-dollar" title="Agregar Pago"></i></button>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
</div>