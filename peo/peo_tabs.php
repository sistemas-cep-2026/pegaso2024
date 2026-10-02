<?php 
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_peo_ejeestrategico.php");
$bo_ejeestra=new bo_peo_ejeestrategico();
$date_ejeestra=$bo_ejeestra->listar();

$color_estado = [
	'A' => 'success',
	'I' => 'danger'
];

?>
<div class="row">
	<div class="col-xxl-12">
		<div class="card">
			<div class="card-header align-items-center d-flex">
				<h4 class="card-title mb-0 flex-grow-1">Planificación - Plan Estratégico </h4>
			</div>
			<div class="card-body">
				<ul class="nav nav-tabs nav-border-top nav-border-top-primary mb-3" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-bs-toggle="tab" href="#nav-border-top-home" role="tab" aria-selected="false">
							Eje extratégico
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_objetivosIndex();" data-bs-toggle="tab" href="#nav-border-top-objetivos" role="tab" aria-selected="false">
							Objetivos
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="fn_listarIniciativas();" data-bs-toggle="tab" href="#nav-border-top-obiniciativas" role="tab" aria-selected="false">
							Iniciativas
						</a>
					</li>
				</ul>
				<div class="tab-content text-muted">
					<div class="tab-pane active" id="nav-border-top-home" role="tabpanel">
						<div class="d-flex">
							<div class="flex-grow-1 ms-2">
								<table class="table">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">NOMBRE</th>
											<th scope="col">ESTADO</th>
											<th scope="col">ACCIÓN</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=1;
										foreach($date_ejeestra as $row) {?>
											<tr>
												<th scope="row"><?php echo $i ?></th>
												<td><?php echo $row["nombre"] ?></td>
												<td><?php echo u_estado($row["flag_text"], $color_estado[$row['flag']]); ?></td>
												<td>
													<button type="button" title="Editar" data-bs-toggle="tooltip" class="btn btn-icon bg-transparent text-info" ><i class="fa fa-edit"></i></button>
													<button type="button" title="Eliminar" data-bs-toggle="tooltip" class="btn btn-icon bg-transparent text-danger" ><i class="fa fa-trash"></i></button>
												</td>
											</tr>
											<?php $i++;} ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="nav-border-top-objetivos" role="tabpanel">
							<div class="d-flex">
								<div class="flex-grow-1 ms-2">
									<div id="divlistarIndex"></div>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="nav-border-top-obiniciativas" role="tabpanel">
							<div class="d-flex">
								<div class="flex-grow-1 ms-2">
									<div id="divlistarIniIndex"></div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- end card-body -->
			</div>
		</div>
	</div>
	<?php
	$include_scripts = function () {
		return importTypeahead();
	};
?>