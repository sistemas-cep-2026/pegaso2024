<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_banc_comprobantes_de_caja.php");
require_once(u_src() . "bo/bo_general.php");

$bo_general = new bo_general();
$bo_bancos_comp = new bo_banc_comprobantes_de_caja();

$ent_bancos_comp = new banc_comprobantes_de_caja();

$cc_local = s_local_vinculado() ?? '';
$anho = $_REQUEST['anho'] ?? '';
$periodo = $_REQUEST['periodo'] ?? '';
$c_banco = $_REQUEST['c_banco'] ?? '';
$tipo = $_REQUEST['tipo'] ?? '';

$data_local = $bo_general->RegionID($cc_local);
$cc_local_text = '';
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'];
}

// número de cuenta real, sin depender de que el código de banco tenga
// siempre 6 caracteres (formato guardado: "codigoBanco-numeroCuenta")
$partes_banco = explode('-', $c_banco, 2);
$cod_banco_sel = $partes_banco[0] ?? '';
$cta_banco_sel = $partes_banco[1] ?? '';

$data = $bo_bancos_comp->libro_banco_data($cc_local, $c_banco, $anho, $periodo, $tipo);

$x = ($anho * 100) + $periodo;
$data_si = $bo_bancos_comp->libro_banco_saldoinicial($cta_banco_sel, $x);
$inicial_banco = 0;
$inicial = 0;
foreach ($data_si as $saldo) {
	$inicial_banco = $saldo["movimiento"];
	$inicial = $saldo["movimiento"];
}

$data_saldo = $bo_bancos_comp->saldo_banco($cod_banco_sel, $cta_banco_sel, $anho, $periodo);
$saldo_final = 0;
$cheques = 0;
foreach ($data_saldo as $saldo) {
	$saldo_final = $saldo["saldo_final"];
	$cheques = $saldo["cheques"];
}
$data_bancos = $bo_general->ListarcuentasBancarias(s_local_vinculado(), $cod_banco_sel, $cta_banco_sel);
$nombre_banco = '';
$c_cta_corriente = '';
foreach ($data_bancos as $cabt) {
	$c_banco = $cabt["c_banco"];
	$nombre_banco = $cabt["nombre"];
	$c_cta_corriente = $cabt["c_cta_corriente"];
}

// cheques girados y aún pendientes de cobro según el banco (mismo criterio
// que usa rep_cheques_listar.php con tipo='P'), para la conciliación de abajo
$dia = ultimo_dia($periodo, $anho);
$dia = $dia . '/' . $periodo . '/' . $anho . ' 23:59:59';
$data_cheques_pendientes = $bo_bancos_comp->estado_cheques($cc_local, $c_banco, $anho, $periodo, 'P', $dia);
$saldo_cheques = 0;
foreach ($data_cheques_pendientes as $chp) {
	$saldo_cheques += (float) ($chp['monto'] ?? 0);
}

