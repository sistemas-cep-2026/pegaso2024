<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_fin_documentos_de_venta.php");

$bo_documentos_venta = new bo_fin_documentos_de_venta();

$s_local=s_local();
$data_region=$bo_general->listarRegiones();
$data_periodos = $bo_documentos_venta->listarPeriodos();
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card-body">
			<form class="needs-validation" id="frm_habilesInhabiles" action="javascript:fn_habilesInhabiles()" method="post" novalidate>
				<div class="mb-1 row justify-content-center align-items-center">
					<div class="col-sm-3">
						<div class="input-group mb-0">
							<select name="cc_local" id="cc_local" class="form-control" onchange="submit()">
								<?php echo generarOpcionesRegion($data_region, $s_local); ?>
							</select>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="input-group mb-0">
							<select name="periodo" id="periodo" class="form-control" onchange="submit()">
								<?php
								foreach ($data_periodos as $peri) {
									?>
									<option value="<?php echo $peri["periodo"] ?>"><?php echo $peri["periodo"] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3 text-start">
						<?php echo bt_filtrar() ?> <?php echo bt_cancelar(); ?>
					</div>
				</div>
			</form>
			<div class="row mb-3">
				<div class="col-lg-12 table-responsive">
					<div id="divReporHabilesIn"></div>
				</div>
			</div>
		</div>
	</div> <!-- end col -->
</div>
