<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
s_validar_pagina();
require_once(u_src() . "bo/bo_web_tram_colegiacion_control.php");
require_once(u_src() . "bo/bo_web_tram_colegiacion.php");

$bo_web_tram_colegiacion_cont = new bo_web_tram_colegiacion_control();
$bo_tram_colegiacion = new bo_web_tram_colegiacion();
$ent_tram_colegiacion = new web_tram_colegiacion();
$ent_web_tram_colegiacion_cont = new web_tram_colegiacion_control();


$c_persona = s_crypt($_REQUEST["c_persona"], 'out');
$cr_texto = $_REQUEST["cr"];
$cep = $_REQUEST["cep"];

if (empty($c_persona)) {
	die(errors());
}

/*******************COLEGIADO******************** */
/*************************************** */
$ent_web_tram_colegiacion_cont->setC_persona($c_persona);
$data_control = $bo_web_tram_colegiacion_cont->ListarEstado($ent_web_tram_colegiacion_cont);

$data_coleg = array_filter($data_control, function ($item) {
	return $item['codigo'] === 'CL';
});

$data_cr = array_filter($data_control, function ($item) {
	return $item['codigo'] === 'CR';
});

$data_cn = array_filter($data_control, function ($item) {
	return $item['codigo'] === 'CN';
});

foreach ($data_coleg as $cl) {
	$estado_cl_control = $cl["estado"];
	$fecha_cl = $cl["fecha"];
}

foreach ($data_cr as $cr) {
	$detallecr = $cr["detalle"];
	$estado_cr_control = empty($cr["estado"]) ? 'P' : $cr["estado"];
	$fecha_cr = $cr["fecha"];
}

foreach ($data_cn as $cn) {
	$fecha_cn = $cn["fecha"];
}

/*******************COLEGIADO******************** */
$arr_estado_cl_control = [
	'P' => [
		'icono' => 'fa-info',
		'color' => 'alert-dark',
		'mensaje' => 'Pendiente de envío',
	],
	'R' => [
		'icono' => 'fa-times',
		'color' => 'alert-danger',
		'mensaje' => 'Documento rechazado por el CR el ' . $fecha_cr . ' <a class="link-secondary text-decoration-underline" data-bs-toggle="collapse" data-bs-target="#flush-historial" href="#">Ver detalles</a>'
	],
	'E' => [
		'icono' => 'fa-check',
		'color' => 'alert-success',
		'mensaje' => 'El solicitante envió su expediente el: ' . $fecha_cl
	]
];


/*******************REGIONAL******************** */

$arr_estado_cr_control = [
	'P' => [
		'icono' => 'fa-clock',
		'color' => 'alert-dark',
		'mensaje' => 'En espera de recepción y/o evaluacion',
	],
	'R' => [
		'icono' => 'fa-times',
		'color' => 'alert-danger',
		'mensaje' => 'Documento rechazado por el CDN el ' . $fecha_cn . ' <a class="link-secondary text-decoration-underline" data-bs-toggle="collapse" data-bs-target="#flush-historial" href="#">Ver detalles</a>'
	],
	'A' => [
		'icono' => 'fa-check',
		'color' => 'alert-success',
		'mensaje' => 'El CR aprobó el expediente el: ' . $fecha_cr
	]
];

$ent_tram_colegiacion->setNum_documento($c_persona);

