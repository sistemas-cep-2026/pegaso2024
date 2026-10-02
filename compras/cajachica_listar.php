<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_comp_liquidaciones_caja_chica.php");
$bo_cajachica = new bo_comp_liquidaciones_caja_chica();

$ent_cajachica = new comp_liquidaciones_caja_chica();

$cc_local = s_local_vinculado() ?? '';
//$flag = $_REQUEST['flag'] ?? '';
$anho = $_REQUEST['anho'] ?? '';

//$ent_cajachica->setFlag($flag);
$ent_cajachica->setC_local($cc_local);
//$ent_cajachica->setAnho($anho);
$data_cajchica  = $bo_cajachica->listar($ent_cajachica);

?>
<div class="table-responsive">
	<table class="table table-hover table-sm" id="table-cajachica">
		<thead class="table-light">
			<tr>
				<th>#</th>
				<th>FECHA CREA</th>
				<th>C.CAJA</th>
				<th>N° CHEQUE/OPE</th>
				<th>BANCO</th>
				<th>FEC. OPE.</th>
				<th>NOMBRE</th>
				<th class="text-end">TOTAL CAJA</th>
				<th class="text-end">RENDIDO</th>
				<th class="text-end">SALDO</th>
				<th>ESTADO</th>
				<th>RENDIDO BANCO?</th>
				<th class="text-center">OP</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 1; //
			foreach ($data_cajchica as $row) {
				$ent_cajachica->setC_liquidacion_caja_chica($row["c_liquidacion_caja_chica"]);
				$data_cajchica_rendido  = $bo_cajachica->listar_rendido($ent_cajachica);
				foreach ($data_cajchica_rendido as $rowrendido) {
					$rendido = $rowrendido["rendido"];
				}
			?>
				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo $row["fecha_text"] ?></td>
					<td><?php echo $row["c_liquidacion_caja_chica"] ?></td>
					<td><?php echo digitos($row["nro_cheque"], '6'); ?></td>
					<td><?php echo $row["banco_cta"]; ?></td>
					<td><?php echo $row["fecha_operacion"]; ?></td>
					<td><?php echo $row["nombre"]; ?></td>
					<td class="text-end"><?php echo decimal_millar($row["monto"] + $row["monto_apertura"], 2); ?></td>
					<td class="text-end"><?php echo decimal_millar($rendido, 2); ?></td>
					<td class="text-end"><?php echo decimal_millar($row["monto"] + $row["monto_apertura"] - $rendido, 2); ?></td>
					<td><?php echo u_estado($row["flag_text"], $color_flag_listar[$row["flag"]]); ?></td>
					<td><?php echo u_estado($row["flag_text_bancos"], $color_flag_listar[$row["flag_bancos"]]); ?></td>
					<td class="text-end">
						<div class="dropdown">
							<a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="ri-more-2-fill"></i>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<li><a class="dropdown-item" href="#" onclick="redireccionar_ventana('<?php echo url('compras/cajachica_print?cod=' . s_crypt($row['c_liquidacion_caja_chica'])); ?>',750);">
										<i class='fas fa-print'></i> Imprimir</a></li>
								<?php if ($row["flag"] == '&' && $row["flag_bancos"] == '&'): ?>
									<li><a class="dropdown-item" href="#" onclick="fn_controlCajaChica('<?php echo s_crypt($row['c_liquidacion_caja_chica'], 'in') ?>','<?php echo s_crypt('U', 'in') ?>')"><i class='fas fa-edit'></i> Modificar</a></li>
								<?php endif; ?>
								<?php if ($row["flag"] == '*' && $row["flag_bancos"] == '&'): ?>
									<li><a class="dropdown-item" href="#" onclick="fn_anularRegistroFrom({cc_caja_chica:'<?php echo s_crypt($row['c_liquidacion_caja_chica']) ?>',opc:'<?php echo s_crypt('A') ?>'});"><i class='fas fa-eye'></i> Abrir</a></li>
								<?php endif; ?>
								<?php if ($row["flag"] == '&' && $row["flag_bancos"] == '&'): ?>
									<li><a class="dropdown-item" href="#" onclick="fn_procesarRegistroFrom({cc_caja_chica:'<?php echo s_crypt($row['c_liquidacion_caja_chica']) ?>',opc:'<?php echo s_crypt('P') ?>'});"><i class='fas fa-cog'></i> CerrarCaja</a></li>
								<?php endif; ?>

							</ul>
						</div>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</div>