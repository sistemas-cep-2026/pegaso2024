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
 						<h5 class="card-title mb-0">Lista de Colegiados</h5>
 					</div>
 				</div>
 			</div>
 			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
 				<form method="post" action="javascript:fn_buscarRegistro();" id="frmBuscarRegistro">
 					<div class="row g-3 justify-content-center">
 						<div class="col-xxl-5 col-sm-6">
 							<div class="search-box">
 								<input type="text" class="form-control search" name="varbuscar" id="varbuscar"
 									placeholder="Buscar por CEP o Apellidos" autofocus>
 								<i class="ri-search-line search-icon"></i>
 							</div>
 						</div>
 						<div class="col-xxl-3 col-sm-3">
 							<?php echo bt_cancelar('Limpiar', 'onclick="fn_buscarRegistro()"'); ?>
 						</div>
 						<!--end col-->
 					</div>
 					<!--end row-->
 				</form>
 			</div>
 			<div class="card-body pt-2">
 				<div id="divListarRegistros"><?= cargador(); ?></div>
 			</div>
 		</div>
 	</div>
 </div>
 <?php $include_scripts = fn() => importDatatable() . importTypeahead(); ?>