<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

$bo_documentos = new bo_tram_documentos_recibidos();

$ent_documentos= new tram_documentos_recibidos();


$cc_local = $_REQUEST['cc_local'] ?? '';
$num_inicio = $_REQUEST['num_inicio'] ?? '';
$num_final = $_REQUEST['num_final'] ?? '';
$gestion = $_REQUEST['gestion'] ?? '';

$ent_documentos->setCc_local($cc_local);
$ent_documentos->setNum_inicio($num_inicio);
$ent_documentos->setNum_final($num_final);
$ent_documentos->setGestion($gestion);


$data_documentops=$bo_documentos->rep_cabecera($ent_documentos);

?>
<div id="print-section" class="print-section">
	<div class="row bg-white">
		<div class="table-responsive">
			<table class="table table-borderless table-sm">
				<tr class="texto_printer">
					<td class="text-center" colspan="2"><h3>HORAS EXTRAS - CONSOLIDADO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $periodo."/".$anho?></h3>
					</td>
				</tr>
				<tr class="texto_printer">
					<td>Usuario: <strong><?php echo $user_nombre ?></strong></td>
					<td class="text-end"><?php echo fecha_hora_hoy() ?></td>
				</tr>
			</table>
			<hr>
			<?php 
			
			?>
			<table class="table table-borderless table-sm small">
				<thead class="table-light">
					<tr>
						<th>Fecha</th>
						<th>Expediente</th>
						<th>Nombre</th>
						<th>Número</th>	
						<th>Fech. doc</th>
						<th>Opción</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($data_documentops as $row) {
		
						?>
						<tr>
							<td class="col-md-2"><?php echo $row["fecha_ingreso"] ?></td>
							<td class="col-md-2"><?php echo $row["c_expediente"] ?></td>
							<td class="col-md-2"><?php echo $row["nombre"] ?></td>
							<td class="col-md-2"><?php echo $row["num_documento"]?></td>
							<td class="col-md-2"><?php echo $row["fecha_documento"]?></td>
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="5" class="text-end">Total :</th>
						<th class="text-end"><?php echo segundos_tiempo($totaldia);?></th>
					</tr>
				</tfoot>
			</table>
			<br>
	</div>
</div>
</div>
<div class="flex-grow-1 ms-2 text-center">
	<?php echo bt_imprimirDiv();?>
</div>

