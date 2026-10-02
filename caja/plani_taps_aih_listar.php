<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");
require_once(u_src() . "bo/bo_general.php");
$bo_general = new bo_general();
$bo_doc_ventas = new bo_fin_documentos_de_venta();


$ent_doc_ventas = new bo_fin_documentos_de_venta();



$cc_local = $_REQUEST['cc_local'] ?? '';
$periodo = $_REQUEST['periodo'] ?? '';

$bo_doc_ventas->ActualizarHabiles($periodo);

$ent_doc_ventas->setC_local($cc_local);
$ent_doc_ventas->setPeriodo($periodo);


$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'];
}


?>
<div id="print-section" class="print-section">
	<div class="row bg-white">
		<div class="table-responsive">
			<table class="table table-borderless table-sm">
				<tr class="texto_printer">
					<td class="text-center" colspan="2"><h3>KARDEX MENSUAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $periodo."/".$anho?></h3><small> <?php echo date('d/m/Y H:i:s')." --".s_usuario(); ?> </small></td>
				</tr>
			</table>
			<?php foreach ($data_arti as $art): 
				$sub_familia = $art['c_sub_familia'];
				$data_detalle = $bo_guiasali->consumos_mensual_data($cc_local, $periodo, $anho, $sub_familia);
				?>
				<h4><i class='fas fa-tags'></i> <?= $art['nombre_familia'] ?></h4>
				<table class="table table-hover table-sm" id="table-reporte">
					<thead class="table-light">
						<tr>
							<th class="col-1">#</th>
							<th class="col-1">CODIGO</th>
							<th class="col-4">NOMBRE</th>
							<th class="col-1 text-center">VALOR INICIAL</th>
							<th class="col-1 text-center">TOTAL INGRESO</th>
							<th class="col-1 text-center">TOTAL GASTO</th>
							<th class="col-1 text-center">SALDO FINAL</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data_detalle as $index => $row): ?>
							<tr>
								<td><?= $index + 1 ?></td>
								<td><?= digitos($row["c_articulo"],7) ?></td>
								<td><?= $row["nombre"] ?></td>
								<td class="text-center"><?= decimal_millar($row["bi"],0) ?></td>
								<td class="text-center"><?= decimal_millar($row["ti"],0) ?></td>
								<td class="text-center"><?= decimal_millar($row["tg"],0) ?></td>
								<td class="text-center"><?= decimal_millar($row["sf"],0) ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>

				</table>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<div class="flex-grow-1 ms-2 text-center">
	<?php echo bt_imprimirDiv();?>
</div>
