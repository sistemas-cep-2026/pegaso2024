<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();

$data_anho = listarAnhos();
$periodo = u_meses();
$cc_local = s_local();
$usuario = s_usuario();
$data_region = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');
 
?>

<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="row align-items-center gy-3">
					<div class="col-sm">
						<h5 class="card-title mb-0">Reporte de compras</h5>
					</div>

				</div>
			</div>
			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
				<form class="needs-validation" id="frmListarRegistros" action="javascript:fn_reporteCompras()" method="post" novalidate>
					<div class="row mb-3 justify-content-center">
						
					<div class="col-sm-3">
							<select name="cc_local" id="cc_local" class="form-control" required onchange="submit()">
								 
								<?php
								foreach ($data_region as $loc) { ?>
									<option value="<?php echo $loc['c_local']; ?>" <?= ($loc['c_local'] === s_local_vinculado()) ? 'selected' : '' ?>><?php echo $loc['nombre']; ?></option>
								<?php } ?>
							</select>
						</div>
					<div class="col-sm-2">
							<select name="anho" id="anho" class="form-control">

								<?php foreach ($data_anho as $row) { ?>
									<option value="<?php echo $row['anho']; ?>" <?php if ($row['anho'] == date("Y")) {
																					echo "selected";
																				} ?>>
										<?php echo $row['anho']; ?>
									</option>
								<?php } ?>
							</select>
						</div>
						<div class="col-sm-2">
							<select name="periodo" id="periodo" class="form-control">
								<?php
								foreach ($periodo as $key => $value) {
								?>
									<option value="<?php echo $key ?>" <?php if ($key == date("m")) {
																			echo "selected";
																		} ?>><?php echo $value ?></option>
								<?php } ?>
							</select>
						</div>
						

						<div class="col-sm-3">
							<!-- Botones de Buscar y Cancelar -->
							<?php echo bt_filtrar() ?>
							<?php echo bt_cancelar() ?>
						</div>
					</div>
				</form>
			</div>
			<!--<div class="card-body pt-2">
				<div id="divReporCompras"></div>
			</div>
        -->
			<div class="col-xxl-12">
				<div class="card-body">
					<div id="divReporCompras"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $include_scripts = function () {
	return importformmasks() . importDatatable();
} ?>