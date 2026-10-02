<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");

require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");

$bo_compras = new bo_comp_documentos_de_compras();
$bo_general = new bo_general();
$ent_compras = new comp_documentos_de_compras();

$cc_local = s_local_vinculado();
$anho = s_anho();
$periodo = s_periodo();

$ent_compras->setCc_local($cc_local);
$ent_compras->setCod_ano($anho);
$ent_compras->setCod_mes($periodo);
$ent_compras->setC_liquidacion_caja_chica('1');


$data_compras = $bo_compras->listarReporte($ent_compras);

?>
<div class="table-responsive">
	<table class="table table-hover table-sm" id="table-cjachoca">
		<thead class="table-light">
			<tr>
				<th>#COMP.</th>
				<th>FECHA</th>
				<th>PROVEEDOR</th>
				<th>DOCUMENTO</th>
				<th>D/R</th>
				<th>OBSERVACION</th>
				<th class="text-end">TOTAL</th>
				<th class="text-center">ESTADO</th>
				<th class="text-center">CAJA</th>
				<th class="text-end">OPCIONES</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($data_compras as $row) {
			?>
				<tr>
					<td><?php echo $row['comprobante'] ?></td>
					<td><?php echo $row['fecha_documento'] ?></td>
					<td><?php echo $row['ruc'] . '-' . recortarCadena($row['nombre'], 30) ?></td>
					<td><?php echo $row['cod_documento'] . '&nbsp;&nbsp;&nbsp;' . $row['num_documento'] ?></td>
					<td><?php
						$tipo_desc = trim($row['tipo_desc'] ?? '');

						if ($tipo_desc !== '' && $tipo_desc !== null) {
							$porcentaje = decimal($row['porcentaje'], 0);
							$numero = $row['reten_numero'];
							$fecha = $row['reten_fecha_print'];

							// No mostrar si la fecha es 1900-01-01
							if ($fecha == '1900-01-01' or $fecha == '01/01/1900') {
								$fecha = '';
							}
							$tipo = ($tipo_desc == 'D') ? 'DET.' : 'RET.';
							echo "{$tipo} - {$porcentaje}% * {$numero} * {$fecha}";
						}
						?></td>
					<td class="td_oculta_text-30"><?php echo recortarCadena($row['observacion'], 30) ?></td>
					<td class="text-end"><?php echo decimal_millar($row['total'], 2) ?></td>
					<td class="text-center">
						<span class="badge rounded-pill <?php echo $color_flag_cont[$row["flag"]]; ?>"><?php echo $row["flag_text"]; ?>
					</td>
					<td class="text-center">
						<span class="badge rounded-pill <?php echo $color_flag_cont[$row["flag_caja"]]; ?>"><?php echo $row["c_liquidacion_caja_chica"]; ?>
					</td>
					<td class="text-end">
						<div class="dropdown" data-bs-display="static">
							<a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="ri-more-2-fill"></i>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<li><a class="dropdown-item" href="#" onclick="redireccionar_ventana('<?php echo url('compras/rep_compras_print?cod=' . s_crypt($row['cc_compra'])); ?>',750);"><i class='fas fa-print'></i> Imprimir</a></li>
								<?php if ($row["flag"] <> 'A' && $row["flag_cancelado"] == '&' && $row["flag_caja"] == '&' && $row['adelanto'] == 0.00): ?>
									<li><a class="dropdown-item" href="?id=<?php echo s_crypt('700003') ?>&cod=<?php echo s_crypt($row['cc_compra']) ?>&opc=<?php echo s_crypt('U') ?>"><i class='fas fa-edit'></i> Modificar</a></li>
								<?php endif; ?>
								<?php if ($row["flag"] <> 'A' && $row["flag_cancelado"] == '&' && $row["flag_caja"] == '&' && $row['adelanto'] == 0.00): ?>
									<li><a class="dropdown-item" href="#" onclick="fn_anularRegistroFrom('<?php echo s_crypt($row['cc_compra']) ?>','<?php echo s_crypt('A') ?>');"><i class='fas fa-eye-slash'></i> Anular</a></li>
								<?php endif; ?>

							</ul>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>