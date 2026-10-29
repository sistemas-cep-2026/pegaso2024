<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_seg_usuarios.php");
require_once(u_src() . "bo/bo_general.php");
 
require_once(u_src() . "bo/bo_tram_documentos_enviados.php");

$bo_general = new bo_general();
 
$bo_documentos = new bo_tram_documentos_enviados();
$ent_documentos = new tram_documentos_enviados();

$fecha_desde = u_fecha($_REQUEST["fecha_desde"] ?? '') . ' 00:00';
$fecha_hasta = u_fecha($_REQUEST["fecha_hasta"] ?? '') . ' 23:59';

$ent_documentos->setC_local(s_local());
$ent_documentos->setFecha_desde($fecha_desde);
$ent_documentos->setFecha_hasta($fecha_hasta);


$data_doc = $bo_documentos->listar($ent_documentos);
$color_flag = [
	'A' => 'success',
	'P' => 'warning',
	'T' => 'primary',
];
?>
<div id="print-section" class="print-section">
	<div class="table-responsive">
		<table class="table table-striped table-hover table-sm align-middle" id="table-expedientes">
			<thead>
				<tr class="table-light">
					<th>#</th>
					<th>Fecha</th>
					<th>Tipo Doc.</th>
					<th>Num.</th>
					<th>Osb</th>
					<th>Usuario</th>
				 
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach ($data_doc as $row) {
					$color = $color_flag[$row["flag"]] ?? 'secondary';
				?>
					<tr data-cc-docrecibidos="<?php echo (int) $row['cc_docenviado']; ?>">
						<td><?php echo $i ?></td>
						<td><?php echo $row['fecha_text'] ?></td>
						<td class="fw-semibold"><?php echo  $row['c_tipo_de_documento']  ?></td>
							<td><?php echo $row['num_documento']  ?></td>
				 
						<td><?php echo htmlspecialchars($row['asunto']) ?></td>
						<td><?php echo  $row['c_usuario']  ?></td>
					 
						 

					</tr>
				<?php $i++;
				} ?>
			</tbody>
		</table>
		 

	</div>
</div>