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
$periodo = $_REQUEST['periodo'];
$tipo = $_REQUEST['tipo'];
$cta_ini = $_REQUEST['cta_ini'];
$cta_fin = $_REQUEST['cta_fin'];


$data_mayor = $bo_libros->ListarLibroMayor_cuentasbase($cc_local, $anho, $periodo, $cta_ini, $cta_fin);
//print_r($data_mayor);
$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'];
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
				<td colspan="6" class="titulo">LIBRO MAYOR: <strong> <?php echo $anho . '-' . $periodo ?> </strong> </td>
			</tr>
			<tr>
				<td colspan="2">RUC: <strong>20117925375</strong> </td>
				<td colspan="4">RAZON SOCIAL: COLEGIO DE ENFERMERO DEL PERU - <strong><?php echo $cc_local_text ?></strong></td>
			</tr>

			<tr>
				<th rowspan="2" class="tabla-celda_cab col-100">FECHA DE LA OPERACION</th>
				<th rowspan="2" class="tabla-celda_cab col-100">NUMERO CORRELATIVO DEL LIBRO</th>
				<th colspan="2" class="tabla-celda_cab col-520">REFERENCIA DE LA OPERACIÓN</th>
				<th colspan="2" class="tabla-celda_cab">SALDOS Y MOVIMIENTOS</th>
			</tr>
			<tr>
				<th class="tabla-celda_cab col-60">DOCUMENTO SUSTENTATORIO</th>
				<th class="tabla-celda_cab col-300">REFERENCIA</th>
				<th class="tabla-celda_cab col-80">DEUDOR</th>
				<th class="tabla-celda_cab col-80">ACREEDOR</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($data_mayor as $mayor) {
			?>
				<tr>
					<td colspan="6" class="text-top"><strong><?php echo $mayor['cuenta_padre'] . ' ' . $mayor['nombre_cuenta']; ?><strong></td>
				</tr>
				<?php
				$debe_cc = 0;
				$haber_cc = 0;

				$data_mayor_cuentas = $bo_libros->ListarLibroMayor_cuentas($cc_local, $anho, $periodo, $mayor['cuenta_padre']);
				$debe_c = 0;
				$haber_c = 0;
				foreach ($data_mayor_cuentas as $regcuenta) {

				?>
					<tr>
						<td colspan="4" class="text-top"><strong><?php echo $regcuenta['cuenta_dato'] . ' ' . $regcuenta['nombre_dato']; ?></strong></td>
					</tr>

					<?php $data_diario_saldo_i = $bo_libros->ListarLibroMayor_saldoincial($cc_local, $anho, $periodo,$regcuenta['cuenta_dato'] );
					foreach ($data_diario_saldo_i as $si) {
						$debe_i = $si['debe_s'];
						$haber_i = $si['haber_s'];
					}
					?>
					<tr>
						<td colspan="4" class="td_oculta_text-20 col-100 text-end"><strong>SALDO INICIAL:</strong></td>
						<td class="td_oculta_text-20 col-100 text-end"><strong><?php echo decimal_millar($debe_i, 2); ?></strong></td>
						<td class="td_oculta_text-20 col-100 text-end"><strong><?php echo decimal_millar($haber_i, 2); ?></strong></td>
					</tr>
					<?php
					$debe = 0;
					$haber = 0;
					$data_mayor_detalle = $bo_libros->ListarLibroMayor_detalle($cc_local, $anho, $periodo, $regcuenta['cuenta_dato'], 'M');
					foreach ($data_mayor_detalle as $det) {
						$debe += $det['debe'];
						$haber += $det['haber'];
						
						
					?>
						<tr>
							<td class="text-top"> <?php echo $det['fecha']; ?> </td>
							<td class="text-top"> <?php echo $det['voucher']; ?> </td>
							<td class="text-top"> <?php echo $det['cod_documento'] . ' ' . $det['num_documento']; ?> </td>
							<td class="td_oculta_text-60 text-top"><?php echo recortarCadena($det['observacion'], 55); ?></td>
							<td class="td_oculta_text-20 col-120 text-end"><?php echo decimal_millar($det['debe'], 2); ?></td>
							<td class="td_oculta_text-20 col-120 text-end"><?php echo decimal_millar($det['haber'], 2); ?></td>
						</tr>
					<?php
					}
					?>
					<tr>
						<td colspan="4" class="text-end"><strong>MOVIMIENTOS PERIODO => <?php echo $regcuenta['cuenta_dato'] . ' ' . $regcuenta['nombre_dato']; ?></strong></td>
						<td class="linea-arriba text-end col-120"><?php echo decimal_millar($debe, 2); ?></td>
						<td class="linea-arriba text-end col-120"><?php echo decimal_millar($haber, 2); ?></td>
					</tr>
					<tr>
						<td colspan="5" class="text-end"><strong>SALDO MOVIMIENTOS PERIODO=></strong></td>
						<td class="linea-arriba text-end col-120"><?php echo decimal_millar($debe - $haber, 2); ?>
					</tr>

					<tr>
						<td colspan="4" class="text-end"><strong>SALDO DEL PERIODO => <?php echo $regcuenta['cuenta_dato'] . ' ' . $regcuenta['nombre_dato']; ?></strong></td>
						<td class="linea-arriba text-end col-120"><?php echo decimal_millar($debe+$debe_i, 2); ?></td>
						<td class="linea-arriba text-end col-120"><?php echo decimal_millar($haber+$haber_i, 2); ?></td>
					</tr>
					<tr>
						<td colspan="5" class="text-end"><strong>TOTAL SALDO DEL PERIODO =></strong></td>
						<td class="linea-arriba text-end col-120"><?php $debe_c=$debe_c+($debe+$debe_i);$haber_c=$haber_c+($haber+$haber_i);echo decimal_millar(($debe+$debe_i) - ($haber+$haber_i), 2); ?></td>
					</tr>

				<?php } ?>
				 
				<tr>
					<td colspan="7" class="text-end">&nbsp;</td>
					
				</tr>
				<tr>
					<td colspan="4" class="text-end"><strong>ACUMULADO => <?php echo $mayor['cuenta_padre'] . ' ' . $mayor['nombre_cuenta']; ?></strong></td>
					<td class="linea-arriba text-end col-120"><?php echo decimal_millar($debe_c, 2); ?></td>
					<td class="linea-arriba text-end col-120"><?php echo decimal_millar($haber_c, 2); ?></td>
				</tr>
				<tr>
					<td colspan="5" class="text-end"><strong>SALDO CUENTA/PERIODO =></strong></td>
					<td class="linea-arriba text-end col-120"><?php echo decimal_millar($debe_c - $haber_c, 2); $debe_c=0; $haber_c=0;?></td>
				</tr>
			<?php
			}
			?>


		
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