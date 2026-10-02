<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_salida.php");
$bo_guiasali = new bo_alm_guias_de_salida();

$ent_guiasali = new alm_guias_de_salida();

$anho = $_REQUEST['anho'] ?? '';
$periodo = $_REQUEST['periodo'] ?? '';

$ent_guiasali->setAnho($anho);
$ent_guiasali->setPeriodo($periodo);
$ent_guiasali->setC_local(s_local_vinculado());

$userCrea = s_nivel() === 'A' ? '' : s_usuario();
$ent_guiasali->setUser_crea($userCrea);


$data_hono  = $bo_guiasali->listar($ent_guiasali);

?>

<div class="table-responsive">
	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<th>#</th>
				<th>FECHA</th>
				<th>DOCUMENTO</th>
				<th>NOMBRE</th>
				<th>OBS</th>
				<th>ESTADO</th>
				<th class="text-center">OPCIONES</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$estados_color = [
				'T' => 'success',
				'A' => 'danger',
				'P' => 'warning',
			];
			$i = 1; //  
			foreach ($data_hono as $row) {
			?>
				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo $row["fecha_text"] ?></td>
					<td><?php echo $row["cc_guia"]; ?></td>
					<td><?php echo $row["nombre"]; ?></td>
					<td><?php echo $row["justificacion"]; ?></td>
					<td><?php echo u_estado($row["flag_text"], $estados_color[$row["flag"]]); ?></td>
					<td class="text-center">
						<a href="#" onclick="fn_imprimir('<?php echo s_crypt($row['cc_guia'], 'in') ?>')" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Print Vale de Salida"><i class="fas fa-print"></i></a>
						<?php if (($row["flag"] === 'P')) { ?>
							<a href="?id=<?php echo s_crypt('600001', 'in') ?>&cc_guia=<?php echo s_crypt($row['cc_guia'], 'in') ?>&opc=<?php echo s_crypt('U', 'in') ?>" class="btn btn-sm btn-soft-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Vale de Salida"><i class="fas fa-edit"></i></a>
							<?php if ($row["flag"] === 'P') { ?>
								<a href="#" onclick="fn_anularDocumento('<?php echo s_crypt($row['cc_guia'], 'in') ?>','<?php echo s_crypt('A', 'in') ?>')" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Anula Vale de Salida"><i class="fas fa-minus-square"></i></a>
						<?php }
						} ?>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</div>