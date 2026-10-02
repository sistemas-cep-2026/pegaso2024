<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_salida.php");
require_once(u_src() . "bo/bo_general.php");
$bo_general = new bo_general();
$bo_guiasali = new bo_alm_guias_de_salida();


$ent_guiasali = new alm_guias_de_salida();


$cc_local = s_local_vinculado() ?? '';
$anho = $_REQUEST['anho'] ?? '';
$periodo = $_REQUEST['periodo'] ?? '';

$ent_guiasali->setC_local($cc_local);
$ent_guiasali->setAnho($anho);
$ent_guiasali->setPeriodo($periodo);

$bo_guiasali->consumos_mensual($ent_guiasali);

$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'];
}

$data_arti=$bo_guiasali->articulo_familia($cc_local, $periodo, $anho);
?>


<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/style_print.css">
	<title>COLEGIO DE ENFERTMEROS DEL PERÚ</title>
	<style>
        body {
            font-size: 16px;
        }
        table {
            font-size: 12px;
        }
        th, td {
            font-size: 12px;
        }
        h3, h4 {
            font-size: 18px;
        }
    </style>
</head>

<body class="portrait">
	<table>
	<td class="text-center" colspan="5"><h3>KARDEX MENSUAL - <?php echo $cc_local_text.' ('.$periodo."/".$anho.')';?></h3>
					<h4> <?php echo date('d/m/Y H:i:s')." -- ".s_usuario(); ?> </h4></td>
			<?php  
			
				?>
				<h4><i class='fas fa-tags'></i> <?= $art['nombre_familia'] ?></h4>
				<table class="table table-hover table-sm" id="table-reporte">
					<thead class="table-light">
						<tr>
							<th class="col-1">#</th>
							<th class="col-1">FAMILIA</th>
						 
					 
							<th class="col-5 text-left">NOMBRE</th>
							
							<th class="col-1 text-end">INICIAL</th>
							<th class="col-1 text-end">INGRESO</th>
							<th class="col-1 text-end">SALIDA</th>
							<th class="col-1 text-end">SALDO</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$data_detalle = $bo_guiasali->consumos_mensual_data($cc_local, $periodo, $anho);
						foreach ($data_detalle as $index => $row): ?>
							<tr>
								<td><?= $index + 1 ?></td>
								<td><?= $row["nombre_familia"]; ?></td>
				 
								<td><?= digitos($row["c_articulo"],7).'-' .$row["presentacion"] .'-'. substr($row["nombre"],0,65) ?></td>
								
								<td class="td_oculta_text-20 col-50 text-end"><?= decimal_millar($row["bi"],0) ?></td>
								<td class="td_oculta_text-20 col-50 text-end"><?= decimal_millar($row["ti"],0) ?></td>
								<td class="td_oculta_text-20 col-50 text-end"><?= decimal_millar($row["tg"],0) ?></td>
								<td class="td_oculta_text-20 col-50 text-end"><?= decimal_millar($row["sf"],0) ?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
						</table>
				 
	<div style="text-align: center; margin-bottom: 10px;">
		<button onclick="window.print();">
			<i class="bi bi-printer"></i> Imprimir
		</button>
	</div>

</body>

</html>