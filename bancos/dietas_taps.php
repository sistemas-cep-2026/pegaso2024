<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_banc_dietas.php");

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_banc_dietas = new bo_banc_dietas();

$ent_banc_dietas = new banc_dietas();
$data_area   = $bo_general->AreaAdministrativa_dieta();
$cc_local = s_local_vinculado();

$flag = '0';
$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_dietas = isset($_REQUEST['cod']) ? s_crypt($_REQUEST['cod'], 'out') : '';
$disabled = '';
$ent_banc_dietas->setFecha(date('Y-m-d'));
$cod_ano = s_anho();
$cod_mes = s_periodo();
$ent_banc_dietas->setCc_local($cc_local);
$ent_banc_dietas->setOpc($opc);

if ($opc === 'U') {
	$ent_banc_dietas->setCc_dietas($cc_dietas);
	$data  = $bo_banc_dietas->listarID($ent_banc_dietas);
	foreach ($data as $act) {
		$ent_banc_dietas->setCc_persona(s_crypt($act['cc_persona'], 'in'));
		$ent_banc_dietas->setNombre_persona($act['nombre_persona']);
		$ent_banc_dietas->setNombre_area($act['nombre_area']);

		$ent_banc_dietas->setfecha($act['fecha']);
		$ent_banc_dietas->setC_area_adm($act['c_area_adm']);
		$ent_banc_dietas->setReferencia($act['referencia']);
		$ent_banc_dietas->setFlag($act["flag"]);
		$ent_banc_dietas->setCod_ano($act["cod_ano"]);
		$ent_banc_dietas->setCod_mes($act["cod_mes"]);
		$flag = $act["flag"];
		$disabled = in_array($flag, ['*', 'A']) ? 'disabled' : '';
	}
}

// igual que en ingresos_taps.php / egresos_taps.php: con el registro recién
// creado ('0') o guardado como pendiente ('&') los campos siguen editables;
// en cualquier otro estado intermedio (ej. 'I') quedan de solo lectura.
$disabled_temp_prima = ($flag == '&' || $flag == '0') ? ' ' : ' readonly';

$meses = u_meses_contable();
$nombre_mes = $meses[$cod_mes] ?? 'Mes no definido';
?>

<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="d-flex align-items-center">
					<div class="avatar-sm flex-shrink-0 me-3">
						<span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
							<i class="ri-hand-coin-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<h4 class="card-title mb-0">
							REGISTRO DE DIETAS
						</h4>
						<p class="text-muted mb-0 fs-13">
							Registro y consulta de dietas directivos
						</p>
					</div>
				</div>
			</div>
			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
				<ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#crear_documento" aria-controls="crear_documento" role="tab" aria-selected="true">
							CREAR REGISTRO
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_buscarDietas();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">
							LISTAR REGISTROS
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
						<form action="javascript:fn_guardarDietas();" id="frmRegistroDietas" novalidate>
							<input type="hidden" name="cc_dietas" id="cc_dietas" value="<?php echo s_crypt($cc_dietas) ?>">
							<input type="hidden" name="flag" id="flag" value="<?php echo $flag ?>">
							<div class="row">
								<div class="col-md-9 p-2 border-end">
									<fieldset <?php echo $disabled; ?>>
										<div class="row">
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<span class="input-group-text bg-warning text-dark fw-semibold">
														<i class="bi bi-exclamation-triangle-fill me-1"></i>
														Periodo Actual:
													</span>
													<input type="text" class="form-control bg-warning bg-opacity-25 border-warning fw-bold" value="<?= $nombre_mes . ' => ' . $cod_ano ?>"
														disabled>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<span class="input-group-text">Fecha: </span>
													<input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $ent_banc_dietas->getFecha(); ?>" <?php echo $disabled_temp_prima ?>>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="input-group mb-3">
													<span class="input-group-text">Comp.:</span>
													<input type="text" class="form-control" id="comprobante" name="comprobante" value="<?= digitos($ent_banc_dietas->getCc_dietas(), 6); ?>" disabled>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-10">
												<div class="input-group mb-3">
													<input type="hidden" class="form-control" id="cc_persona" name="cc_persona" value="<?php echo $ent_banc_dietas->getCc_persona(); ?>">
													<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre o CEP del Directivo" value="<?php echo $ent_banc_dietas->getNombre_persona(); ?>" required <?php echo $disabled_temp_prima ?>>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-8">
												<div class="input-group mb-3">
													<span class="input-group-text">Area:</span>
													<select name="c_area_adm" id="c_area_adm" class="form-control" required>

														<?php foreach ($data_area as $area): ?>
															<option value="<?php echo $area['cc_area_adm']; ?>"
																<?= ($ent_banc_dietas->getC_area_adm() == $area['cc_area_adm']) ? 'selected' : '' ?>>
																<?php echo htmlspecialchars($area['nombre']); ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>

											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="input-group mb-3">
													<span class="input-group-text">Referencia : </span>
													<input type="text" class="form-control" id="referencia" name="referencia" value="<?php echo $ent_banc_dietas->getReferencia(); ?>" <?php echo $disabled_temp_prima ?>>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<input type="hidden" name="c_local" id="c_local" value="<?php echo $cc_local ?>">
												<input type="hidden" name="cc_dietas" id="cc_dietas" value="<?php echo s_crypt($cc_dietas, 'in') ?>">
												<input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
												<div class="row border-bottom mb-1 py-2"></div>
											</div>
										</div>
									</fieldset>
								</div>
								<div class="col-md-3">
									<div class="mt-md-1">
										<?php include 'dietas_botones.php'; ?>
									</div>
								</div>
							</div>
						</form>
						<div class="row">
							<div class="col-md-9 border-end">
								<div id="divDetalleIngresos"></div>
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