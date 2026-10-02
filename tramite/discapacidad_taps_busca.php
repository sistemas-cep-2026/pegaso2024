<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas_discapacidad.php");

$bo_general = new bo_general();
$bo_discapacidad = new bo_gen_personas_discapacidad();
$mes = u_meses();
$data_anho = $bo_discapacidad->listarAnhos();
?>
<div class="row">
	<div class="col-xxl-12">
		<form class="needs-validation" id="frmFormRegistro" action="javascript:fn_listarReporte()" method="post" novalidate>
			<div class="row mb-3 justify-content-center">
				<div class="col-sm-3">
					<input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="NombrDDe" placeholder="Nombre" value="">
				</div>
				<div class="col-sm-2">
					<select name="anho" id="anho" class="form-control" onchange="this.form.submit()">
						<option value="">Año</option>
						<?php foreach ($data_anho as $row) { ?>
							<option value="<?= $row['anho'] ?>" <?= ($row['anho'] == date('Y')) ? 'selected' : '' ?>>
								<?= $row['anho'] ?>
							</option>
						<?php } ?>
					</select>
				</div>
				<div class="col-sm-3">
					<?php echo bt_buscar("Buscar")  ?> <?php bt_cancelar() ?>
				</div>
			</div>
		</form>
		<div class="row mb-3">
			<div class="col-lg-12 table-responsive">
				<div id="divReporte"></div>
			</div>
		</div>
	</div>
</div> <!-- end col -->


<?php $include_scripts = function () {
	return importDatatable() . importTypeahead();
} ?>