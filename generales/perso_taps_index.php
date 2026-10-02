<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_general.php");

s_validar_pagina();
$cc_local = s_local();
$usuario = s_usuario();
$bo_general = new bo_general();
?>
<div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
	<i class="ri-error-warning-line me-3 align-middle fs-16"></i>
	<strong>¡ATENCIÓN!</strong><br>
	SI ES COLEGIADO (TIENE CEP), AGREGAR EL RUC O MODIFICAR EN MATRICULA.<br>
	ANTES DE CREAR PROVEEDOR, EFECTÚE LAS BÚSQUEDAS PERTINENTES, EVITE DUPLICIDADES.<br>
	CASO DESEE RECTIFICAR RUC O RAZÓN SOCIAL, ENVIAR CORREO A
	<a href="mailto:SISTEMAS@CEP.ORG.PE" class="alert-link">SISTEMAS@CEP.ORG.PE</a>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="row align-items-center gy-3">
					<div class="col-sm">
						<h5 class="card-title mb-0">Lista de Proveedores</h5>
					</div>
					<div class="col-sm-auto">
						<div class="d-flex gap-1 flex-wrap">
							<button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal" onclick="fn_control('','<?php echo s_crypt('I', 'in') ?>')"><i class="ri-add-line align-bottom me-1"></i> Nuevo Proveedor</button>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
				<form method="post" action="javascript:fn_buscar();" id="frmBuscar">
					<div class="row g-3 justify-content-center">
						<div class="col-xxl-3 col-sm-6">
							<div class="search-box">
								<input type="text" class="form-control search" name="_razon" id="_razon" placeholder="Razon">
								<i class="ri-search-line search-icon"></i>
							</div>
						</div>
						<!--end col-->
						<div class="col-xxl-2 col-sm-3">
							<input type="text" class="form-control" name="_ruc" id="_ruc" placeholder="Ruc">
						</div>
						<div class="col-xxl-2 col-sm-3">
							<input type="text" class="form-control" name="_num_documento" id="_num_documento" placeholder="DNI">
						</div>


						<div class="col-xxl-2 col-sm-2">
							<?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
						</div>
						<!--end col-->
					</div>
					<!--end row-->
				</form>
			</div>
			<div class="card-body pt-2">
				<div id="divListar"></div>
			</div>
		</div>
	</div>
</div>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const razonInput = document.getElementById('razon');
		const rucInput = document.getElementById('ruc');
		const dniInput = document.getElementById('num_documento');

		// Cuando se tipea en razón, limpiar RUC
		razonInput.addEventListener('input', function() {
			if (this.value.trim() !== '') {
				rucInput.value = '';
				dniInput.value = '';
			}
		});

		// Cuando se tipea en RUC, limpiar razón
		rucInput.addEventListener('input', function() {
			if (this.value.trim() !== '') {
				razonInput.value = '';
				dniInput.value = '';
			}
		});

		dniInput.addEventListener('input', function() {
			if (this.value.trim() !== '') {
				razonInput.value = '';
				rucInput.value = '';
			}
		});

	});
</script>
<?php $include_scripts = function () {
	return importDatatable() . importTypeahead();
} ?>