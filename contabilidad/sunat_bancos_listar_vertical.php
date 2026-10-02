<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");
require_once(u_src() . "bo/bo_contabilidad_libros.php");

$bo_general = new bo_general();

$bo_libros = new bo_contabilidad_libros();

$cc_local = $_REQUEST['cc_local'];
$anho = $_REQUEST['anho'];
//$desde = $_REQUEST['desde'];
$hasta = $_REQUEST['hasta'];

$desde =  $_REQUEST['hasta'];


$cc_banco = substr($_REQUEST['cc_banco'], 0, 6);
$cc_banco_cuenta = substr($_REQUEST['cc_banco'], 6, 30);


$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'];
}

$listarBancos_texto = $bo_libros->ListarcuentasBancarias($cc_local, $cc_banco, $cc_banco_cuenta);

foreach ($listarBancos_texto as $cabt) {
	$c_banco     = $cabt["c_banco"];
	$nombre_banco  = $cabt["nombre"];
	$c_cta_corriente = $cabt["c_cta_corriente"];
	$cc_contable = $cabt["c_cuenta_pcge2014"];
}

$data_diario_saldo_i = $bo_libros->ListarLibroMayor_saldoincial($cc_local, $anho, $desde, $cc_contable);
foreach ($data_diario_saldo_i as $si) {
	$debe_i = $si['debe_s'];
	$haber_i = $si['haber_s'];
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/style_print.css">
	<title>COLEGIO DE ENFERTMEROS DEL PERÚ</title>
</head>

<body class="portrait">
	<table>
		<thead>
			<tr>
				<td colspan="10" class="titulo">LIBRO CAJA Y BANCOS - DETALLE DE LOS MOVIMIENTOS DE LA CUENTA CORRIENTE </td>
			</tr>
			<tr>
				<td colspan="10">PERIODO: <strong> <?php echo $anho . ' -- DESDE: ' . $desde . ' HASTA: ' . $hasta; ?> </strong> </td>
			</tr>
			<tr>
				<td colspan="10"> BANCO: <strong><?php echo $nombre_banco . ' ' . $c_cta_corriente . ' (' . $cc_contable . ')'; ?></strong></td>
			</tr>
			<tr>
				<td colspan="10">RUC: <strong>20117925375</strong> RAZON SOCIAL: <strong>COLEGIO DE ENFERMERO DEL PERU - <?php echo $cc_local_text ?></strong></td>
			</tr>
			<tr>
				<th rowspan="2" class="tabla-celda_cab">ORDEN</th>

				<th colspan="5" class="tabla-celda_cab">OPERACIONES</th>

				<th colspan="2" class="tabla-celda_cab">CUENTA CONTABLE</th>

				<th colspan="2" class="tabla-celda_cab">SALDOS Y MOVIMIENTOS</th>
			</tr>
			<tr>
				<th class="tabla-celda_cab">FECHA OPE.</th>
				<th class="tabla-celda_cab">MEDIO</th>
				<th class="tabla-celda_cab">DESCRIPCION OPERACION</th>
				<th class="tabla-celda_cab">DENOMINACION</th>
				<th class="tabla-celda_cab col-50">NUMERO TRANSACCION</th>

				<th class="tabla-celda_cab col-60">CUENTA CONTABLE</th>
				<th class="tabla-celda_cab">DENOMINACION</th>

				<th class="tabla-celda_cab">DEUDOR</th>
				<th class="tabla-celda_cab">ACREEDOR</th>
			</tr>
		</thead>
		<tbody>

			<tr>
				<td colspan="8" class="td_oculta_text-20 text-end"><strong>SALDO INICIAL:</strong></td>
				<td class="td_oculta_text-20 col-120 text-end"><strong><?php echo decimal_millar($debe_i, 2); ?></strong></td>
				<td class="td_oculta_text-20 col-120 text-end"><strong><?php echo decimal_millar($haber_i, 2); ?></strong></td>
			</tr>
			<?php


			for ($i = $desde; $i <= $hasta; $i++) {
				$periodo = str_pad($i, 2, "0", STR_PAD_LEFT);
				$data_mayor_detalle = $bo_libros->ListarLibroMayor_detalle($cc_local, $anho, $periodo, $cc_contable, 'B');

				$debe = 0;
				$haber = 0;
				foreach ($data_mayor_detalle as $det) {
					$debe += $det['debe'];
					$haber += $det['haber'];


			?>
					<tr>
						<td class="text-top"> <?php echo $det['numero']; ?> </td>
						<td class="text-top"> <?php echo $det['fecha']; ?> </td>

						<td class="text-top"> <?php if ($det["debe"] > 0) {
													echo '002';
												} else {
													echo '001';
												} ?> </td>

						<td class="td_oculta_text-20 text-top"><?php echo recortarCadena($det['observacion'],16); ?></td>
						<td class="text-top"> <?php echo substr($det['nombre_social'], 0, 15); ?> </td>
						<td class="text-top"> <?php echo $det['cod_documento'] . ' ' . $det['num_documento']; ?> </td>
						<td><?php if ($i > 0 && $i < 13) {
								echo $det["cuenta_origen"];
							} else {
								echo $cc_contable;
							} ?> </td>
						<td><?php if ($i > 0 && $i < 13) {
								echo substr($det["cuenta_origen_n"], 0, 14);
							} else {
								echo substr($c_cta_corriente, 0, 14);
							} ?></td>
						<td class="td_oculta_text-20 col-100 text-end"><?php echo decimal_millar($det['debe'], 2); ?></td>
						<td class="td_oculta_text-20 col-100 text-end"><?php echo decimal_millar($det['haber'], 2); ?></td>
					</tr>
				<?php }	?>
				<tr>
					<td colspan="8" class="text-end"><strong>MOVIMIENTOS PERIODO => <?php echo $regcuenta['cuenta_dato'] . ' ' . $regcuenta['nombre_dato']; ?></strong></td>
					<td class="linea-arriba text-end col-100"><?php echo decimal_millar($debe, 2); ?></td>
					<td class="linea-arriba text-end col-100"><?php echo decimal_millar($haber, 2); ?></td>
				</tr>
				<tr>
					<td colspan="9" class="text-end"><strong>SALDO MOVIMIENTOS PERIODO=></strong></td>
					<td class="linea-arriba text-end col-100"><?php echo decimal_millar($debe - $haber, 2); ?>
				</tr>

				<tr>
					<td colspan="8" class="text-end"><strong>SALDO DEL PERIODO => <?php echo $regcuenta['cuenta_dato'] . ' ' . $regcuenta['nombre_dato']; ?></strong></td>
					<td class="linea-arriba text-end col-100"><?php echo decimal_millar($debe + $debe_i, 2); ?></td>
					<td class="linea-arriba text-end col-100"><?php echo decimal_millar($haber + $haber_i, 2); ?></td>
				</tr>
				<tr>
					<td colspan="9" class="text-end"><strong>TOTAL SALDO DEL PERIODO =></strong></td>
					<td class="linea-arriba text-end col-100"><?php echo decimal_millar(($debe + $debe_i) - ($haber + $haber_i), 2); ?></td>
				</tr>
			<?php }	?>


		</tbody>
	</table>
	<br>
	<div style="text-align: center; margin-bottom: 10px;">
		<button onclick="window.print();">
			<i class="bi bi-printer"></i> Imprimir
		</button>
	</div>
</body>

</html>