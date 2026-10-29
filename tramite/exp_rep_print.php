<?php
require_once dirname(__DIR__) . "/util/seguridad.php";
require_once dirname(__DIR__) . "/util/util.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
s_validar_pagina();
require_once(u_src() . "bo/bo_tram_documentos_recibidos.php");

$bo_doc_recibidos = new bo_tram_documentos_recibidos();
$ent_doc_recibidos = new tram_documentos_recibidos();

$c_expediente_desde = s_crypt($_REQUEST['cod'], 'out');
$c_expediente_hasta = s_crypt($_REQUEST['cod2'], 'out');
$c_local = s_local();
$ent_doc_recibidos->setC_expediente_desde($c_expediente_desde);
$ent_doc_recibidos->setC_expediente_hasta($c_expediente_hasta);

$ent_doc_recibidos->setC_local($c_local);
$data_docume = $bo_doc_recibidos->listarParaImprimirRango($ent_doc_recibidos);

$fecha_emision = date('d/m/Y');
$hora_emision = date('H:i:s');

ob_start();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo url('css/print_pdf.css?ver=' . rand(1, 999999)); ?>">
</head>

<body class="reporte-expedientes">

	<!-- CABECERA -->
	<table class="reporte-cabecera">
		<tr>
			<td style="width:40%;" class="fw-bold">
				<?php echo htmlspecialchars($c_expediente_desde); ?>
			</td>

			<td style="width:60%; text-align:right;">
				Fecha Emisión :
				<?php echo $fecha_emision; ?>

				&nbsp;&nbsp;

				Hora Emisión :
				<?php echo $hora_emision; ?>
			</td>
		</tr>
	</table>


	<!-- TABLA PRINCIPAL -->
	<table class="tabla-expedientes">

		<thead>
			<tr>
				<th class="col-detalle">
					EXP / REFERENCIA / ÁREA
				</th>

				<th class="col-fecha">
					FECHA
				</th>

				<th class="col-firma" style="text-align:center;">
					V°B°
				</th>
			</tr>
		</thead>

		<tbody>

			<?php if (empty($data_docume)): ?>

				<tr>
					<td colspan="3" style="text-align:center; padding:15px;">
						No hay expedientes para listar.
					</td>
				</tr>

			<?php else: ?>

				<?php foreach ($data_docume as $row): ?>

					<tr>

						<!-- EXPEDIENTE / REFERENCIA / ASUNTO / ÁREA -->
						<td class="col-detalle">

							<div class="linea-referencia">

								<?php echo htmlspecialchars($row['c_expediente'] ?? ''); ?>

								&nbsp;&nbsp;

								<span style="text-decoration:underline;">
									<?php echo htmlspecialchars($row['c_tipo_de_documento'] ?? ''); ?>
								</span>

								&nbsp;

								<?php echo htmlspecialchars($row['nombre_referencia'] ?? ''); ?>

							</div>


							<div class="linea-asunto">
								<?php echo htmlspecialchars($row['asunto'] ?? ''); ?>
							</div>


							<div class="linea-area">

								<?php if (!empty($row['c_area_adm_text'])): ?>

									<span class="area">
										<?php echo htmlspecialchars($row['c_area_adm_text']); ?>
									</span>

								<?php endif; ?>


								<?php if (!empty($row['c_accion_text'])): ?>

									<span class="accion">
										<?php echo htmlspecialchars($row['c_accion_text']); ?>
									</span>

								<?php endif; ?>

							</div>

						</td>


						<!-- FECHA -->
						<td class="col-fecha">

							<?php
							echo htmlspecialchars(
								$row['fecha_entrega_text']
									?? $row['fecha_ingreso_text']
									?? ''
							);
							?>

						</td>


						<!-- FIRMA -->
						<td class="col-firma">

							<div class="firma-box">
								&nbsp;
							</div>

						</td>

					</tr>

				<?php endforeach; ?>

			<?php endif; ?>

		</tbody>

	</table>

	<script type="text/javascript">
		setTimeout(function() {
			window.print();
		}, 500);
		window.onafterprint = function() {
			window.close();
		};
	</script>

</body>

</html>