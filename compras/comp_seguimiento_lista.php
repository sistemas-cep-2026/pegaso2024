<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");
require_once(u_src() . "bo/bo_comp_items_documentos_de_compra_cue.php");
require_once(u_src() . "bo/bo_general.php");
$bo_compras = new bo_comp_documentos_de_compras();
$bo_compra_det = new bo_comp_items_documentos_de_compra_cue();

$ent_compras = new comp_documentos_de_compras();
$ent_compras_det = new comp_items_documentos_de_compra_cue();
$bo_general = new bo_general();

$cc_local = $_REQUEST['cc_local'] ?? '';
$anho = $_REQUEST['anho']  ?? '';
$cc_persona = s_crypt($_REQUEST['cc_persona'], 'out') ?? '';
$cod_documento = $_REQUEST['cod_documento']  ?? '';
$num_documento = $_REQUEST['num_documento']  ?? '';


//echo $cc_local . 'C' . $anho . 'a' . $cc_persona . 'P' . $cod_documento . 'd' . $num_documento . 'n';

$ent_compras->setCc_local($cc_local);
$ent_compras->setCod_ano($anho);
$ent_compras->setCc_persona($cc_persona);
$ent_compras->setCod_documento($cod_documento);
$ent_compras->setNum_documento($num_documento);

$data_cab = $bo_compras->listarID_sequgimiento($ent_compras);
if (empty($data_cab)) {
    echo 'No hay registros o coincidencias.';
    exit;
}


foreach ($data_cab as $cab) {
    $cc_compra = $cab['cc_compra'];
    $num_doc = $cab['cod_documento'] . " " . $cab['num_documento'];
    $fec_emsion = $cab['fecha_documento_print'];
    $fec_venc = $cab['fecha_vencimiento_print'];
    $perido = $cab['cod_mes'] . " / " . $cab['cod_ano'];
    $total = $cab['total'];
    $proveedor = $cab['razon_social'];
    $observacion = $cab['observacion'];
    $porcentaje = $cab['porcentaje'];
    $user_crea = $cab['c_usuario_crea'];
    $cod_ano = $cab['cod_ano'];
    $cod_mes = $cab['cod_mes'];
    $cc_local = $cab['c_local'];
    $comprobante = $cab['comprobante'];
    $ent_compras->setCc_compra($cc_compra);
    $ent_compras_det->setCc_compra($cc_compra);
    $tipo_desc = $cab['tipo_desc'];
    $porcentaje = $cab['porcentaje'];
    $reten_numero = $cab['reten_numero'];
    $reten_fecha_print = $cab['reten_fecha_print'];
}


