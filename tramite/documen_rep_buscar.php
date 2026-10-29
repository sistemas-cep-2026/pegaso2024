<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_general.php");
 
 
$bo_general = new bo_general();
 
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card-body">
			<form class="needs-validation" id="frmListarRegistros" action="javascript:fn_reporte()" method="post" novalidate>
				<div class="mb-1 row justify-content-center align-items-center">
					<div class="col-sm-2">
						<div class="input-group mb-1">
							<span class="input-group-text">F. Desde:</span>
							<input type="date" class="form-control" id="fecha_desde" name="fecha_desde" value="<?= fecha_hoy() ?>">
						</div>
					</div>
					<!-- Fecha hasta -->
					<div class="col-sm-2">
						<div class="input-group mb-1">
							<span class="input-group-text">F. Hasta:</span>
							<input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" value="<?= fecha_hoy() ?>">
						</div>
					</div>
				</div>

			 

				<div class="row mb-2">
					<div class="col-sm-12 text-center">
						<?php echo bt_filtrar(); ?>
						<?php echo bt_cancelar(); ?>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-lg-12 table-responsive">
					<div id="div_ReporLista"></div>
				</div>
			</div>
		</div>
	</div> <!-- end col -->
</div>
<?php $include_scripts = function () {
	return importTypeahead() . importInputMask() . importformmasks() . importDatatable() . importSelect2();
} ?>