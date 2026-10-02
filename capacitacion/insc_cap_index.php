<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cap_eventos.php");

$bo_general = new bo_general();
$bo_eventos = new bo_cap_eventos();

$cc_local = s_local();
$usuario = s_usuario();

$data_local = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');
$data_anho = $bo_eventos->listarAnhos();
?>
<div class="row">
	<div class="col-xxl-12">
		<div class="card">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">LISTAR INSCRIPCIONES A EVENTOS</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-xxl-12">
						<form class="needs-validation" id="frmBuscarParticipantes" action="javascript:fn_reporteParticipantes()" method="post" novalidate>
							<div class="row mb-3 justify-content-center">
								<div class="col-sm-2">
									<select name="anho" id="anho" class="form-control" onchange="cargarEventos()" required>
										<option value="">Año</option>
										<?php foreach ($data_anho as $row) { ?>
											<option value="<?php echo $row['anho'] ?>" <?php if ($row['anho'] == date("Y")) {
																							echo "selected";
																						} ?>>
												<?php echo $row['anho'] ?>
											</option>
										<?php } ?>
									</select>
								</div>
								<div class="col-sm-3">
									<select class="form-control" id="c_local" name="c_local" onchange="cargarEventos()">
										<option value="">Selecciona...</option>
										<?php foreach ($data_local as $loc): ?>
											<option value="<?= $loc['c_local'] ?>" <?= $loc['c_local'] == s_local() ? 'selected' : '' ?>>
												<?= $loc['nombre'] ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-sm-7">
									<select class="form-control select2" id="cc_evento" name="cc_evento" required>
									</select>
								</div>

							</div>
							<div class="row text-center">
								<div class="col-sm-12">
									<?php echo bt_buscar("Buscar") ?> <?php bt_cancelar() ?>
								</div>
							</div>

						</form>
						<div class="row mb-3">
							<div class="col-lg-12 table-responsive">
								<div id="divReporParticipantes"></div>
							</div>
						</div>
					</div>
				</div>

			</div><!-- end row -->
		</div>
	</div>
</div>


<?php $include_scripts = function () {
	return importDatatable() . importToolTip() . importTypeahead() . importSelect2();
} ?>