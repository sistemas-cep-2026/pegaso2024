<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_alm_requisicion.php");
$bo_requisicion = new bo_alm_requisicion();

$ent = new alm_requisicion();

$anho = $_REQUEST['anho'] ?? '';
$periodo = $_REQUEST['periodo'] ?? '';

$ent->setAnho($anho);
$ent->setPeriodo($periodo);
$ent->setCc_local(s_local_vinculado());

$userCrea = s_nivel() === 'A' ? '' : s_usuario();
$ent->setUser_crea($userCrea);


$data_hono  = $bo_requisicion->listar($ent);

?>

<div class="table-responsive">
	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<th>#</th>
				<th>FECHA</th>
				<th>DOCUMENTO</th>

				<th>OBS</th>
				<th>ESTADO</th>
				<th class="text-center">OPCIONES</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$estados_color = [
				'T' => 'success',
				'A' => 'danger', // anulado
				'P' => 'warning', // pendiente
				'&' => 'warning', // pendiente
				'*' => 'success', //procesado

			];
			$i = 1; //
			foreach ($data_hono as $row) {
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row["fecha_text"] ?></td>
					<td><?php echo $row["cc_requisicion"]; ?></td>

					<td><?php echo $row["observacion"]; ?></td>
					<td><?php echo u_estado($row["flag_text"], $estados_color[$row["flag"]]); ?></td>
					<td class="text-center">
						
						<a href="#" onclick="fn_imprimir('<?php echo s_crypt($row['cc_requisicion'], 'in') ?>')" 
						class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Vale de Salida"><i class="fas fa-print"></i></a>

						<?php if ( ($row["flag"] === 'P')  || ($row["flag"] === '&')) { ?>
							<a href="?id=<?php echo s_crypt('600004', 'in') ?>&cc_requisicion=<?php echo s_crypt($row['cc_requisicion'], 'in') ?>&opc=<?php echo s_crypt('U', 'in') ?>" 
							class="btn btn-sm btn-soft-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Vale de Salida"><i class="fas fa-edit"></i></a>
						
							<?php if (($row["flag"] === 'P') || ($row["flag"] === '&')) { ?>
							<a href="#" onclick="fn_anularDocumento('<?php echo s_crypt($row['cc_requisicion'], 'in') ?>','<?php echo s_crypt('A', 'in') ?>')" 
							class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Anula Vale de Salida"><i class="fas fa-minus-square"></i></a>
						<?php }
						} ?>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</div>