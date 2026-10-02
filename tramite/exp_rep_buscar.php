<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_general.php");
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_doc_recibidos = new bo_tram_documentos_recibidos();
$bo_general = new bo_general();

$ent_doc_recibidos = new tram_documentos_recibidos();
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card-body">
			<form class="needs-validation" id="frmListarRegistrosExp" action="javascript:fn_reporteExp()" method="post" novalidate>
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

				<div class="mb-1 row justify-content-center align-items-center">
					<div class="col-sm-3">
						<div class="input-group mb-1">
							<span class="input-group-text">Nombre:</span>
							<input type="text" class="form-control" id="nombre_remitente" name="nombre_remitente" placeholder="Nombre del remitente" value="">
						</div>
					</div>

					<!-- Expediente desde -->
					<div class="col-sm-2">
						<div class="input-group mb-1">
							<span class="input-group-text">Exp. Desde:</span>
							<input type="text" class="form-control" id="num_desde" name="num_desde" placeholder="# expediente" inputmode="numeric" value="">
						</div>
					</div>

					<!-- Expediente hasta -->
					<div class="col-sm-3">
						<div class="input-group mb-1">
							<span class="input-group-text">Exp. Hasta:</span>
							<input type="text" class="form-control" id="num_hasta" name="num_hasta" placeholder="# expediente" inputmode="numeric" value="">
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