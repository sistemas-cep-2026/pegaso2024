<?php

require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");

s_validar_pagina();

require_once(u_src() . "bo/bo_banc_comprobantes_de_caja.php");
require_once(u_src() . "bo/bo_banc_items_comprobantes_de_caja.php");
require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_gen_parametro_det.php");

$bo_cab = new bo_banc_comprobantes_de_caja();
$bo_det = new bo_banc_items_comprobantes_de_caja();

$bo_ent = new banc_comprobantes_de_caja();
$bo_ent_det = new banc_items_comprobantes_de_caja();

$bo_general = new bo_general();
$bo_parametro_detalle = new bo_gen_parametro_det();

$cc_documento = s_crypt($_REQUEST['cod'] ?? '', 'out');

$bo_ent->setCc_documento($cc_documento);
$bo_ent_det->setCc_documento($cc_documento);

$periodo = '';
$cod_ano = '';
$cod_mes = '';
$cc_local = '';
$cc_local_text = '';
$proveedor = '';
$ruc = '';
$c_liquidacion_caja_chica = '';
$fecha_creacion = '';
$fecha = '';
$monto = 0;
$usuario = '';
$c_forma_cancelacion = '';
$cod_ingreso_egreso = '';
$observacion = '';
$observacion2 = '';
$banco_text = '';
$c_cuenta_pcge2014 = '';
$fecha_anul = '';
$num_boleta_cheque = '';
$flag_text = '';
$flag_text_cancelado = '';

$data = $bo_cab->listarID($bo_ent);

foreach ($data as $cab) {

	$cc_documento = $cab['cc_documento'] ?? '';
	$periodo = ($cab['cod_mes'] ?? '') . ' / ' . ($cab['cod_ano'] ?? '');

	$cod_ano = $cab['cod_ano'] ?? '';
	$cod_mes = $cab['cod_mes'] ?? '';
	$cc_local = $cab['c_local'] ?? '';

	$proveedor = $cab['nombre_completo'] ?? '';
	$ruc = $cab['ruc'] ?? '';

	$c_liquidacion_caja_chica = $cab['c_liquidacion_caja_chica'] ?? '';

	$fecha_creacion = $cab['fecha_creacion'] ?? '';
	$fecha = $cab['fecha_documento'] ?? '';

	$monto = $cab['monto'] ?? 0;
	$usuario = $cab['usuario'] ?? '';

	$c_forma_cancelacion = $cab['c_forma_cancelacion'] ?? '';
	$cod_ingreso_egreso = $cab['cod_ingreso_egreso'] ?? '';

	$observacion = $cab['observacion'] ?? '';
	$observacion2 = ' /*/ '.$cab['observacion2'] ?? '';

	$banco_text = $cab['banco_text'] ?? '';
	$c_cuenta_pcge2014 = $cab['c_cuenta_pcge2014'] ?? '';

	$fecha_anul = $cab['fecha_anul'] ?? '';
	$num_boleta_cheque = $cab['num_boleta_cheque'] ?? '';

	$flag_text = $cab['flag_text'] ?? '';
	$flag_text_cancelado = $cab['flag_text_cancelado'] ?? '';
}

$data_bancos = $bo_general->ListarcuentasBancarias($cc_local, '', '');
$data_local = $bo_general->RegionID($cc_local);

foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'] ?? '';
}

if (trim($cod_ingreso_egreso) === 'I') {
	$cod_ingreso_egreso_text = 'INGRESO';
	$color_ie = '#198754';
	$bg_ie = '#e9f7ef';
} else {
	$cod_ingreso_egreso_text = 'EGRESO';
	$color_ie = '#dc3545';
	$bg_ie = '#fbeaec';
}

