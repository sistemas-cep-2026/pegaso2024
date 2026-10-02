<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once(u_src() . "bo/bo_general.php");
s_validar_pagina();
$bo_general = new bo_general();
$cc_local = s_local();
$usuario = s_usuario();
$data_periodo = $bo_general->listarRegionesAdministrativo($cc_local, $usuario);
?>
<div class="modal-header">
	<h4 class="modal-title">Periodo Contable</h4>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
	<form action="javascript:fn_actualizar();" id="frmActualiza" novalidate>
		<div class="row  mb-2">
			<div class='col-sm-5'>
				<select name="cc_local_vinculado" id="cc_local_vinculado" class="form-control" onChange="fn_lista_periodo(this.value)" required>
					<option value="">Seleccione...</option>
					<?php
					foreach ($data_periodo as $loc) { ?>
						<option value="<?php echo $loc['cc_local']; ?>"><?php echo $loc['nombre']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class='col-sm-5'>
				<select name="cont_periodo" id="cont_periodo" class="form-control" required>
				</select>
			</div>
			<div class='col-sm-2'>
				<?php echo bt_filtrar('Ir'); ?>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$("#frmActualiza").validate();

	function fn_actualizar() {
		var str = $("#frmActualiza").serialize();
		ajax('comun/periodo_actualiza', str)
			.then(function(data) {
				recargar();
				modalRegistro.hide();
			}).catch(function(err) {
				swalError(err);
			});
	}
</script>