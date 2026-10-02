<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_recaud_excelbcp.php");

$bo_recaud_excelbcp = new bo_recaud_excelbcp();

$ent_recaud_excelbcp = new recaud_excelbcp();

$data_recaudo = $bo_recaud_excelbcp->Recaudadora_Excelbcp();


$data_ultimaact = $bo_recaud_excelbcp->ultimaActualizacion();
$fecha_act = $data_ultimaact[0]['ultimo'] ?? null;
?>

<div class="row">
	<div class="col-12">
		<?php if (count($data_recaudo) > 0):	?>
			<div class="row">
				<div class="table-responsive">
					<table class="table table-striped">
						<thead class="table-light">
							<tr>
								<th>#</th>
								<th>Código Depositante</th>
								<th>Dato Adicional</th>
								<th>Fecha</th>
								<th>Hora</th>
								 
								<th>Monto</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 1;
							foreach ($data_recaudo as $row): ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo $row["codigo_depositante"]; ?></td>
									<td><?php echo $row["dato_adicional"]; ?></td>
									<td><?php echo $row["fecha"]; ?></td>
									<td><?php echo $row["hora"]; ?></td>
								 
									<td><?php echo $row["monto"]; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php else: ?>
			<div class="row">
				<div class="col-12">
					<h3 class="text-center">Subir el archivo del BCP <span class="badge bg-danger"></i> <?php echo $fecha_act ?></span>
					</h3>
				</div>
			</div>

			<div class="row justify-content-center">
				<div class="col-lg-10">
					<div class="card-body">
						<form id="formImportar" action="javascript:fn_grabarImportar();" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-lg-7">
									<input type="file" class="form-control" id="archivo" name="archivo" accept=".txt" required>
									<input type="hidden" name="opc" value="I">
								</div>
								<div class="col-lg-5 d-flex align-items-end">
									<div>
										<?php echo bt_guardar("Enviar"); ?>
										<?php echo bt_cancelar(); ?>
									</div>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>

		<?php endif; ?>
	</div>
</div>