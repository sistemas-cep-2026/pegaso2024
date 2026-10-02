<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
//require_once(u_src() . "bo/bo_fin_recaudobbva.php");
//require_once(u_src() . "bo/bo_recaud_bcp_detalle.php");
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();
//$bo_bbva = new bo_fin_recaudobbva();
//$bo_bcp = new bo_recaud_bcp_detalle();

?>
<div class="row">
	<div class="col-12"> 
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="row align-items-center gy-3">
					<div class="col-sm">
						<h5 class="card-title mb-0">Cuentas Recaudos</h5>
					</div>
				</div>
			</div>
			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
				<ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#descargas" aria-controls="descargas" role="tab" aria-selected="true">DESCARGAS</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_BuscarBCP();" id="bcp-tab" data-bs-toggle="tab" href="#bcp" aria-controls="bcp" role="tab" aria-selected="false">RECAUDO BCP</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_BuscarBBVA();" id="bbva-tab" data-bs-toggle="tab" href="#bbva" aria-controls="bbva" role="tab" aria-selected="false">RECAUDO BBVA</a>
					</li>
					
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="descargas" aria-labelledby="descargas-tab" role="tabpanel">
						<?php include __DIR__ . '/recau_taps_show.php'; ?>
					</div>
					<div class="tab-pane" id="bcp" aria-labelledby="bcp-tab" role="tabpanel">
						<div class="container-fluid mt-1">
							<div id="div_fromBCP"></div>
						</div>
					</div>
					<div class="tab-pane" id="bbva" aria-labelledby="bbva-tab" role="tabpanel">
						<div class="container-fluid mt-1">
							<div id="div_fromBBVA"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
