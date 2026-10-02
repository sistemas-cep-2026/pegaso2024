<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
require_once(u_src() . "bo/bo_tram_seguimiento_documentos_recibid.php");
require_once(u_src() . "bo/bo_general.php");
$bo_doc_recibidos = new bo_tram_documentos_recibidos();
$bo_doc_recibidos_det = new bo_tram_seguimiento_documentos_recibid();

$ent_doc_recibidos = new tram_documentos_recibidos();
$ent_doc_recibidos_det = new tram_seguimiento_documentos_recibid();
$bo_general = new bo_general();

$cc_docrecibidos = s_crypt($_REQUEST['cod'] ?? '', 'out');

$ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);

$expediente = '';
$cc_local = '';
$remitente = '';
$cmp_remitente = '';
$tipo_doc = '';
$numero = '';
$fecha_documento = '';
$asunto = '';
$fecha_ingreso = '';
$c_local_origen_text = '';
$usuario = '';
$tipo_persona_text = '';

$data_doc_recibidos = $bo_doc_recibidos->listarId($ent_doc_recibidos);
foreach ($data_doc_recibidos as $row) {
	$expediente = $row['c_expediente'] ?? '';
	$cc_local = $row['c_local'] ?? '';
	$remitente = $row['nombre_remitente'] ?? '';
	$cmp_remitente = $row['cmp_remitente'] ?? '';
	$tipo_doc = $row['c_tipo_de_documento'] ?? '';
	$numero = $row['num_documento'] ?? '';
	$fecha_documento = $row['fecha_documento_text'] ?? '';
	$asunto = $row['asunto'] ?? '';
	$fecha_ingreso = $row['fecha_ingreso'] ?? '';
	$c_local_origen_text = $row['c_local_origen_text'] ?? '';
	$usuario = $row['c_usuario'] ?? '';
	$tipo_persona_text = $row['tipo_persona_text'] ?? '';
}
$ent_doc_recibidos_det->setCc_docrecibidos($cc_docrecibidos);
$data_detalle = $bo_doc_recibidos_det->listaIDExp($ent_doc_recibidos_det);

$cc_local_text = '';
$correo = '';
$telefono = '';
$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'] ?? '';
	$correo = $loc['local_mail'] ?? '';
	$telefono = $loc['local_tel'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hoja de Trámite - <?php echo htmlspecialchars($expediente); ?></title>
	<link rel="icon" href="<?php echo url('images/logo_print.jpg') ?>" type="image/png">
	<link rel="stylesheet" type="text/css" href="<?php echo url('css/print.css'); ?>">
	<script>
		window.onafterprint = function() {
			window.close();
		};
	</script>
</head>

<body class="bg-dark my-2 print-top-compact" onload="window.print();">
	<div class="page bg-white">
		<div class="p-2">
			<table class="table table-borderless table-sm mb-1 align-middle">
				<tr>
					<td class="col-2 text-center">
						<img src="<?php echo url('images/logo_print.jpg'); ?>" width="70" alt="Reimprimir"
							title="Clic para volver a imprimir" style="cursor:pointer;" onclick="window.print();">
					</td>
					<td class="col-6 text-center">
						<h4 class="mb-0 fw-bold">HOJA DE TRAMITE</h4>
						<div class="fw-bold fs-12"><?php echo htmlspecialchars($cc_local_text); ?></div>
					</td>
					<td class="col-4 text-end">
						<span class="fs-4 fw-bold">EXP: <?php echo htmlspecialchars($expediente); ?></span>
					</td>
				</tr>
			</table>

			<table class="table table-borderless table-sm mb-1">
				<tr>
					<td class="col-8 fs-13">
						<span class="fw-bold">REMITE:</span>
						(<?php echo htmlspecialchars($tipo_persona_text); ?>) <?php echo htmlspecialchars($remitente); ?><?php echo $cmp_remitente ? ' ' . htmlspecialchars($cmp_remitente) : ''; ?><br>
						<span class="fw-bold">DOC.:</span>
						<?php echo htmlspecialchars($tipo_doc . '-' . $numero . ' (' . $fecha_documento . ')'); ?><br>
						<span class="fw-bold">ASUNTO:</span> <?php echo htmlspecialchars($asunto); ?>
					</td>
					<td class="col-4 fs-13">
						<span class="fw-bold">REGISTRO:</span> <?php echo htmlspecialchars($fecha_ingreso); ?><br>
						<span class="fw-bold">ORIGEN:</span> <?php echo htmlspecialchars($c_local_origen_text); ?>
					</td>
				</tr>
			</table>

			<table class="table table-bordered border-dark table-sm mb-2 fs-12">
				<thead>
					<tr>
						<th class="col-2 p-1">FECHA</th>
						<th class="col-4 p-1">ACCION</th>
						<th class="col-4 p-1">DESTINO</th>
						<th class="col-2 p-1">FIRMA</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1;
					foreach ($data_detalle as $det): ?>
						<tr>
							<td class="p-1">(<?php echo $i; ?>) - <?php echo htmlspecialchars($det['fecha_entrega_text'] ?? ''); ?></td>
							<td class="p-1"><?php echo htmlspecialchars($det['c_accion_text'] ?? ''); ?></td>
							<td class="p-1"><?php echo htmlspecialchars($det['c_area_adm_text'] ?? ''); ?></td>
							<td class="p-1"></td>
						</tr>
					<?php $i++;
					endforeach; ?>
					<tr>
						<td class="py-1"></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td class="py-1"></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<div class="border-top pt-1 mb-1 fs-12">
				<span class="fw-bold">Obs:</span>
				<div class="text-end mt-1"><?php echo htmlspecialchars($fecha_ingreso . ' (' . $usuario . ')'); ?></div>
			</div>
			<div class="text-center text-muted fs-12 my-2">✂- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</div>
			<div>
				<div class="fw-bold fs-12 mb-1">
					CONSTANCIA DE RECEPCIÓN
				</div>

				<table class="table table-borderless mb-0">
					<tr>
						<td class="col-2 text-center">
							<img src="<?php echo url('images/logo_print.jpg'); ?>" width="60" alt="Logo">
						</td>
						<td class="col-6 fs-12">
							<span class="fw-bold fs-12">
								<?php echo htmlspecialchars($cc_local_text); ?>
							</span>
							<br>
							<span class="fw-bold">Remite:</span>
							(<?php echo htmlspecialchars($tipo_persona_text); ?>)
							<?php echo htmlspecialchars($remitente); ?>
							<?php echo $cmp_remitente ? ' ' . htmlspecialchars($cmp_remitente) : ''; ?>
							<br>
							<span class="fw-bold">Asunto:</span>
							<?php echo htmlspecialchars($asunto); ?>
						</td>
						<td class="col-4 text-end">
							<div class="fs-6 fw-bold">
								EXP: <?php echo htmlspecialchars($expediente); ?>
							</div>
							<div class="mt-1">
								<span class="fw-bold">Registro:</span>
								<?php echo htmlspecialchars($fecha_ingreso); ?>
							</div>
						</td>
					</tr>
				</table>
				<div class="fs-12 mb-2">
					<span>
						Tel.: <?php echo htmlspecialchars($telefono); ?> </span>&nbsp;&nbsp;
					<span> Web: <a href="https://www.cep.org.pe" target="_blank"> https://www.cep.org.pe </a>
					</span>
					&nbsp;&nbsp;
					<span>
						Correo: <?php echo htmlspecialchars($correo); ?>
					</span>
				</div>
			</div>
		</div>
	</div>
</body>

</html>