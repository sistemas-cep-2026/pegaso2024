<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_banc_comprobantes_de_caja.php");
require_once(u_src() . "bo/bo_comp_liquidaciones_caja_chica.php");

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_comprobantes_de_caja = new bo_banc_comprobantes_de_caja();
$bo_compras	=	new bo_comp_liquidaciones_caja_chica();

$ent_comprobantes_de_caja = new banc_comprobantes_de_caja();
$ent_compras = new comp_liquidaciones_caja_chica();

$disabled = '';
$disabled_temp = '';
$cc_local = s_local_vinculado();
$cod_ano = s_anho();
$cod_mes = s_periodo();
$flag = '0';
$flag_text = 'NUEVO';

$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_documento = isset($_REQUEST['cod']) ? s_crypt($_REQUEST['cod'], 'out') : '';

$data_bancos    = $bo_general->ListarcuentasBancarias(s_local_vinculado(), '', '');
$forma_pago = $bo_parametro_detalle->listarParametroDet('comprobantes_de_caja', 'c_forma_cancelacion');

$fecha = fechaPeriodoActual($cod_ano, $cod_mes);
$ent_comprobantes_de_caja->setFecha($fecha);

$ent_compras->setC_local($cc_local);
$data_compras = $bo_compras->CajaChicaPendiente($ent_compras);

$tp_coleg = tipo_cliente();

$ent_comprobantes_de_caja->setNumero('000000');

