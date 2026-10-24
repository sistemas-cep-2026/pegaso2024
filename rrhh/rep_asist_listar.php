<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cont_asistencia.php");
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_asistencia = new bo_cont_asistencia();
$bo_persona = new bo_gen_personas();

$ent_persona = new gen_personas();

$cc_persona = $_REQUEST['cc_persona'] ?? '';
$anho = $_REQUEST['anho'] ?? '';
$periodo = $_REQUEST['periodo'] ?? '';

$estado = $_REQUEST['estado'];
//echo $cc_persona;
$ent_persona->setC_persona($cc_persona);
$data_persona = $bo_persona->listarID($ent_persona);
foreach ($data_persona as $per) {
	$nombre_completo = $per['nombre_completo'];
}
if ($cc_persona === '') {
	echo errors();
	exit;
}
if ($estado === 'V') {

	$data_dia  = $bo_asistencia->listarPersona($cc_persona, $anho, $periodo);
	if (count($data_dia) > 0) {	?>
		<div class="table-responsive">
			<h5 class="fs-14 text-truncate mb-1">
				<h2><?php echo $nombre_completo ?>
					<a href="javascript:fn_controlAsistencia('','<?php echo s_crypt($cc_persona, 'in') ?>','<?php echo s_crypt('I', 'in') ?>')"><i class='fas fa-plus-circle'></i></a>
				</h2>
			</h5>
			<table class="table table-hover table-sm" id="table-reporte">
				<thead class="table-light">
					<tr>
						<th>#</th>
						<th>DIA</th>
						<th>FECHA</th>
						<th>LABORAL</th>
						<th>ESTADO</th>
						<th class="text-center">OP</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					foreach ($data_dia as $dia) {
					?>
						<tr>
							<td><?php echo $i ?></td>
							<td><?php echo $dia['dia_semana'] ?></td>
							<td><?php echo $dia['fecha'] ?></td>
							<td><?php echo $dia['horario'] ?> hsr.</td>
							<td><span class="badge rounded-pill <?php echo $color_flag_estado[$dia["flag"]]; ?>"><?php echo $dia["flag_text"]; ?></td>
							<td class="text-center">
								<a href="javascript:fn_controlAsistencia('<?php echo s_crypt($dia['id'], 'in') ?>','<?php echo s_crypt($dia['cc_persona'], 'in') ?>','<?php echo s_crypt('U', 'in') ?>')" class="text-primary"><i class="fas fa-edit fa-1x"></i></a>
							</td>
						</tr>
					<?php $i++;
					} ?>
				</tbody>
			</table>
		</div>
	<?php } else {
		echo errors();
	}
} elseif ($cc_persona == 'T') {

	$data_cuadra  = $bo_asistencia->ReporlistarPersona_todos($anho, $periodo); ?>

	<div class="table-responsive">

		<table class="table table-hover table-sm" id="table-reporte">
			<thead class="table-light">
				<tr>
					<th>#</th>
					<th>DOCUMENTO</th>
					<th>NOMBRE</th>
					<th>FECHA</th>
					<th>LABORAL</th>
					<th>INGRESO</th>
					<th>SALIDA</th>
					<th>HT</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach ($data_cuadra as $dia) {
				?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $dia['num_documento'] ?></td>
						<td><?php echo $dia['nombre'] ?></td>
						<td><?php echo $dia['dia_semana'] . " " . $dia['fecha'] ?></td>
						<td><?php echo $dia['horario'] ?> hsr.</td>
						<td><?php echo $dia['hora_inicio'] ?> </td>
						<td><?php echo $dia['hora_salida'] ?> </td>
						<td><?php echo calcularDiferenciaHoras($dia['hora_inicio'], $dia['hora_salida']) ?> </td>
					</tr>
				<?php $i++;
				} ?>
			</tbody>
		</table>
		<?php

	} else {

		$data_cuadra  = $bo_asistencia->ReporlistarPersona($cc_persona, $anho, $periodo);
		if (count($data_cuadra) > 0) {	?>
			<div class="table-responsive">
				<h5 class="fs-14 text-truncate mb-1">
					<h2><?php echo $nombre_completo ?>
					</h2>
				</h5>
				<table class="table table-hover table-sm" id="table-reporte">
					<thead class="table-light">
						<tr>
							<th>#</th>
							<th>FECHA</th>
							<th>INGRESO</th>
							<th>SALIDA</th>
							<th>LABORAL</th>
							<th>HT</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($data_cuadra as $dia) {
						?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $dia['dia_semana'] . " " . $dia['fecha'] ?></td>

								<td><?php echo $dia['hora_inicio'] ?> </td>
								<td><?php echo $dia['hora_salida'] ?> </td>
								<td><?php echo $dia['horario'] ?> hsr.</td>
								<td><?php echo calcularDiferenciaHoras($dia['hora_inicio'], $dia['hora_salida']) ?> </td>
							</tr>
						<?php $i++;
						} ?>
					</tbody>
				</table>
			</div>
	<?php } else {
			echo errors();
		}
	} ?>