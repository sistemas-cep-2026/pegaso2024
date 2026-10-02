<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cap_eventos.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_general = new bo_general();
$bo_eventos = new bo_cap_eventos();
$bo_parametro_det = new bo_gen_parametro_det();

$cc_local = s_local();
$usuario = s_usuario();
$es_admin_general = ($cc_local === '28');

$data_local = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');
$data_anho = $bo_eventos->listarAnhos();
$data_categoria = $bo_parametro_det->listarParametroDet('cap_eventos', 'tipo');
?>
<div class="row">
	<div class="col-xxl-12">
		<div class="card">
			<div class="card-header align-items-center d-flex">
				<div class="flex-grow-1">
					<h4 class="card-title mb-0">Eventos de capacitación</h4>
					<p class="text-muted mb-0 fs-13">Cursos, congresos, diplomados y foros</p>
				</div>
				<a href="?id=<?= s_crypt('410001', 'in') ?>&sec=<?= s_crypt('2', 'in') ?>&opc=<?= s_crypt('I', 'in') ?>" class="btn btn-success add-btn" data-bs-placement="top" title="Nuevo Evento">
					<i class="ri-add-line align-bottom me-1"></i> Nuevo curso
				</a>
			</div>
			<div class="card-body">
				<div id="div_listadoCursos">
					<form class="needs-validation" id="frmBuscarFiltro" action="javascript:fn_listarEventos()" method="post" novalidate>
						<div class="row g-2 align-items-end">
							<div class="col-md-5">
								<label class="form-label text-muted fs-13 mb-1">Buscar</label>
								<input type="text" name="fnombre" id="fnombre" class="form-control" placeholder="Nombre del curso">
							</div>
							<div class="col-md-2">
								<label class="form-label text-muted fs-13 mb-1">Año</label>
								<select name="fanho" id="fanho" class="form-control">
									<option value="">Todos</option>
									<?php foreach ($data_anho as $row): ?>
										<option value="<?= $row['anho'] ?>" <?= $row['anho'] == date("Y") ? 'selected' : '' ?>>
											<?= $row['anho'] ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-md-2">
								<label class="form-label text-muted fs-13 mb-1">Categoría</label>
								<select name="ftipo" id="ftipo" class="form-control">
									<option value="">Todas</option>
									<?php foreach ($data_categoria as $cat): ?>
										<option value="<?= $cat['cc_codigo'] ?>"><?= $cat['detalle'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<?php if ($es_admin_general): ?>
								<div class="col-md-2">
									<label class="form-label text-muted fs-13 mb-1">Consejo</label>
									<select class="form-control" id="fc_local" name="fc_local">
										<option value="">Todos</option>
										<?php foreach ($data_local as $loc): ?>
											<option value="<?= $loc['c_local'] ?>"><?= $loc['nombre'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							<?php else: ?>
								<input type="hidden" id="fc_local" name="fc_local" value="<?= $cc_local ?>">
							<?php endif; ?>
							<div class="col-md-<?= $es_admin_general ? '1' : '3' ?>">
								<?php echo bt_buscar("Buscar") ?>
							</div>
						</div>
					</form>

					<div class="row g-3 mt-2" id="div_listarEventosFiltro"></div>
				</div>

				<div id="div_detalleCurso" class="d-none"></div>
			</div>
		</div>
	</div>
</div>
<?php $include_scripts = function () {
	return importToolTip();
} ?>