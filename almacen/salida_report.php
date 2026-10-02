<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_alm_guias_de_salida.php");
$bo_guiasali = new bo_alm_guias_de_salida();

$ent_guiasali = new alm_guias_de_salida();

$cc_local = s_local_vinculado();
$anho = $_REQUEST['anho'] ?? '';
$periodo = $_REQUEST['periodo'] ?? '';

$ent_guiasali->setC_local($cc_local);
$ent_guiasali->setAnho($anho);
$ent_guiasali->setPeriodo($periodo);

$data  = $bo_guiasali->listar($ent_guiasali);

$headerReporte = "<h2 class='text-center'>Reporte de Vale de Salida </h2><p class='text-center'>Desde: $desde Hasta: $hasta</p>";
echo "<script>var headerContent = `" . $headerReporte . "`;</script>";
?>
<div class="table-responsive">
	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<th>#</th>
				<th>FECHA</th>
				<th>GUIA</th>
				<th>NOMBRE</th>
				<th>OBS</th>
				<th>ESTADO</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i=1;//
			foreach ($data as $row) { 
				$val="almacen/balsalid_tabs_print?cc_guia=".s_crypt($row['cc_guia'],'in')."&tipo=GS";
				?>

				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo $row["fecha_text"] ?></td>
					<td><a  href="#" onclick="redireccionar_ventana('<?php  echo url($val) ?>',750);"><?php echo $row["cc_guia"]; ?><a></td>
					<td><?php echo $row["nombre"]; ?></td>
					<td><?php echo $row["justificacion"]; ?></td>
					<td><?php echo $row["flag_text"] ?></td>
					 
				
				</tr>
				<?php $i++;
			} ?>
		</tbody>
	</table>
</div>
