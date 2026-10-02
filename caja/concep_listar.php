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
<div class="table-responsive">
    <table class="table table-sm">
        <thead class="table-light">
            <th class="col-1"># <?php echo $hasta ?></th>
            <th class="col-5">COD- DETALLE</th>
            <th class="col-2">DESDE</th>
            <th class="col-2">HASTA</th>
            <th class="col-2">AÑO</th>
            <th class="text-end">TOTAL</th>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($data_doc_venta as $cab) {
                $subtotal = 0;
            ?>
                <tr>
                    <th><?php echo $cab['c_cuenta_ventas'] ?></th>
                    <th colspan="6"><?php echo $cab['nombre_pcge'] ?></th>
                </tr>
                <?php
                $i = 1;
                $ent_documento_venta->setC_cuenta_ventas($cab['c_cuenta_ventas']);
                $data_deta = $bo_documento_venta->detalle_ingresosConceptos($ent_documento_venta);
                foreach ($data_deta as $det) {
                    $subtotal += $det['total'];
                ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><a href="#" onclick="fn_conceptoVista('<?php echo $det['c_articulo'] ?>','<?php echo $cc_local ?>','<?php echo $desde ?>','<?php echo $hasta ?>','<?php echo $det['c_anho'] ?>')"><?php echo $det['c_articulo'] . "-" . $det['nombre'] ?></a></td>
                        <td><?php echo $det['mes_desde'] ?></td>
                        <td><?php echo $det['mes_hasta'] ?></td>
                        <td><?php echo $det['c_anho'] ?></td>
                        <td class="text-end"><?php echo decimal($det['total'], 2) ?></td>
                    </tr>
                <?php
                    $i++;
                } ?>
                <tr>
                    <th colspan="5" class="text-end">TOTAL => :</th>
                    <th class="text-end"><?php echo decimal($subtotal, 2) ?></th>
                </tr>
            <?php
                $total += $subtotal; // Acumulamos el total general correctamente
            } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-end">TOTAL GENERAL =></th>
                <th class="text-end"><?php echo decimal($total, 2) ?></th>
            </tr>
        </tfoot>
    </table>
</div>