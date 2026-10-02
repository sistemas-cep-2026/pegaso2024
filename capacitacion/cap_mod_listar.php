<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cap_eventos_modulo.php");

$bo_capmod = new bo_cap_eventos_modulo();

$ent_capmod = new cap_eventos_modulo();

$cc_evento = $_REQUEST['cc_evento'] ?? '';
$ent_capmod->setCc_evento($cc_evento);

$data = $bo_capmod->listar($ent_capmod);

?>
<div class="d-flex align-items-center justify-content-between mb-3">
	<div>
		<h6 class="mb-0">Módulos registrados</h6>
		<p class="text-muted mb-0 fs-13"><?php echo count($data) ?> módulo<?php echo count($data) != 1 ? 's' : '' ?></p>
	</div>
	<button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal" onclick="fn_control('','<?php echo s_crypt('I', 'in') ?>','<?php echo s_crypt($cc_evento, 'in') ?>')">
		<i class="ri-add-line align-bottom me-1"></i> Nuevo Módulo
	</button>
</div>
<div class="table-responsive">
	<?php if (empty($data)) { ?>
		<div class="text-center text-muted p-4">
			<i class="ri-book-2-line fs-1 d-block mb-2"></i>
			Aún no hay módulos registrados para este evento.
		</div>
	<?php } else { ?>
		<table class="table table-hover align-middle table-sm" id="table-cap-mod">
			<thead class="table-light">
				<tr>
					<th>#</th>
					<th>MÓDULO</th>
					<th class="text-center">ESTADO</th>
					<th class="text-end">OPCIONES</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach ($data as $row) {
				?>
					<tr>
						<td><?php echo $i ?></td>
						<td>
							<i class="ri-book-open-line text-muted me-1"></i>
							<?php echo $row["ct_modulo"] ?>
						</td>
						<td class="text-center">
							<?php if ($row["flag"] == '*') { ?>
								<span class="badge bg-success-subtle text-success">ACTIVO</span>
							<?php } else { ?>
								<span class="badge bg-danger-subtle text-danger">ANULADO</span>
							<?php } ?>
						</td>
						<td class="text-end">
							<button class="btn btn-soft-primary btn-sm"
								onclick="fn_control('<?php echo s_crypt($row['cc_capmod'], 'in') ?>','<?php echo s_crypt('U', 'in') ?>','<?php echo s_crypt($cc_evento, 'in') ?>')">
								<i class='fas fa-edit'></i>
							</button>
						</td>
					</tr>
				<?php $i++;
				} ?>
			</tbody>
		</table>
	<?php } ?>
</div>