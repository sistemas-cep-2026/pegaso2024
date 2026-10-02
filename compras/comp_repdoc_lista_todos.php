<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();

require_once(u_src() . "bo/bo_general.php");

require_once(u_src() . "bo/bo_comp_documentos_de_compras.php");

$bo_compras = new bo_comp_documentos_de_compras();
$bo_general = new bo_general();
$ent_compras = new comp_documentos_de_compras();

$cc_local = $_REQUEST['cc_local'] ?? '';
$anho = $_REQUEST['anho']  ?? '';
$cc_persona = s_crypt($_REQUEST['cc_persona'], 'out') ?? '';


 
$ent_compras->setCc_persona($cc_persona);


$data_compras = $bo_compras->listarRepdoc_total($ent_compras);
?>
<div class="table-responsive">
	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<th>#</th>
				<th>PROVEEDOR</th>
				<th>CR</th>
				<th>PERIODO</th>
				<th>VECES</th> 
				
			</tr>
		</thead>
		<tbody>
			<?php
			$n=0;
			foreach ($data_compras as $row) {
				
			$n++;
				?>
				<tr>
					<td><?php echo $n ?></td>
					<td><?php echo $row['ruc'] .'-'.recortarCadena($row['nombre'], 100) ?></td>
					<td><?php echo $row['c_local'] ?></td>
					<td><?php echo $row['cod_ano'].'-'.$row['cod_mes']; ?></td>
					<td><?php echo $row['cantidad']?></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
