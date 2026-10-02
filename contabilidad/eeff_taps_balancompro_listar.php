<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_fin_contabilidad_balance.php");

$bo_general = new bo_general();
$bo_balance = new bo_fin_contabilidad_balance();

$ent_balance = new fin_contabilidad_balance();

$cc_local = $_REQUEST['cc_local'];
$anho = $_REQUEST['anho'];
$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];
$version = $_REQUEST['version'];
$digitos = $_REQUEST['digitos'];

$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
    $cc_local_text = $loc['nombre'];
}

$ent_balance->setCc_local($cc_local);
$ent_balance->setAnho($anho);
$ent_balance->setDesde($desde);
$ent_balance->setHasta($hasta);
$ent_balance->setVersion($version);
$ent_balance->setDigitos($digitos);

$bo_balance->EjecutaBalanceComprobacion($ent_balance);/**procesa informacion*/

$data_comprobacion=$bo_balance->BalanceComprobacion($ent_balance);
$data_totales=$bo_balance->TotalesBalanceComprobacion($ent_balance);/*totales balance de comprobacion*/
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style_print.css">
    <title>COLEGIO DE ENFERTMEROS DEL PERÚ</title>
</head>

<body class="landscape">
    <table>
        <tbody>
            <tr>
                <td class="titulo">COLEGIO DE ENNFERMEROS DEL PER&Uacute;</td>
                <td class="titulo">BALANCE DE COMPROBACION</td>
                <td>Fecha de emisi&oacute;n: <?php echo date('d/m/Y') ?></td>
            </tr>
            <tr>
                <td><br></td>
                <td>A&ntilde;o contable: <?php echo $anho." del ". $desde. " al ".$hasta ?></td>
                <td>Hora de emisi&oacute;n:&nbsp; <?php echo date('H:i:s'); ?></td>
            </tr>
        </tbody>
    </table>
    <table>
      <thead>
        <tr>
            <th colspan="2" class="tabla-celda_cab text-inicio">Montos expresados en soles</th>
            <th colspan="2" class="tabla-celda_cab">Suma del Mayor</th>
            <th colspan="2" class="tabla-celda_cab">Saldos</th>
            <th colspan="2" class="tabla-celda_cab">Inventario</th>
            <th colspan="2" class="tabla-celda_cab">Naturaleza</th>
            <th colspan="2" class="tabla-celda_cab">Funci&oacute;n</th>
        </tr>
        <tr>
           <th class="tabla-celda_cab text-inicio">(C) Cuenta</th>
           <th class="tabla-celda_cab text-inicio">Nombre</th>
           <th class="tabla-celda_cab text-end">Debe</th>
           <th class="tabla-celda_cab text-end">Haber</th>
           <th class="tabla-celda_cab text-end">Deudor</th>
           <th class="tabla-celda_cab text-end">Acreedor</th>
           <th class="tabla-celda_cab text-end">Activo</th>
           <th class="tabla-celda_cab text-end">Pasivo</th>
           <th class="tabla-celda_cab text-end">P&eacute;rdida</th>
           <th class="tabla-celda_cab text-end">Ganancia</th>
           <th class="tabla-celda_cab text-end">P&eacute;rdida</th>
           <th class="tabla-celda_cab text-end">Ganancia</th>
       </tr>
   </thead>
   <tbody>
    <?php 
    foreach ($data_comprobacion as $row){?>
        <tr>
            <td class="col-82"><a href="eeff_taps_balancompro_analitico.php"><?php echo $row['cuenta']; ?></a></td>
            <td class="col-250 td_oculta_text-60"><?php echo recortarCadena($row['nombre'],50); ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['debe'], 2) ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['haber'], 2) ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['deudor'], 2) ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['acreedor'], 2) ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['activo'], 2) ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['pasivo'], 2) ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['nperdida'], 2) ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['nganacia'], 2) ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['fperdida'], 2) ?></td>
            <td class="text-end col-60"><?php echo decimal_millar($row['fganacia'], 2) ?></td>
        </tr>
    <?php } ?>
</tbody>
<?php 
foreach ($data_totales as $tot) {
    $total_debe=$tot['total_debe'];
    $total_haber=$tot['total_haber'];
    $total_deudor=$tot['total_deudor'];
    $total_acreedor=$tot['total_acreedor'];
    $total_activo=$tot['total_activo'];
    $total_pasivo=$tot['total_pasivo'];
    $total_nperdida=$tot['total_nperdida'];
    $total_nganancia=$tot['total_nganancia'];
    $total_fperdida=$tot['total_fperdida'];
    $total_fganancia=$tot['total_fganancia'];

    $dif_activo=$total_pasivo-$total_activo;
}
?>
<tfoot>
    <tr>
        <td colspan="2" class="text-end"><strong>TOTAL GENERAL : </strong></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_debe, 2) ?> </td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_haber, 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_deudor, 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_acreedor, 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_activo, 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_pasivo, 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_nperdida, 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_nganancia, 2) ?> </td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_fperdida, 2) ?> </td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_fganancia, 2) ?> </td>

    </tr>
     <tr>
        <td colspan="6" class="text-end"><strong>Utilidades antes de participar en impuestos : </strong></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($dif_activo, 2) ?> </td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?> </td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?> </td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?> </td>
    </tr>
    <tr>
        <td colspan="6" class="text-end"></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar($total_pasivo, 2) ?> </td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?> </td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?> </td>
        <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?> </td>
    </tr>
</tfoot>
</table>

<br>
<div style="text-align: center; margin-bottom: 10px;">
    <button onclick="window.print();" >
        <i class="bi bi-printer"></i> Imprimir
    </button>
</div>
</body>

</html>

