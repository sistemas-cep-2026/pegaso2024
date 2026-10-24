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

$cc_local = s_local();

// Capturar parámetros
$periodo = $_REQUEST["periodo"] ?? '';
$anho = $_REQUEST["anho"] ?? '';
$usuario = $_REQUEST["usuario"] ?? '';

// Filtros iniciales
$ent_actividad->setUsuario($usuario);
$ent_actividad->setAnho($anho);
$ent_actividad->setPeriodo($periodo);
$ent_actividad->setCc_local($cc_local);

$data_user = $bo_usuario->listarUsuarioPerido($anho, $periodo, $usuario, $cc_local);
$data_dia = $bo_actividad->ListarActiDia($ent_actividad);

if (empty($data_dia)) {
	echo errors();
	return;
}
?>
<div id="print-section" class="print-section">
	<div class="row bg-white">
		<div class="table-responsive">
			<table class="table table-borderless table-sm">
				<tr class="texto_printer">
					<td class="text-center" colspan="2">
						<h3>HORAS EXTRAS - APROBADOS INFORME &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $periodo . "/" . $anho ?></h3>
					</td>
				</tr>
			</table>
			<hr>
			<?php foreach ($data_user as $user): ?>
				<?php
				$ent_actividad->setUsuario($user['usuario']);
				echo "<h5>{$user['nombre']}</h5>";
				?>
				<?php foreach ($data_dia as $dia): ?>
					<?php
					$ent_actividad->setDia($dia["dia"]);
					$data_activ = $bo_actividad->ListarActiMensual($ent_actividad);
					if (empty($data_activ)) continue;
					?>
					<table class="table table-borderless table-sm small">
						<tbody>
							<?php
							$totaldia = 0;
							foreach ($data_activ as $key):
								$segundos = ($key["minutos"] * 60);
								$totaldia += $segundos;
							?>
								<tr>
									<td class="col-md-2"><?php echo $key["cc_sustento"] ?></td>
									<td class="col-md-2"><?php echo diadesemana($key["fecha_from"]) ?> [<?php echo $key["dia_text"] ?>]</td>
									<td class="col-md-2"><?php echo $key["fecha"] ?></td>
									<td class="col-md-2"><?php echo $key["area"] ?></td>
									<td class="col-md-2"><?php echo $key["horaini"] . " &nbsp;=>&nbsp; " . $key["horafin"] ?></td>
									<td class="col-md-2 text-end"><?php echo segundos_tiempo($segundos); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5" class="text-end">Total :</th>
								<th class="text-end"><?php echo segundos_tiempo($totaldia); ?></th>
							</tr>
						</tfoot>
					</table>
					<br>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<div class="flex-grow-1 ms-2 text-center">
	<?php echo bt_imprimirDiv(); ?>
</div>