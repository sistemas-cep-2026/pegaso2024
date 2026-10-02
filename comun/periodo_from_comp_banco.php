<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once(u_src() . "bo/bo_general.php");
s_validar_pagina();
$bo_general = new bo_general();
$cc_local = s_local();
$usuario = s_usuario();
$data_periodo = $bo_general->listarRegionesAdministrativo($cc_local, $usuario);

// consejo y período activos en la sesión actual, para preseleccionarlos al abrir el modal
$cc_local_actual = s_local_vinculado();
$periodo_actual = s_anho() . s_periodo();
$data_periodos_actual = $bo_general->listarPeriodos_comp_banco($cc_local_actual);
?>
<div class="modal-header">
	<h4 class="modal-title">
		<i class="bx bx-map-pin text-primary align-middle me-1"></i> Consejo / Período
	</h4>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
	<p class="text-muted fs-13 mb-3">Selecciona el consejo regional y el período que deseas consultar.</p>
	<form action="javascript:fn_actualizar();" id="frmActualiza" novalidate>
		<div class="row g-2 align-items-end">
			<div class="col-sm-5">
				<label for="cc_local_vinculado" class="form-label text-muted fs-13 mb-1">
					<i class="bx bx-buildings"></i> Consejo Regional
				</label>
				<select name="cc_local_vinculado" id="cc_local_vinculado" class="form-control" onChange="fn_lista_periodo_comp_banco(this.value)" required>
					<option value="">Seleccione...</option>

					<?php foreach ($data_periodo as $loc) { ?>
						<option value="<?php echo $loc['c_local']; ?>" <?php echo (trim($loc['c_local']) == $cc_local_actual) ? 'selected' : ''; ?>>
							<?php echo $loc['nombre']; ?>
						</option>
					<?php } ?>

				</select>
			</div>
			<div class="col-sm-5">
				<label for="cont_periodo" class="form-label text-muted fs-13 mb-1">
					<i class="bx bx-calendar"></i> Período
				</label>
				<select name="cont_periodo" id="cont_periodo" class="form-control" required>
					<?php if (empty($data_periodos_actual)) { ?>
						<option value="">Seleccione un consejo primero...</option>
					<?php } else { ?>
						<?php foreach ($data_periodos_actual as $per) { ?>
							<option value="<?php echo $per['periodo']; ?>" <?php echo (trim($per['periodo']) == $periodo_actual) ? 'selected' : ''; ?>>
								<?php echo $per['c_mes'] . '-' . $per['c_ano']; ?>
							</option>
						<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="col-sm-2">
				<?php echo bt_filtrar('Ir'); ?>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$("#frmActualiza").validate();

	function fn_actualizar() {
		swalProcesando();
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