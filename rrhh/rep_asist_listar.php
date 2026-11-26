<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cont_asistencia.php");
require_once(u_src() . "bo/bo_gen_personas.php");

$bo_asistencia = new bo_cont_asistencia();
$bo_persona = new bo_gen_personas();

$ent_persona = new gen_personas();

function asis_h($t)
{
	return htmlspecialchars(trim((string) $t), ENT_QUOTES, 'UTF-8');
}

/** Nombre del día en español (DATENAME depende del idioma de SQL Server y puede venir en inglés). */
function asis_dia($dia)
{
	$dias = ['monday' => 'Lunes', 'tuesday' => 'Martes', 'wednesday' => 'Miércoles', 'thursday' => 'Jueves',
		'friday' => 'Viernes', 'saturday' => 'Sábado', 'sunday' => 'Domingo'];
	$k = strtolower(trim((string) $dia));
	return $dias[$k] ?? ucfirst($k);
}

/** Horas trabajadas del día; con una sola marcación no hay salida. */
function asis_ht($dia)
{
	if ((int) ($dia['marcaciones'] ?? 0) < 2) {
		return '<span class="badge bg-warning-subtle text-warning">Sin salida</span>';
	}
	return asis_h(calcularDiferenciaHoras(trim((string) $dia['hora_inicio']), trim((string) $dia['hora_salida'])));
}

// Filtros validados (antes llegaban directo al SQL)
$cc_persona = trim((string) ($_REQUEST['cc_persona'] ?? ''));
$anho = (string) ($_REQUEST['anho'] ?? '');
$periodo = (string) ($_REQUEST['periodo'] ?? '');
$estado = (string) ($_REQUEST['estado'] ?? '');

if ($cc_persona === '' || !preg_match('/^(T|[0-9A-Za-z]{1,10})$/', $cc_persona)) {
	echo errors('Seleccione una persona.');
	exit;
}
if (!ctype_digit($anho) || (int) $anho < 2000 || !ctype_digit($periodo) || (int) $periodo < 1 || (int) $periodo > 12) {
	echo errors('Seleccione el año y el periodo.');
	exit;
}
// El recuadre (editar marcaciones) es solo para nivel A, igual que en la pantalla
$es_recuadre = ($estado === 'V' && s_nivel() === 'A');

$nombre_completo = '';
if ($cc_persona !== 'T') {
	$ent_persona->setC_persona($cc_persona);
	foreach ($bo_persona->listarID($ent_persona) as $per) {
		$nombre_completo = $per['nombre_completo'];
	}
}

if ($es_recuadre) {
	if ($cc_persona === 'T') {
		echo errors('Para el recuadre seleccione una persona.', 'warning');
		exit;
	}
	$data_dia = $bo_asistencia->listarPersona($cc_persona, $anho, $periodo);
	if (count($data_dia) > 0) { ?>
		<div class="table-responsive">
			<h2 class="fs-5 mb-2"><?php echo asis_h($nombre_completo) ?>
				<a href="javascript:fn_controlAsistencia('','<?php echo s_crypt($cc_persona, 'in') ?>','<?php echo s_crypt('I', 'in') ?>')" title="Agregar marcación"><i class='fas fa-plus-circle'></i></a>
			</h2>
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
							<td><?php echo asis_h(asis_dia($dia['dia_semana'])) ?></td>
							<td><?php echo asis_h($dia['fecha']) ?></td>
							<td><?php echo asis_h($dia['horario']) ?> hrs.</td>
							<td><span class="badge rounded-pill <?php echo $color_flag_estado[$dia["flag"]] ?? 'bg-secondary'; ?>"><?php echo asis_h($dia["flag_text"]); ?></span></td>
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
} elseif ($cc_persona === 'T') {

	$data_cuadra = $bo_asistencia->ReporlistarPersona_todos($anho, $periodo);
	if (count($data_cuadra) > 0) { ?>
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
							<td><?php echo asis_h($dia['num_documento']) ?></td>
							<td><?php echo asis_h($dia['nombre']) ?></td>
							<td><?php echo asis_h(asis_dia($dia['dia_semana']) . " " . $dia['fecha']) ?></td>
							<td><?php echo asis_h($dia['horario']) ?> hrs.</td>
							<td><?php echo asis_h($dia['hora_inicio']) ?></td>
							<td><?php echo ((int) $dia['marcaciones'] < 2) ? '—' : asis_h($dia['hora_salida']) ?></td>
							<td><?php echo asis_ht($dia) ?></td>
						</tr>
					<?php $i++;
					} ?>
				</tbody>
			</table>
		</div>
	<?php } else {
		echo errors();
	}
} else {

	$data_cuadra = $bo_asistencia->ReporlistarPersona($cc_persona, $anho, $periodo);
	if (count($data_cuadra) > 0) { ?>
		<div class="table-responsive">
			<h2 class="fs-5 mb-2"><?php echo asis_h($nombre_completo) ?></h2>
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
							<td><?php echo asis_h(asis_dia($dia['dia_semana']) . " " . $dia['fecha']) ?></td>
							<td><?php echo asis_h($dia['hora_inicio']) ?></td>
							<td><?php echo ((int) $dia['marcaciones'] < 2) ? '—' : asis_h($dia['hora_salida']) ?></td>
							<td><?php echo asis_h($dia['horario']) ?> hrs.</td>
							<td><?php echo asis_ht($dia) ?></td>
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
