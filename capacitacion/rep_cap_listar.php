<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cap_eventos_matricula.php");

$bo_general = new bo_general();
$bo_eventos_det = new bo_cap_eventos_matricula();

$ent_eventos_det = new cap_eventos_matricula();

$cc_evento = $_REQUEST['cc_evento'] ?? null;
$ent_eventos_det->setCc_evento($cc_evento);

$data_parti = $bo_eventos_det->listarParticipante($ent_eventos_det);

// categorías: enfermero = colegiado (tiene c_cmp), no enfermero = sin c_cmp
// "Total participantes" solo cuenta a quienes tienen el flag asistente activo
// (una fila puede ser solo ponente y/o solo organizador, sin ser asistente)
$participantes_asistentes = array_filter($data_parti, function ($row) {
	return $row['asistente'] == 1;
});
$total = count($participantes_asistentes);
$enfermeros = 0;
foreach ($participantes_asistentes as $row) {
	if (!empty($row['c_cmp'])) $enfermeros++;
}
$no_enfermeros = $total - $enfermeros;

$ponentes = 0;
$organizadores = 0;
foreach ($data_parti as $row) {
	if ($row['ponente'] == 1) $ponentes++;
	if ($row['organizador'] == 1) $organizadores++;
}
?>
<div class="row">
	<div class="col-xl-8">
		<div class="table-responsive" style="max-height: 560px; overflow-y: auto;">
			<form action="javascript:;" id="frm_listaParticipantes" novalidate>
				<table class="table table-hover table-nowrap" id="table_listaParticipantes">
					<thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
						<tr>
							<th scope="col"># </th>
							<th scope="col">CEP</th>
							<th scope="col">DNI</th>
							<th scope="col">NOMBRE</th>
							<th scope="col" class="text-center">ASISTENTE</th>
							<th scope="col" class="text-center">PONENTE</th>
							<th scope="col" class="text-center">ORGANIZADOR</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($data_parti as $row) { ?>
							<tr id="row<?php echo s_crypt($i); ?>">
								<td><?php echo $i ?></td>
								<td><?php echo $row['c_cmp']; ?></td>
								<td><?php echo $row['num_documento']; ?></td>
								<td><?php echo $row['nombre_completo']; ?></td>
								<td class="text-center">

									<?php if ($row["asistente"] == 1): ?>
										<a title="Descargar Asistente" data-bs-toggle="tooltip" href="<?php echo $row['print_documento']; ?>?id=<?= s_crypt_public($row['cc_evento'], 'in') ?>&cod=<?= s_crypt_public($row['c_persona'], 'in') ?>&tipo=<?= s_crypt_public('A', 'in') ?>&cc_mat=<?= s_crypt_public($row['cc_evento_mat'], 'in') ?>"
											target="_blank"><i class="fas fa-cloud-download-alt"></i> Descargar</a>
									<?php endif; ?>
								</td>
								<td class="text-center">

									<?php if ($row["ponente"] == 1): ?>
										<a title="Descargar Ponente" data-bs-toggle="tooltip" href="<?php echo $row['print_documento']; ?>?id=<?= s_crypt_public($row['cc_evento'], 'in') ?>&cod=<?= s_crypt_public($row['c_persona'], 'in') ?>&tipo=<?= s_crypt_public('P', 'in') ?>&cc_mat=<?= s_crypt_public($row['cc_evento_mat'], 'in') ?>"
											target="_blank"><i class="fas fa-cloud-download-alt"></i> Descargar</a>
									<?php endif; ?>
								</td>
								<td class="text-center">

									<?php if ($row["organizador"] == 1): ?>
										<a title="Descargar organizador(a)" data-bs-toggle="tooltip" href="<?php echo $row['print_documento']; ?>?id=<?= s_crypt_public($row['cc_evento'], 'in') ?>&cod=<?= s_crypt_public($row['c_persona'], 'in') ?>&tipo=<?= s_crypt_public('C', 'in') ?>&cc_mat=<?= s_crypt_public($row['cc_evento_mat'], 'in') ?>"
											target="_blank"><i class="fas fa-cloud-download-alt"></i> Descargar</a>
									<?php endif; ?>
								</td>
							</tr>
						<?php $i++;
						} ?>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	<div class="col-xl-4">
		<div class="card border">
			<div class="card-body">
				<h6 class="text-muted text-uppercase fw-semibold mb-3">Categorías</h6>

				<div class="d-flex align-items-center mb-3">
					<div class="avatar-xs flex-shrink-0 me-3">
						<span class="avatar-title bg-light text-primary rounded-circle fs-16">
							<i class="ri-group-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<p class="text-muted mb-0">Total participantes</p>
						<h5 class="mb-0"><?php echo $total ?></h5>
					</div>
				</div>

				<div class="d-flex align-items-center mb-3">
					<div class="avatar-xs flex-shrink-0 me-3">
						<span class="avatar-title bg-success-subtle text-success rounded-circle fs-16">
							<i class="ri-user-heart-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<p class="text-muted mb-0">Enfermeros (colegiados)</p>
						<h5 class="mb-0"><?php echo $enfermeros ?></h5>
					</div>
				</div>

				<div class="d-flex align-items-center mb-3">
					<div class="avatar-xs flex-shrink-0 me-3">
						<span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-16">
							<i class="ri-user-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<p class="text-muted mb-0">No enfermeros</p>
						<h5 class="mb-0"><?php echo $no_enfermeros ?></h5>
					</div>
				</div>

				<div class="d-flex align-items-center mb-3">
					<div class="avatar-xs flex-shrink-0 me-3">
						<span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
							<i class="ri-mic-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<p class="text-muted mb-0">Ponentes</p>
						<h5 class="mb-0"><?php echo $ponentes ?></h5>
					</div>
				</div>

				<div class="d-flex align-items-center">
					<div class="avatar-xs flex-shrink-0 me-3">
						<span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-16">
							<i class="ri-team-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<p class="text-muted mb-0">Organizador</p>
						<h5 class="mb-0"><?php echo $organizadores ?></h5>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
