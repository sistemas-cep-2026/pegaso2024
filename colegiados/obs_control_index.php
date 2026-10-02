<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
?>
<div class="col-xl-12 col-lg-12">
	<div class="card">
		<div class="card-body">
			<form class="needs-validation" id="frmRegistro" action="javascript:fn_buscarRegistro()" method="post" novalidate>
				<div class="mb-1 row justify-content-center">
					<div class="col-sm-5">
						<input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="Nombre" placeholder="Cep o apellidos"  value="" >
					</div>
					<div class="col-sm-3">
						<?php echo bt_buscar("Buscar")  ?> <?php bt_cancelar("Cancelar") ?>
					</div>
				</div>
			</form>
			<div class="mb-1 row">
				<div class="col-sm-12">
					<div id="divRegistros"></div>
				</div>
			</div>

		</div>
	</div>
</div>
<?php $include_scripts = function () {
    return importDatatable() . importTypeahead();
} ?>
