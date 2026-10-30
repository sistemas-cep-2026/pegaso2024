<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");
$bo_general = new bo_general();
$bo_documento_venta = new bo_fin_documentos_de_venta();

$ent_documento_venta = new fin_documentos_de_venta();

$cc_local = $_REQUEST['c_local'] ?? '';
$desde = u_fecha($_REQUEST['desde']) ?? '';
$hasta = u_fecha($_REQUEST['hasta']) ?? '';

$ent_documento_venta->setCod_desde($desde);
$ent_documento_venta->setCod_hasta($hasta);
$ent_documento_venta->setC_local($cc_local);

$data_doc_venta = $bo_documento_venta->Cab_ingresosConceptos($ent_documento_venta);

?>
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div class="d-flex align-items-center gap-2 text-muted">
        <i class="ri-calendar-2-line fs-16"></i>
        <span>Período:</span>
        <span class="fw-semibold text-body"><?php echo $desde ?></span>
        <span>al</span>
        <span class="fw-semibold text-body"><?php echo $hasta ?></span>
    </div>
    <span class="badge bg-body-secondary text-body fs-12"><?php echo count($data_doc_venta) ?> cuenta(s)</span>
</div>

<div class="table-responsive border rounded">
    <table class="table table-sm table-hover align-middle mb-0">
        <thead class="table-light text-uppercase fs-12">
            <tr>
                <th class="col-1">#</th>
                <th class="col-5">COD - DETALLE</th>
                <th class="col-2 text-center">DESDE</th>
                <th class="col-2 text-center">HASTA</th>
                <th class="col-1 text-center">AÑO</th>
                <th class="text-end">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data_doc_venta)) { ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="ri-file-list-3-line fs-1 d-block mb-2"></i>
                        No se encontraron ingresos en el período seleccionado.
                    </td>
                </tr>
            <?php } ?>
            <?php
            $total = 0;
            foreach ($data_doc_venta as $cab) {
                $subtotal = 0;
            ?>
                <tr>
                    <th class="bg-body-secondary"><?php echo $cab['c_cuenta_ventas'] ?></th>
                    <th colspan="5" class="bg-body-secondary"><?php echo $cab['nombre_pcge'] ?></th>
                </tr>
                <?php
                $i = 1;
                $ent_documento_venta->setC_cuenta_ventas($cab['c_cuenta_ventas']);
                $data_deta = $bo_documento_venta->detalle_ingresosConceptos($ent_documento_venta);
                foreach ($data_deta as $det) {
                    $subtotal += $det['total'];
                ?>
                    <tr>
                        <td class="text-muted"><?php echo $i ?></td>
                        <td>
                            <a href="#" class="d-inline-flex align-items-baseline gap-2 link-underline-opacity-0 link-underline-opacity-100-hover" onclick="fn_conceptoVista('<?php echo $det['c_articulo'] ?>','<?php echo $cc_local ?>','<?php echo $desde ?>','<?php echo $hasta ?>','<?php echo $det['c_anho'] ?>')">
                                <span class="fw-semibold"><?php echo $det['c_articulo'] ?></span>
                                <span><?php echo $det['nombre'] ?></span>
                            </a>
                        </td>
                        <td class="text-center"><?php echo $det['mes_desde'] !== '' ? $det['mes_desde'] : '<span class="text-muted">—</span>' ?></td>
                        <td class="text-center"><?php echo $det['mes_hasta'] !== '' ? $det['mes_hasta'] : '<span class="text-muted">—</span>' ?></td>
                        <td class="text-center"><?php echo $det['c_anho'] !== '' ? $det['c_anho'] : '<span class="text-muted">—</span>' ?></td>
                        <td class="text-end text-nowrap"><?php echo decimal($det['total'], 2) ?></td>
                    </tr>
                <?php
                    $i++;
                } ?>
                <tr class="table-light">
                    <th colspan="5" class="text-end text-muted fs-12">TOTAL CUENTA <?php echo $cab['c_cuenta_ventas'] ?></th>
                    <th class="text-end text-nowrap"><?php echo decimal($subtotal, 2) ?></th>
                </tr>
            <?php
                $total += $subtotal; // Acumulamos el total general correctamente
            } ?>
        </tbody>
        <?php if (!empty($data_doc_venta)) { ?>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-end bg-body-secondary">TOTAL GENERAL</th>
                    <th class="text-end text-nowrap bg-body-secondary"><?php echo decimal($total, 2) ?></th>
                </tr>
            </tfoot>
        <?php } ?>
    </table>
</div>