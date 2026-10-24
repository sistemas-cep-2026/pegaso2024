<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_cont_asistencia.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");

$bo_asistencia = new bo_cont_asistencia();
$bo_usuario = new bo_seg_usuarios();


$ent_usuario = new seg_usuarios();

$data_anho = $bo_asistencia->listarAnhos();
$mes = u_meses();
$cc_usuario = s_usuario();
$cc_local = s_local();
$ent_usuario->setCc_local($cc_local);
$data_usuer = $bo_usuario->ListarUsuarios($ent_usuario)

?>

<div class="col-lg-12">
	<div class="card">
		<div class="card-header align-items-center d-flex">
			<h4 class="card-title mb-0 flex-grow-1">REGISTRO DE ASISTENCIA</h4>
		</div><!-- end card header -->
		<div class="card-body">
			<div class="live-preview">
				<div class="row justify-content-center text-center">
					<form class="needs-validation" id="frmBuscarRegistro" action="javascript:fn_buscarRegistro()" method="post" novalidate>
						<div class="mb-1 row justify-content-center align-items-center">
							<div class="col-sm-2">
								<select name="anho" id="anho" class="form-control" onchange="submit()" required>
									<option value="">Año</option>
									<?php
									foreach ($data_anho as $row) {
									?>
										<option value="<?php echo $row['anho'] ?>" <?php if ($row['anho'] == date("Y")) {
																						echo "selected";
																					} ?>><?php echo $row['anho'] ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-2">
								<select name="periodo" id="periodo" class="form-control" onchange="submit()" required>
									<option value="">Periodo</option>
									<?php
									foreach ($mes as $key => $value) {
									?>
										<option value="<?php echo $key ?>" <?php if ($key == date("m")) {
																				echo "selected";
																			} ?>><?php echo $value ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3">
								<select name="cc_persona" id="cc_persona" class="form-control" onchange="submit()">
									<option value="T">*TODOS*</option>
									<?php
									foreach ($data_usuer as $user) {
									?>
										<option value="<?php echo $user["c_persona"] ?>"><?php echo $user["nombre"] ?></option>
									<?php } ?>
								</select>
							</div>
							<?php if (s_nivel() === 'A') { ?>
								<div class="col-sm-2">
									<div class="form-check form-switch form-switch-lg" dir="ltr">
										<input
											type="checkbox"
											class="form-check-input"
											id="vista"
											name="estado"
											value="V"
											onchange="this.form.submit();">
										<label class="form-check-label" for="vista">Recuadre</label>
									</div>
								</div>
							<?php } ?>
							<div class="col-sm-3 text-start">
								<?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
							</div>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="card-body pt-2">
						<div id="divReporAsistencia"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $include_scripts = function () {
	return importDatatable() . importTypeahead();
} ?>