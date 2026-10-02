<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>

<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="row align-items-center gy-3">
					<div class="col-sm">
						<h5 class="card-title mb-0">Fraccionamiento</h5>
					</div>
					<!--<div class="col-sm-auto">
 						<div class="d-flex gap-1 flex-wrap">
 							<button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Create Order</button>
 						</div>
 					</div>-->
				</div>
			</div>
			<div class="card-body border border-dashed border-end-0 border-start-0">
				<form method="post" action="javascript:fn_buscarRegistro();" id="frmFormRegistro" novalidate>
					<div class="row g-3 justify-content-center">
						<div class="col-xxl-5 col-sm-6">
							<div class="search-box">
								<input type="hidden" class="form-control" name="c_persona" value="">
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="CEP - Apellidos y nombres" value="" required>
								<i class="ri-search-line search-icon"></i>
							</div>
						</div>
						<div class="col-xxl-3 col-sm-6">
							<?php echo bt_filtrar("Buscar") ?>
							<button class="btn btn-outline-warning waves-effect" onclick="location.reload();">
								<i class="fas fa-ban"></i>
								<span>Cancelar</span>
							</button>
						</div>
						<!--end col-->
					</div>
					<!--end row-->
				</form>
			</div>
			<div class="col-xxl-12">
				<div class="card-body">
					<div id="div_fracc_index"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $include_scripts = function () {
	return importDatatable() . importTypeahead();
} ?>