<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas_discapacidad.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_parametro_detalle = new bo_gen_parametro_det();
$bo_general = new bo_general();
$bo_discapacidad = new bo_gen_personas_discapacidad();

$ent_discapacidad = new gen_personas_discapacidad();

$tipo = $bo_parametro_detalle->listarParametroDet("gen_personas_discapacidad", "cod_tipo");

$opc         = s_crypt($_REQUEST['opc'] ?? 'I', 'out');
$cc_discapac = s_crypt($_REQUEST['cod'] ?? '', 'out');
$disabled    = '';


if ($opc === 'U') {
	$ent_discapacidad->setCc_discapac($cc_discapac);
	$data_disc = $bo_discapacidad->listarID($ent_discapacidad);

	if (!empty($data_disc)) {
		foreach ($data_disc as $row) {
			$ent_discapacidad->setCc_discapac($row['cc_discapac']);
			$ent_discapacidad->setNombre($row['nombre']);
			$ent_discapacidad->setFecha_crea($row['fecha_registro']);
			$ent_discapacidad->setFecha_registro($row['fecha_conadis']);
			$ent_discapacidad->setCod_tipo($row['cod_tipo']);
			$ent_discapacidad->setReg_conadis($row['reg_conadis']);
			$ent_discapacidad->setObs($row['obs']);
			$ent_discapacidad->setFlag($row['flag']);
		}
		$disabled = 'disabled';
	}
}

?>
<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="d-flex align-items-center">
					<div class="avatar-sm flex-shrink-0 me-3">
						<span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
							<i class="ri-wheelchair-line"></i>
						</span>
					</div>
					<div class="flex-grow-1">
						<h4 class="card-title mb-0">REGISTRO DE INCAPACIDAD</h4>
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
						<form action="javascript:fn_grabarRegistro();" id="frmGrabarRegistro" novalidate>
							<div class="row">
								<div class="col-md-9 p-2 border-end">
									<fieldset <?php echo $disabled; ?>>
										<div class="row">
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<span class="input-group-text">N° Discapacidad-CEP : </span>
													<input type="number" class="form-control" id="cc_discapac" name="cc_discapac" value="<?php echo $ent_discapacidad->getCc_discapac(); ?>" disabled>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="input-group mb-3">
													<span class="input-group-text">Fecha Registro CEP : </span>
													<input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php echo $ent_discapacidad->getFecha_crea(); ?>" disabled>

												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-9">
												<div class="input-group mb-3">
													<input type="hidden" class="form-control" id="c_persona" name="c_persona" value="">
													<input type="text" class="form-control" id="nombre" name="nombre" placeholder="CEP - Apellido y nombres" value="<?php echo $ent_discapacidad->getNombre(); ?>" required>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<span class="input-group-text">Discapacidad : </span>
													<select name="cod_tipo" id="cod_tipo" class="form-control" required>
														<?php foreach ($tipo as $fl) { ?>
															<option value="<?php echo $fl['cc_codigo'] ?>" <?php if ($ent_discapacidad->getCod_tipo() === $fl['cc_codigo']) echo "selected"; ?>>
																<?php echo $fl['detalle'] ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<span class="input-group-text">Reg. Conadis? : </span>
													<input type="number" class="form-control" id="reg_conadis" name="reg_conadis" value="<?php echo $ent_discapacidad->getReg_conadis(); ?>" maxlength="12">

												</div>
											</div>
											<div class="col-lg-4">
												<div class="input-group mb-3">
													<span class="input-group-text">Fecha CONADIS : </span>
													<input type="date" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php echo $ent_discapacidad->getFecha_registro(); ?>" required>

												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="input-group mb-3">
													<span class="input-group-text">Observaciones : </span>
													<input type="text" class="form-control" id="obs" name="obs" value="<?php echo $ent_discapacidad->getObs(); ?>" required maxlength="100">
												</div>
											</div>
										</div>
										<?php if ($opc === 'U') { ?>
											<div class="row">
												<div class="col-lg-12">
													<div class="alert alert-success alert-dismissible fade show" role="alert">
														Operación realizada correctamente.
														<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
													</div>
												</div>
											</div>
										<?php } ?>
									</fieldset>
								</div>

								<div class="col-md-3">
									<div class="mt-md-1">
										<div class="d-grid gap-1">
											<input type="hidden" name="opc" id="opc" value="<?php echo s_crypt('I', 'in') ?>">
											<?php  ?>
											<?php if ($ent_discapacidad->getFlag() == '') { ?>
												<button type="submit" class="waves-effect btn btn-outline-primary">
													<i class="fa fa-chevron-right"></i> Procesar
												</button>
											<?php } else { ?>
												<button class="waves-effect btn btn-outline-info" type="button" onclick="redireccionar('?id=<?php echo s_crypt($id); ?>')">
													<i class="fa fa-times"></i> Nuevo
												</button>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="reporte_documento" aria-labelledby="reporte_documento-tab" role="tabpanel">
						<div id="div_listar"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $include_scripts = function () {
	return importDatatable() . importTypeahead();
} ?>