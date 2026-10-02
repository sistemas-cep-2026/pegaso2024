<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");

require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");

$bo_compras = new bo_comp_documentos_de_compras();
$bo_general = new bo_general();
$ent_compras = new comp_documentos_de_compras();

$cc_local = $_REQUEST['cc_local'] ?? '';
$anho = $_REQUEST['anho']  ?? '';
$cc_persona = s_crypt($_REQUEST['cc_persona'], 'out') ?? '';


$ent_compras->setCc_local($cc_local);
$ent_compras->setCod_ano($anho);
$ent_compras->setCc_persona($cc_persona);


$data_compras = $bo_compras->listarRepdoc($ent_compras);
?>
<div class="table-responsive">
	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<th>#COMP.</th>
				<th>PERIODO</th>
				<th>FECHA</th>
				<th>REGISTRO</th>
				<th>PROVEEDOR</th>
				<th>DOCUMENTO</th> 
				<th>D/R</th>
				<th>OBSERVACION</th> 
				<th>CAJA</th>
				<th class="text-end">TOTAL</th>
				<th class="text-center">ESTADO</th>
				<th class="text-center">BANCO?</th>
				<th class="text-center">OPCIONES</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($data_compras as $row) {
				?>
				<tr>
					<td><?php echo $row['cc_compra'] ?></td>
					<td><?php echo $row['periodo'] ?></td>
					<td><?php echo $row['fecha_documento'] ?></td>
					<td><?php echo $row['comprobante'] ?></td>
					<td><?php echo $row['ruc'] .'-'.recortarCadena($row['nombre'], 30) ?></td>
					<td><?php echo $row['cod_documento'].'&nbsp;&nbsp;&nbsp;'.$row['num_documento'] ?></td>
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
					<td><?php echo $row['c_liquidacion_caja_chica'] ?></td>
					<td class="text-end"><?php echo decimal_millar($row['total'], 2) ?></td>
					<td class="text-center">
						<span class="badge rounded-pill <?php echo $color_flag_cont[$row["flag"]]; ?>"><?php echo $row["flag_text"]; ?>
					</td>
					<td class="text-center">
						<span class="badge rounded-pill <?php echo $color_flag_cont[$row["flag_cancelado"]]; ?>"><?php echo $row["flag_text_cancelado"]; ?>
					</td>
					<td class="text-center">
						<a class="dropdown-item" href="#" onclick="redireccionar_ventana('<?php echo url('compras/rep_compras_print?cod='.s_crypt($row['cc_compra'])); ?>',750);"><i class='fas fa-print'></i></a>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
