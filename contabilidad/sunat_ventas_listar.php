<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_contabilidad_libros.php");

$bo_general = new bo_general();
$bo_compras = new bo_contabilidad_libros();

$cc_local=$_REQUEST['cc_local'];
$anho=$_REQUEST['anho'];
$periodo=$_REQUEST['periodo'];

$data_ventas=$bo_compras->ListarLibroVentas($cc_local, $anho, $periodo);
$data_local=$bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
    $cc_local_text=$loc['nombre'];
}

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
        <thead>
        <tr>
            <td colspan="8" class="titulo">REGISTRO DE VENTAS E INGRESOS</td>
        </tr>
        <tr>
            <td colspan="8">PERIODO=> <strong><?php echo $anho." - ".$periodo ?></strong></td>
        </tr>
        <tr>
            <td colspan="8" >RUC=> <strong> 20117925375 - EXPRESADO EN NUEVOS SOLES</td>
        </tr>
        <tr>
            <td colspan="8">RAZON SOCIAL=> <strong>COLEGIO DE ENFERMERO DEL PERU - <?php echo $cc_local_text ?></strong></td>
        </tr>
         <tr>
            <th rowspan="3" class="tabla-celda_cab col-60">NUMERO CORRELATIVO DEL REGISTRO CODIGO UNICO DE LA OPERACION</th>
            <th rowspan="3" class="tabla-celda_cab col-60">FECHA DE EMISION O COMPROBANTE DE PAGO DEL DOCUMENTO</th>
            <th rowspan="3" class="tabla-celda_cab col-60">FECHA DE VENCIMINETO Y/O PAGO</th>
            <th colspan="3" rowspan="2" class="tabla-celda_cab">COMPROBANTE DE PAGO</th>
            <th colspan="3" class="tabla-celda_cab">INFORMACION DEL CLIENTE </th>
            <th rowspan="3" class="tabla-celda_cab col-82">BASE IMPONIBLE DE LA OPERACION GRABADA</th>
            <th colspan="2" class="tabla-celda_cab">IMPORTE TOTAL DE LA EXONERACION</th>
            <th rowspan="3" class="tabla-celda_cab col-82">IGV Y/O IMP</th>
            <th rowspan="3" class="tabla-celda_cab col-60">OTROS TRIBUTOS</th>
            <th rowspan="3" class="tabla-celda_cab col-60">IMPORTE TOTAL</th>
            <th rowspan="3" class="tabla-celda_cab col-50">TIPO DE CAMBIO</th>
            <th colspan="4" class="tabla-celda_cab">DOCUMENTO ORIGINAL QUE SE MODIFICA</th>
        </tr>
        <tr>
            <th colspan="2" class="tabla-celda_cab">DOCUMENTO DE IDENTIDAD</th>
            <th rowspan="2" class="tabla-celda_cab col-250">APELLIDOS Y NOMBRE O RAZON SOCIAL O DENOMINACION </th>
            <th rowspan="2" class="tabla-celda_cab col-60">EXO.</th>
            <th rowspan="2" class="tabla-celda_cab col-60">INAF.</th>
            <th rowspan="2" class="tabla-celda_cab col-50">TIPO</th>
            <th rowspan="2" class="tabla-celda_cab col-82">SERIE-NUMERO</th>
        </tr>
        <tr>
            <th class="tabla-celda_cab col-41">TIPO</th>
            <th class="tabla-celda_cab col-41">SERIE</th>
            <th class="tabla-celda_cab col-41">NUMERO</th>
            <th class="tabla-celda_cab col-41">TIPO</th>
            <th class="tabla-celda_cab col-60">NUMERO</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $importe_total=0;
        $igv_total=0;
        $exonerada_total=0;
        $biplong_total=0;
        $i=0;
        foreach ($data_ventas as $row) {
            $importe_total+=$row["importe_total"];
            $igv_total+=$row["igv"];
            $exonerada_total+=$row["exonerada"];
            $biplong_total+=$row["biplong"];
             $i++;
        ?>
        <tr>
            <td align="center"><?php echo $row["correlativo"].digitos($i, 5); ?></td>
            <td align="center"><?php echo $row["fecha"] ?></td>
            <td align="center"><?php echo $row["fecha2"] ?></td>
            <td align="center"><?php echo $row["rci"] ?></td>
            <td  align="center" colspan="2"><?php echo $row["num_documento"] ?></td>
            <td align="center" ><?php echo $row["tipo_doc"] ?></td>
            <td align="center" ><?php echo $row["num_doc"] ?></td>
            <td class="td_oculta_text-60 col-300"><?php echo recortarCadena($row["nombre"],60) ?></td>
            <td class="text-end"><?php echo decimal_millar($row["biplong"],2) ?></td>
            <td class="text-end"><?php echo decimal_millar($row["exonerada"],2) ?></td>
            <td class="text-end"><?php echo decimal_millar($row["xxxx"],2) ?></td>
            <td class="text-end"><?php echo decimal_millar($row["igv"],2) ?></td>
            <td class="text-end"><?php echo decimal_millar($row["xxxx"],2) ?></td>
            <td class="text-end"><?php echo decimal_millar($row["importe_total"],2) ?></td>
            <td class="text-end">1.000</td>
            <td  align="center" colspan="2"> <?php echo $row["na_doc_referencia"] ?></td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9" class="text-end"><strong>TOTAL GENERAL : </strong></td>
            <td class="linea-arriba text-end"><?php echo decimal_millar($biplong_total, 2) ?> </td>
            <td class="linea-arriba text-end"><?php echo decimal_millar($exonerada_total, 2) ?></td>
            <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
             <td class="linea-arriba text-end"><?php echo decimal_millar($igv_total, 2) ?></td>
            <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?> </td>
            <td class="linea-arriba text-end"><?php echo decimal_millar($importe_total, 2) ?> </td>

        </tr>
    </tfoot>

</table>
<br>
<div style="text-align: center; margin-bottom: 10px;">
    <button  onclick="window.print();">
        <i class="bi bi-printer"></i> Imprimir
    </button>
</div>
</body>
</html>
