<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once(u_src() . "bo/bo_general.php");
s_validar_pagina();
$bo_general = new bo_general();
$cc_local = s_local();
$usuario = s_usuario();
$data_periodo = $bo_general->listarRegionesAdministrativo($cc_local, $usuario);

// Módulo actual (700 Compras, 800 Bancos, 900 Contabilidad): define qué cierre se mira.
$modulo = substr(trim((string) s_mod_id()), 0, 3);
$modulos_txt = array('700' => 'Compras', '800' => 'Bancos', '900' => 'Contabilidad');
$modulo_txt = isset($modulos_txt[$modulo]) ? $modulos_txt[$modulo] : '';

// consejo y período activos en la sesión actual, para preseleccionarlos al abrir el modal
$cc_local_actual = s_local_vinculado();
$periodo_actual = s_anho() . s_periodo();
$data_periodos_actual = $bo_general->listarPeriodosAbiertos($cc_local_actual, $modulo);
?>
<div class="modal-header">
	<h4 class="modal-title">
		<i class="bx bx-map-pin text-primary align-middle me-1"></i> Consejo / Período
	</h4>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
	<p class="text-muted fs-13 mb-3">
		Selecciona el consejo regional y el período que deseas consultar.
		<?php if ($modulo_txt !== '') { ?>
			Solo se muestran los períodos <span class="badge bg-warning-subtle text-warning">abiertos</span> de <strong><?php echo $modulo_txt; ?></strong>.
		<?php } ?>
	</p>
	<form action="javascript:fn_actualizar();" id="frmActualiza" novalidate>
		<div class="row g-2 align-items-end">
			<div class="col-sm-5">
				<label for="cc_local_vinculado" class="form-label text-muted fs-13 mb-1">
					<i class="bx bx-buildings"></i> Consejo Regional
				</label>
				<select name="cc_local_vinculado" id="cc_local_vinculado" class="form-select" onChange="fn_lista_periodo_comp_banco(this.value)" required>
					<option value="">Seleccione...</option>
					<?php foreach ($data_periodo as $loc) { ?>
						<option value="<?php echo htmlspecialchars(trim($loc['c_local']), ENT_QUOTES, 'UTF-8'); ?>" <?php echo (trim($loc['c_local']) == $cc_local_actual) ? 'selected' : ''; ?>>
							<?php echo htmlspecialchars($loc['nombre'], ENT_QUOTES, 'UTF-8'); ?>
						</option>
					<?php } ?>
				</select>
			</div>
			<div class="col-sm-5">
				<label for="cont_periodo" class="form-label text-muted fs-13 mb-1">
					<i class="bx bx-calendar"></i> Período
				</label>
				<select name="cont_periodo" id="cont_periodo" class="form-select" required>
					<?php if (empty($data_periodos_actual)) { ?>
						<option value="">Sin períodos abiertos...</option>
					<?php } else { ?>
						<option value="">Seleccione...</option>
						<?php foreach ($data_periodos_actual as $per) {
							$valor = trim($per['periodo']); ?>
							<option value="<?php echo htmlspecialchars($valor, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($valor == $periodo_actual) ? 'selected' : ''; ?>>
								<?php echo htmlspecialchars(trim($per['c_mes']) . '-' . trim($per['c_ano']), ENT_QUOTES, 'UTF-8'); ?>
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
				if (!data || typeof data !== 'object' || data.error) {
					throw (data && data.message) || data || 'No se pudo cambiar el período.';
				}
				modalRegistro.hide();
				recargar();
			}).catch(function(err) {
				swalError(err);
			});
	}
</script>
