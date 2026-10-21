<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_recaud_bcp_detalle.php");
$bo_general = new bo_general();
$bo_recaudobcp=new bo_recaud_bcp_detalle();

$ent_recaudobcp=new recaud_bcp_detalle();


$tipo = $_GET['c_tipo'] ?? $_POST['c_tipo'] ?? '';
$var = $_GET['periodo'] ?? $_POST['periodo'] ?? '';

$periodo = substr($var, 3, 4).substr($var, 0, 2);
$cc_local = (s_local() === '28') ? '' : s_local();

$ent_recaudobcp->setTipo($tipo);
$ent_recaudobcp->setPeriodo($periodo);
$ent_recaudobcp->setC_local($cc_local);

if (in_array($tipo, ['H', 'D'])) {

	$data_bcphoy=$bo_recaudobcp->listar($ent_recaudobcp);
	$data_bcptotal=$bo_recaudobcp->total_recaudo($ent_recaudobcp);
	foreach($data_bcptotal as $tot){
		$cantidad=$tot['cantidad'];
		$t=$tot['total_total_distribuir'];
		$tn=$tot['total_nacional'];
		$tcr=$tot['total_region'];
		$tfijoregion=$tot['total_fijoregion'];
	}
	
	$date_estado=$bo_general->periodos_recaudadoras($periodo);
	$bcp = $date_estado[0]['bcp'] ?? null;
	?>
	<div class="table-responsive">
		<?php if ((string) $bcp === '0') { ?>
			<div class="alert alert-danger shadow text-center" role="alert">
				<strong> <i class='fas fa-exclamation-triangle'></i> </strong> BCP
			</div>
		<?php } ?>
		<table class="table table-hover table-sm" id="table-reportebcp">
			<thead class="table-light">
				<tr>
					<th>#</th>
					<th>NOMBRE</th>
					<th>CEP/DNI</th>
					<th>FECHA</th>
						<th>HORA</th>
						<th>FECHA SIS</th>
					<th>CONCEPTO</th>
					<th>OP</th>
				
					<th>CR</th>
					<th class="text-end">MONTO</th>
					<th class="text-end">=&gt;</th>
					<th class="text-end">%CN</th>
					<th class="text-end">%CR</th>
					<th class="text-end">FIJO CR</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$i=1;
				foreach ($data_bcphoy as $row) {
					?>
					<tr>
						<td><?php echo $i . '-' . $row["id"]; ?></td>
						<td><?php echo $row["nombre2"] ?></td>
						<td><?php echo $row["c_cmp"] ?></td>
						<td><?php echo $row["fecha"] ?></td>
						<td><?php echo $row["hora"] ?></td>
							<td><?php echo $row["fecha_id"] ?></td>
						<td><?php echo $row["nombre1"] ?></td>
						<td><?php echo   $row["operacion_canal"]  ; ?></td>
						
						<td><?php echo $row["c_local"] ?></td>
						<td class="text-end"><?php echo decimal($row["distribuir"], 2) ?></td>
						<td class="text-end"><span>=&gt;</span></td>
						<td class="text-end"><?php echo decimal($row["nacional"], 2) ?></td>
						<td class="text-end"><?php echo decimal($row["region"], 2) ?></td>
						<td class="text-end"><?php echo decimal($row["fijoregion"], 2) ?></td>
					</tr>
					<?php $i++;} ?>
				</tbody>
				<footer>
					<tr>
						<th colspan="6"></th>
						<th class="text-end">TOTAL :</th>
						<th><?php echo $cantidad ?></th>
						<th class="text-end"><?php echo decimal($t, 2) ?></th>
						<th class="text-end"><span>=&gt;</span></th>
						<th class="text-end"><?php echo decimal($tn, 2) ?></th>
						<th class="text-end"><?php echo decimal($tcr, 2) ?></th>
						<th class="text-end"><?php echo decimal($tfijoregion, 2) ?></th>
					</tr>
				</footer>
			</table>
		</div>
	<?php }elseif($tipo=='R'){
		$data_local=$bo_general->local_procentaje();
		?>
		<table class="table table-sm">
			<?php foreach ($data_local as $cr) {
				
				$visible = ($periodo >= 202208 && $periodo <= 202412) ? 'S' : 'N';

				$ent_recaudobcp->setFecha($periodo);
				$ent_recaudobcp->setC_local($cr["c_local"]);
				?>
				<thead class="table-light">
					<tr>
						<th > <strong> CR <?php echo $cr["nombre1"] ?></strong></th>
						<th class="text-end">RECAUDADO <?php echo "P : ".$periodo ?></th>
						<th class="text-end">CN TRAMITES</th>
						<th class="text-end"><?php if($visible==='S'){ echo "(100 CN)"; } else { echo "-&gt;"; } ?></th>
						<th class="text-end">CR TRAMITES	</th>
						<th class="text-end">COTI. X DIST.</th>
						<th class="text-end">CN <?php echo decimal($cr["porc_cotizacion"], 0); ?>%</th>
						<th class="text-end">CR <?php echo 100 - $cr["porc_cotizacion"] ?>%</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$data_resum=$bo_recaudobcp->recaudo_resumen($ent_recaudobcp);
					foreach ($data_resum as $row2) {
						if ($row2["dd"] == 'M') {
							if ($periodo >= 200101 && $periodo <= 202207) {
								$tfcn = ($tfcn + (400 * $row2["tt"]));
								$fcn = (400 * $row2["tt"]);
								$vcn = $row2["nacional"] - (400 * $row2["tt"]);
							}
							if ($rango >= 202208 && $rango <= 202412) {
								if ($row["c_local"] <> '03') {
									$tfcn = ($tfcn + (670 * $row2["tt"]));
									$fcn = (670 * $row2["tt"]);
									$s100 = (100 * $row2["tt"]);
									$vcn = $row2["nacional"] - (670 * $row2["tt"]) - $s100;

								} else {
									$tfcn = ($tfcn + (770 * $row2["tt"]));
									$fcn = (770 * $row2["tt"]);
									$s100 = (0 * $row2["tt"]);
									$vcn = $row2["nacional"] - (770 * $row2["tt"]);
								}
							}
							if ($rango >= 202501 && $rango <= 202812) {
								$tfcn = ($tfcn + (770 * $row2["tt"]));
								$fcn = (770 * $row2["tt"]);
								$s100 = (0 * $row2["tt"]);
								$vcn = $row2["nacional"] - (770 * $row2["tt"]);
							}
						} else {
							$vcn = $row2["nacional"];
						}
						?>
						<tr>
							<td><?php echo " &nbsp;&nbsp;&nbsp;=> ".$row2['nombre1'] ?></td>
							<td class="text-end"><?php echo decimal($row2["total"], 2) ?></td>
							<td class="text-end"><?php echo decimal($fcn, 2); ?></td>
							<td class="text-end"> <?php if($visible==='S'){ echo decimal($s100, 2); } else { echo "-&gt;"; } ?></td>
							<td class="text-end"><?php echo decimal($row2["fijoregion"], 2) ?></td>
							<td class="text-end"><?php echo decimal(($row2["total"] ?? 0) - $fcn - $s100 - ($row2["fijoregion"] ?? 0), 2) ?>x</td>
							<td class="text-end"><?php echo decimal($vcn, 2); ?></td>
							<td class="text-end"><?php echo decimal($row2["region"], 2); $s100 = 0; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			<?php } ?>
		</table>
	<?php } ?>
