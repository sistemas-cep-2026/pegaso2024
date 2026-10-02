<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_doc_recibidos = new bo_tram_documentos_recibidos();

$ent_doc_recibidos = new tram_documentos_recibidos();

$fecha_desde = u_fecha($_REQUEST["fecha_desde"] ?? '') . ' 01:00';
$fecha_hasta = u_fecha($_REQUEST["fecha_hasta"] ?? '') . ' 23:59';
$nombre_remitente = $_REQUEST["nombre_remitente"] ?? '';
$num_desde = $_REQUEST["num_desde"];
$num_hasta = $_REQUEST["num_hasta"];

$ent_doc_recibidos->setC_local(s_local());
$ent_doc_recibidos->setFecha_desde($fecha_desde);
$ent_doc_recibidos->setFecha_hasta($fecha_hasta);
$ent_doc_recibidos->setNombre_remitente($nombre_remitente);
$ent_doc_recibidos->setNum_desde($num_desde);
$ent_doc_recibidos->setNum_hasta($num_hasta);

$data_doc = $bo_doc_recibidos->listar($ent_doc_recibidos);
$color_flag = [
	'A' => 'success',
	'P' => 'info',
];
?>
<div id="print-section" class="print-section">
	<div class="table-responsive">
		<table class="table table-striped table-hover table-sm align-middle" id="table-expedientes">
			<thead>
				<tr class="table-light">
					<th>#</th>
					<th>Fecha</th>
					<th>Expediente</th>
					<th>Nombre</th>
					<th>Número</th>
					<th>Fec. Doc.</th>
					<th>Asunto</th>
					<th>Usuario</th>
					<th>Estado</th>
					<th class="text-center">Opciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach ($data_doc as $row) {
					$color = $color_flag[$row["flag"]] ?? 'secondary';
				?>
					<tr data-cc-docrecibidos="<?php echo (int) $row['cc_docrecibidos']; ?>">
						<td><?php echo $i ?></td>
						<td><?php echo htmlspecialchars($row['fecha_ingreso']) ?></td>
						<td class="fw-semibold"><?php echo htmlspecialchars($row['c_expediente']) ?></td>
						<td><?php echo htmlspecialchars($row['nombre_remitente'] ?? ''); ?></td>
						<td><?php echo htmlspecialchars($row['num_documento']) ?></td>
						<td><?php echo htmlspecialchars($row['fecha_documento_text']) ?></td>
						<td><?php echo htmlspecialchars($row['asunto']) ?></td>
						<td><?php echo htmlspecialchars($row['c_usuario']) ?></td>
						<td><span class="badge bg-<?php echo $color; ?>-subtle text-<?php echo $color; ?>"><?php echo htmlspecialchars($row["flag_text"]); ?></span></td>
						<td>
							<div class="d-flex gap-1 justify-content-center">
								<a href="javascript:void(0);" onclick="fn_verSeguimientoExp('<?php echo s_crypt($row['cc_docrecibidos']); ?>');"
									class="btn btn-soft-primary btn-sm waves-effect waves-light"
									data-bs-toggle="tooltip" data-bs-placement="top" title="Ver seguimiento" aria-label="Ver seguimiento">
									<i class="ri-eye-line"></i>
								</a>
								<a href="javascript:void(0);" onclick="redireccionar_ventana('<?php echo url('tramite/exp_print?cod=' . s_crypt($row['cc_docrecibidos'])); ?>',750);"
									class="btn btn-soft-secondary btn-sm waves-effect waves-light"
									data-bs-toggle="tooltip" data-bs-placement="top" title="Imprimir" aria-label="Imprimir">
									<i class="ri-printer-line"></i>
								</a>
							</div>
						</td>

					</tr>
				<?php $i++;
				} ?>
			</tbody>
		</table>
		<?php if ($num_desde  !== '') { ?>
			<div class="flex-grow-1 ms-2 text-center">
				<a href="#"
					class="btn btn-outline-primary"
					title="Imprimir"
					onclick="redireccionar_ventana('<?php echo url('tramite/exp_rep_print.php?cod=' . s_crypt($num_desde)); ?>', 750); return false;">
					<i class="ri-printer-line me-1"></i> Imprimir
				</a>
			</div>
		<?php } ?>

	</div>
</div>