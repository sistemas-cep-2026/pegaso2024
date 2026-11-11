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
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'];
}

$dia = ultimo_dia($periodo, $anho);
$dia = $dia . '/' . $periodo . '/' . $anho . ' 23:59:59';
$data = $bo_bancos_comp->estado_cheques($cc_local, $c_banco, $anho, $periodo, $tipo, $dia);

// número de cuenta real, sin depender de que el código de banco tenga
// siempre 6 caracteres (formato guardado: "codigoBanco-numeroCuenta")
$partes_banco = explode('-', $c_banco, 2);
$data_bancos = $bo_general->ListarcuentasBancarias(s_local_vinculado(), $partes_banco[0] ?? '', $partes_banco[1] ?? '');
foreach ($data_bancos as $cabt) {
	$c_banco = $cabt["c_banco"];
	$nombre_banco = $cabt["nombre"];
	$c_cta_corriente = $cabt["c_cta_corriente"];
}

$opciones_tipo = [
	'P' => 'PENDIENTES',
	'C' => 'COBRADOS',
	'A' => 'ANULADOS',
	'%' => 'TODOS'
];
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="<?php echo url('css/style_print.css'); ?>">
	<title>COLEGIO DE ENFERMEROS DEL PERÚ</title>

</head>

<body class="portrait">
	<h3 class="solo-impresion">
		<div>CHEQUES: <?php echo $opciones_tipo[$tipo] ?? 'TODOS'; ?> - <?php echo $cc_local_text ?></div>
		<div>BANCO=&gt;<strong> <?php echo $nombre_banco ?> / <?php echo $c_cta_corriente; ?></strong></div>
		<div>PERIODO=&gt;<strong><?php echo $anho . '-' . $periodo; ?></strong></div>
	</h3>

	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<td>#</td>
				<td>CH</td>
				<td>FECHA</td>
				<td>REF.- OBS.</td>
				<td>COBRADO EL</td>
				<td>MONTO</td>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			$m = 0;
			foreach ($data as $d) {
				$m = $m + $d["monto"];
				$i++;
			?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $d["num_boleta_cheque"] ?></td>
					<td><?php echo $d["fecha1"] ?></td>
					<td><?php echo $d["observacion"] . ' - ' . $d["observacion2"]; ?></td>
					<td><?php echo $d["fecha_concluir"] ?></td>
					<td align="right"><?php echo decimal($d["monto"], 2); ?></td>
				</tr>
			<?php } ?>

			<!-- Fila de totales -->
			<tr class="total-row">
				<td colspan="4"></td>
				<td class="text-right">TOTAL=&gt;</td>
				<td align="right"><?php echo decimal($m, 2); ?></td>
			</tr>

			<!-- Fila de footer -->
			<tr class="footer-row">
				<td colspan="6">
					<?php echo $nombre_banco . ' / ' . $c_cta_corriente . ' (' . $anho . '-' . $periodo . ')   ***  PRINT: ' . fecha_hora_hoy() . ' - ' . s_usuario(); ?>
				</td>
			</tr>
		</tbody>
	</table>

	<div style="text-align: center; margin-top: 20px;">
		<button onclick="window.print();">
			<i class="bi bi-printer"></i> Imprimir
		</button>
	</div>

</body>

</html>