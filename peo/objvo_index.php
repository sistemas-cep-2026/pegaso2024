<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_peo_ejeestrategico.php");
$bo_eje = new bo_peo_ejeestrategico();

$data_objet  =   $bo_eje->listar();
?>
<div class="row">
	<div class="col-md-12">
		<div class="card-body">
			<form action="javascript:fn_listarObjetivos();" role="form" id="frmBuscarRegistro" class="needs-validation" novalidate="">
				<div class="row mb-2">
					<div class="col-md-8">
						<select name="cc_ejeestrategico" id="cc_ejeestrategico" class="form-control" onchange="submit()" >
							<option value="">Selecciona Objetivo</option>
							<?php
							$i=1;
							foreach ($data_objet as $per) {
								?>
								<option value="<?php echo $per["cc_ejeestrategico"] ?>"><?php echo "Eje ".$i.".- ".$per["nombre"] ?></option>
								<?php $i++;} ?>
							</select>
						</div>
						<div class="col-md-2 text-center">
							<?php echo bt_buscar(); ?>
							<?php echo bt_cancelar(); ?>
						</div>
					</div>
				</form>
			</div>
			<div class="table-responsive-xl p-1" id="divListaObjetivos"></div>
		</div>
	</div>