<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_honorabilidad.php");
$bo_honorabilidad = new bo_tram_honorabilidad();

$ent_honorabilidad = new tram_honorabilidad();

$nombre = $_REQUEST['nombre'] ?? '';
$anho = $_REQUEST['anho'] ?? '';
$periodo = $_REQUEST['periodo'] ?? '';

$ent_honorabilidad->setNombre($nombre);
$ent_honorabilidad->setAnho($anho);
$ent_honorabilidad->setPeriodo($periodo);

$data_hono  = $bo_honorabilidad->listar($ent_honorabilidad);

$headerReporte = "<h2 class='text-center'>Registros de Honorabilidad $periodo / $anho</h2>";
echo "<script>var headerContent = `" . $headerReporte . "`;</script>";

?>

<div class="table-responsive">
	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<th>NUMERO</th>
				<th>FECHA</th>
				<th>CEP</th>
				<th>DOCUMENTO</th>
				<th>NOMBRE</th>
				<th>CR</th>
				<th>RECAUDO BBVA</th>
				<th>ESTADO</th>
				<th>OP</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$estados_color = [
				'P' => 'success',
				'A' => 'danger'
			];
			$i = 1;
			foreach ($data_hono as $row) {
				$diferencia = compararFechas($row['fecha_reg']);
			?>
				<tr>
					<td><?php echo $row["numero"] ?></td>
					<td><?php echo $row["fecha_reg"] ?></td>
					<td><?php echo $row["cep"]; ?></td>
					<td><?php echo $row["num_documento"]; ?></td>
					<td><?php echo $row["nombre"]; ?></td>
					<td><?php echo $row["c_localtext"]; ?></td>
					<td><?php echo $row["banco"]; ?></td>
					<td><?php echo u_estado($row["flag_text"], $estados_color[$row["flag"]]); ?></td>
					<td>
						<a href="#" onclick="fn_imprimir('<?php echo s_crypt($row['cc_honorab'], 'in') ?>')" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Previsualizar Certificado"><i class="fa-solid fa-print"></i></a>
						<?php if (($diferencia < 5) and ($row["flag"] === 'P')) { ?>
							<a href="#" onclick="fc_anular('<?php echo s_crypt($row['cc_honorab'], 'in') ?>','<?php echo s_crypt('A', 'in') ?>')" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Anular"><i class='fas fa-toggle-on'></i></a>
						<?php } ?>

					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</div>