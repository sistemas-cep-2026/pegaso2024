<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_tram_honorabilidad.php");
$desde = date('Y-m-01');
$hasta = date('Y-m-d');
$bo_general = new bo_general();
$bo_honorabilidad = new bo_tram_honorabilidad();
$mes = u_meses();
$data_anho = $bo_honorabilidad->listarAnhos();
?>
<div class="row">
	<div class="col-xxl-12">
		<form id="frmFormRegistroArticulo" action="almacen/rep_kardex_art_listar.php" method="post" target="divReporteArticulo">

			<div class="row justify-content-center">

				<div class="col-sm-2">
					<div class="input-group mb-3">
						<span class="input-group-text">Desde : </span>
						<input type="date" class="form-control" id="desde" name="desde" placeholder="Desde" value="<?php echo $desde ?>">
					</div>
				</div>
				<div class="col-sm-2">
					<div class="input-group mb-3">
						<span class="input-group-text">Hasta : </span>
						<input type="date" class="form-control" id="hasta" name="hasta" placeholder="Hasta" value="<?php echo $hasta ?>">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="input-group mb-1">
						<input type="hidden" class="form-control" id="c_articulo" name="c_articulo">
						<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre artículo">
					</div>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-sm-12 text-center">
					<?php echo bt_buscar("Buscar")  ?> <?php bt_cancelar("Cancelar") ?>

				</div>
			</div>
		</form>
		<div class="row mb-3">
			<div class="col-lg-12 table-responsive">
				<div class="text-center spinner-content d-none" aria-live="polite">
					<div class="spinner-border" role="status">
						<span class="sr-only">Cargando...</span>
					</div>
				</div>
				<iframe name="divReporteArticulo" loading="lazy" class="iframe-loader d-none" id="divReporteArticulo" style="width: 100%; height: 600px; border: none;" onload="cargadorReportes()"></iframe>
			</div>
		</div>

	</div>
</div> <!-- end col -->