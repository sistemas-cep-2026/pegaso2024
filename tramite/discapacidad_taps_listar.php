<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_gen_personas_discapacidad.php");
$bo_gen_discapacidad = new bo_gen_personas_discapacidad();

$ent_gen_discapacidad = new gen_personas_discapacidad();

$nombre = $_REQUEST['nombre'] ?? '';
$anho = $_REQUEST['anho'] ?? '';

$cc_local = s_local();
$c_local  = ($cc_local === '28') ? '' : $cc_local;

$ent_gen_discapacidad->setNombre($nombre);
$ent_gen_discapacidad->setAnho($anho);
$ent_gen_discapacidad->setC_local($c_local);

$data_discapacidad  = $bo_gen_discapacidad->listar($ent_gen_discapacidad);

$headerReporte = "<h2 class='text-center'>Registros Discapacidad</h2>";
echo "<script>var headerContent = `" . $headerReporte . "`;</script>";

?>

<div class="table-responsive">
	<table class="table table-hover table-sm" id="table-reporte">
		<thead class="table-light">
			<tr>
				<th>CODIGO</th>
				<th>CEP</th>
				<th>NOMBRE</th>
				<th>CR</th>
				<th>TIPO</th>
				<th>FECHA</th>
				<th>N° REG.</th>
				<th>OBS</th>
				<th class="text-center">ESTADO</th>
				<th class="text-end">OP</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$estados_color = [
				'*' => 'success',
				'A' => 'danger'
			];
			foreach ($data_discapacidad as $row) { ?>
				<tr>
					<td><?php echo $row["cc_discapac"] ?></td>
					<td><?php echo $row["c_cmp"]; ?></td>
					<td><?php echo $row["nombre"]; ?></td>
					<td><?php echo $row["c_local_text"]; ?></td>
					<td><?php echo $row["cod_tipo_text"]; ?></td>
					<td><?php echo $row["fecha_registro"]; ?></td>
					<td><?php echo $row["reg_conadis"]; ?></td>
					<td><?php echo $row["obs"]; ?></td>
					<td class="text-center"><?php echo u_estado($row["flag_text"], $estados_color[$row["flag"]]); ?></td>
					<td class="text-end">
						<a href="#" onclick="fn_imprimir_('<?php echo s_crypt($row['cc_honorab'], 'in') ?>')" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Previsualizar Certificado"><i class="fa-solid fa-print"></i></a>
					</td>
				</tr>
			<?php $i++;
			} ?>
		</tbody>
	</table>
</div>