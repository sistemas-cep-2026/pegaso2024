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
$c_banco = $_REQUEST['c_banco'] ?? '';

$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'];
}

// número de cuenta real, sin depender de que el código de banco tenga
// siempre 6 caracteres (formato guardado: "codigoBanco-numeroCuenta")
$partes_banco = explode('-', $c_banco, 2);
$cod_banco_sel = $partes_banco[0] ?? '';
$cta_banco_sel = $partes_banco[1] ?? '';

$data = $bo_bancos_comp->saldos_cuenta_banco($cod_banco_sel, $cta_banco_sel);
$data_bancos = $bo_general->ListarcuentasBancarias(s_local_vinculado(), $cod_banco_sel, $cta_banco_sel);
$nombre_banco = '';
$c_cta_corriente = '';
foreach ($data_bancos as $cabt) {
	$c_banco = $cabt["c_banco"];
	$nombre_banco = $cabt["nombre"];
	$c_cta_corriente = $cabt["c_cta_corriente"];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?php echo url('css/style_print.css'); ?>">
	<title>COLEGIO DE ENFERMEROS DEL PERÚ</title>
	<style>
		body {
			font-size: 14px;
		}

		table {
			font-size: 10px;
			width: 100%;
			border-collapse: collapse;
		}

		th,
		td {
			font-size: 10px;
			padding: 4px;
			border: 1px solid #ddd;
		}

		h3,
		h4 {
			font-size: 12px;
		}

		/* ✅ ESTILOS PARA ALINEACIÓN */
		.text-right {
			text-align: right !important;
		}

		.text-left {
			text-align: left !important;
		}

		.text-center {
			text-align: center !important;
		}

		/* ✅ Alineación de columnas numéricas */
		td:nth-child(3),  /* INGRESO */
		td:nth-child(4),  /* EGRESO */
		td:nth-child(5),  /* SALDO */
		td:nth-child(6),  /* SALDO EXTRACTO */
		td:nth-child(7) { /* DIFERENCIA */
			text-align: right !important;
		}

		thead th {
			background-color: #dee2e6;
			font-weight: bold;
		}

		tbody tr:nth-child(even) {
			background-color: #f8f9fa;
		}

		tbody tr:hover {
			background-color: #e7f1ff;
		}

		/* Fila de totales */
		.total-row {
			background-color: #e7f1ff !important;
			font-weight: bold;
			border-top: 2px solid #0d6efd !important;
		}

		.total-row td {
			font-weight: bold;
		}

		/* Footer */
		.footer-row {
			background-color: #f8f9fa !important;
			font-size: 9px;
			color: #666;
		}

		button {
			background-color: #0d6efd;
			color: white;
			border: none;
			padding: 10px 20px;
			font-size: 12px;
			border-radius: 4px;
			cursor: pointer;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
		}

		button:hover {
			background-color: #0a58ca;
		}

		@media print {
			button {
				display: none;
			}

			body {
				margin: 0;
			}
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
	</style>
</head>

<body class="portrait">
	<h3 class="solo-impresion">
		<div>SALDOS POR PERIODO - <?php echo $cc_local_text ?></div>
		<div>BANCO => <strong><?php echo $nombre_banco ?> / <?php echo $c_cta_corriente; ?></strong></div>
	</h3>

	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<th class="text-right">#</th>
				<th class="text-center">PERIODO</th>
				<th class="text-right">INGRESO</th>
				<th class="text-right">EGRESO</th>
				<th class="text-right">SALDO</th>
				<th class="text-right">SALDO EXTRACTO</th>
				<th class="text-right">DIFERENCIA</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			$m_ingreso = 0;
			$m_egreso = 0;
			foreach ($data as $d) {
				$m_ingreso = $m_ingreso + $d["ingreso"];
				$m_egreso = $m_egreso + $d["egreso"];
				$i++;
			?>
				<tr>
					<td class="text-right"><?php echo $i; ?></td>
					<td class="text-center"><?php echo $d["c_ano"] . '-' . $d["cod_mes"]; ?></td>
					<td class="text-right"><?php echo decimal($d["ingreso"], 2) ?></td>
					<td class="text-right"><?php echo decimal($d["egreso"], 2) ?></td>
					<td class="text-right"><?php echo decimal($d["movimiento"], 2) ?></td>
					<td class="text-right"><?php echo decimal($d["saldo_final"], 2) ?></td>
					<td class="text-right"><?php echo decimal($d["movimiento"] - $d["saldo_final"], 2) ?></td>
				</tr>
			<?php } ?>
		</tbody>
		<tfoot>
			<tr class="total-row">
				<td colspan="2" class="text-right">TOTAL=&gt;</td>
				<td class="text-right"><?php echo decimal($m_ingreso, 2) ?></td>
				<td class="text-right"><?php echo decimal($m_egreso, 2) ?></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
				<td class="text-right"></td>
			</tr>
			<tr class="footer-row">
				<td colspan="7" class="text-left">
					<?php echo $nombre_banco . ' / ' . $c_cta_corriente . ' *** PRINT: ' . fecha_hora_hoy() . ' - ' . s_usuario(); ?>
				</td>
			</tr>
		</tfoot>
	</table>

	<div style="text-align: center; margin-top: 20px;">
		<button onclick="window.print();" style="padding: 10px 20px; cursor: pointer;">
			<i class="bi bi-printer"></i> Imprimir
		</button>
	</div>

</body>

</html>