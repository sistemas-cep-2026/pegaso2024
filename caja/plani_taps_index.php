<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="row">
	<div class="col-xxl-12">
		<div class="card">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Registro de horas extras</h4>
			</div>
			<div class="card-body">
				<ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" onclick="fn_listarHabilese();" data-bs-toggle="tab" href="#habiles_inhabiles" role="tab" aria-selected="false">
							Hábiles e inhabiles
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_listarEssalud();" data-bs-toggle="tab" href="#pla_essalud" role="tab" aria-selected="false">
							Planilla EsSalud
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_listarMinsa();" data-bs-toggle="tab" href="#plan_minsa" role="tab" aria-selected="false">
							Planilla Minsa
						</a>
					</li>
				</ul>
				<div class="tab-content text-muted">
					<div class="tab-pane active" id="habiles_inhabiles" role="tabpanel">
						<div class="d-flex">
							<div class="flex-grow-1 ms-2">
								<?php include __DIR__ . '/plani_taps_aih_buscar.php'; ?>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="pla_essalud" role="tabpanel">
						<div class="d-flex">
							<div class="flex-grow-1 ms-2">
								hola2
							</div>
						</div>
					</div>
					<div class="tab-pane" id="plan_minsa" role="tabpanel">
						<div class="d-flex">
							<div class="flex-grow-1 ms-2">
								hola3
							</div>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div>
	</div>
</div>

<?php $include_scripts = function () {
	return importDatatable() . importTypeahead();
} ?>
