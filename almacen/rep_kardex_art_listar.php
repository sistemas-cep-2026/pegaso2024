<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_salida.php");
require_once(u_src() . "bo/bo_gen_articulos.php");
require_once(u_src() . "bo/bo_general.php");
$bo_general = new bo_general();
$bo_guiasali = new bo_alm_guias_de_salida();
$bo_articulos = new bo_gen_articulos();

$ent_articulo = new gen_articulos();
$ent_guiasali = new alm_guias_de_salida();

$cc_local = s_local_vinculado() ?? '';
$desde =  u_fecha($_REQUEST['desde']) ?? '';
$hasta =  u_fecha($_REQUEST['hasta']) ?? '';
$c_articulo = $_REQUEST['c_articulo'] ?? '';
$nomArticulo = $_REQUEST['nombre'] ?? '';

$ent_guiasali->setC_local($cc_local);
$ent_guiasali->setDesde($desde);
$ent_guiasali->setHasta($hasta);
$ent_guiasali->setC_articulo($c_articulo);

$data  = $bo_guiasali->listarKardexArticulo($ent_guiasali);

$ent_articulo->setC_articulo($c_articulo);
$ent_articulo->setC_local($cc_local);
$data_articulos = $bo_articulos->listarid($ent_articulo);
foreach ($data_articulos as $rowa) {
	$unidad = $rowa["unidad"];
	$familia_nombre = $rowa["familia_nombre"];
	$sub_familia_nombre = $rowa["sub_familia_nombre"];
	$saldo = $rowa["saldo"];
}

$data_local = $bo_general->RegionID($cc_local);
foreach ($data_local as $loc) {
	$cc_local_text = $loc['nombre_abv_print'];
}
$headerReporte = "<h2 class='text-center'>Reporte de Vale de Salida </h2><p class='text-center'>Año: $anho Periodo: $periodo</p>";
echo "<script>var headerContent = `" . $headerReporte . "`;</script>";
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
		<h2 class="text-left"><strong>CONSUMO POR ARTICULO</strong></h3>
			<p class="text-left"><strong><?php echo $cc_local_text ?></strong> </p>
			<p class="text-left"><strong><?php echo $c_articulo . " " . $nomArticulo . " - " . $unidad . " - " . $familia_nombre; ?></strong> </p>
			<p class="text-left">DESDE=&gt;<strong><?php echo $desde ?></strong> HASTA=&gt;<strong><?php echo $hasta ?></strong> SALDO = <strong><?php echo $saldo ?></strong></p>
			<thead>
				<tr class="active">
					<th style="text-align: left">#</th>
					<th style="text-align: left">FECHA KARDEX</th>
					<th style="text-align: left">FECHA DOC</th>
					<th style="text-align: left">DOC</th>
					<th style="text-align: left">SOLICITANTE</th>
					<th style="text-align: right">CANTIDAD</th>
					<th style="text-align: right">SALDO</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 0;
				$total = 0;
				if (count($data) > 0) {
					foreach ($data as $row) {
						$i++;
						switch ($row["cod_tipo"]) {
							case "GS":
								$val = "balsalid_tabs_print?cc_guia=" . s_crypt($row['cc_guia'], 'in') . "&tipo=" . $row["cod_tipo"];
								break;
							case "GE":
								$val = "guia_tabs_print?cc_guia=" . s_crypt($row['cc_guia'], 'in') . "&tipo=" . $row["cod_tipo"];
								break;
						} ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $row["fecha1"] ?></td>
							<td><?php echo $row["fecha_doc"] ?></td>
							<td><a href="<?php echo $val; ?>" target="_blank">
									<?php if ($row["cod_tipo"] == "GS") {
										echo 'VS';
									} else {
										echo $row["cod_tipo"];
									};
									echo " * " . $row["cc_guia"];
									?>
								</a>
							</td>
							<td><?php echo $row["usu_crea"] . " * " . substr($row["obs"], 0, 49) ?></td>
							<td class="text-end"><?php echo $row["cod_incremento_decremento"] . decimal($row["cantidad"], 0) ?></td>
							<td class="text-end"><?php echo decimal($row["saldo"], 0) ?></td>
						</tr>
					<?php } ?>
					<tr>
						<td class="text-end" colspan="6"><strong>SALDO FINAL ==&gt;</strong></td>
						<td class="text-end"><strong><?php echo decimal($row["saldo"], 0) ?></strong></td>
					</tr>
				<?php } else { ?>
					<tr>
						<td colspan="6" class="text-center">B&uacute;squeda sin &eacute;xito</td>
					</tr>

				<?php } ?>
			</tbody>
	</table>
	<div style="text-align: center; margin-bottom: 10px;">
		<button onclick="window.print();">
			<i class="bi bi-printer"></i> Imprimir
		</button>
	</div>

</body>

</html>