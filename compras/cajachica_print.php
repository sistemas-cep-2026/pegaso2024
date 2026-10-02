<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_comp_liquidaciones_caja_chica.php");
$bo_cajachica = new bo_comp_liquidaciones_caja_chica();
$ent_cajachica = new comp_liquidaciones_caja_chica();
$bo_general = new bo_general();

$cc_caja_chica = s_crypt($_REQUEST['cod'], 'out');
$ent_cajachica->setCc_caja_chica($cc_caja_chica);

$data_cajchica  = $bo_cajachica->listarID($ent_cajachica);

foreach ($data_cajchica as $cab) {
    $nro_cheque = $cab['nro_cheque'];
    $c_banco = $cab['c_banco'];
    $c_cta_corriente = $cab['c_cta_corriente'];
    $banco_cta = $cab['nombre_banco'];
    $fecha_operacion = $cab['fecha_operacion_print'];
    $flag = $cab['flag'];
    $cc_local =  $cab['c_local'];
    $cc_persona = $cab['c_persona'];
    $monto = $cab['monto'];
    $monto_apertura = $cab['monto_apertura'];
    $nombre = $cab['nombre'];
    $num_documento = $cab['num_documento'];
    $c_liquidacion_caja_chica = $cab['c_liquidacion_caja_chica'];
}
$ent_cajachica->setC_local($cc_local);
$ent_cajachica->setC_liquidacion_caja_chica($c_liquidacion_caja_chica);


$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
    $cc_local_text = $loc['nombre'];
}

$data_detalle = $bo_cajachica->listar_doc($ent_cajachica);
$total_haber = array_sum(array_column($data_detalle, 'total'));


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMAS || COLEGIO DE ENFERMEROS DEL PERÚ</title>
    <link rel="icon" href="<?php echo url('images/logo_print.jpg') ?>" type="image/png">
    <link rel="stylesheet" type="text/css" href="<?php echo url('css/print.css'); ?>">
</head>

<body class="bg-dark my-2">
    <div class="page bg-white">

        <table class="table table-sm table-borderless">
            <tr>
                <th class="col-md-6 fs-6"> <?php echo $cc_local_text; ?></th>
                <th class="col-md-3 text-end fs-6">FECHA CAJA: <?php echo $fecha_operacion; ?> </th>
                <th class="col-md-3 text-end fs-6">CAJA CHICA: <?php echo digitos($cc_caja_chica, 6) ?> </th>
            </tr>
            <tr>
                <td colspan="12" class="text-end  fs-6">
                 <strong>MODULO DE COMPRAS</strong>
             </td>
         </tr>
     </table>
     <table class=" table table-sm table-bordered w-auto">
        <thead class="table-light">
            <tr>
                <th>RESPONSABLE</th>
                <th>BANCO</th>
                <th>FEC. OPE.</th>
                <th>NUM.OPE</th>
                <th>APERTURA S/.</th>
                <th>REPOSICION S/.</th>
                <th>CAJA S/.</th>
                <th>RENDIDO S/.</th>
                <th>SALDO CIERRE S/.</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-nowrap"><?php echo $num_documento . ' - ' . $nombre; ?></td>
                <td class="text-nowrap"><?php echo $nombre_banco ?></td>
                <td class="text-nowrap"><?php echo $fecha_operacion ?></td>
                <td class="text-nowrap"><?php echo $nro_cheque ?></td>
                <td class="text-nowrap">S/. <?php echo decimal_millar($monto_apertura, 2) ?></td>
                <td class="text-nowrap text-end">S/. <?php echo decimal_millar($monto, 2) ?></td>
                <th class="text-end"><?php echo decimal_millar($monto_apertura+$monto, 2) ?></th>
                <th class="text-end"><?php echo decimal_millar($total_haber, 2) ?></th>
                <th class="text-end"><?php echo decimal_millar($monto_apertura+$monto-$total_haber, 2) ?></th>
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
                <th>#</th>
                <th>RUC-RAZON</th>
                <th>FECHA</th>
                <th>DOCUMENTO</th>

                <th>CUENTA</th>
                <th class="text-end">MONTO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;

            foreach ($data_detalle as $det) {
                ?>
                <tr>
                    <td class="text-nowrap"><?php echo $i ?></td>
                    <td class="text-nowrap"><?php echo $det['razon_social'] ?></td>
                    <td class="text-nowrap"><?php echo $det['fecha_documento_print'] ?></td>
                    <td class="text-nowrap"><?php echo $det['cod_documento'] . ' ' . $det['num_documento']; ?></td>
                    <td class="text-nowrap"><?php echo $det['c_cuenta']; ?></td>
                    <td class="text-nowrap text-end "><?php echo decimal_millar($det['total'], 2) ?></td>
                </tr>
                <tr>
                    <td class="text-nowrap "> </td>
                    <td colspan="4" class="text-nowrap "><?php echo $det['observacion']; ?></td>
                </tr>
                <?php $i++;
            } ?>
            <tr>
                <th colspan="5" class="text-end">TOTAL EGRESO => </th>
                <th class="text-end"><?php echo decimal_millar($total_haber, 2) ?></th>
            </tr>
            <tr>
                <th colspan="5" class="text-end">SALDO CAJA/EFECTIVO => </th>
                <th class="text-end"><?php echo decimal_millar($monto_apertura+$monto-$total_haber, 2) ?></th>
            </tr>
        </tbody>
    </table>
    <table>
        <tr>
            <td><?php echo sistema_vesion(); ?>
            - User Print: <strong> <?php echo s_usuario() ?> </strong> Fecha Print: <strong><?php echo fecha_hora_hoy(); ?> </strong>
        </td>

    </tr>
</table>
</div>
</body>

</html>