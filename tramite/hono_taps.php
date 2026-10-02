<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_tram_honorabilidad.php");


$bo_general = new bo_general();
$bo_honorabilidad = new bo_tram_honorabilidad();

$ent_honorabilidad = new tram_honorabilidad();

$opc = 'I';
if (isset($_REQUEST["opc"])) {
	$opc = s_crypt($_REQUEST["opc"], 'out');
}

$flag = '';
$disabled = '';
$cc_honorab = '';
$nombre_anho = 'Año de la Esperanza y el Fortalecimiento de la Democracia';
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="d-flex align-items-center">
					<div class="avatar-sm flex-shrink-0 me-3">
						<span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
							<i class="ri-award-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<h4 class="card-title mb-0">Registro Documentos de Honorabilidad</h4>
						<p class="text-muted mb-0 fs-13">Constancias de honorabilidad profesional</p>
					</div>
				</div>
			</div>
			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
				<ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#nav-border-top-home" role="tab" aria-selected="false">
							NUEVO REGISTRO
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_listarBuscar();" data-bs-toggle="tab" href="#nav-border-top-profile" role="tab" aria-selected="false">
							LISTAR REGISTROS
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="nav-border-top-home" aria-labelledby="crear_documento-tab" role="tabpanel">

						<form method="post" action="javascript:fn_grabarRegistro();" id="frmGrabarRegistro" novalidate>
							<input type="hidden" name="flag" id="flag" value="<?php echo $flag ?>">
							<div class="row">
								<div class="col-md-12 p-2 ">
									<fieldset <?php echo $disabled; ?>>
										<div class="row">
											<div class="col-lg-11">
												<input type="hidden" class="form-control" id="c_persona" name="c_persona" value="">
												<input type="text" class="form-control mb-3" id="nombre" name="nombre" placeholder="CEP - Apellido y nombres" value="" required>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-7">
												<div class="input-group mb-3">
													<span class="input-group-text bg-light-subtle">Autoridad</span>
													<input type="text" class="form-control" id="autoridad" name="autoridad" placeholder="" value="Dra. S.P. Petronila Elizabeth Alvarado Chávez" required>
												</div>
											</div>
											<div class="col-lg-5">
												<div class="input-group mb-3">
													<span class="input-group-text bg-light-subtle">Fecha texto</span>
													<input type="text" class="form-control" id="fecha_text" name="fecha_text" placeholder="" value="<?php echo "Lima, " . fechatexto(date('d/m/Y')) ?>" required>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-5">
												<div class="input-group mb-3">
													<span class="input-group-text bg-light-subtle">Cargo</span>
													<input type="text" class="form-control" id="cargo" name="cargo" placeholder="Evento" value="Decana Nacional" required>

												</div>
											</div>
											<div class="col-lg-5">
												<div class="input-group mb-3">
													<span class="input-group-text bg-light-subtle">Imagen</span>
													<input type="text" class="form-control" id="img_fondo" name="img_fondo" placeholder="Imagen de fondo" value="img_gestion05.jpg" required>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-9">
												<div class="input-group mb-3">
													<span class="input-group-text bg-light-subtle">Nombre del <?= date('Y') ?></span>
													<input type="text" class="form-control" id="nombre_anho" name="nombre_anho" placeholder="" value="<?= htmlspecialchars($nombre_anho) ?>" required>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-9">
												<div class="input-group mb-3">
													<span class="input-group-text bg-light-subtle">Recaudo BBVA</span>
													<select name="recaudo_id" id="recaudo_id" class="form-control" required>
														<option value="">Selecciona</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 text-center">
												<input type="hidden" name="cc_honorab" value="<?php echo s_crypt($cc_honorab, 'in') ?>">
												<input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
												<?php echo bt_guardar('Guardar'); ?> <?php echo bt_cancelar('Cancelar'); ?>
											</div>
										</div>
									</fieldset>
								</div>
							</div>
						</form>
					</div><!-- end row -->
					<div class="tab-pane" id="nav-border-top-profile" role="tabpanel">
						<div class="d-flex">
							<div class="flex-grow-1 ms-2">
								<div id="div_listar"></div>
							</div>
						</div>
					</div>

				</div><!-- end col -->
			</div><!-- end row -->

		</div>
	</div>
</div>

<?php $include_scripts = function () {
	return importDatatable() . importTypeahead();
} ?>