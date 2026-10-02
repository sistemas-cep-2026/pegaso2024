<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");
require_once(u_src() . "bo/bo_banc_beneficiofam.php");

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_fam = new bo_banc_beneficiofam();

$ent_fam = new banc_beneficiofam();

$cc_local = s_local();

$tipo_fam = $bo_parametro_detalle->listarParametroDet('banc_beneficiofam', 'cod_tipo');
$data_cta = $bo_general->ListarcuentasBancarias($cc_local, '', '', '');
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="d-flex align-items-center">
					<div class="avatar-sm flex-shrink-0 me-3">
						<span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
							<i class="ri-heart-2-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<h4 class="card-title mb-0">
							REGISTRO DE AYUDA MUTUA (FAM)
						</h4>
						<p class="text-muted mb-0 fs-13">
							Registro y consulta FAM
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
						<a class="nav-link" onclick="fn_listarBuscar();" id="reporte_documento-tab" data-bs-toggle="tab" href="#reporte_documento" aria-controls="reporte_documento" role="tab" aria-selected="false">
							LISTAR REGISTROS
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="crear_documento" aria-labelledby="crear_documento-tab" role="tabpanel">
						<form action="javascript:fn_guardarFam();" id="frmRegistroFam" novalidate>
							<div class="row">
								<div class="col-md-9 p-2 border-end">
									<div class="row">
										<div class="col-lg-6">
											<div class="input-group mb-3">
												<span class="input-group-text">Tipo fam: </span>
												<select name="cod_tipo" id="cod_tipo" class="form-control" required>
													<option value="">Seleccione...</option>
													<?php
													foreach ($tipo_fam  as $row) { ?>
														<option value="<?php echo $row['cc_codigo'] ?>"><?php echo $row['detalle'] ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="input-group mb-3">
												<span class="input-group-text">Fecha: </span>
												<input type="date" class="form-control" id="fecha" name="fecha" value="<?= fecha_hoy() ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-10">
											<div class="input-group mb-3">
												<input type="hidden" class="form-control" id="cc_persona" name="cc_persona" value="">
												<input type="text" class="form-control" id="nombre" name="nombre" placeholder="CEP o Apellidos y Nombres" value="" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-11">
											<div class="input-group mb-3">
												<span class="input-group-text">Observación : </span>
												<input type="text" class="form-control" id="referencia" name="referencia" placeholder="Referencia" oninput="contar_actividad()" maxlength="90" value="">
												<small id="charCount">0/90</small>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="row border-bottom mb-1"></div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-7">
											<div class="input-group mb-3">
												<span class="input-group-text">Cuenta : </span>
												<select name="c_banco" id="c_banco" class="form-control" required>
													<option value="">Seleccione...</option>
													<?php
													foreach ($data_cta  as $row) { ?>
														<option value="<?php echo $row['banco_cta'] ?>"><?php echo $row['nombre'] . ' ' . $row['c_cta_corriente'] ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-4">
											<div class="input-group mb-3">
												<span class="input-group-text">Monto S/. : </span>
												<input type="text" class="form-control input-pen" id="monto" name="monto" placeholder="0.00" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-7">
											<div class="input-group mb-3">
												<span class="input-group-text">Fecha Ope : </span>
												<input type="date" class="form-control" id="fecha_operacion" name="fecha_operacion" placeholder="" required>
											</div>
										</div>
										<div class="col-lg-5">
											<div class="input-group mb-3">
												<span class="input-group-text">N° Ope : </span>
												<input type="text" class="form-control" id="operacion" name="operacion" placeholder="" required>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 text-center">
											<input type="hidden" name="cc_local" id="cc_local" value="<?php echo $cc_local ?>">
											<?= bt_guardar(); ?> <?= bt_cancelar(); ?>
										</div>
									</div>
								</div>
								<div class="col-md-3 p-2">
									<div class="alert alert-danger d-flex" role="alert">
										<i class="bx bx-error-circle fs-18 flex-shrink-0 me-2"></i>
										<div>
											<strong>Comunicado importante</strong><br>
											Revise cuidadosamente la información antes de guardar. Los datos registrados no podrán ser modificados.<br>
											Cualquier corrección deberá ser solicitada mediante documento dirigido al Consejo Nacional, a nombre de la Decana Nacional, con sustento válido.<br>
											<strong>Tenga en cuenta que el apoyo FAM es otorgado por única vez a cada miembro de la Orden.</strong>
										</div>
									</div>
								</div>
							</div>
						</form>
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