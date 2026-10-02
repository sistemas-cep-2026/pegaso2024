<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_contabilidad_libros.php");

$bo_general = new bo_general();
$bo_compras = new bo_contabilidad_libros();

$cc_local = $_REQUEST['cc_local'];
$anho = $_REQUEST['anho'];
$periodo = $_REQUEST['periodo'];
$tipo = $_REQUEST['tipo'];

$data_compras = $bo_compras->listarCompras($cc_local, $anho, $periodo, $tipo);
$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
    $cc_local_text = $loc['nombre'];
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
                <td colspan="8" class="titulo">REGISTRO DE COMPRAS(IGV) <?php if($tipo<>'CP'){ echo '- RECIBOS POR HONORARIOS';} ?></td>
            </tr>
            <tr>
                <td colspan="8">PERIODO=> <strong><?php echo $anho." - ".$periodo ?></strong></td>
            </tr>
            <tr>
                <td colspan="8">RUC: <strong>20117925375</strong> - EXPRESADO EN NUEVOS SOLES</td>
            </tr>
            <tr>
                <td colspan="8">RAZON SOCIAL: <strong>COLEGIO DE ENFERMERO DEL PERU - <?php echo $cc_local_text ?></strong></td>
            </tr>
            <tr>
                <th rowspan="3" class="tabla-celda_cab col-102">NÚMERO CORRELATIVO DEL REGISTRO O CÓDIGO ÚNICO DE LA OPERACIÓN</th>
                <th rowspan="3" class="tabla-celda_cab col-92">FECHA EMISIÓN</th>
                <th rowspan="3" class="tabla-celda_cab col-92">FECHA DE VENC.</th>
                <th colspan="3" rowspan="2" class="tabla-celda_cab col-163">COMPROBANTE DE PAGO O DOCUMENTO</th>
                <th colspan="3" class="tabla-celda_cab col-796">INFORMACIÓN DEL PROVEEDOR</th>
                <th colspan="2" rowspan="2" class="tabla-celda_cab col-143">ADQUISICIONES GRAVADAS DESTINADAS A OPERACIONES GRAVADAS Y NO GRAVADAS</th>
                <th colspan="2" rowspan="2" class="tabla-celda_cab col-82">ADQUISICIONES GRAVADAS DESTINADAS A OPERACIONES GRAVADAS Y/O DE EXPORTACIÓN Y A OPERACIONES NO GRAVADAS</th>
                <th colspan="2" rowspan="2" class="tabla-celda_cab col-82">ADQUISICIONES GRAVADAS DESTINADAS A OPERACIONES NO GRAVADAS</th>
                <th rowspan="3" class="tabla-celda_cab col-41">VALOR DE LAS ADQUISICIONES NO GRAVADAS Y OTROS</th>
                <th rowspan="3" class="tabla-celda_cab col-41">OTROS TRIBUTOS Y CARGOS</th>
                <th rowspan="3" class="tabla-celda_cab col-102">IMPORTE TOTAL</th>
                <th colspan="2" rowspan="2" class="tabla-celda_cab col-143">CONSTANCIA DE DEPÓSITO DE DETRACCIÓN</th>
                <th rowspan="3" class="tabla-celda_cab col-41">TIPO DE CAMBIO</th>
            </tr>
            <tr>
                <th colspan="2" class="tabla-celda_cab col-143">DOC.</br>IDENTIDAD</th>
                <th rowspan="2" class="tabla-celda_cab col-653">APELLIDOS Y NOBRES DENOMINACION O RAZON SOCIAL</th>
            </tr>
            <tr>
                <th class="tabla-celda_cab col-20">TIPO</th>
                <th class="tabla-celda_cab col-61">S</th>
                <th class="tabla-celda_cab col-71">NUM</th>
                <th class="tabla-celda_cab col-20">TIPO</th>
                <th class="tabla-celda_cab col-102">NÚMERO</th>
                <th class="tabla-celda_cab col-102">BASE IMPONIBLE</th>
                <th class="tabla-celda_cab col-41">IGV</th>
                <th class="tabla-celda_cab col-41">BASE IMPONIBLE</th>
                <th class="tabla-celda_cab col-41">IGV</th>
                <th class="tabla-celda_cab col-41">BASE IMPONIBLE</th>
                <th class="tabla-celda_cab col-41">IGV</th>
                <th class="tabla-celda_cab col-31">NÚMERO</th>
                <th class="tabla-celda_cab col-102">FECHA</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total1 = 0;
            $total2 = 0;
            $total = 0;
            $i=0;
            foreach ($data_compras as $row) {
                $total1 += $row['total_original'];
                $total2 += $row['otyc'];
                $total += $row['total_original']+ $row['otyc'];
                $i++;

                ?>
                <tr>
                    <td align="center"><?php echo $row['comprobante']. digitos($i, 5); ?></td>
                    <td align="center"><?php echo $row['fecha_documento'] ?></td>
                    <td align="center"><?php echo $row['fecha_de_pago'] ?></td>
                    <td align="center" colspan="3"><?php echo $row['cod_documento'].'&nbsp;&nbsp;&nbsp;'.$row['num_documento'] ?></td>
                    <td align="center"><?php echo  $row['tipo_doc'] ?></td>
                    <td align="center" ><?php echo $row['num_doc'] ?></td>
                    <td class="td_oculta_text-30"><?php echo recortarCadena($row['nombre'], 30) ?></td>
                    <td class="text-end"><?php echo decimal_millar($row['total_original'], 2) ?></td>
                    <td class="text-end"><?php echo decimal_millar('0', 2) ?></td>
                    <td class="text-end"><?php echo decimal_millar('0', 2) ?></td>
                    <td class="text-end"><?php echo decimal_millar('0', 2) ?></td>
                    <td class="text-end"><?php echo decimal_millar('0', 2) ?></td>
                    <td class="text-end"><?php echo decimal_millar('0', 2) ?></td>
                    <td class="text-end"><?php echo decimal_millar('0', 2) ?></td>
                    <td class="text-end"><?php echo decimal_millar($row['otyc'], 2) ?></td> 
                    <td class="text-end"><?php echo decimal_millar($row['total_original']+$row['otyc'], 2) ?></td>
                    <td><?php echo $row['num_detraccion'] ?></td>
                    <td><?php echo $row['fecha_detraccion'] ?></td>
                    <td align="center"><?php echo decimal_millar('1', 2) ?></td>
                </tr>
            <?php } ?>
        
            <tr>
                <td colspan="9" class="text-end"><strong>TOTAL GENERAL : </strong></td>
                <td class="linea-arriba text-end"><?php echo decimal_millar($total1, 2) ?> </td>
                <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
                <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
                <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
                <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
                <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
                <td class="linea-arriba text-end"><?php echo decimal_millar('0', 2) ?></td>
                <td class="linea-arriba text-end"><?php echo decimal_millar($total2, 2) ?> </td>
                <td class="linea-arriba text-end"><?php echo decimal_millar($total, 2) ?> </td>
                
            </tr>
            </tbody>
          
    </table>

    <br>
    <div style="text-align: center; margin-bottom: 10px;">
        <button onclick="window.print();" >
            <i class="bi bi-printer"></i> Imprimir
        </button>
    </div>
</body>

</html>

