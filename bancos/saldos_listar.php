<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");

s_validar_pagina();

require_once(u_src() . "bo/bo_banc_saldos_bancos_cuentas.php");

$bo_saldos = new bo_banc_saldos_bancos_cuentas();
$ent_saldos = new banc_saldos_bancos_cuentas();

$cc_local = s_local_vinculado() ?? '';
$cod_anho = $_REQUEST['cod_anho'] ?? '';
$c_banco_filtro = $_REQUEST['c_banco'] ?? '';

$c_banco = substr($c_banco_filtro, 0, 6);
$cuenta = substr($c_banco_filtro, 7);

$ent_saldos->setCc_local($cc_local);
$ent_saldos->setCod_ano($cod_anho);
$ent_saldos->setC_banco($c_banco);
$ent_saldos->setC_cta_cte($cuenta);

$data = $bo_saldos->listar($ent_saldos);

?>

<div class="table-responsive">
	<div class="d-flex justify-content-between align-items-center mb-3">
		<div>
		</div>
		<div>
			<button type="button" class="btn btn-success" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal" onclick="fn_control('','<?php echo s_crypt('I', 'in'); ?>','<?php echo $c_banco_filtro; ?>')">
				<i class="ri-add-line align-bottom me-1"></i>
				Nuevo Saldo
			</button>
		</div>
	</div>

	<table class="table table-hover table-sm align-middle" id="table-cajachica">
		<thead class="table-light">
			<tr>
				<th style="width:60px;">#</th>
				<th> PERIODO </th>
				<th> BANCO / CUENTA </th>
				<th class="text-end"> SALDO FINAL </th>
				<th class="text-end" style="width:130px;"> OPCIONES </th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			if (!empty($data)) {
				foreach ($data as $row) {
					$cc_saldo = $row['cc_saldo'] ?? '';
					$fecha = $row['fecha'] ?? '';
					$nombre = $row['nombre'] ?? '';
					$cuenta = $row['c_cta_cte'] ?? '';
					$c_anho = $row['c_anho'] ?? '';
					$c_mes = $row['c_mes'] ?? '';
					$saldo_final = (float)($row['saldo_final'] ?? 0);
			?>
					<tr>
						<td> <?php echo $i++; ?> </td>

						<td> <?php echo htmlspecialchars($fecha) . ' (' . $c_anho . '/' . $c_mes . ')'; ?> </td>
						<td> <?php echo htmlspecialchars($nombre . ' => ' . $cuenta); ?> </td>
						<td class="text-end fw-semibold"> <?php echo decimal_millar($saldo_final, 2); ?> </td>
						<td class="text-end">
							<button type="button" class="btn btn-sm btn-soft-primary" title="Modificar saldo" onclick="fn_control('<?php echo s_crypt($cc_saldo, 'in'); ?>',
                                    '<?php echo s_crypt('U', 'in'); ?>')">
								<i class="fas fa-edit me-1"></i>
							</button>
						</td>
					</tr>
				<?php

				}
			} else {
				?>
				<tr>
					<td colspan="5" class="text-center text-muted py-4">
						<i class="ri-information-line me-1"></i>
						No se encontraron saldos registrados.
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>