$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
    $cc_local_text = $loc['nombre'];
}
?>
<div id="print-section" class="print-section">
    <div class="row bg-white">
        <div class="table-responsive">
            <table class="table table-sm table-borderless">
                <tr>
                    <th class="col-md-6 fs-6"> <?php echo $cc_local_text; ?></th>
                </tr>
            </table>
            <table>
                <tr>
                    <td><strong>MODULO DE COMPRAS</strong></td>
                </tr>
            </table>
            <table class=" table table-sm table-bordered w-auto">
                <thead class="table-light">
                    <tr>
                        <th class="col-md-10">RUC - RAZON SOCIAL</th>
                        <th class="col-md-2"># CAJA CH.</th>
                        <th class="col-md-2">PERIODO</th>
                        <th class="col-md-2">COMP.:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap"><?php echo $proveedor ?></td>
                        <td class="text-nowrap"><?php echo $caja_chica ?></td>
                        <td class="text-nowrap"><?php echo $perido ?></td>
                        <td class="text-nowrap"> <?php echo digitos($comprobante, 6) ?> </td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-sm table-bordered w-auto">
                <thead class="table-light">
                    <tr>
                        <th>N° DOCUMENTO</th>
                        <th>FEC. EMI.</th>
                        <th>FEC. VEN.</th>
                        <th>D/R</th>
                        <th class="text-end">V. VENTA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-nowrap"><?php echo $num_doc ?></td>
                        <td class="text-nowrap"><?php echo $fec_emsion ?></td>
                        <td class="text-nowrap"><?php echo $fec_venc ?></td>
                        <td><?php
                            $tipo_desc = trim($tipo_desc ?? '');

                            if ($tipo_desc !== '' && $tipo_desc !== null) {
                                $porcentaje = decimal($porcentaje, 0);
                                $numero = $reten_numero;
                                $fecha = $reten_fecha_print;

                                // No mostrar si la fecha es 1900-01-01
                                if ($fecha == '1900-01-01' or $fecha == '01/01/1900') {
                                    $fecha = '';
                                }
                                $tipo = ($tipo_desc == 'D') ? 'DET.' : 'RET.';
                                echo "{$tipo} - {$porcentaje}% * {$numero} * {$fecha}";
                            }
                            ?></td>
                        <td class="text-nowrap text-end">S/. <?php echo decimal_millar($total, 2) ?></td>

                    </tr>
                </tbody>
            </table>
            <table>
                <tr>
                    <td class="text-nowrap"><strong><?php echo $observacion ?></strong></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table class="table table-sm">
                <thead class="table-light">
                    <tr>
                        <th>CUENTA</th>
                        <th>NOMBRE DE LA CUENTA</th>
                        <th class="text-end">DEBE</th>
                        <th class="text-end">HABER</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data_detalle = $bo_compra_det->listaIDCompra($ent_compras_det);
                    $total_debe = array_sum(array_column($data_detalle, 'debe'));
                    $total_haber = array_sum(array_column($data_detalle, 'haber'));
                    foreach ($data_detalle as $det) {
                    ?>
                        <tr>
                            <td class="text-nowrap"><?php echo $det['c_cuenta'] ?></td>
                            <td class="text-nowrap"><?php echo $det['nombre_cuenta'] ?></td>
                            <td class="text-nowrap text-end"><?php echo decimal_millar($det['debe'], 2) ?></td>
                            <td class="text-nowrap text-end "><?php echo decimal_millar($det['haber'], 2) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-end">TOTAL => </th>
                        <th class="text-end"><?php echo decimal_millar($total_debe, 2) ?></th>
                        <th class="text-end"><?php echo decimal_millar($total_haber, 2) ?></th>
                    </tr>
                </tfoot>
            </table>

            <?php
            $data_cab_banco = $bo_compras->listarID_segui_banco($ent_compras);

            foreach ($data_cab_banco as $cabbanco) {


            ?>
                <table>
                    <tr>
                        <td><strong>BANCOS =><?php echo $cabbanco['c_forma_cancelacion'] . ' ' . $cabbanco['num_boleta_cheque'] ?></strong></td>
                    </tr>
                </table>
                <table class=" table table-sm table-bordered w-auto">
                    <thead class="table-light">
                        <tr>
                            <th class="col-md-2">FECHA</th>
                            <th class="col-md-2">BANCO</th>
                            <th class="col-md-2">TIPO</th>
                            <th class="col-md-2">OPERACION</th>
                            <th class="col-md-2">REGISTRO</th>
                            <th class="col-md-2">MONTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-nowrap"><?php echo $cabbanco['fecha_documento'] ?></td>
                            <td class="text-nowrap"><?php echo $cabbanco['nombre'] . '-' . $cabbanco['c_cta_corriente']; ?></td>
                            <td class="text-nowrap"><?php echo $cabbanco['c_forma_cancelacion'] ?></td>
                            <td class="text-nowrap"><?php echo $cabbanco['num_boleta_cheque'] ?></td>
                            <td class="text-nowrap"><?php echo $cabbanco['comprobante'] ?></td>
                            <td class="text-nowrap"><?php echo $cabbanco['monto'] ?></td>

                        </tr>
                    </tbody>
                </table>
                <table class=" table table-sm table-bordered w-auto">
                    <thead class="table-light">
                        <tr>
                            <th class="col-md-5">OBS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-nowrap"><?php echo $cabbanco['observacion'] ?></td>
                        </tr>
                    </tbody>
                </table>

                <?php

                $ent_compras->setCc_compra($cabbanco['voucher']);
                $data_cab_conta = $bo_compras->listarID_segui_conta($ent_compras);
                foreach ($data_cab_conta as $cabconta) {
                ?>
                    <table>
                        <tr>
                            <td><strong>CONTABILIDAD <?php echo $cabbanco['voucher'] ?></strong>
                            </td>
                        </tr>
                    </table>
                    <table class=" table table-sm table-bordered w-auto">
                        <thead class="table-light">
                            <tr>
                                <th class="col-md-2">FECHA</th>
                                <th class="col-md-3">ASIENTO</th>
                                <th class="col-md-3">SUB-DIARIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-nowrap"><?php echo $cabconta['fecha_documento'] ?></td>
                                <td class="text-nowrap"><?php echo $cabconta['voucher'] ?></td>
                                <td class="text-nowrap"><?php echo $cabconta['sub_diario'] ?></td>

                            </tr>
                        </tbody>
                    </table>
                    <table class=" table table-sm table-bordered w-auto">
                        <thead class="table-light">
                            <tr>
                                <th class="col-md-2">C.CUENTA</th>
                                <th class="col-md-3">DEBE</th>
                                <th class="col-md-3">HABER</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php


                            $data_cab_contadet = $bo_compras->listarID_segui_contadet($ent_compras);
                            foreach ($data_cab_contadet as $cabcontadet) {
                            ?>
                                <tr>
                                    <td class="text-nowrap"><?php echo $cabcontadet['c_cuenta'] ?></td>
                                    <td class="text-nowrap"><?php echo $cabcontadet['debe'] ?></td>
                                    <td class="text-nowrap"><?php echo $cabcontadet['haber'] ?></td>

                                </tr>

                            <?php

                            }

                            ?>

                        </tbody>
                    </table>

            <?php
                }
            }


            ?>
            <table>
                <tr>
                    <td><?php

                        echo sistema_vesion(); ?><br>
                        User Crea: <strong> <?php echo $user_crea ?> </strong> Fecha Print: <strong><?php echo fecha_hora_hoy(); ?> </strong> </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="flex-grow-1 ms-2 text-center">
    <?php echo bt_imprimirDiv(); ?>
</div>