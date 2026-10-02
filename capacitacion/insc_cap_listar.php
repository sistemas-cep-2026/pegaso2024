<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_cap_eventos_inscripcion.php");
require_once(u_src() . "bo/bo_cap_eventos.php");

$bo_general     = new bo_general();
$bo_eventos     = new bo_cap_eventos();
$bo_eventos_det = new bo_cap_eventos_inscripcion();

$ent_eventos = new cap_eventos();
$ent_eventos_det = new cap_eventos_inscripcion();

$cc_evento = $_REQUEST['cc_evento'] ?? null;
$ent_eventos_det->setCc_evento($cc_evento);

$ent_eventos->setCc_evento($cc_evento);

$data_parti = $bo_eventos_det->listarRecaudoBCP($ent_eventos_det);

?>
<div class="table-responsive">
	<form action="javascript:;" id="frm_listaParticipantes" novalidate>
		<table class="table table-hover table-nowrap" id="table-listaParticipantes">
			<thead class="table-light">
				<tr>
					<th>#</th>
					<th>FECHA</th>
					<th>CEP</th>
					<th>NOMBRE</th>
					<th>CORREO</th>
					<th>CELULAR</th>
					<th>OP</th>
					<th class="text-end">MONTO</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				$total = 0;
				$totala = 0;
				foreach ($data_parti as $row) {
					$total += $row['total_distribuir'];
				?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $row['fecha']; ?></td>
						<td><?php echo $row['c_cmp']; ?></td>
						<td><?php echo $row['num_documento'] . ' =>' . $row['nombre_completo']; ?></td>
						<td><?php echo $row['email1']; ?></td>
						<td><?php echo $row['celular1']; ?></td>
						<td><?php echo $row['numero_operacion']; ?></td>
						<td class="text-end"><?php echo decimal($row['total_distribuir'], 2); ?></td>
					</tr>
				<?php $i++;
				} ?>
			</tbody>
			<tfoot class="table-secondary fw-bold">
				<tr>
					<td colspan="7" class="text-end">Total:</td>
					<td class="text-end"><?= decimal($total, 2) ?></td>
				</tr>
			</tfoot>
		</table>
	</form>
</div>