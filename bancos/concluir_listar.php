<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_banc_saldos_bancos_cuentas.php");
$bo_cajachica = new bo_banc_saldos_bancos_cuentas();

$ent_cajachica = new banc_saldos_bancos_cuentas();

$cc_local = s_local_vinculado() ?? '';
$cod_ano = $_REQUEST['cod_ano'] ?? '';
$cod_periodo = $_REQUEST['cod_periodo'] ?? '';
$bancocta = $_REQUEST['bancocta'] ?? '';
$c_banco = substr($bancocta, 0, 6);
$c_cta     = substr($bancocta, 6);

$ent_cajachica->setCc_local($cc_local);
$ent_cajachica->setCod_ano($cod_ano);
$ent_cajachica->setCod_mes($cod_periodo);
$ent_cajachica->setC_banco($c_banco);
$ent_cajachica->setC_cta_cte($c_cta);
$data_caja  = $bo_cajachica->listar($ent_cajachica);
?>
<div class="table-responsive">
	<table class="table table-hover" id="table-cajachica">
		<thead class="table-light">
			<tr>
				<th>#</th>
				<th>FECHA GIRO</th>
				<th>BANCO</th>
				<th>PERIODO</th>
				<th>REFERENCIA</th>
				<th>FECHA CONCLUSION</th>
				<th class="text-end">MONTO</th>
				<th class="text-end">OPCIONES</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach ($data_caja  as $row) {
			?>
				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo $row["fecha"] ?></td>
					<td><?php echo $row["nombre"] . ' = ' . $row["c_cta_cte"]; ?></td>
					<td><?php echo $row["c_anho"] . ' - ' . $row["c_mes"]; ?></td>
					<td><?php echo $row["c_anho"] . ' - ' . $row["c_mes"]; ?></td>
					<td><?php echo $row["c_anho"] . ' - ' . $row["c_mes"]; ?></td>
					<td class="text-end"><?php echo decimal_millar($row["saldo_final"], 2); ?></td>
					<td class="text-end">
						<button class="btn btn-primary"
							onclick="fn_control('<?php echo s_crypt($row['cc_saldo'], 'in') ?>','<?php echo s_crypt('U', 'in') ?>')">
							<i class='fas fa-edit'></i> Modificar
						</button>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</div>