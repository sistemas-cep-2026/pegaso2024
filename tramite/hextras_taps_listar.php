<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_actividad_sustento.php");
require_once(u_src() . "bo/bo_tram_actividad_sustento_detalle.php");
require_once(u_src() . "bo/bo_seg_usuarios.php");

$bo_actividad = new bo_tram_actividad_sustento();
$bo_actividad_det = new bo_tram_actividad_sustento_detalle();
$bo_usuario = new bo_seg_usuarios();

$ent_actividad = new tram_actividad_sustento();
$ent_actividad_det = new tram_actividad_sustento_detalle();
$ent_usuario = new seg_usuarios();

$usuario = s_usuario();

$cc_local = s_local();

$periodo = $_REQUEST["periodo"] ?? '';
$anho = $_REQUEST["anho"] ?? '';
$flag = $_REQUEST["flag"] ?? '';

$ent_actividad->setUsuario($usuario);
$ent_actividad->setAnho($anho);
$ent_actividad->setPeriodo($periodo);
$ent_actividad->setCc_local($cc_local);
$ent_actividad->setFlag($flag);

$data_activ = $bo_actividad->ListarActiMensual($ent_actividad);


$ent_usuario->setUsuario($usuario);
$data_user = $bo_usuario->listarId($ent_usuario);
foreach ($data_user as $user) {
	$user_user = $user["c_usuario"];
	$user_nombre = $user["nombre"];
	$c_local_text = $user["c_local_text"];
}

?>
<!-- Sección para imprimir -->
<div id="print-section" class="print-section">
	<!-- Tabla de ejemplo -->
	<table class="table table-borderless table-sm">
		<tr class="texto_printer">
			<td class="text-center" colspan="2">
				<h3>REGISTRO DE HORAS EXTRAS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $periodo . "/" . $anho ?></h3>
			</td>
		</tr>
		<tr class="texto_printer">
			<td>Usuario: <strong><?php echo $user_nombre ?></strong></td>
			<td class="text-end"><?php echo fecha_hora_hoy() ?></td>
		</tr>
	</table>
	<table class="table table-borderless table-sm divtable">
		<thead>
			<tr class="table-active">
				<th class="col-md-1"># REG</th>
				<th class="col-md-3">FECHA</th>
				<th class="col-md-6">DESCRIPCION</th>
				<th class="col-md-2 text-center">FIRMA</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data_activ as $key) {
				$ent_actividad_det->setCc_sustento($key["cc_sustento"]);
				$data_deta = $bo_actividad_det->ListarIdActividad($ent_actividad_det);
				$diferencia = compararFechas($key['fecha_from']);
			?>
				<tr>
					<td><?php echo $key["cc_sustento"] ?></td>
					<td><?php echo $key["fecha"] ?> <strong> [<?php echo $key["dia_text"] ?>]</strong> </td>
					<td></td>
					<td></td>
				</tr>
				<tr class="border-bottom">
					<td colspan="3"><?php echo $key["area"] . "&nbsp;&nbsp;" . $key["horaini"] . " => " . $key["horafin"] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $key["obs"] ?></td>
					<td class="text-center">___________
						<?php if ($diferencia < 75) { ?>
							<a href="?id=<?php echo s_crypt('400001', 'in') ?>&cod=<?php echo s_crypt($key["cc_sustento"], 'in') ?>&opc=<?php echo s_crypt('U', 'in') ?>" class="text-primary"><i class="fas fa-edit fa-1x"></i></a>
						<?php } ?>

						<?php if (count($data_deta) == '') { ?>
							<a href="javascript: fc_eliminarDia('<?php echo s_crypt($key["cc_sustento"], 'in') ?>','<?php echo s_crypt('E', 'in') ?>')"><i class="fas fa-trash text-danger"></i></a>
						<?php } ?>
					</td>
				</tr>

			<?php } ?>
		</tbody>
	</table>
</div>
<div class="flex-grow-1 ms-2 text-center">
	<?php echo bt_imprimirDiv(); ?>
</div>