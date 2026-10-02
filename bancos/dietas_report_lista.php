<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_banc_dietas.php");
$bo_general = new bo_general();
$bo_banc_dietas = new bo_banc_dietas();

$ent_banc_dietas = new banc_dietas();

$cc_local = s_local_vinculado();
$desde = u_fecha($_REQUEST['desde']) ?? '';
$hasta = u_fecha($_REQUEST['hasta']) ?? '';

$ent_banc_dietas->setDesde($desde);
$ent_banc_dietas->setHasta($hasta);
$ent_banc_dietas->setCc_local($cc_local);

$data = $bo_banc_dietas->listar($ent_banc_dietas);

?>
<div class="table-responsive">
    <table class="table table-sm">
        <thead class="table-light">
            <th># </th>
            <th>FECHA</th>
            <th>PERIODO</th>
            <th>DIRECTIVO</th>
            <th>CONCEPTO</th>
            <th class="text-end">MOVILIDAD</th>
            <th class="text-end">DIETA</th>
            <th class="text-end">RETENCION</th>
            <th class="text-end">NETO</th>
            <th>OPC</th>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="10" class="text-center text-muted p-4">No hay dietas registradas para este rango de fechas.</td>
                </tr>
            <?php endif; ?>
            <?php
            foreach ($data as $cab) {
            ?>
                <tr>
                    <td> <?= $cab['cc_dietas'] ?></td>
                    <td><?php echo $cab['fecha'] ?></td>
                    <td><?php echo $cab['cod_ano'] . '-' . $cab['cod_mes']; ?></td>
                    <td><?php echo $cab['c_cmp'] . '-' . $cab['nombre_persona'] ?></td>
                    <td><?php echo $cab['nombre_area'] . '-' . $cab['referencia'] ?></td>
                    <td class="text-end"><?php echo decimal($cab['movilidad'], 2); ?></td>
                    <td class="text-end"><?php echo decimal($cab['dieta'], 2); ?></td>
                    <td class="text-end"><?php echo decimal($cab['retencion'], 2); ?></td>
                    <td class="text-end"><?php echo decimal(($cab['movilidad'] + $cab['dieta'] - $cab['retencion']), 2); ?></td>
                    <td class="text-center">
                        <a href="javascript:void(0);" onclick="fn_imprimir('<?= s_crypt($cab['cc_dietas'], 'in') ?>')"
                            class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="Imprimir"> <i class="fas fa-print"></i>
                        </a>
                    </td>
                </tr>
            <?php

            } ?>
        </tbody>

    </table>
</div>