foreach ($data_bancos as $ban) {

	if (trim($banco_text) === trim($ban['banco_cta'] ?? '')) {
		$banco_text = trim($ban['nombre'] ?? '') . ' ==> ' . trim($ban['c_cta_corriente'] ?? '');
		break;
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>SISTEMAS || COLEGIO DE ENFERMEROS DEL PERÚ</title>
	<link rel="icon" href="<?php echo url('images/logo_print.jpg'); ?>">
	<link rel="stylesheet" href="<?php echo url('css/print.css'); ?>">

</head>

<body class="bg-dark my-2">
	<div class="page bg-white">
		<div class="row align-items-center mb-2">
			<div class="col-4 d-flex align-items-center">
				<img src="<?php echo url('images/logo_print.jpg'); ?>" width="70" class="me-2" alt="Logo">
				<div>
					<div class="fw-bold fs-6">
						COMPROBANTE DE BANCO
					</div>
					<div class="fw-bold">
						<?php echo $cc_local_text; ?>
					</div>
				</div>

			</div>

			<div class="col-4 text-center">
				<div style="display:inline-block; padding:6px 20px; border:2px solid <?php echo $color_ie; ?>; border-radius:6px; background-color: <?php echo $bg_ie; ?>;">
					<span style="font-size:18px; font-weight:bold; color: <?php echo $color_ie; ?>; letter-spacing:1px;">
						<?php echo $cod_ingreso_egreso_text; ?>
					</span>
				</div>
			</div>

			<div class="col-4 text-end">
				<div style="display:inline-block; padding:6px 16px; border:2px solid #000; border-radius:6px; text-align:center;">
					<div style="font-size:11px; font-weight:bold; letter-spacing:1px;"><?php echo $c_forma_cancelacion; ?></div>
					<div style="font-size:9px; color:#555; margin-top:2px;">N° OPERACIÓN</div>
					<div style="font-size:20px; font-weight:bold; line-height:1.1;"><?php echo digitos($num_boleta_cheque, 7); ?></div>
				</div>
			</div>
		</div>
		<div style="font-size:12px; letter-spacing:1px;">
			<div>
				<strong>PERIODO :</strong>
				<?php echo $periodo; ?>
				<strong>FECHA :</strong>
				<?php echo $fecha; ?>
			</div>

			<div>
				<strong>ID :</strong>
				<?php echo digitos($cc_documento, 7); ?>
			</div>
			<div>
				<strong>CUENTA :</strong>
				<?php echo $banco_text; ?>
			</div>
			<div>
				<strong>GIRADO A :</strong>
				<?php echo $proveedor; ?>
			</div>
			<div>
				<strong>REF :</strong>
				<?php echo $observacion.$observacion2 ; ?>
			</div>
		</div>
		<table class="table table-sm table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>CUENTA</th>
					<th>C. NOMBRE</th>
					<th>ENTIDAD - NOMBRE</th>
					<th>NUMERO</th>
					<th>DEBE</th>
					<th>HABER</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$data_detalle = $bo_det->ListarIdComprobante($bo_ent_det);
				$total = 0;
				$i = 1;
				foreach ($data_detalle as $det) {
					$monto_detalle = (float)($det['monto'] ?? 0);
					$total += $monto_detalle;

				?>
					<tr>
						<td> <?php echo $i++; ?> </td>
						<td> <?php echo $det['c_cuenta'] ?? ''; ?> </td>
						<td> <?php echo $det['nombre_cuenta'] ?? ''; ?> </td>
						<td> <?php echo $det['nombre_completo'] ?? ''; ?> </td>
						<td> <?php echo ($det['cod_documento'] ?? '') . '-' . ($det['num_documento'] ?? ''); ?></td>
						<?php if( (trim($cod_ingreso_egreso) === 'I')){ ?>
						<td></td>
						<td class="text-end">
							<?php echo decimal_millar($monto_detalle, 2); ?>
						</td>
					
						<?php }else{ ?>

						<td class="text-end">
							<?php echo decimal_millar($monto_detalle, 2); ?>
						</td>
<td></td>						
						<?php } ?>

					</tr>
				<?php } ?>
				<tr>
					<td></td>
					<td> <?php echo $c_cuenta_pcge2014; ?> </td>
					<td> <?php echo $banco_text; ?> </td>
					<td></td>
					<td> <?php echo $num_boleta_cheque; ?> </td>
					<?php if( (trim($cod_ingreso_egreso) === 'I')){ ?>
		
					<td class="text-end"> <?php echo decimal_millar($total, 2); ?> </td>
								<td></td>
					<?php }else{ ?>
					<td></td>
					<td class="text-end"> <?php echo decimal_millar($total, 2); ?> </td>
					
<?php } ?>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="5" class="text-end">
						TOTAL =>
					</th>
					<th class="text-end">
						<?php echo decimal_millar($total, 2); ?>
					</th>
					<th class="text-end">
						<?php echo decimal_millar($total, 2); ?>
					</th>
				</tr>
			</tfoot>
		</table>

		<div class="row mt-5 text-center">
			<div class="col-4">
				DECANATO
				<div class="border" style="height:80px;"></div>
			</div>
			<div class="col-4">
				TESORERIA
				<div class="border" style="height:80px;"></div>
			</div>
			<div class="col-4">
				CONTADOR
				<div class="border" style="height:80px;"></div>
			</div>
		</div>
		<div class="mt-3">
			CREADO:
			<?php echo $fecha_creacion; ?>
			<?php echo $usuario; ?>
			<br>
			PRINT:
			<?php echo fecha_hora_hoy(); ?>
			(<?php echo s_usuario(); ?>)
		</div>
	</div>
</body>

</html>