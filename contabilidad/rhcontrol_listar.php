<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cont_rhcontrol.php");

$bo_general = new bo_general();
$bo_conta_rhcontrol = new bo_cont_rhcontrol();

$cc_local = $_REQUEST['cc_local'];
$anho = $_REQUEST['anho'];
$periodo = $_REQUEST['periodo'];
$tipo = $_REQUEST['tipo'];

$data = $bo_conta_rhcontrol->preparar($cc_local, $anho, $periodo, $tipo);
$data_compras = $bo_conta_rhcontrol->listar($cc_local, $anho, $periodo, $tipo);

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
      <style>
        /* Aumenta altura y tamaño del texto solo en las filas del cuerpo */
        table tbody tr td {
  
            font-size: 16px;     /* tamaño de letra */
           
        }

       
    </style>
</head>
<body class="landscape">
    <table>
        <thead>
            <tr>
                <td colspan="9" class="titulo">PRESTACION DE SERVICIO POR RENTA DE 4TA CATEGORIA - CONTROL</td>
            </tr>
            <tr>
                <td colspan="9">PERIODO=> <strong><?php echo $anho." - ".$periodo ?></strong></td>
            </tr>
            <tr>
                <td colspan="9">RUC: <strong>20117925375</strong> - EXPRESADO EN NUEVOS SOLES</td>
            </tr>
            <tr>
                <td colspan="9">RAZON SOCIAL: <strong>COLEGIO DE ENFERMERO DEL PERU - <?php echo $cc_local_text ?></strong></br> </td>
            </tr>
            <tr>
               
              
               
                <th colspan="2" class="tabla-celda_cab col-500">INFORMACIÓN DEL PROVEEDOR</th> 
                 <th  rowspan="3" class="tabla-celda_cab col-163">DOCUMENTO</th>
                 <th rowspan="3" class="tabla-celda_cab col-92">FECHA EMISIÓN</th>
                <th rowspan="3" class="tabla-celda_cab col-92">FECHA DE PAGO</th>
                <th rowspan="3"   class="tabla-celda_cab col-143">MONTO POR RH</th>
                <th rowspan="3"   class="tabla-celda_cab col-82">RETENCIONES</th>
                <th rowspan="3"   class="tabla-celda_cab col-82">TOTAL NETO</th>
                <th rowspan="3" class="tabla-celda_cab col-41">OSB</th>
                
                
            </tr>
            <tr>
                <th rowspan="2" class="tabla-celda_cab col-120">RUC</th>
                <th rowspan="2" class="tabla-celda_cab col-380">APELLIDOS Y NOBRES DENOMINACION O RAZON SOCIAL</th>
            </tr>
            <tr>
                
             
                
            
            </tr>
        </thead>
        <tbody>
            <?php
            
            $retencion = 0;
            $total = 0;
            $i=0;
            foreach ($data_compras as $row) {
                $total += $row['total'];
                $retencion += $row['retencion'];
                
                $i++;

                ?>
                <tr>
                
                    <td align="center"><?php echo $row['ruc'] ?></td>
                    
                    <td  ><?php echo $row['nombre'] ?></td>
                    <td align="center"><?php echo $row['cod_documento'].'&nbsp;&nbsp;&nbsp;'.$row['num_documento'] ?></td>
                    <td align="center"><?php echo  $row['fecha_documento'] ?></td>
                    <td align="center" ><?php echo $row['fecha_pago'] ?></td>
                    <td class="text-end"><?php echo decimal_millar($row['total'], 2) ?></td>
                    <td class="text-end"><?php echo decimal_millar($row['retencion'], 2) ?></td> 
                    <td class="text-end"><?php echo decimal_millar($row['total']-$row['retencion'], 2) ?></td>
                    <td align="center"></td>
                </tr>
            <?php } ?>
        
            <tr>
                <td colspan="5" class="text-end"><strong>TOTAL GENERAL : (<?php echo $i;?>)</strong></td>
                <td class="linea-arriba text-end"><?php echo decimal_millar($total, 2) ?> </td>
                
         
                <td class="linea-arriba text-end"><?php echo decimal_millar($retencion, 2) ?> </td>
                <td class="linea-arriba text-end"><?php echo decimal_millar($total-$retencion, 2) ?> </td>
                
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

