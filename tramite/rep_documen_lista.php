<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_tram_documentos_enviados.php");

$bo_general    = new bo_general();
$bo_documentos = new bo_tram_documentos_enviados();
$ent_documentos = new tram_documentos_enviados();

// Tipos de documento: sirven para validar el filtro y para mostrar el nombre en la lista.
// bo_general->tipo_documento() devuelve nombre = "codigo - descripcion".
$tipos_doc = [];
foreach ($bo_general->tipo_documento('T') as $tipo) {
	$tipos_doc[trim($tipo['c_tipo_de_documento'])] = $tipo['nombre'];
}

$c_tipo_de_documento = trim($_REQUEST["c_tipo_de_documento"] ?? '');
if (!isset($tipos_doc[$c_tipo_de_documento])) {
	$c_tipo_de_documento = ''; // vacío o no reconocido => TODOS
}

$fecha_desde = u_fecha($_REQUEST["fecha_desde"] ?? '') . ' 00:00';
$fecha_hasta = u_fecha($_REQUEST["fecha_hasta"] ?? '') . ' 23:59';

$ent_documentos->setC_local(s_local());
$ent_documentos->setFecha_desde($fecha_desde);
$ent_documentos->setFecha_hasta($fecha_hasta);
$ent_documentos->setC_tipo_de_documento($c_tipo_de_documento);

$data_doc = $bo_documentos->listar($ent_documentos);

// '*' = procesado (documen_index.php); lo demás sigue pendiente de procesar.
// [texto, color, icono]
$estadoMap = [
	'*' => ['PROCESADO', 'success', 'ri-checkbox-circle-line'],
	'A' => ['ANULADO', 'danger', 'ri-close-circle-line'],
];
$estadoDefecto = ['PENDIENTE', 'warning', 'ri-time-line'];

// Resumen superior: total y cantidad por estado
$resumen = [];
foreach ($data_doc as $row) {
	$flag = trim((string)($row['flag'] ?? ''));
	$est  = $estadoMap[$flag] ?? $estadoDefecto;
	if (!isset($resumen[$est[0]])) {
		$resumen[$est[0]] = ['color' => $est[1], 'icono' => $est[2], 'total' => 0];
	}
	$resumen[$est[0]]['total']++;
}
$total_docs = count($data_doc);
?>
<div id="print-section" class="print-section">
	<div class="table-responsive">
		<table class="table table-hover table-sm align-middle table-nowrap mb-0" id="table-reporte">
			<thead class="table-light text-uppercase fs-12">
				<tr>
					<th class="text-center">#</th>
					<th>Fecha</th>
					<th>Tipo Doc.</th>
					<th>Número</th>
					<th>Asunto</th>
					<th>Usuario</th>
					<th class="text-center">Estado</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				<?php foreach ($data_doc as $row): ?>
					<?php
					$cod_tipo = trim((string)($row['c_tipo_de_documento'] ?? ''));
					// Quita el prefijo "codigo - " porque el código ya se muestra aparte
					$nombre_tipo = preg_replace('/^\s*\S+\s-\s/', '', $tipos_doc[$cod_tipo] ?? '');
					$area = trim((string)($row['area'] ?? ''));
					$flag = trim((string)($row['flag'] ?? ''));
					[$estadoTexto, $estadoColor, $estadoIcono] = $estadoMap[$flag] ?? $estadoDefecto;
					$asunto = (string)($row['asunto'] ?? '');
					?>
					<tr data-cc-docenviado="<?= (int)($row['cc_docenviado'] ?? 0) ?>">
						<td class="text-center text-muted"><?= $i++ ?></td>
						<td class="text-muted"><?= htmlspecialchars($row['fecha_text'] ?? '') ?></td>
						<td>
							<div><?= $area !== '' ? htmlspecialchars($area) . ' - ' : '' ?><?= htmlspecialchars($cod_tipo) ?></div>
							<?php if ($nombre_tipo !== ''): ?>
								<div class="text-muted fs-12"><?= htmlspecialchars($nombre_tipo) ?></div>
							<?php endif; ?>
						</td>
						<td class="fw-semibold text-primary"><?= htmlspecialchars((string)digitos($row['num_documento'] ?? 0, 6)) ?></td>
						<td class="text-wrap" title="<?= htmlspecialchars($asunto) ?>"><?= htmlspecialchars($asunto) ?></td>
						<td class="text-uppercase fs-12"><?= htmlspecialchars($row['c_usuario'] ?? '') ?></td>
						<td class="text-center"><span class="badge bg-<?= $estadoColor ?>-subtle text-<?= $estadoColor ?>"><i class="<?= $estadoIcono ?> align-middle me-1"></i><?= $estadoTexto ?></span></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>