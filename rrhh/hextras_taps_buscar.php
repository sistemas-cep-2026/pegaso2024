<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_actividad_sustento.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_actividad = new bo_tram_actividad_sustento();

$ent_actividad = new tram_actividad_sustento();

$data_anho = $bo_actividad->listarAnhos();
$mes = u_meses();
$data_flag = $bo_parametro_detalle->listarParametroDet("tram_actividad_sustento", "flag");
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card-body">
			<form class="needs-validation" id="frmFormRegistroMensual" action="javascript:fn_reporteMensual()" method="post" novalidate>
				<div class="mb-1 row justify-content-center align-items-center">
					<div class="col-sm-2">
						<select name="anho" id="anho" class="form-control" onchange="submit()">
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
						<select name="periodo" id="periodo" class="form-control" onchange="submit()">
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
					<div class="col-sm-2">
						<select name="flag" id="flag" class="form-control" onchange="submit()">
							<?php
							foreach ($data_flag as $fl) { ?>
								<option value="<?php echo $fl['cc_codigo'] ?>"><?php echo $fl['detalle']  ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="col-sm-3 text-start">
						<?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
					</div>
				</div>
			</form>
			<div class="row mb-3">
				<div class="col-lg-12 table-responsive">
					<div id="divReportemensual"></div>
				</div>
			</div>
		</div>
	</div> <!-- end col -->
</div>