$data_historial = $bo_tram_colegiacion->listarHistorialXNumDocumento($ent_tram_colegiacion);
$data_recaudoxds = $bo_tram_colegiacion->PersonaIDdni_nuevocol_recaudox($ent_tram_colegiacion);
?>
<div class="row">
	<div class="col-xl-9">
		<div class="row">
			<div class="col-xl-6 px-1">
				<div class="mx-2 alert <?= $arr_estado_cl_control[$estado_cl_control]['color'] ?> alert-label-icon rounded-label fade show material-shadow" role="alert">
					<i class="mr-2 fa <?= $arr_estado_cl_control[$estado_cl_control]['icono'] ?> label-icon"></i>
					<b class="fs-5">SOLICITANTE</b><br>
					<span><strong><?= $arr_estado_cl_control[$estado_cl_control]['mensaje']; ?></strong></span>
				</div>
			</div>
			<div class="col-xl-6 px-1">
				<div class="mx-2 alert <?= $arr_estado_cr_control[$estado_cr_control]['color'] ?> alert-label-icon rounded-label fade show material-shadow" role="alert">
					<i class="mr-2 fa <?= $arr_estado_cr_control[$estado_cr_control]['icono'] ?> label-icon"></i>
					<b class="fs-5"><?= $cr_texto; ?></b><br>
					<span><strong><?= $arr_estado_cr_control[$estado_cr_control]['mensaje']; ?></strong></span>
				</div>
			</div>
			<div class="col-xl-12">
				<?php
				if (empty($data_recaudoxds[0]['bcp1']) && empty($data_recaudoxds[0]['bbva1'])) {
					echo errors("FALTA PAGO DE RECAUDO (BCP O BBVA).");
				} else {
				?>
					<div class="mx-2 alert alert-success alert-border-left fade show material-shadow" role="alert">
						<div class="alert-body">
							<div class="d-flex">
								<div class="flex-shrink-0 me-3">
									<i class="ri-check-double-line fa-2x align-middle"></i>
								</div>
								<div class="flex-grow-1">
									<h5 class="alert-heading">Pago Recaudo</h5>
									<?php
									foreach ($data_recaudoxds as $reca) {
									?>
										<p class="mb-0"><?= $reca["bcp1"]; ?></p>
										<p class="mb-0"><?= $reca["bbva1"]; ?></p>
									<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<div class="col-xl-3">
		<?php
		if (empty($cep)) {


			if ($estado_cl_control == 'P') {
				echo errors('EL TRÁMITE AÚN NO HA SIDO ENVIADO POR EL SOLICITANTE.');
			} else {
		?>
				<div class="d-grid gap-2">
					<button type="button" onclick="fn_procesarShow({c_persona:'<?= s_crypt($c_persona) ?>', codigo:'CR', estado:'R', cr: '<?= $cr_texto ?>'});" class="btn btn-danger">
						<i class="mr-2 fa fa-times"></i> Rechazar
					</button>
					<button type="button" onclick="fn_procesarShow({c_persona:'<?= s_crypt($c_persona) ?>', codigo:'CR', estado:'A', cr: '<?= $cr_texto ?>'});" class="btn btn-success">
						<i class="mr-2 fa fa-check"></i> Aceptar
					</button>
					<a href="<?= url('colegiados/print_documentocol?c_persona=' . $c_persona); ?>" target="_blank" class="btn btn-info">
						<i class="mr-2 fa fa-print"></i> Imprimir
					</a>
				</div>
		<?php
			}
		}
		?>

	</div>
</div>
<div class="row p-1">
	<div class="accordion accordion-flush" id="accordionHistorialaPadre">
		<div class="accordion-item border-0">
			<h2 class="accordion-header">
				<button class="accordion-button p-1 caret-off bg-white border-0 shadow-none btn-lg" type="button" data-bs-toggle="collapse" data-bs-target="#flush-historial" aria-expanded="false" aria-controls="flush-historial">
					<span class="btn btn-ghost-info"><i class="fa fa-search"></i> Historial <i class="fa fa-caret-down align-middle"></i></span>
				</button>
			</h2>
			<div id="flush-historial" class="accordion-collapse collapse" data-bs-parent="#accordionHistorialaPadre">
				<div class="accordion-body">
					<div class="table-responsive">
						<table class="table table-sm table-condensed">
							<thead class="table-active">
								<tr>
									<th scope="col">#</th>
									<th scope="col">Fecha</th>
									<th scope="col">Fase</th>
									<th scope="col">Usuario</th>
									<th scope="col">Observaci&oacute;n</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								foreach ($data_historial as $historial) {
								?>
									<tr>
										<th scope="row"><?php echo $i; ?></th>
										<td><?php echo $historial['fecha']; ?></td>
										<td><?php echo $historial['fase']; ?></td>
										<td><?php echo $historial['c_usuario']; ?></td>
										<td><?php echo $historial['detalle']; ?></td>
									</tr>
								<?php
									$i++;
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>