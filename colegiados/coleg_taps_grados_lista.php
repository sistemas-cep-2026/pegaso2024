<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_personas_especialidad.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_especialidad = new bo_tram_personas_especialidad();
$bo_det = new bo_gen_parametro_det();

$ent_especialidad = new tram_personas_especialidad();

$cc_persona = s_crypt($_REQUEST['cc_persona'], 'out');
$ent_especialidad->setCc_persona($cc_persona);
$data_lista_grados =  $bo_especialidad->listarXPersona($ent_especialidad);

$data_tipos_grados = $bo_det->listarParametroDet('personas', 'tipo_grado');
$arr_tipos_grados = array_values(array_filter($data_tipos_grados, function ($item) {
	return !in_array($item['cc_codigo'], ['C', 'H', 'T']);
}));

$cc_persona = s_crypt($cc_persona);

$arr_users = [
	'ADMIN',
	'CN00103',
	'CN00105',
	'G280028'
];
?>
<div class="card">
	<div class="card-body">
		<div class="d-flex align-items-center mb-4">
			<h5 class="card-title flex-grow-1 mb-0">Grados y Diplomados Profesionales <span class="fs-25">(ID: <?= $ent_especialidad->getCc_persona(); ?>)</span></h5>
			<div class="flex-shrink-0">
				<?php
				if (in_array(trim(s_usuario()), $arr_users)) {
				?>
					<div class="dropdown">
						<button class="btn btn-primary dropdown-toggle caret-off" type="button" id="dropdownMenuGrados" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="ri-add-fill me-1 align-bottom"></i> Nuevo
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenuGrados">
							<?php
							foreach ($arr_tipos_grados as $tipo_especialidad) {
								$icon = in_array($tipo_especialidad['cc_codigo'], ['E', 'M', 'D']) ? 'ri-user-star-fill text-primary fa-lg"' : 'fa-regular fa-id-card text-success fa-lg';
							?>
								<li>
									<a class="dropdown-item" href="#!" onclick="fn_nuevoRegistroGrados({cc_persona:'<?= $cc_persona; ?>', tipo_especialidad:'<?= $tipo_especialidad['cc_codigo']; ?>'})">
										<i class="<?= $icon; ?>"></i> <?= $tipo_especialidad['detalle']; ?>
									</a>
								</li>
							<?php
							}
							?>
						</ul>
					</div>
				<?php
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 table-responsive">
				<?php
				if (empty($data_lista_grados)) {
					echo errors();
				} else {
				?>
					<table class="table table-borderless align-middle mb-0">
						<thead class="table-light">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Grado</th>
								<th scope="col">N° Registro</th>
								<th scope="col">Fecha registro</th>
								<th scope="col">Literal / Mención</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($data_lista_grados as $grados) {
							?>
								<tr>
									<th scope="row"><?= $i; ?></th>
									<td>
										<div class="flex-shrink-0 avatar-xs">
											<div class="avatar-title bg-primary text-white rounded-3 fs-18 shadow-lg" data-bs-toggle="tooltip" data-bs-title="<?= $grados['tipo_nombre_esp']; ?>">
												<?= $grados['tipo_especialidad']; ?>
											</div>
										</div>
									</td>

									<th scope="row"><?= $grados['c_reg_esp']; ?></th>
									<td><?= $grados['fecha']; ?></td>
									<td>
										<h6><?= $grados['literal']; ?></h6>
									</td>
									<td>
										<?php
										if (in_array(trim(s_usuario()), $arr_users)) {
										?>
											<button class="btn btn-sm btn-info"
												onclick="fn_nuevoRegistroGrados({cc_persona:'<?= $cc_persona; ?>', linea:'<?= $grados['linea']; ?>',tipo_especialidad:'<?= $grados['tipo_especialidad']; ?>', opc:'<?= s_crypt('U'); ?>'})">
												<i class="ri-edit-box-line align-bottom fs-6"></i>
											</button>
										<?php
										}
										?>
									</td>
								</tr>
							<?php
								$i++;
							}
							?>

						</tbody>
					</table>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
<?= importToolTip(); // IMPORT TOOLTIP 
?>