 <?php
	require_once(dirname(__DIR__) . "/util/seguridad.php");
	require_once(dirname(__DIR__) . "/util/util.php");
	require_once(u_src() . "bo/bo_general.php");
	require_once(u_src() . "bo/bo_gen_parametro_det.php");
	s_validar_pagina();
	$cc_local = s_local();
	$usuario = s_usuario();
	$bo_general = new bo_general();
	$bo_gen_parametro_det = new bo_gen_parametro_det();

	$data_estado = $bo_gen_parametro_det->listarParametroDet('seg_usuarios', 'flag');

	$data_local = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');
	?>
 <div class="row">
 	<div class="col-lg-12">
 		<div class="card" id="orderList">
 			<div class="card-header border-0">
 				<div class="row align-items-center gy-3">
 					<div class="col-sm">
 						<h5 class="card-title mb-0">Lista de Usuarios</h5>
 					</div>
 					<div class="col-sm-auto">
 						<div class="d-flex gap-1 flex-wrap">
 							<button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal" onclick="fn_control('','<?php echo s_crypt('I', 'in') ?>')"><i class="ri-add-line align-bottom me-1"></i> Crear usuario</button>
 						</div>
 					</div>
 				</div>
 			</div>
 			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
 				<form method="post" action="javascript:fn_buscarUsuarios();" id="frmBuscarUsuarios">
 					<div class="row g-3 justify-content-center">
 						<div class="col-xxl-3 col-sm-6">
 							<div class="search-box">
 								<input type="text" class="form-control search" name="nombres" id="nombres" placeholder="Buscar por nombres y apellidos">
 								<i class="ri-search-line search-icon"></i>
 							</div>
 						</div>
 						<!--end col-->
 						<div class="col-xxl-2 col-sm-6">
 							<input type="text" class="form-control" name="usuario" id="usuario" placeholder="Usuario">
 						</div>
 						<div class="col-xxl-3 col-sm-6">
 							<select class="form-control" id="cc_local" name="cc_local" onchange="submit()">
 								<option value="">Selecciona...</option>
 								<?php foreach ($data_local as $loc): ?>
 									<option value="<?= $loc['c_local'] ?>" <?= ($loc['c_local'] == s_local() && s_local() !== '28') ? 'selected' : '' ?>>
 										<?= $loc['nombre'] ?>
 									</option>
 								<?php endforeach; ?>
 							</select>
 						</div>
 						<!--end col-->
 						<div class="col-xxl-2 col-sm-4">
 							<select name="flag" id="flag" class="form-control" onchange="submit()">
 								<option value="">Seleccione...</option>
 								<?php
									foreach ($data_estado as $act) { ?>
 									<option value="<?php echo $act['cc_codigo']; ?>" <?php echo ($act['cc_codigo'] == 'A') ? 'selected' : ''; ?>>
 										<?php echo $act['detalle']; ?>
 									</option>
 								<?php } ?>
 							</select>
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
 				<div id="divListarUsuarios"></div>
 			</div>
 		</div>
 	</div>
 </div>
 <?php $include_scripts = function () {
		return importDatatable() . importTypeahead() . importToolTip();
	} ?>