<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_personas.php");

s_validar_pagina();

$bo_general = new bo_general();

$bo_gen_personas = new bo_gen_personas();
$ent = new gen_personas();



$ruc = isset($_REQUEST['_ruc']) ? $_REQUEST['_ruc'] : '';

$razon = isset($_REQUEST['_razon']) ? $_REQUEST['_razon'] : '';
$num_documento = isset($_REQUEST['_num_documento']) ? $_REQUEST['_num_documento'] : '';
//echo $ruc.' '.$razon;

$ent->setRuc($ruc);
$ent->setNombre($razon);
$ent->setNum_documento($num_documento);

$data  = $bo_gen_personas->listar_proveedores($ent);

?>
<div class="table-responsive table-card mb-1">
	<table class="table table-nowrap align-middle" id="table_personas">
		<thead class="text-muted table-light">
			<tr class="text-uppercase">
				<th>#</th>
				<th>FECHA CREACION</th>
				<th>RUC - DNI</th>
				<th>RAZON</th>
				<th>MAIL</th>
				<th>CEL</th>
				<th>OPCION</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach ($data as $row) { ?>
				<tr>
					<td><?php echo $row['c_persona']  ?></td>
					<td><?php echo $row['fecha_de_registro'] . '-' . $row['usuario']; ?></td>
					<td><?php echo $row['ruc'] . '-' . $row['num_documento']; ?></td>
					<td><?php echo $row['nombre'] ?></td>
					<td><?php echo $row['email1'] ?></td>
					<td><?php echo $row['celular1'] ?></td>

					<td class="text-center">
						<?php if (!empty($row['c_cmp'])) {
							echo 'CEP: ' . $row["c_cmp"];
						} else {
						?>

							<a href="#" onclick="fn_control('<?php echo s_crypt($row['c_persona'], 'in'); ?>', '<?php echo s_crypt('U', 'in'); ?>')"
								title="Editar"><i class="fas fa-lock-open fs-16"></i>
							</a>
						<?php } ?>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</div>