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

$data_diario_saldo_i = $bo_libros->ListarLibroDiario_saldoincial($cc_local, $anho, $periodo);
foreach ($data_diario_saldo_i as $si) {
	$debe_i = $si['debe_s'];
	$haber_i = $si['haber_s'];
}


$data_diario = $bo_libros->ListarLibroDiario($cc_local, $anho, $periodo);
$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre'];
}
//if(count($data_diario)>0){
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/style_print.css">
	<title>COLEGIO DE ENFERTMEROS DEL PERÚ</title>
</head>

<body class="landscape">
	<table>
		 
		<thead>
			<tr>
			<td colspan="6" class="titulo">LIBRO DIARIO - PERIODO:<strong> <?php echo $anho . '-' . $periodo ?> </strong></td>
			</tr>
			<tr>
				<td  colspan="2" >RUC:<strong> 20117925375 </strong></td>
				<td  colspan="4" >RAZON SOCIAL: COLEGIO DE ENFERMERO DEL PERU - <strong><?php echo $cc_local_text ?></strong></td>
			</tr>

			<tr>
				<th rowspan="2" class="tabla-celda_cab col-100">NUMERO CORRELATIVO DEL ASIENTO</th>
				<th rowspan="2" class="tabla-celda_cab col-100">FECHA DE LA OPERACION</th>
				<th rowspan="2" class="tabla-celda_cab col-520">GLOSA O DESCRIPCION DE LA OPERACION</th>
				<th colspan="3" class="tabla-celda_cab col-520">REFERENCIA DE LA OPERACIÓN</th>
				<th colspan="2" class="tabla-celda_cab">CUENTA CONTABLE ASOCIADA A LA OPERACIÓN</th>
				<th colspan="2" class="tabla-celda_cab">MOVIMIENTO</th>
			</tr>
			<tr>
				<th class="tabla-celda_cab col-300">CODIGO DEL LIBRO O REGISTRO</th>
				<th class="tabla-celda_cab col-100">NUMERO CORRELATIVO</th>
				<th class="tabla-celda_cab col-120">NUMERO DEL DOCUMENTO SUSTENTATORIO</th>
				<th class="tabla-celda_cab col-150">CODIGO</th>
				<th class="tabla-celda_cab col-330">DENOMINACION</th>
				<th class="tabla-celda_cab col-100">DEBE</th>
				<th class="tabla-celda_cab col-100">HABER</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="8" class="td_oculta_text-20 col-100 text-end"><strong>ACUMULADOS:</strong></td>
				<td class="td_oculta_text-20 col-100 text-end"><strong><?php echo decimal_millar($debe_i, 2); ?></strong></td>
				<td class="td_oculta_text-20 col-100 text-end"><strong><?php echo decimal_millar($haber_i, 2); ?></strong></td>
			</tr>
			<?php
			$debe = 0;
			$haber = 0;
			foreach ($data_diario as $dia) {
			 
				$debe += $dia['debe'];
				$haber += $dia['haber'];
			?>
				<tr>
					<td class="text-top"><?php  if($dia['minimo']===$dia['linea']){echo $dia['numero'];} ?></td>
					<td class="text-top"><?php  if($dia['minimo']===$dia['linea']){echo $dia['fecha'];} ?></td>
					<td class="td_oculta_text-60 text-top"><?php   if($dia['minimo']===$dia['linea']){ echo recortarCadena($dia['observacion'], 50);} ?></td>
					<td class="td_oculta_text-40 text-top"><?php  if($dia['minimo']===$dia['linea']){ echo $dia['sunat'];} ?></td>
					<td class="text-top"><?php   if($dia['minimo']===$dia['linea']){echo $dia['voucher'];} ?></td>
					<td class="td_oculta_text-60 text-top"><?php  if($dia['minimo']===$dia['linea']){ echo $dia['cod_documento'] . "/" . $dia['num_documento'];} ?></td>
					 
					<td class="td_oculta_text-20 col-100"><?php echo recortarCadena($dia['c_cuenta'], 12); ?></td>
					<td class="col-350 td_oculta_text-60"><?php echo recortarCadena($dia['nombre'], 37); ?></td>
					<td class="td_oculta_text-20 col-100 text-end"><?php echo decimal_millar($dia['debe'], 2); ?></td>
					<td class="td_oculta_text-20 col-100 text-end"><?php echo decimal_millar($dia['haber'], 2); ?></td>
				</tr>
			<?php
				 
			}
			?>
	
	 
			<tr>
				<td colspan="8" class="text-end"><strong>TOTAL ==></strong></td>
				<td class="linea-arriba text-end col-100"><?php echo decimal_millar($debe, 2); ?> </td>
				<td class="linea-arriba text-end col-100"><?php echo decimal_millar($haber, 2); ?></td>
			</tr>
			<tr>
				<td colspan="8" class="text-end"><strong>TOTAL ACUMULADO==> <?php echo $periodo . " / " . $anho; ?> </strong></td>
				<td class="linea-arriba text-end col-100"><?php echo decimal_millar($debe+$debe_i, 2); ?> </td>
				<td class="linea-arriba text-end col-100"><?php echo decimal_millar($haber+$haber_i, 2); ?></td>
			</tr>
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