// no se oculta ninguna columna en este reporte; se deja el mecanismo por si
// en el futuro se necesita condicionar la visibilidad de alguna columna
$hidden = '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?php echo url('css/style_print.css'); ?>">
	<title>COLEGIO DE ENFERMEROS DEL PERÚ</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			font-size: 14px;
			margin: 15px;
		}

		h3, h5 {
			font-size: 12px;
			margin: 5px 0;
			line-height: 1.5;
		}

		table {
			width: 100%;
			border-collapse: collapse;
			font-size: 10px;
			margin-bottom: 10px;
		}

		th,
		td {
			font-size: 10px;
			padding: 5px 8px;
			border: 1px solid #ddd;
		}

		thead {
			background-color: #e9ecef;
		}

		thead th,
		thead td {
			font-weight: bold;
			background-color: #dee2e6;
			text-align: center;
		}

		tbody tr:nth-child(even) {
			background-color: #f8f9fa;
		}

		tbody tr:hover {
			background-color: #e7f1ff;
		}

		/* Alineación */
		.text-right,
		td[align="right"],
		th[align="right"] {
			text-align: right !important;
		}

		.text-left,
		td[align="left"],
		th[align="left"] {
			text-align: left !important;
		}

		.text-center,
		td[align="center"],
		th[align="center"] {
			text-align: center !important;
		}

		/* Sin atributo align, por defecto izquierda */
		td[align=""] {
			text-align: left !important;
		}

		/* Número de operación / cheque en fuente monoespaciada, igual que en cheques */
		td:nth-child(5) {
			font-family: 'Courier New', monospace;
		}

		/* Tabla de resumen */
		table[width="0"] {
			width: auto !important;
			margin: 0 auto;
		}

		table[width="0"] td {
			padding: 3px 8px;
			border: none;
			font-size: 10px;
		}

		/* Botón imprimir */
		button {
			background-color: #0d6efd;
			color: white;
			border: none;
			padding: 8px 20px;
			font-size: 12px;
			border-radius: 4px;
			cursor: pointer;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
		}

		button:hover {
			background-color: #0a58ca;
		}

		/* Ocultar botón al imprimir */
		@media print {
			button {
				display: none;
			}

			body {
				margin: 0;
			}
		}

		strong {
			font-weight: bold;
		}

		/* Datos de cabecera: solo visibles al imprimir, no en pantalla */
		.solo-impresion {
			display: none;
		}

		@media print {
			.solo-impresion {
				display: block;
			}
		}

		.cabecera-reporte h5 {
			margin: 0 0 8px 0;
			font-size: 13px;
		}

		.cabecera-reporte div {
			margin-bottom: 3px;
		}
	</style>
</head>

