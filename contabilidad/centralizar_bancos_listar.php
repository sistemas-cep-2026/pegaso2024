<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_contabilidad_centralizar.php");

$bo_general = new bo_general();
$bo_centralizar = new bo_contabilidad_centralizar();

$cc_local = $_REQUEST['cc_local'];
$anho = $_REQUEST['anho'];
$periodo = $_REQUEST['periodo'];
 
$data = $bo_centralizar->listarBancos($cc_local);
 
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style_print.css">
    <title>COLEGIO DE ENFERTMEROS DEL PERÚ</title>
</head>
<body  >
    <table>
        
        <tbody>
            <tr>
                    <td align="center">AÑO</td>
                    <td align="center">MES</td>
                    <td align="center">ACUMULADO S/.</td>
                   <td align="center">CANTIDAD DE REGISTROS</td>
                    
                </tr>
            <?php
            $total1 = 0;
            $total2 = 0;
            $total = 0;
            $i=0;
            foreach ($data as $row) {
 
                
                $i++;

                ?>
                <tr>
                    <td align="center"><?php echo $row['cod_ano'] ?></td>
                    <td align="center"><?php echo $row['cod_mes'] ?></td>
                    <td align="center"><?php echo $row['total'] ?></td>
                   <td align="center"><?php echo $row['cantidad'] ?></td>
                    
                </tr>
            <?php } ?>
        
           
            </tbody>
          
    </table>
 <br>
    <input type="hidden" id="centralizar_cc_local" value="<?php echo htmlspecialchars($cc_local, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" id="centralizar_anho" value="<?php echo htmlspecialchars($anho, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" id="centralizar_periodo" value="<?php echo htmlspecialchars($periodo, ENT_QUOTES, 'UTF-8'); ?>">

    <button type="button" id="btnProcesarBancos" class="btn btn-primary"
            onclick="parent.fn_ProcesarBancos(this)">
        <i class="bi bi-gear"></i> PROCESAR <?php echo htmlspecialchars($anho . '-' . $periodo, ENT_QUOTES, 'UTF-8'); ?>
    </button>
</body>

</html>

