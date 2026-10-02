<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");
require_once(u_src() . "bo/bo_comp_items_documentos_de_compra_cue.php");
require_once(u_src() . "bo/bo_general.php");
$bo_compras = new bo_comp_documentos_de_compras();
$bo_compra_det = new bo_comp_items_documentos_de_compra_cue();

$ent_compras = new comp_documentos_de_compras();
$ent_compras_det = new comp_items_documentos_de_compra_cue();
$bo_general = new bo_general();

$cc_compra = s_crypt($_REQUEST['cod'], 'out');

$ent_compras->setCc_compra($cc_compra);
$ent_compras_det->setCc_compra($cc_compra);

$data_compra = $bo_compras->listarID($ent_compras);

foreach ($data_compra as $cab) {
	$cc_compra = $cab['cc_compra'];
	$tipo_doc = $cab['cod_documento'];
	$num_doc = $cab['cod_documento'] . " " . $cab['num_documento'];
	$fec_emsion = $cab['fecha_documento_print'];
	$fec_venc = $cab['fecha_vencimiento_print'];
	$perido = $cab['cod_mes'] . " / " . $cab['cod_ano'];
	$total = $cab['total'];
	$proveedor = $cab['razon_social'];
	$observacion = $cab['observacion'];
	$porcentaje = $cab['porcentaje'];
	$usuario = $cab['c_usuario_crea'];
	$fecha_creacion = $cab['fecha_creacion'];
	$fecha_creacion_print = $cab['fecha_creacion_print'];
	$cod_ano = $cab['cod_ano'];
	$cod_mes = $cab['cod_mes'];
	$cc_local = $cab['c_local'];
	$comprobante = $cab['comprobante'];
	$error_text = $cab['error_text'];
	$c_liquidacion_caja_chica = $cab['c_liquidacion_caja_chica'];
	$flag_text = $cab["flag_text"];
	$flag_text_cancelado = $cab["flag_text_cancelado"];
	$reten_fecha = $cab["reten_fecha"];
	$reten_numero = $cab["reten_numero"];
	$tipo_desc = $cab["tipo_desc"];
}

$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'];
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SISTEMAS || COLEGIO DE ENFERMEROS DEL PERÚ</title>
	<link rel="icon" href="<?php echo url('images/logo_print.jpg') ?>" type="image/png">
	<link rel="stylesheet" type="text/css" href="<?php echo url('css/print.css'); ?>">
	<style>
		/* ✅ Aumentar tamaño de texto general */
		body {
			font-size: 13px;
			/* Tamaño base más grande */
		}

		table {
			font-size: 12px;
			/* Tablas más grandes */
		}

		th,
		td {
			font-size: 12px;
			/* Celdas más grandes */
		}

		.fs-6 {
			font-size: 14px !important;
			/* Headers más grandes */
		}

		strong {
			font-size: 13px;
			/* Negritas más grandes */
		}

		/* Si necesitas más grande aún, ajusta estos valores:
		body { font-size: 16px; }
		table { font-size: 15px; }
		th, td { font-size: 15px; }
		.fs-6 { font-size: 17px !important; }
		*/
		/* ✅ Texto pequeño para información de footer */
.table-footer-info {
	font-size: 10px;
}

.table-footer-info td {
	font-size: 10px;
	line-height: 1.3;
}

.table-footer-info strong {
	font-size: 10px;
}
	</style>
</head>