<body class="portrait">
	<div class="solo-impresion cabecera-reporte">
		<h5>ESTADO DE CUENTA BANCARIO - <?php echo htmlspecialchars($cc_local_text) ?></h5>
		<div><strong>BANCO :</strong> <?php echo htmlspecialchars($nombre_banco) ?> / <?php echo htmlspecialchars($c_cta_corriente); ?></div>
		<div><strong>PERIODO :</strong> <?php echo htmlspecialchars($anho . ' - ' . $periodo); ?></div>
		<div><strong>SALDO INICIAL :</strong> <?php echo decimal($inicial_banco, 2); ?></div>
	</div>

	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<td><strong>#</strong></td>
				<td>ID</td>
				<td><strong>FECHA</strong></td>
				<td><strong>TIPO</strong></td>
				<td><strong># OPE/CH.</strong></td>
				<td><strong>OBS.</strong></td>
				<td><strong>MONTO</strong></td>
				<td <?php echo $hidden ?>><strong>SALDO</strong></td>
			</tr>
		</thead>
		<tbody>
			<?php
			$ing = 0;
			$egre = 0;
			$id = 0;
			$c_ingresos_cant = 0;
			$c_egresos_cant = 0;
			$c_cheques = 0;
			$c_ch_anulados = 0;
			foreach ($data as $d) {
				$inicial = $inicial + $d["monto"];
				if ($d["monto"] > 0) {
					$ing = $ing + $d["monto"];
					$c_ingresos_cant = $c_ingresos_cant + 1;
				} else {
					$egre = $egre + $d["monto"];
					$c_egresos_cant = $c_egresos_cant + 1;
				}
				if ($d["c_forma_cancelacion"] == "CH") {
					$c_cheques = $c_cheques + 1;
				}
				if ($d["c_forma_cancelacion"] == "CH" && $d["flag"] == "A") {
					$c_ch_anulados = $c_ch_anulados + 1;
				}
				$id = $id + 1;
			?>
				<tr>
					<td align=""><?php echo $id ?></td>
					<td align=""><a href="<?php echo url('bancos/rep_bancos_print.php?cod=' . s_crypt($d["cc_documento"])); ?>" target="_blank"> <?php echo $d["cc_documento"] ?></a></td>
					<td align=""><?php echo $d["fecha"] ?></td>
					<td align="left"><?php echo $d["cod_ingreso_egreso"] . '-' . $d["c_forma_cancelacion"] ?></td>
					<td><?php echo $d["num_boleta_cheque"]; ?></td>
					<td><?php if ($d["flag"] == "*") {
							echo "";
						} else {
							echo "*ANULADO* ";
						} ?><?php echo substr(($d["Observacion"] . "--" . $d["Observacion2"]), 0, 60) ?></td>
					<td align="right"><?php if ($d["flag"] == "*") {
											echo decimal($d["monto"], 2);
										} else {
											echo "*ANULADO*";
										} ?></td>
					<td align="right" <?php echo $hidden ?>><?php echo decimal($inicial, 2) ?></td>
				</tr>
			<?php } ?>

			<tr>
				<td colspan="6"></td>
				<td>&nbsp;</td>
				<td align="right">=</td>
			</tr>
			<tr>
				<td colspan="6"><?php echo $nombre_banco . ' / ' . $c_cta_corriente . ' (' . $anho . '-' . $periodo . ')   ***  PRINT:' . fecha_hora_hoy() . ' - ' . s_usuario(); ?></td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td>
			</tr>
		</tbody>
	</table>

	<table width="0" align="center" border="0" cellspacing="0">
		<tr>
			<td align="right">CHEQUES GIRADOS==&gt;</td>
			<td align="right"><?php echo $c_cheques ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">CANTIDAD INGRESOS==&gt;</td>
			<td align="right"><?php echo $c_ingresos_cant ?></td>
			<td align="right"></td>
		</tr>
		<tr>
			<td align="right">CHEQUES ANULADOS==&gt;</td>
			<td align="right"><?php echo $c_ch_anulados ?></td>
			<td align="right">&nbsp;</td>
			<td align="right">CANTIDAD EGRESOS==&gt;</td>
			<td align="right"><?php echo $c_egresos_cant ?></td>
			<td align="right"></td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right"></td>
		</tr>
		<tr>
			<td align="right"><strong>SALDO INICIAL==&gt;</strong></td>
			<td align="right"><strong><?php echo decimal($inicial_banco, 2); ?> </strong></td>
			<td width="35" align="right">&nbsp;</td>
			<td align="right" <?php echo $hidden ?>><strong>SALDO FINAL==&gt;</strong></td>
			<td align="right" <?php echo $hidden ?>><strong><?php echo decimal($inicial, 2) ?></strong></td>
			<td align="right" <?php echo $hidden ?>>&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><strong>INGRESO==&gt;</strong></td>
			<td align="right"><strong><?php echo decimal($ing, 2) ?></strong></td>
			<td align="right">&nbsp;</td>
			<td align="right"><strong>CH. PEN. COBRO EXTRACTO==></strong></td>
			<td align="right"><strong><?php echo decimal($saldo_cheques, 2)  ?></strong></td>
			<td align="right">(+)</td>
		</tr>
		<tr>
			<td align="right"><strong>EGRESO==&gt;</strong></td>
			<td align="right"><strong><?php echo decimal($egre, 2) ?></strong></td>
			<td align="right">&nbsp;</td>
			<?php $s = ($saldo_final - $inicial);
			$xx = decimal($s - $saldo_cheques, 2);
			if ($xx == 0) { ?>
				<td align="right"></td>
				<td align="right"></td>
			<?php } else { ?>
				<td align="right" <?php echo $hidden ?>><strong>***ERROR DIF.***==&gt;</strong></td>
				<td align="right" <?php echo $hidden ?>><strong><?php echo $xx ?></strong></td>
				<td align="right" <?php echo $hidden ?>>(+)</td>
			<?php } ?>
		</tr>
		<tr <?php echo $hidden ?>>
			<td align="right"><strong>SALDO FINAL==&gt;</strong></td>
			<td align="right"><strong><?php echo decimal($inicial, 2) ?></strong></td>
			<td align="right">&nbsp;</td>
			<td align="right"><strong>SALDO EXTRACTO==&gt;</strong></td>
			<td align="right"><strong><?php echo decimal($saldo_final, 2) ?></strong></td>
			<td align="right">(=)</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align="right"></td>
			<td align="right"></td>
			<td>&nbsp;</td>
		</tr>
	</table>

	<div style="text-align: center; margin-top: 20px;">
		<button onclick="window.print();">
			<i class="bi bi-printer"></i> 🖨️ Imprimir
		</button>
	</div>

</body>

</html>