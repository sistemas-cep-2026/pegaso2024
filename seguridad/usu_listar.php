 <?php
	require_once(dirname(__DIR__) . "/util/seguridad.php");
	require_once(dirname(__DIR__) . "/util/util.php");
	require_once(u_src() . "bo/bo_general.php");
	require_once(u_src() . "bo/bo_gen_parametro_det.php");
	require_once(u_src() . "bo/bo_seg_usuarios.php");
	s_validar_pagina();
	//$cc_local=s_local();
	$bo_general = new bo_general();
	$bo_usuarios = new bo_seg_usuarios();
	$bo_gen_parametro_det = new bo_gen_parametro_det();

	$ent_usuarios = new seg_usuarios();

	$data_estado = $bo_gen_parametro_det->listarParametroDet('seg_usuarios', 'flag');


	// si viene un valor explícito en el filtro (incluido '28'), se respeta tal cual:
	// '28' es el Consejo Nacional, un local real con sus propios usuarios, no un
	// comodín de "sin filtro". Solo cuando NO llega ningún filtro y el usuario de
	// sesión es el admin general, se muestra el consolidado de todos los consejos.
	if (isset($_REQUEST['cc_local'])) {
		$cc_local = $_REQUEST['cc_local'];
	} else {
		$cc_local = (s_local() === '28') ? '' : s_local();
	}
	$usuario = isset($_REQUEST['usuario']) ? $_REQUEST['usuario'] : '';
	$flag = isset($_REQUEST['flag']) ? $_REQUEST['flag'] : '';
	$nombres = isset($_REQUEST['nombres']) ? $_REQUEST['nombres'] : '';

	$ent_usuarios->setCc_local($cc_local);
	$ent_usuarios->setUsuario($usuario);
	$ent_usuarios->setFlag($flag);
	$ent_usuarios->setNombre($nombres);

	$data_usuarios = $bo_usuarios->listar($ent_usuarios);
	?>
 <div class="table-responsive table-card mb-1">
 	<table class="table table-nowrap align-middle" id="table_usuarios">
 		<thead class="text-muted table-light">
 			<tr class="text-uppercase">
 				<th>#</th>
 				<th>Fec. Reg.</th>
 				<th>Usuario</th>
 				<th>Nombre</th>
 				<th>CR</th>
 				<th>Fec. Blo.</th>
 				<th>Estado</th>
 				<th>OPCION</th>
 			</tr>
 		</thead>
 		<tbody>
 			<?php
				$i = 1;
				foreach ($data_usuarios as $row) { ?>
 				<tr>
 					<td><?php echo $i ?></td>
 					<td><?php echo $row['fecha_registro'] ?></td>
 					<td><?php echo $row['usuario'] ?></td>
 					<td><?php echo $row['nombre'] ?></td>
 					<td><?php echo $row['cc_local_text'] ?></td>
 					<td><?php echo $row['fecha_bloqueo'] ?></td>
 					<td><?php
							$color_estado = [
								'A' => 'success',
								'I' => 'danger'
							];
							echo u_estado($row["flag_text"], $color_estado[$row['flag']]);/*s_crypt(*/
							?></td>
 					<td class="text-end">
 						<a href="#" onclick="fn_control('<?php echo s_crypt($row['usuario'], 'in'); ?>', '<?php echo s_crypt('U', 'in') ?>')"
 							class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
 							<i class="fas fa-edit"></i>
 						</a>
 						<?php if ($row['flag'] === 'A'): ?>
 							<a href="#" onclick="fn_Anular('<?php echo s_crypt($row['usuario'], 'in'); ?>', '<?php echo s_crypt('A', 'in'); ?>')"
 								class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Bloquear usuario">
 								<i class="fas fa-lock fs-13"></i>
 							</a>
 						<?php else: ?>
 							<span class="btn btn-sm btn-soft-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="Usuario bloqueado">
 								<i class="fas fa-ban fs-13"></i>
 							</span>
 						<?php endif; ?>

 						<a href="#" onclick="fn_controlClave('<?php echo s_crypt($row['usuario'], 'in'); ?>', '<?php echo s_crypt('C', 'in'); ?>')"
 							class="btn btn-sm btn-soft-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Reiniciar clave">
 							<i class="fas fa-key fs-13"></i>
 						</a>
 					</td>
 				</tr>
 			<?php $i++;
				} ?>
 		</tbody>
 	</table>
 </div>