<body class="bg-dark my-2">
	<div class="page bg-white">

		<table class="table table-sm table-borderless">
			<tr>
				<th class="col-md-6 fs-6"> CEP - <?php echo $cc_local_text; ?></th>
				<th class="col-md-3 text-end fs-6">PER: <?php echo $perido; ?> </th>
				<th class="col-md-3 text-end fs-6">COMP.: <?php echo digitos($comprobante, 6) ?> </th>
			</tr>

			<tr>
				<td rowspan="3">
					<img src="<?php echo url('images/logo_print.jpg') ?>" width="15%" />
				</td>
				<td colspan="8" class="text-end  fs-6">
					<strong>MODULO DE COMPRAS</strong>
				</td>
			</tr>
			<tr>
				<td colspan="12" class="text-end fs-6">
					<strong><?php echo $flag_text; ?> </strong>
				</td>
			</tr>
		</table>

		<table class="table table-sm table-bordered w-auto mb-0">
			<thead class="table-light">
				<tr>
					<th class="col-md-10">RUC - RAZON SOCIAL</th>
					<th class="col-md-2"># CAJA CH.</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-nowrap"><?php echo $proveedor ?></td>
					<td class="text-nowrap"><?php echo $c_liquidacion_caja_chica ?></td>
				</tr>
			</tbody>
		</table>

		<table class="table table-sm table-bordered w-auto mb-0">
			<thead class="table-light">
				<tr>
					<th>N° DOCUMENTO</th>
					<th>FEC. EMI.</th>
					<th>FEC. VEN.</th>
					<th><?php echo !empty($tipo_desc) ? (($tipo_desc == 'D') ? 'DETRACCION' : 'RETENCION') : ''; ?></th>
					<th class="text-end">V. VENTA</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-nowrap"><?php echo $num_doc ?></td>
					<td class="text-nowrap"><?php echo $fec_emsion ?></td>
					<td class="text-nowrap"><?php echo $fec_venc ?></td>
					<td class="text-nowrap"><?php echo decimal($porcentaje, 0) . "% * ".$reten_numero.' * '.$reten_fecha_print;?></td>
					<td class="text-nowrap text-end">S/. <?php echo decimal_millar($total, 2) ?></td>
				</tr>
			</tbody>
		</table>

		<table class="mb-0">
			<tr>
				<td class="text-nowrap"><strong><?php echo $observacion . '-' . $error_text; ?></strong></td>
			</tr>
		</table>

		<table class="table table-sm">
			<thead class="table-light">
				<tr>
					<th>CUENTA</th>
					<th>NOMBRE DE LA CUENTA</th>
					<th class="text-end"><?php if ($tipo_doc !== 'TT') : ?>
							DEBE
						<?php endif; ?></th>
					<th class="text-end"><?= ($tipo_doc == 'TT') ? 'MONTO' : 'HABER'; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$data_detalle = $bo_compra_det->listaIDCompra($ent_compras_det);
				$total_debe = array_sum(array_column($data_detalle, 'debe'));
				$total_haber = array_sum(array_column($data_detalle, 'haber'));
				foreach ($data_detalle as $det) {
				?>
					<tr>
						<td class="text-nowrap"><?php echo $det['c_cuenta'] ?></td>
						<td class="text-nowrap"><?php echo $det['nombre_cuenta'] ?></td>
						<td class="text-nowrap text-end"><?php if ($tipo_doc !== 'TT') : ?>
								<?php echo decimal_millar($det['debe'], 2) ?>
							<?php endif; ?>
						</td>
						<td class="text-nowrap text-end "><?php echo decimal_millar($det['haber'], 2) ?></td>
					</tr>
				<?php } ?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2" class="text-end">TOTAL => </th>
					<th class="text-end"><?php echo decimal_millar($total_debe, 2) ?></th>
					<th class="text-end"><?php echo decimal_millar($total_haber, 2) ?></th>
				</tr>
			</tfoot>
		</table>

	<table class="table-footer-info">
	<tr>
		<td>
			- Crea User : <strong> <?php echo $fecha_creacion_print; ?> <?php echo $usuario ?> </strong>
			- Print User : <strong> <?php echo fecha_hora_hoy(); ?> <?php echo s_usuario() ?> </strong> <br> 
			<?php echo sistema_vesion().' '.$cc_compra;?>
		</td>
	</tr>
</table>
	</div>
</body>

</html>