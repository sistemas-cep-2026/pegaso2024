<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_gen_parametro_det = new bo_gen_parametro_det();
$data_activo = $bo_gen_parametro_det->listarParametroDet('personas', 'flag_activo');
$data_tpdocumen = $bo_gen_parametro_det->listarParametroDet('personas', 'cod_documento');
$data_local = $bo_general->listarRegionesAdministrativo(s_local(), s_usuario());
?>
<div class="row">
	<div class="col-lg-12">
		<div class="card" id="orderList">
			<div class="card-header border-0">
				<div class="row align-items-center gy-3">
					<div class="col-sm">
						<h5 class="card-title mb-0">Reporte de Colegiados</h5>
					</div>
				</div>
			</div>
			<div class="card-body border border-dashed border-end-0 border-start-0 border-bottom-0">
				<form method="post" action="javascript:fn_buscarRegistro();" id="frmBuscarRegistro">
					<div class="row g-3 justify-content-center mb-2">
						<div class="col-xxl-5 col-sm-6">
							<label for="nombres" class="form-label">Nombres</label>
							<input type="text" class="form-control" name="nombres" id="nombres" placeholder="Apellidos y nombres">
						</div>
						<div class="col-xxl-2 col-sm-6">
							<label for="cod_documento" class="form-label">Tipo documento</label>
							<select class="form-select text-uppercase" id="cod_documento" name="cod_documento">
								<option value="">Seleccione...</option>
								<?php
								foreach ($data_tpdocumen as $est) {
								?>
									<option value="<?= $est['cc_codigo']; ?>">
										<?= $est['detalle_corto']; ?>
									</option>
								<?php } ?>
							</select>
						</div>
						<div class="col-xxl-2 col-sm-6">
							<label for="num_documento" class="form-label">Número documento</label>
							<input type="number" class="form-control" name="num_documento" id="num_documento" placeholder="Número documento">
						</div>
						<div class="col-xxl-2 col-sm-6">
							<label for="flag_activo" class="form-label">Estado</label>
							<select name="flag_activo" id="flag_activo" class="form-select text-uppercase">
								<option value="">Seleccione...</option>
								<?php
								foreach ($data_activo as $activo) {
								?>
									<option value="<?= $activo['cc_codigo'] ?>"><?= $activo['detalle']; ?></option>
								<?php
								}
								?>
							</select>
						</div>
					</div>
					<div class="row g-3 justify-content-center mb-2">
						<div class="col-xxl-3 col-sm-6">
                            <label for="c_tipo" class="form-label">CR:</label>
                            <select name="c_local" id="c_local" class="form-select select2">
                                <?php
                                foreach ($data_local as $local_col) {
                                ?>
                                    <option value="<?= $local_col['c_local']; ?>" <?= $local_col['c_local'] === s_local() ? 'selected' : ''; ?>><?= $local_col['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
						<div class="col-xxl-2 col-sm-6">
							<label for="desde" class="form-label">CEP desde</label>
							<input type="number" class="form-control" name="desde" id="desde" placeholder="000000">
						</div>
						<div class="col-xxl-2 col-sm-6">
							<label for="hasta" class="form-label">CEP hasta</label>
							<input type="number" class="form-control" name="hasta" id="hasta" placeholder="000000">
						</div>
					</div>
					<div class="row g-3 justify-content-center">
						<div class="col-xxl-12 text-center">
							<?= bt_buscar(); ?>
							<?= bt_cancelar('Limpiar'); ?>
						</div>
					</div>
				</form>
			</div>
			<div class="card-body pt-2">
				<div id="divListarRegistros" class="table-responsive">
					<table class="table align-middle mb-0 table-hover" id="table_colegiados">
						<thead class="table-light">
							<tr>
								<th class="text-center" colspan="12">
									<h4> REPORTE DE COLEGIADOS<br>
									Usuario <?= s_usuario() ?> <span id="fecha"></span></h4>
								</th>
							</tr>
							<tr>
								<th scope="col">#</th>
								<th scope="col">CEP</th>
								<th scope="col">APELLIDOS Y NOMBRES</th>
								<th scope="col">DOCUMENTO</th>
								<th scope="col">CR</th>
								<th scope="col">FECHA COL.</th>
								<th scope="col">FECHA NACIM.</th>
								<th scope="col">CORREO</th>
								<th scope="col">CELULAR</th>
								<th scope="col">ESTADO</th>
								<th scope="col">HABIL</th>
								<th scope="col" class="text-end">S/D</th>
							</tr>
						</thead>
						<tbody> </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $include_scripts = fn() => importDatatable() . importTypeahead(). importMomentJs(); ?>