if ($opc === 'U') {
	$ent_comprobantes_de_caja->setCc_documento($cc_documento);
	$dat_ac = $bo_comprobantes_de_caja->listarID($ent_comprobantes_de_caja);
	foreach ($dat_ac as $act) {

		$ent_comprobantes_de_caja->setFecha($act["fecha_documento"] ?? '');

		$ent_comprobantes_de_caja->setC_persona(($act["c_persona"] ?? '') !== '' ? s_crypt($act["c_persona"], 'in') : '');
		$ent_comprobantes_de_caja->setObservacion($act["observacion"] ?? '');
		$ent_comprobantes_de_caja->setRazon_social($act["nombre_completo"] ?? '');
		$ent_comprobantes_de_caja->setC_forma_cancelacion($act["c_forma_cancelacion"] ?? '');
		$ent_comprobantes_de_caja->setC_banco($act["banco_text"] ?? '');
		$ent_comprobantes_de_caja->setNum_boleta_cheque($act["num_boleta_cheque"] ?? '');
		$ent_comprobantes_de_caja->setC_liquidacion_caja_chica($act["c_liquidacion_caja_chica"] ?? '');
		$ent_comprobantes_de_caja->setNumero($act["numero"] ?? '');
		$ent_comprobantes_de_caja->setMonto($act["monto"] ?? '');

		$flag = $act["flag"] ?? '';
		$flag_text = $act["flag_text"] ?? '';

		$disabled = in_array($flag, ['*', 'A'], true) ? 'disabled' : '';
	}
}
$disabled_temp = ($flag == '&' || $flag == '0') ? ' ' : ' readonly';
$disabled_temp_prima =  ($flag == '&' || $flag == '0')  ? ' ' : ' readonly';
$tieneCajaChica = !empty($ent_comprobantes_de_caja->getC_liquidacion_caja_chica());
$meses = u_meses_contable();
$nombre_mes = $meses[$cod_mes] ?? 'Mes no definido';
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="d-flex align-items-center">
					<div class="avatar-sm flex-shrink-0 me-3">
						<span class="avatar-title bg-danger-subtle text-danger rounded-circle fs-18">
							<i class="ri-arrow-up-circle-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<h4 class="card-title mb-0">REGISTRO DE EGRESOS</h4>
						<p class="text-muted mb-0 fs-13">Comprobantes de egreso de caja</p>
					</div>
				</div>
			</div>
			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
				<ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#crear_documento" aria-controls="crear_documento" role="tab" aria-selected="true">CREAR REGISTRO</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_listarBuscar();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">LISTAR REGISTROS</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
						<form action="javascript:fn_guardarEgresos();" id="frmRegistroEgresos" novalidate>
							<input name="cc_documento" id="cc_documento" type="hidden" value="<?php echo s_crypt($cc_documento) ?>">
							<input type="hidden" name="flag" id="flag" value="<?php echo $flag ?>">
							<div class="row">
								<div class="col-md-9 p-2 border-end">
									<fieldset <?php echo $disabled; ?>>
										<div class="row">
											<div class="col-lg-5">
												<label class="form-label text-muted fs-13 mb-1">Periodo Actual</label>
												<div class="input-group mb-3">
													<span class="input-group-text bg-light-subtle">
														<i class="ri-calendar-2-line"></i>
													</span>
													<input type="text" class="form-control fw-semibold" value="<?= $nombre_mes . ' => ' . $cod_ano ?>"
														disabled>
												</div>
											</div>
											<div class="col-lg-3">
												<label class="form-label text-muted fs-13 mb-1">Comprobante</label>
												<div class="input-group mb-3">
													<span class="input-group-text bg-light-subtle">#</span>
													<input type="text" class="form-control" id="comprobante" name="comprobante" value="<?= $ent_comprobantes_de_caja->getNumero(); ?>" disabled>
												</div>
											</div>
											<div class="col-lg-4 text-center">
												<label class="form-label text-muted fs-13 mb-1 d-block">Estado</label>
												<span class="badge <?php echo $color_flag_cont[$flag] ?? 'bg-secondary'; ?> fs-13 px-3 py-2">
													<i class="<?php echo $icon_flag[$flag] ?? 'fas fa-circle'; ?> me-2"></i>
													<?php echo $flag_text; ?>
												</span>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3">
												<label for="fecha" class="form-label text-muted fs-13 mb-1">Fecha</label>
												<input type="date" class="form-control mb-3" id="fecha" name="fecha" value="<?php echo $ent_comprobantes_de_caja->getFecha(); ?>">
											</div>
											<div class="col-lg-2">
												<label for="tipo_persona" class="form-label text-muted fs-13 mb-1">Tipo</label>
												<select name="c_persona_ref" class="form-control form-select mb-3" id="tipo_persona" onchange="$('#nombre').val('');">
													<?php
													foreach ($tp_coleg as $key => $value) { ?>
														<option value="<?= $key ?>">
															<?= $value ?>
														</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-lg-7">
												<label for="nombre" class="form-label text-muted fs-13 mb-1">Nombre o Razón Social</label>
												<input type="hidden" class="form-control" id="c_persona" name="c_persona" value="<?php echo $ent_comprobantes_de_caja->getC_persona(); ?>">
												<input type="text" class="form-control mb-3" id="nombre" name="nombre" placeholder="Nombre o Razón Social" value="<?php echo $ent_comprobantes_de_caja->getRazon_social(); ?>" required>
											</div>
										</div>
										<div class="row align-items-end">
											<div class="col-lg-4">
												<label for="c_banco" class="form-label text-muted fs-13 mb-1">Banco</label>
												<select name="c_banco" id="c_banco" class="form-control mb-3">
													<?php
													foreach ($data_bancos as $ban) { ?>
														<option value="<?= "{$ban['c_banco']}-{$ban['c_cta_corriente']}" ?>"
															<?= ($ent_comprobantes_de_caja->getC_banco() == $ban['banco_cta']) ? 'selected' : '' ?>>
															<?= "{$ban['nombre']} =>> {$ban['c_cta_corriente']}" ?>
														</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-lg-2">
												<label for="c_forma_cancelacion" class="form-label text-muted fs-13 mb-1">Tipo de pago</label>
												<select name="c_forma_cancelacion" id="c_forma_cancelacion" class="form-control mb-2">
													<?php
													foreach ($forma_pago as $row) {
													?>
														<option value="<?= $row['cc_codigo'] ?>"
															<?= ($ent_comprobantes_de_caja->getC_forma_cancelacion() == $row['cc_codigo']) ? 'selected' : '' ?>>
															<?= $row['detalle'] ?>
														</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-lg-2">
												<label for="num_boleta_cheque" class="form-label text-muted fs-13 mb-1">N° Boleta/Cheque</label>
												<div class="input-group mb-2">
													<span class="input-group-text bg-light-subtle"><i class="ri-file-list-3-line"></i></span>
													<input type="text" class="form-control" id="num_boleta_cheque" name="num_boleta_cheque" value="<?php echo $ent_comprobantes_de_caja->getNum_boleta_cheque(); ?>">
												</div>
											</div>

											<div class="col-lg-2">
												<label class="form-label text-end fs-13 mb-1 d-block">Monto</label>
												<div class="bg-success-subtle rounded p-2 text-end mb-2">
													<span class="fw-bold fs-16 text-success" id="monto">
														S/ <?php echo number_format((float)$ent_comprobantes_de_caja->getMonto(), 2); ?>
													</span>
												</div>
											</div>
										</div>
										<!--</div>-->
										<div class="row align-items-center bg-light-subtle rounded mx-0 py-2 mb-3">
											<div class="col-lg-2">
												<div class="form-check form-switch form-switch-md" dir="ltr">
													<input type="checkbox" class="form-check-input" id="cajachica" <?= $tieneCajaChica ? 'checked' : '' ?>>
													<label class="form-check-label" for="cajachica">Activar</label>
												</div>
											</div>
											<div class="col-lg-10">
												<select name="c_liquidacion_caja_chica" id="c_liquidacion_caja_chica" class="form-control" <?= $tieneCajaChica ? '' : 'disabled' ?>>
													<option value="">Selecciona</option>
													<?php foreach ($data_compras as $comp): ?>
														<option value="<?= htmlspecialchars($comp['c_liquidacion_caja_chica']) ?>"
															<?= ($ent_comprobantes_de_caja->getC_liquidacion_caja_chica() == $comp['c_liquidacion_caja_chica']) ? 'selected' : '' ?>>
															<?= htmlspecialchars($comp['caja_chica']) ?>
														</option>
													<?php endforeach; ?>

												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="input-group mb-3">
													<span class="input-group-text bg-light-subtle"><i class="ri-edit-2-line"></i></span>
													<input type="text" class="form-control" id="observacion" name="observacion" value="<?php echo $ent_comprobantes_de_caja->getObservacion(); ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<input type="hidden" name="c_local" id="c_local" value="<?php echo $cc_local ?>">
												<input type="hidden" name="cc_documento" id="cc_documento" value="<?php echo s_crypt($cc_documento, 'in') ?>">
												<input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
												<div class="row border-bottom mb-1 py-2"></div>
											</div>
										</div>
									</fieldset>
								</div>
								<div class="col-md-3">
									<div class="mt-md-1">
										<?php include 'egresos_botones.php'; ?>
									</div>
								</div>
							</div>
						</form>
						<div class="row">
							<div class="col-md-9 border-end">
								<div id="divDetalleEgresos"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="reporte_documento" aria-labelledby="reporte_documento-tab" role="tabpanel">
						<div id="div_listarBuscar"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $include_scripts = function () {
	return importTypeahead() . importInputMask() . importformmasks() . importDatatable();
} ?>