<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_doc_recibidos = new bo_tram_documentos_recibidos();

$ent_doc_recibidos = new tram_documentos_recibidos();

$cc_local = s_local();
$flag = '0';
$opc = isset($_REQUEST['opc']) ? s_crypt($_REQUEST['opc'], 'out') : 'I';
$cc_docrecibidos = isset($_REQUEST['cod']) ? s_crypt($_REQUEST['cod'], 'out') : '';

$tipo_persona = $bo_parametro_detalle->listarParametroDet("documentos_recibidos1", "tipo_persona");
$data_doc = $bo_general->tipo_documento();
$data_cargos = $bo_general->listarCargos();

$usuario = s_usuario();
$data_regional = $bo_general->listarRegionesAdministrativo($cc_local, $usuario, 'A');

$disabled = '';

$ent_doc_recibidos->setFecha_documento(date('Y-m-d'));
if ($opc === 'U') {
	$ent_doc_recibidos->setCc_docrecibidos($cc_docrecibidos);
	$dat_ac = $bo_doc_recibidos->listarId($ent_doc_recibidos);
	foreach ($dat_ac as $act) {
		$ent_doc_recibidos->setC_expediente($act["c_expediente"]);
		$ent_doc_recibidos->setC_tipo_de_documento($act["c_tipo_de_documento"]);
		$ent_doc_recibidos->setNum_documento($act["num_documento"]);
		$ent_doc_recibidos->setFecha_documento($act["fecha_documento"]);
		$ent_doc_recibidos->setC_persona($act["c_persona"]);
		$ent_doc_recibidos->setRazon_social($act["razon_social"]);
		$ent_doc_recibidos->setC_persona_pf($act["c_persona_pf"]);
		$ent_doc_recibidos->setNombre_remitente($act["nombre_remitente"]);
		$ent_doc_recibidos->setAsunto($act["asunto"]);
		$ent_doc_recibidos->setAsunto2($act["asunto2"]);
		$ent_doc_recibidos->setC_local($act["c_local"]);
		$ent_doc_recibidos->setTipo_persona($act["tipo_persona"]);
		$ent_doc_recibidos->setC_local_origen($act["c_local_origen"]);
		$ent_doc_recibidos->setC_cargo($act["c_cargo"]);
		$flag = $act["flag"];
		$disabled =  'disabled';
	}
	$disabled_temp = ' disabled';
}
$desti_text = ($cc_local  == '28') ? 'DECANA(O) NACIONAL' : 'DECANA(O) REGIONAL';
$destinatario = $ent_doc_recibidos->getDestinatario() ?: $desti_text;
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header align-items-center d-flex border-0">
				<h4 class="card-title mb-0 flex-grow-1">
					<i class="bx bx-folder-open text-primary align-middle me-1"></i> REGITRO DE EXPEDIENTES
				</h4>
			</div>
			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
				<ul class="nav nav-tabs nav-justified nav-border-top nav-border-top-primary mb-3" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#crear_documento" aria-controls="crear_documento" role="tab" aria-selected="true">
							<i class="bx bx-plus-circle align-middle me-1"></i> NUEVO REGISTRO
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_BuscarExp();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">
							<i class="bx bx-list-ul align-middle me-1"></i> LISTAR REGISTROS
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
						<form action="javascript:fn_guardarExp();" id="frmRegistroExp" novalidate>
							<input type="hidden" name="flag" id="flag" value="<?php echo $flag ?>">
							<div class="row">
								<div class="col-md-9 p-2 border-end">
									<fieldset <?php echo $disabled; ?>>
										<div class="row">
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<span class="input-group-text"><i class="bx bx-hash me-1"></i> N° Exp.</span>
													<input type="number" class="form-control" id="c_expediente" name="c_expediente" value="<?php echo $ent_doc_recibidos->getC_expediente(); ?>" disabled>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<span class="input-group-text"><i class="bx bx-calendar me-1"></i> Fecha Doc.</span>
													<input type="date" class="form-control" id="fecha_documento" name="fecha_documento" value="<?php echo $ent_doc_recibidos->getFecha_documento(); ?>" required>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<span class="input-group-text"><i class="bx bx-user me-1"></i> Remitente</span>
													<select name="tipo_persona" id="tipo_persona" class="form-control" onchange="mostrarCamposExtras()" required>
														<?php foreach ($tipo_persona as $fl) { ?>
															<option value="<?php echo $fl['cc_codigo'] ?>" <?php if ($ent_doc_recibidos->getTipo_persona() === $fl['cc_codigo']) echo "selected"; ?>>
																<?php echo $fl['detalle'] ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-lg-5">
												<div class="input-group mb-3">
													<span class="input-group-text"><i class="bx bx-file me-1"></i> Tipo Doc.</span>
													<select id="c_tipo_de_documento" name="c_tipo_de_documento" class="form-control select2" required>
														<?php foreach ($data_doc as $doc): ?>
															<option value="<?= $doc['c_tipo_de_documento'] ?>"
																<?= $ent_doc_recibidos->getC_tipo_de_documento() === $doc['c_tipo_de_documento'] ? 'selected' : '' ?>>
																<?= $doc['nombre'] ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="input-group mb-3">
													<span class="input-group-text"><i class="bx bx-hash me-1"></i> N°</span>
													<input type="text" class="form-control" id="num_documento" name="num_documento" value="<?php echo $ent_doc_recibidos->getNum_documento(); ?>" required>
												</div>
											</div>
										</div>
										<div id="extraFields" style="display: none;">
											<div class="row">
												<div class="col-lg-8">
													<div class="input-group mb-3">
														<input type="hidden" class="form-control" id="c_persona" name="c_persona" value="<?php echo $ent_doc_recibidos->getC_persona(); ?>">
														<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Razón Social o Colegiado" value="<?php echo $ent_doc_recibidos->getRazon_social(); ?>">
													</div>
												</div>
												<div class="col-lg-4">
													<div class="input-group mb-3">
														<span class="input-group-text"><i class="bx bx-briefcase me-1"></i> Cargo</span>
														<select id="c_cargo" name="c_cargo" class="form-control" required>
															<option value="">SIN CARGO</option>
															<?php foreach ($data_cargos as $car) { ?>
																<option value="<?php echo $car['c_cargo']; ?>" <?php if ($ent_doc_recibidos->getC_cargo() === $car['c_cargo']) echo 'selected'; ?>>
																	<?php echo $car['nombre']; ?>
																</option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-7">
												<div class="input-group mb-3">
													<input type="hidden" class="form-control" id="c_persona_pf" name="c_persona_pf" value="<?php echo $ent_doc_recibidos->getC_persona_pf(); ?>">
													<input type="text" class="form-control" id="nombre_remitente" name="nombre_remitente" placeholder="Remitente" value="<?php echo $ent_doc_recibidos->getNombre_remitente(); ?>" required>
												</div>
											</div>
											<div class="col-lg-5">
												<div class="input-group mb-3">
													<span class="input-group-text"><i class="bx bx-map-pin me-1"></i> CR Origen</span>
													<select class="form-select" id="c_local_origen" name="c_local_origen">
														<option value="">Seleccione una opción...</option>
														<?php foreach ($data_regional as $loc): ?>
															<option
																value="<?= htmlspecialchars($loc['c_local']) ?>"
																<?= ($loc['c_local'] == $ent_doc_recibidos->getC_local_origen()) ? 'selected' : '' ?>>
																<?= htmlspecialchars($loc['nombre']) ?>
															</option>
														<?php endforeach; ?>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-5">
												<div class="input-group mb-3">
													<span class="input-group-text"><i class="bx bx-send me-1"></i> Destinatario</span>
													<input type="text" class="form-control" id="destinatario" name="destinatario" placeholder="<?= $desti_text ?>" value="<?php echo $destinatario ?>" required>
												</div>
											</div>
											<div class="col-lg-7">
												<div class="input-group mb-3">
													<span class="input-group-text"><i class="bx bx-message-detail me-1"></i> Asunto</span>
													<input type="text" class="form-control" id="asunto" name="asunto" value="<?php echo $ent_doc_recibidos->getAsunto(); ?>" required>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="input-group mb-3">
													<span class="input-group-text"><i class="bx bx-note me-1"></i> Observación</span>
													<input type="text" class="form-control" id="asunto2" name="asunto2" value="<?php echo $ent_doc_recibidos->getAsunto2(); ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<input type="hidden" name="c_local" id="c_local" value="<?php echo $cc_local ?>">
												<input type="hidden" name="cc_docrecibidos" id="cc_docrecibidos" value="<?php echo s_crypt($cc_docrecibidos, 'in') ?>">
												<input type="hidden" name="opc" value="<?php echo s_crypt($opc, 'in') ?>">
												<div class="row border-bottom mb-1 py-2"></div>
											</div>
										</div>
									</fieldset>
								</div>

								<div class="col-md-3">
									<div class="mt-md-1">
										<?php include 'exp_taps_botones.php'; ?>
									</div>
								</div>
							</div>
						</form>
						<div class="row">
							<div class="col-md-9 border-end">
								<div id="divDetalleDetalleExp"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<?php /*if ($opc == 'U') {
									include 'exp_file.php';
								}*/ ?>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="reporte_documento" aria-labelledby="reporte_documento-tab" role="tabpanel">
						<div id="div_listarExp"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $include_scripts = function () {
	return importTypeahead() . importInputMask() . importformmasks() . importDatatable() . importSelect2() . importToolTip();;
} ?>